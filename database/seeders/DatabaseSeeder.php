<?php

namespace Database\Seeders;

use \App\Models\Book;
use App\Models\Photo;
use \App\Models\Author;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        $authors = Author::factory(7)->create();
        foreach($authors as $author){
            Book::factory(rand(4, 7))->create(['author_id' => $author->id]);
        }
        $books = Book::all();
        foreach($books as $book){
            Photo::factory(rand(1, 5))->create(['book_id' => $book->id]);
        }
    }
}
