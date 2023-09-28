<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class OrdersControllers extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function print(Order $order)
    {
        $pdf = Pdf::loadView('dashboard.orders.invoice', [
            'order'=>$order,
        ]);
        return $pdf->stream();
    }

    public function index()
    {
        $request=request();

        $orders = Order::all();
        return view('dashboard.orders.index' , compact('orders'));
    }



    public function accept(Order $order)
    {
        // Check if the order can be accepted (e.g., based on its current status)
        if ($order->status === 'pending') {
            // Update the order status to 'accepted' or any appropriate status
            $order->update(['status' => 'accepted']);

            // You can perform additional actions like sending notifications or emails here

            return redirect()->route('orders.index')->with('message', 'Order has been accepted.');
        }

        return redirect()->route('orders.index')->with('message', 'Unable to accept the order.');
    }


}
