<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryBook extends Model
{
    use softDeletes;

    protected $table = 'category_book';

    protected $fillable = [
        'name'
    ];

    // public function book() 
    // {
    //     return $this->hasMany( \App\Models\Book::class );
    // }
}
