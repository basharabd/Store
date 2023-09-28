<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PDO;
use PhpParser\Node\Stmt\TryCatch;

class CategoriesController extends Controller
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

       // Gate::authorize('categories.view');

        // if(!Gate::allows('categories.view')){
        //     abort(403);
        // }
        $request = request();
    //   $categories =category:: leftJoin('categories as parents' ,'parents.id', '=' ,'categories.parent_id' )
    //   ->select([
    //     'categories.*',
    //     'parents.name as parent_name',
    //   ])

    //   ->filter($request->query())
    //   ->orderBy('categories.name')->paginate();

    $categories =category::with('parent')
    ->withCount([
        'products as products_number'=>function($builder){
            $builder->where('status' , '='  , 'active');

        }
    ])
    ->filter($request->query())
    ->orderBy('categories.name')->paginate();

     //   $categories=Category::active()->paginate();//local scope
      //  $categories=Category::status('archived')->paginate();//daynimac scope

        return view('dashboard.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if(Gate::denies('categories.create')){
//            abort(403);
//        }

        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create' , compact('parents' , 'category') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Gate::authorize('categories.create');


    //    $request->validate(Category::rules());
        $request->merge([
            'slug'=>Str::slug($request->post('name')),
        ]);
        $data = $request->except('image');
        $data['image']=$this->uploadImage($request);
        $categories = Category::create($data);
        return redirect()->route('categories.index')->with('message' , 'created category successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        if(!Gate::allows('categories.view')){
            abort(403);
        }
        return view('dashboard.categories.show' , compact('category'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if(!Gate::allows('categories.update')){
            abort(403);
        }

        try{
            $category = Category::findOrFail($id);
        }catch(Exception $e){
            return redirect()->route('categories.index')->with('info', 'Record Not Found');
        }
        $parents = Category::where('id','<>',$id)
        ->where(function($query) use($id){
            $query->whereNull('parent_id')
            ->ORWhere('parent_id','<>',$id);

        })
        ->get();

        return view('dashboard.categories.edit' , compact('category' , 'parents'));
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
       Gate::authorize('categories.update');

       // $request->validate(Category::rules());
        $category = Category::findOrFail($id);

        $data = $request->except('image');
         $old_image = $category->image;


            $new_image=$this->uploadImage($request);

            if($new_image){
                $data['image']=$new_image;

            }

        $category->update($data);

        if($old_image && $new_image){

            Storage::disk('uploads')->delete($old_image);

        }
        return redirect()->route('categories.index')->with('message' , 'updated category successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Gate::authorize('categories.delete');


        $category = Category::findOrFail($id);
        $category->delete();


        return redirect()->route('categories.index')->with('message' , 'Deleted category successfully');
    }

    public function trash()
    {

        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));

    }

    public function restore($id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('categories.trash')
        ->with('success' , 'Category Restored!');


    }


    public function force_delete($id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
         if($category->image){
            Storage::disk('uploads')->delete($category->image);
        }

        return redirect()->route('categories.trash')
        ->with('success' , 'Category Deleted For Ever!');


    }


    protected function uploadImage(Request $request)
    {

        if(!$request->hasFile('image')){
            return;
        }
            $file = $request->file('image');
            $path =  $file->store('Categories' , [
                'disk'=>'uploads'
            ]);
           return $path;


    }


}
