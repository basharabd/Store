<?php

namespace App\Http\Controllers;

use App\Jobs\NewProductsEmail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        return view('dashboard.index');
    }

    public function ordersChart(Request $request)
    {
        $group = $request->query('group' , 'month');
        $query = Order::select([
            DB::raw('SUM(total) as total'),
            DB::raw('count(*) as count'),

        ])
            ->groupBy([ 'label' ])
            ->OrderBy('label');

        switch ($group) {
            case 'day':
                $query->addSelect(DB::raw('DATE(created_at) as label'));
                $query->whereDate('created_at' , '>=' , Carbon::now()->startOfMonth());
                $query->whereDate('created_at' , '<=' , Carbon::now()->endOfMonth());

                break;
            case 'week':
                $query->addSelect(DB::raw('WEEK(created_at) as label'));
                $query->whereDate('created_at' , '>=' , Carbon::now()->startOfWeek());
                $query->whereDate('created_at' , '<=' , Carbon::now()->endOfWeek());
                break;
            case 'year':
                $query->addSelect(DB::raw('YEAR(created_at) as label'));
                $query->whereYear('created_at' , '>=' , Carbon::now()->subYears(5)->year);
                $query->whereYear('created_at' , '<=' , Carbon::now()->addYears(4)->year);
                break;
            case 'month':
                $query->addSelect(DB::raw('MONTH(created_at) as label'));
                $query->whereYear('created_at' , '>=' , Carbon::now()->startOfYear());
                $query->whereYear('created_at' , '<=' , Carbon::now()->endOfYear());
//                $labels = [
//                    '1'=>'Jan' , 'Feb' , 'Mar' , 'Apr' , 'May' , 'Jue' , 'Jul' , 'Aug',
//                    'Sep' , 'Oct' , 'Nov' , 'Dec',
//
//                ];

            default:
        }


        $labels =    $total = $count = [];

        $entries = $query->get();

         foreach ($entries as $entry)
         {
             $labels[] = $entry->label;
             $total[$entry->label] = $entry->total;
             $count[$entry->label] = $entry->count;
         }

//         foreach ($labels as $month => $name)
//         {
//             if(! array_key_exists($month , $total))
//             {
//                 $total[$month] = 0;
//
//             }
//
//             if(! array_key_exists($month , $count))
//             {
//                 $count[$month] = 0;
//
//             }
//
//         }
//
//         ksort($total);
//         ksort($count);

         return [
             'group'=>$group,
             'labels'=>array_values($labels),
             'datasets'=>[
                 [
                     'label'=>'Total sales',
                     'borderColor'=>'blue',
                     'backgroundColor'=>'blue',
                     'data'=>array_values($total) ,
                 ],
                 [
                     'label'=>'Orders Number',
                     'borderColor'=>'darkgreen',
                     'backgroundColor'=>'darkgreen',
                     'data'=>array_values($count) ,
                 ],
             ],
         ];
    }

    public function newsLetters()
    {
        dispatch(new NewProductsEmail())->onQueue('emails');
        dispatch(new NewProductsEmail())->onQueue('emails');

    }
}
