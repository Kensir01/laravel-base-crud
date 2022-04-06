<?php

namespace App\Http\Controllers;

use App\comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comics = comic::all();
        return view('comic.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pasta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'thumb'=> 'required|url',
                'title'=> 'required|min:10',
                'type' => 'required|min:5',
                'price' => 'required|numeric|min:0',
            ]
            );
        $data = $request->all();

        $comic = new comic();
        
        $comic->fill($data);

        $comic->save();

        return redirect()->route('comic.index')->with('status', 'Comic aggiunto correttamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comic = Comic::find($id);
      
        if($comic){
 
            return view("comic.show", compact("comic"));
 
        } else {
             abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // forma contratta edit
    public function edit(comic $comics) {
        return view('comic.edit', compact('comics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, comic $comics)
    {
        $request->validate(
            [
                'thumb'=> 'required|url',
                'title'=> 'required|min:10',
                'type' => 'required|min:5',
                'price' => 'required|numeric|min:0',
            ]
        );
        
        $data = $request->all();

        $comics->update($data);
        $comics->save();

        return redirect()->route('comic.show', ['comics' => $comics->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(comic $comics)
    {
        $comics->delete();
        return redirect()->route('comic.index')->with('status', 'Elemento correttamente cancellato!');
    }
}
