<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        //Esto esta definido en el modelo
        $authors = Author::with('country:id,country', 'books:title')->get();
        return Inertia::render('Authors/Index', [
            'authors' => $authors,
            'countries' => $countries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:80',
            'last_name' => 'required|max:80',
            'country_id' => 'required|numeric',
        ]);
        $author = new Author($request->input());
        $author->save();
        return redirect('authors');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|max:80',
            'last_name' => 'required|max:80',
            'country_id' => 'required|numeric',
        ]);

        $author->update($request->input());
        return redirect('authors');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return redirect('authors');
    }
}
