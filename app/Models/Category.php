<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      'name', 'parent_id', 'description', 'image', 'status', 'slug'
  ];
    public function products()
    {
      return $this->hasMany(Product::class , 'category_id' , 'id');
    }
    public function parent()
    {

      return $this->belongsTo(Category::class , 'parent_id')
      ->withDefault([
        'name'=>'-',
      ]);
      
    }

    public function children()
    {

      return $this->hasMany(Category::class , 'parent_id' , 'id');
      
    }


    
     //local scope
    public function ScopeActive(Builder $builder){
      $builder->where('status','=','active');
    }

      //Daynamic scope
      public function ScopeStatus(Builder $builder , $status){
        $builder->where('status','=',$status);
      }

      //filter scope

      public function scopeFilter(Builder $builder , $filters)
      {
        if($filters['name'] ?? false){
          $builder->where('categories.name' , 'LIKE' , "%{$filters['name']}%");   
      }

      if($filters['status'] ?? false){
        $builder->where('categories.status' , '=' , $filters['status']);   
      } 
   
        
      }

      public function getImageUrlAttribute()
      {
  
  
        if($this->image)
        {
          return asset('uploads/'.$this->image); 
        }
  
        
        if(Str::startsWith($this->image , ['http://' , 'https://']));
          {
            return $this->image;
          }
  
     
  
        if(!$this->image)
        {
          return 'https://app.advaiet.com/item_dfile/default_product.png'  ;
        }
      }
  
  
    
    public static function rules($id =0)
    {
/*
      return   [
            'name'=>[
              'required',
              'string',
              'max:255',
              'min:3',
              'unique:categories,name,$id',
              'filter:php,laravel,html,css',
            ],

            
            'parent_id'=>[
              'nullable',
              'integer',
              'exists:categories,id',
            ],


            'image'=>[
              'mimes:png,jpg,jpeg',
              'image',
            ],

            'status'=>[
              'mimes:png,jpg,jpeg',
              'in:active,archived',
            ],
         
      ];
        
         */ 
    }
  
}