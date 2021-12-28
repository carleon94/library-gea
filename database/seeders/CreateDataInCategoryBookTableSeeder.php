<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryBook;
use Illuminate\Support\Facades\DB;

class CreateDataInCategoryBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_book')->truncate();
		$categories = [
            'Científico',
            'Aventura',
            'Ciencia Ficción',
            'Deporte',
            'Humor',
            'Marketing',
            'Videojuegos',
            'Historia',
            'Biografía',
            'Novela',
		];

		foreach( $categories as $name ) :
            $category_book = CategoryBook::create( ['name' => $name] );
		endforeach;
    }
}
