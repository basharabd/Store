<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class ProductsController extends Controller
{

    public function __construct() {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request=request();

            $products = Product::
            with(['category' , 'store'])
            ->
            filter($request->query())
            ->orderBy('products.name')
            ->paginate();
        return view('dashboard.products.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $parents = Product::all();
        $product = new Product();

        return view('dashboard.products.create' , compact('product'  , 'parents'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([

            'name'=>'required|string',
            'slug'=>'string|unique:products,id',
            'description'=>'nullable|string',
            'image'=>'image|mimes:png,jpg,jpeg|nullable',
            'price'=>'nullable|integer',
            'compare_price'=>'nullable|integer',
            'status'=>'in:active,draft,archvied',

        ]);

        $request->merge([
            'slug'=>Str::slug($request->post('name')),

        ]);

        $data = $request->except('image');
        $data['image']=$this->uploadImage($request);
        $products = Product::create($data);
        return redirect()->route('products.index')->with('message' , 'created Product successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
       // $products = Product::all();

        return view('dashboard.products.edit',compact('product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([

            'name'=>'required|string',
            'slug'=>'string|unique:products,id',
            'description'=>'nullable|string',
            //'image'=>'mimes:png,jpg,jpeg|nullable',
            'price'=>'nullable|integer',
            'compare_price'=>'nullable|integer',
            'status'=>'in:active,draft,archvied',

        ]);
        $product = Product::findOrFail($id);

        $data = $request->except('image');
         $old_image = $product->image;


            $new_image=$this->uploadImage($request);

            if($new_image){
                $data['image']=$new_image;

            }

        $product->update($data);

        if($old_image && $new_image){

            Storage::disk('uploads')->delete($old_image);

        }


        //gallery

        // $multi = $request->file('image');

        // if($request->hasFile('image'))
        // {

        //     foreach($multi as $file);
        //     {
        //         $image_path1   =  $file->store('Products' , [
        //             'disk'=>'uploads'
        //         ]);

        //         $product->images()->create([

        //             'image'=>$image_path1,

        //         ]);
        //     }

        // }

        return redirect()->route('products.index')->with('message' , 'updated Product successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();


        return redirect()->route('products.index')->with('message' , 'Deleted Product successfully');
    }

    protected function uploadImage(Request $request)
    {

        if(!$request->hasFile('image')){
            return;
        }
            $file = $request->file('image');
            $path =  $file->store('Products' , [
                'disk'=>'uploads'
            ]);
           return $path;


    }

    public function trash()
    {

        $products = Product::onlyTrashed()->paginate();
        return view('dashboard.products.trash', compact('products'));

    }

    public function restore($id)
    {

        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('products.trash')
        ->with('success' , 'Product Restored!');


    }


    public function force_delete($id)
    {

        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
         if($product->image){
            Storage::disk('uploads')->delete($product->image);
        }

        return redirect()->route('products.trash')
        ->with('success' , 'Product Deleted For Ever!');


    }

    public function export(Request $request)
    {
        $query = Product::with(['category', 'store'])
            ->orderBy('name','ASC')
            ->when($request->name , function($query , $value){
                $query->where('name', 'LIKE' , "%{$value}%");

            })
            ->when($request->status , function($query , $value){
                $query->where('status', 'LIKE' , "%{$value}%");

            });

        $export = new ProductExport();
        $export->setQuery($query);

        return Excel::download($export, 'sssssd.xlsx');
    }

    public function importView()
    {

        return view('dashboard.products.import');
    }
    public function import(Request $request)
    {

        $request->validate([
            'file'=>['required' , 'mimes:xls,xlsx,csv'],
        ]);

        Excel::import(new ProductsImport(), $request->file('file')->path());

        return redirect()->route('products.index')
            ->with('success' , 'Product Imported!');
    }



}
