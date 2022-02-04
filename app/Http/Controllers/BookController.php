<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Photo;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    
    public function index(Request $request)
    {   
        $sort_by = $request->query('sort_by', 'id');
        $order = $request->query('order', 'ASC');
        $books = Book::orderBy($sort_by, $order)->paginate(15);
        return view('books.index', ['books' => $books, 'parameters' => ['id', 'title', 'pages','author_id', 'actions'], 'sort_by' => $sort_by, 'order' => $order]);
    }

    public function create()
    {
        if (!Auth::check()){
            abort(403);
        }
        $authors = Author::where('user_id', Auth::id())->get();
        return view('books.create', ['authors' => $authors]);
    }

    public function store(Request $request)
    {
        $request->validate([
                'title' => 'required',
                'pages' => 'required',
                'author_id' => 'required',
        ]);
        $parameters = $request->all();
        $parameters['user_id'] = Auth::id();
        Book::create($parameters);
        return redirect('/books');
    }

    public function show($id)
    {
        $book = Book::find($id);
        $author = Author::find($book->author_id);
        return view('books.show', ['book' => $book, 'author' => $author]);
    }

    
    public function edit($id)
    {
        $book = Book::find($id);
        if (!Auth::check() || Auth::user()->cannot('update', $book)){
            abort(403);
        }
        $authors = Author::where('user_id', Auth::id())->get();
        return view('books.edit', ['book' => $book, 'authors' => $authors]);
    }

    
    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required',
            'pages' => 'required',
            'author_id' => 'required',
        ]);
        $book = Book::find($id);
        $book->update($request->all());
        return redirect('/books');
    }

    
    public static function destroy($id)
    {
        $book = Book::find($id);
        if (!Auth::check() || Auth::user()->cannot('delete', $book)){
            abort(403);
        }
        $book->delete();
        return redirect('/books');
    }
}
