<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * Returns book list
     * 
     */

    public function index()
    {
        $books = Book::all();

        return $this->successResponse($books);
    }

    /**
     * Returns one instance of book 
     * 
     */

    public function show($book)
    {
        $bookResponse = Book::findOrFail($book);

        return $this->successResponse($bookResponse);
    }

    /**
     * Stores a book
     * 
     */

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);
    }

    /**
     * Returns book list
     * 
     */

    public function update(Request $request, $book)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'max:255',
            'author_id' => 'max:255'
        ];

        $this->validate($request, $rules);

        $bookResponse = Book::findOrFail($book);

        $bookResponse->fill($request->all());

        if ($bookResponse->isClean()) {
            return $this->errorsResponse('at least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->successResponse($bookResponse);
    }

    /**
     * Returns book list
     * 
     */

    public function destroy($book)
    {
        $book = Book::findOrFail($book);

        $book->delete();

        return $this->successResponse($book);
    }
}
