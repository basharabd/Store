<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $brands = Brand::latest()
        ->orderBy('name', 'ASC')
        ->when($request->name, function ($query, $value) {
            $query->where('name', 'LIKE', "%{$value}%");
        })
        ->when($request->status, function ($query, $value) {
            $query->where('status', '=', $value);
        })
        ->paginate();
        return view('dashboard.brands.index' , compact('brands'));
    }

    public function create()
    {
        $parents = Brand::all();
        $brand = new Brand();
        return view('dashboard.brands.create' , compact('parents' , 'brand'));
    }

    public function store(Request $request)
    {

        $request->validate([

            'name'=>'required|string',
            'description'=>'nullable|string',
            'image'=>'image|mimes:png,jpg,jpeg|nullable',
            'status'=>'in:active,inactive',

        ]);


        $data = $request->except('image');
        $data['image']=$this->uploadImage($request);
        $brands = Brand::create($data);
        return redirect()->route('brands.index')->with('message' , 'created Brand successfully');

    }



    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('dashboard.brands.edit',compact('brand'));

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'image'=>'image|mimes:png,jpg,jpeg|nullable',
            'status'=>'in:active,inactive',
        ]);

        $brand = Brand::findOrFail($id);

        $data = $request->except('image');
         $old_image = $brand->image;


            $new_image=$this->uploadImage($request);

            if($new_image){
                $data['image']=$new_image;

            }

        $brand->update($data);

        if($old_image && $new_image){

            Storage::disk('uploads')->delete($old_image);

        }

        return redirect()->route('brands.index')->with('message' , 'Updated Brand successfully');

    }


    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('brands.index')->with('message' , 'Deleted Brand successfully');
    }



    protected function uploadImage(Request $request)
    {

        if(!$request->hasFile('image')){
            return;
        }
            $file = $request->file('image');
            $path =  $file->store('Brands' , [
                'disk'=>'uploads'
            ]);
           return $path;


    }

    public function trash()
    {
        dd(true);
        $brands = Brand::onlyTrashed()->paginate();
        return view('dashboard.brands.trash', compact('brands'));

    }

    public function restore($id)
    {

        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();

        return redirect()->route('brands.trash')
            ->with('success' , 'Brand  Restored!');


    }


    public function force_delete($id)
    {

        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->forceDelete();
        if($brand->image){
            Storage::disk('uploads')->delete($brand->image);
        }

        return redirect()->route('brands.trash')
            ->with('success' , 'Brand Deleted For Ever!');


    }


     public function show(Brand $brand)
     {
       return view('dashboard.brands.show' , compact('brand'));
     }


}
