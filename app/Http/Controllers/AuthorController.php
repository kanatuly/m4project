<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;

class AuthorController extends Controller
{
    public function index(Request $request)
    {   
        $authors = Author::all();
        return view('authors.index', ['authors' => $authors]);
    }

    public function create()
    {
        if (!Auth::check()){
            abort(403);
        }
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'name' => 'required',
        ]);
        $parameters = $request->all();
        $parameters['user_id'] = Auth::id();
        Author::create($parameters);
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
        if (!Auth::check() || Auth::user()->cannot('update', $author)){
            abort(403);
        }
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
        $author = Author::find($id);
        if (!Auth::check() || Auth::user()->cannot('delete', $author)){
            abort(403);
        }
        foreach ($author->books as $book){
            BookController::destroy($book->id);
        }
        
        $author->delete();
        return redirect('/authors');
    }
}
