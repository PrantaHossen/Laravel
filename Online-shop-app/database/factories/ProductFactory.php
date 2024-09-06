<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name= fake()->unique()->name();
        $slug= Str::slug($name);
        $description= fake()->unique()->text(50);
        $barcode=fake()->ean13();

        $subCategories=[3,5];
        $subCatRandKey= array_rand($subCategories);

        $brands= [8,9,10,11];
        $brandRandKey= array_rand($brands);
        $price= rand(100,10000);
        $compare_price = $price+50;

        return [
            'name'=>$name,
            'slug'=>$slug,
            'description'=>$description,
            'category_id'=>9,
            'sub_category_id'=>$subCategories[$subCatRandKey],
            'brand_id'=>$brands[$brandRandKey],
            'price'=>$price,
            'sku'=>rand(1000,100000),
            'track_qty'=>'Yes',
            'barcode'=>$barcode,
            'compare_price'=>$compare_price,
            'qty'=>rand(15,20),
            'is_featured'=>'Yes',
            'status'=>1

        ];
    }
}
