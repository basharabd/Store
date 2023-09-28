<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class ProductsImport implements ToModel ,WithHeadingRow
{

    protected $categories;
    public function __construct()
    {
        $this->categories = Category::pluck('id' ,'slug')->toArray();

    }

    protected function createCategory($name)
    {
        $category = Category::create([
            'name'=>$name,
            'slug'=>Str::slug($name),

        ]);
        return $category->id;

    }

    protected function getCategoryId($name)
    {

        $slug  = Str::slug($name);
        if(array_key_exists($slug , $this->categories))
        {
            return $this->categories[$slug];

        }

        $id =  $this->createCategory($name);
        $this->categories[$slug] = $id;
        return $id;
    }

    public function model(array $row)
    {
        return new Product([
            'name'     => $row['name'],
            'store_id'    => $row['store'],
            'category_id'    => $this->getCategoryId($row['category']),
            'description' => $row['description'],
            'image' => $row['image'],
            'price' => $row['price'],
            'compare_price' => $row['compare_price'],
            'quantity' => $row['quantity'],


        ]);
    }
}
