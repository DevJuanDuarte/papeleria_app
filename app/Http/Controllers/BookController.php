<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index',[
            'books' => Book::paginate(5)
        ]);
    }

    public function create()
    {
        return Inertia::render('Books/Create',[
            'authors' => Author::all(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|max:13',
            'description' => 'required|max:200',
            'title' => 'required|max:100',
            'publisher' => 'required|max:13',
            'release_date' => 'required|date',
            'pages' => 'required|numeric',
            'image' => 'required|file|mimes:png,jpg,gif',
            //Con esto se llena la tala author_books
            'authors' => 'required|array'
        ]);
        $book = Book::create($request->all());
        if ($request->hasFile('image')) {
            $imgName = microtime(true).'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/img', $imgName);
            $book->image = '/img/'.$imgName;
            $book->save();
        }
        //Con esto se llena la tabla authors_books
        $book->authors()->sync($request->authors);
        return redirect('books/create')->with('success', 'Book Created');
    }


    public function show(Book $book)
    {
        return Inertia::render('Books/Show', [
            'book' => $book, 'authors' => $book->authors
        ]);
    }

    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit',[
            'authors' => Author::all(),
            'book' => $book,
            'authorsOfBook' => $book->authors
        ]);
    }

    public function update(Request $request, Book $book)
    {
        //
    }

    public function updateBook(Request $request){
        $request->validate([
            'isbn' => 'required|max:13',
            'description' => 'required|max:200',
            'title' => 'required|max:100',
            'publisher' => 'required|max:100',
            'release_date' => 'required|date',
            'pages' => 'required|numeric',
            'id' => 'required|numeric',
            //Con esto se llena la tala author_books
            'authors' => 'required|array'
        ]);
        $book = Book::find($request->id);
        $book->update($request->input());
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($book->image);
            $imgName = microtime(true).'.'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/img', $imgName);
            $book->image = '/img/'.$imgName;
            $book->save();
        }
        //Con esto se llena la tabla authors_books
        $book->authors()->sync($request->authors);
        return redirect('books')->with('success', 'Book Updated');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('books')->with('success', 'Book deleted');
    }
}
