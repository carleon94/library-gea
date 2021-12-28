<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\CategoryBook;

class BookController extends Controller
{
    public function index( Request $request )
    {
        $book_query = Book::query();
        $book_query->with('category');
        if( $request->has('search') ):
            $array_words = explode(' ', $request->search);
            foreach ( $array_words as $word ) :
                $book_query->where( function( $subquery ) use ( $word ) {
                    $subquery->where('title','like', '%'.$word.'%');
                    $subquery->orWhere('author','like', '%'.$word.'%');
                    $subquery->orWhere('editorial','like', '%'.$word.'%');
                });
            endforeach;
        endif;
        if( $request->has('category_book_id') ):
            $book_query->where( 'category_book_id' , $request->category_book_id );
        endif;
        $book_query->orderBy( 'date' , 'DESC' );
        $book_query->orderBy( 'title' , 'ASC' );
        $books = $book_query->get();

        return response()->json([
            'status' => true,
            'books' => $books,
        ]);
    }

    public function show( $id , Request $request )
    {

    }

    public function create( Request $request )
    {
        $categories = CategoryBook::get();
        return response()->json([
            'status' => true,
            'category' => $categories,
        ]);
    }

    public function store( Request $request )
    {
        $data = $request->only([
            'code', 'title', 'author', 'editorial' , 'date' , 'category_book_id' , 'pages' , 'stock'
        ]);

        $book = Book::create( $data );

        return response()->json([
            'status' => true,
            'book' => $book,
            'message' => [
                'title' => 'Biblioteca',
                'description' => 'Libro creado correctamente',
                'type' => 'success'
            ]
        ]);
    }

    public function update( $id , Request $request )
    {

    }

    public function destroy( $id )
    {
        $book = Book::find($id);
        Book::destroy( $id );

        return response()->json([
            'status' => true,
            'book' => $book,
            'message' => [
                'title' => 'Biblioteca',
                'description' => 'Libro eliminado correctamente',
                'type' => 'success'
            ]
        ]);
    }
}
