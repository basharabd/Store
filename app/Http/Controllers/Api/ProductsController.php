<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth:sanctum')->except('index');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
     $products = Product::filters($request->query())
        ->with('category:id,name' , 'store:id,name')
        ->paginate();

        return ProductResource::collection($products);
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
            'price'=>'required|integer|numeric|min:0',
            'compare_price'=>'nullable|numeric|gt:price',//grather than(اكبر من قيمة السعر)
            'status'=>'in:active,draft,archvied',
             
        ]);

        $user = $request->user();
        if (!$user->tokenCan('products.create')) {
            abort(403, 'Not allowed');
        }

        $data = $request->except('image');
        $data['image']=$this->uploadImage($request);
        $products = Product::create($data);

        return   $products;
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //$product = Product::with('category:id,name','store:id,name')->findOrFail($id);
       // return $product->with('category:id,name','store:id,name')->first();

       return new ProductResource($product);
        return $product->load('category:id,name','store:id,name');

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

            'name'=>'sometimes|required|string',
            'slug'=>'string|unique:products,id',
            'description'=>'nullable|string',
            'image'=>'image|mimes:png,jpg,jpeg|nullable',
            'price'=>'sometimes|required|integer|numeric|min:0',
            'compare_price'=>'nullable|numeric|gt:price',//grather than(اكبر من قيمة السعر)
            'status'=>'in:active,draft,archvied',
             
        ]);

        $user = $request->user();
        if (!$user->tokenCan('products.update')) {
            abort(403, 'Not allowed');
        }
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

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('products.delete')) {
            abort(403, 'Not allowed');
        }
        Product::destroy($id);

        return [
            'message' =>' Successfully',
            ]
        ;

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

}