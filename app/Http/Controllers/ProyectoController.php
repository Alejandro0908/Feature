<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{

    //Metodo para crear los registros proyectos
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => 'required|string|max:100|min:5',
            "descripcion" => 'required|string|max:100|min:5',
        ]);


        //Valido y creo el nuevo registro en la tabla proyecto
        //$proyecto = Proyecto::create($request->only('nombre', 'descripcion'));
        $proyecto = Proyecto::create($request->all());

        //redirecccion
        return redirect("/proyecto/{$proyecto->id}");




        return response()->json(['message' => 'Proyecto creado con éxito'], 200);
    }

    //Metodo para obtener los registros de la tabla proyecto
    public function index()
    {
        //Obtengo todos los proyectos creados
        $proyecto = Proyecto::all();
        //Retornar la vista en 'proyecto.index'
        return view('proyecto.index', compact('proyecto'));
    }

   // Metodo para actualizar un registro
   public function update(Request $request, Proyecto $proyecto){
    // Obtengo todos los proyectos creados
    $proyecto->update($request->all());

    return redirect()->route('proyecto.index')->with('success', 'Proyecto actualizado correctamente');

   
}

    //Método para editar los registros de la tabla proyecto
    public function show(Proyecto $proyecto)
    {
        return view('proyecto.show', compact('proyecto'));
    }

    // Método para eliminar un registro de la base temporal
    public function destroy(Proyecto $proyecto)
    {
        // Eliminar el proyecto
        $proyecto->delete();

        // Responder confirmación de eliminación
        return response()->json(['message' => 'Proyecto eliminado con éxito'], 200);
    }

    
}
