<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChirpController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // se envia a la vista index
        return  view('chirps.index',[
                'chirps'=>Chirp::with('user')->orderBy('created_at','desc')->get()]); //del modelo se obtienen todos los registros de la tabla chirps
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
        //validando campos vacios
       $validated= $request->validate([
            'message'=>['required','min:3','max:255']
        ]);
        $request->user()->chirps()->create($validated);

        //Chirp::create([
        //    'message'=>request('message'), //del campo,del name del input
        //    'user_id' => auth()->id(), //del usuario autenticado
        //]);
        //se envia la palabra para el mensaje de enviado con exito
        //retornar a la ruta
        return to_route('chirps.index')
                ->with('estado','Mensaje creado');

    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {   //si el usuario no es el mismo que el usuario autenticado
        //if(auth()->user()->isNot($chirp->user)){
        //    abort(403);
        //}
        $this->authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {    //si el usuario no es el mismo que el usuario autenticado
        //if(auth()->user()->isNot($chirp->user)){
        //    abort(403);
        //}
      //validando campos vacios
      $this->authorize('update',$chirp);
       $validated= $request->validate([
        'message'=>['required','min:3','max:255']
    ]);
        //realiza el cambio
        $chirp->update($validated);
        return to_route('chirps.index')
                ->with('estado','Mensaje Actualizado');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //autorizamos la eliminacion
        $this->authorize('delete',$chirp);
        $chirp->delete();
        //retorna la vista con el mensaje
        return to_route('chirps.index')
        ->with('estado',('Mensaje Eliminado'));

    }
}
