<?php

namespace Database\Seeders;

use \App\Models\Book;
use App\Models\Photo;
use \App\Models\Author;
use App\Jobs\ResizePhoto;
use App\Models\Thumbnail;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run()
    {   
        
        $authors = Author::factory(5)->create();
        foreach($authors as $author){
            Book::factory(rand(2, 3))->create(['author_id' => $author->id]);
        }
        $books = Book::all();
        foreach($books as $book){
            Photo::factory(rand(3, 5))->create(['book_id' => $book->id]);
        }
        $photos = Photo::all();
        foreach($photos as $photo){
            ResizePhoto::dispatch($photo);
        }
    }
}
