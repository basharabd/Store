<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
      'name', 'slug', 'description', 'image', 'category_id', 'store_id',
      'price', 'compare_price', 'status',
  ];

  // hidden column to response json in api

    protected $hidden=[
      'created_at', 'updated_at' , 'deleted_at' , 'image'

    ];

  //  appends Accessosore to response json in api

    protected $appends = [
      'image_url'

    ];

    public function category()
    {
      return $this->belongsTo(Category::class , 'category_id' , 'id')
      ->withDefault();
    }

    public function store()
    {
      return $this->belongsTo(Store::class , 'store_id' ,'id')
      ->withDefault();
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
        $builder->where('products.name' , 'LIKE' , "%{$filters['name']}%");
    }

    if($filters['status'] ?? false){
      $builder->where('products.status' , '=' , $filters['status']);
    }


    }

    public static function booted()
    {
      static::addGlobalScope('store' ,new StoreScope());

      static::creating(function(Product $product)
      {

        $product->slug = Str::slug($product->name);

      });
    }

    //Accessosore

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
      if(! $this->image)
         {
             return  asset('assets/images/logo/logo.svg');
        }

    }

    public function getThumbUrlAttribute()
    {

        if($this->image)
        {
            return route('image' , [
                'uploads' , '265' , '265' ,$this->image

            ]);
        }
        if(Str::startsWith($this->image , ['http://' , 'https://']));
        {
            return $this->image;
        }
        if(! $this->image)
        {
            return  asset('assets/images/logo/logo.svg');
        }

    }



    public function getSalePercentAttribute()
    {
      if(!$this->compare_price)
      {
        return 0;
    }
    return rand(100 - (100 * $this->price  / $this->compare_price) , 2) ;
    }

    public function images()
    {
      return $this->hasMany(ProductImage::class , 'product_id' , 'id');
    }


    //API

    public function scopeFilters(Builder $builder , $filters)
    {
      $options = array_merge([
        'store_id'=>null,
        'category_id'=>null,
        'status'=>'active',
      ] ,$filters );

      $builder->when($options['status'] , function ($query , $status){
        $query->where('status' , $status);

      });



      $builder->when($options['store_id'] , function($builder , $value){
        $builder->where('store_id' , $value);
      });

      $builder->when($options['category_id'] , function($builder , $value){
        $builder->where('category_id' , $value);
      });

    }


}
