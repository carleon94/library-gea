<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CategoryBook;
use JWTAuth;

class RentBookController extends Controller
{
    public function store( Request $request )
    {

        $book = Book::find( $request->book_id );
        // return JWTAuth::user();
        $book->user()->syncWithoutDetaching( $request->user_id );
        $book->stock = $book->stock - 1;
        $book->save();
        
        return response()->json([
            'status' => true,
            'book' => $book,
            'message' => [
                'title' => 'Biblioteca',
                'description' => 'Libro rentado correctamente',
                'type' => 'success'
            ]
        ]);

    }
}
