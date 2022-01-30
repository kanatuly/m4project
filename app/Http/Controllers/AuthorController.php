<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', ['authors' => $authors]);
    }

     public function create()
     {
        
         return view('authors.create');
     }

    public function store(Request $request)
    {
        
        $request->validate([
                'name' => 'required',
        ]);
        Author::create($request->all());
        return redirect('/authors');
    }

    public function show($id)
    {
        $author = Author::find($id);
        return view('authors.show', ['author' => $author]);
    }

    
    public function edit($id)
    {
        $author = Author::find($id);
        return view('authors.edit', ['author' => $author]);
    }

    
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $author = Author::find($id);
        $author->update($request->all());
        return redirect('/authors');
    }

    
    public function destroy($id)
    {
        $author = Author::find($id);
        
        foreach ($author->books as $book){
            BookController::destroy($book->id);
        }
        
        $author->delete();
        return redirect('/authors');
    }
}
