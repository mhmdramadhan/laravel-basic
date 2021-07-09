<?php

use App\Model\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect(['Framework', 'Code', 'CSS', 'Laravel', 'PHP', 'IOT']);
        $categories->each(function ($c){
            Category::create([
                'name' => $c,
                'slug' => \Str::slug($c),
            ]);
        });
    }
}
