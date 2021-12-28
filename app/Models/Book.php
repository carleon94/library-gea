<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use softDeletes;

    protected $table = 'book';

    protected $fillable = [
        'code' , 'image' , 'title' , 'author' , 'editorial' , 'date' , 'category_book_id' , 'pages' , 'stock'
    ];

    public function category()
    {
        return $this->hasOne(\App\Models\CategoryBook::class , 'id' , 'category_book_id' );
    }

    public function user()
    {
        return $this->belongsToMany(\App\Models\Auth\User::class, 'user_book', 'book_id', 'user_id');
    }
}
