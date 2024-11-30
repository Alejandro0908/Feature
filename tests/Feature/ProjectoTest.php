<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectoTest extends TestCase
{
    use RefreshDatabase; // Asegura que las migraciones se ejecuten antes de cada prueba

/** @test */
public function crear_proyecto()
{
    $this->withoutExceptionHandling();

    // Simular una solicitud post para crear un nuevo proyecto
    $response = $this->post('/proyecto', [
        'nombre' => 'prueba',
        'descripcion' => 'Descripcion_prueba',
    ]);

    // Verificar que la respuesta sea una redirección al proyecto creado
    $proyecto = Proyecto::first();
    $response->assertRedirect("/proyecto/{$proyecto->id}");

    // Verificar que se creó un proyecto en la base de datos
    $this->assertDatabaseCount('proyectos', 1);

    // Verificar que los campos del proyecto coinciden con lo enviado
    $this->assertEquals('prueba', $proyecto->nombre);
    $this->assertEquals('Descripcion_prueba', $proyecto->descripcion);
}

    /** @test */
    public function listar_proyectos()
    {

        $this->withoutExceptionHandling();

        //Creo 2 registro de prueba en la base de datos, especificamente en la tabla proyecto
        Proyecto::factory('3')->create();

        // Metodo HTTP
        $response = $this->get('/proyecto');
        // Verificar que la respuesta sea correcta
        $response->assertOk();

        //verificar que se obtuvieron 10 proyectos
        $proyecto = Proyecto::all();

        //Comparar los valores en la vista
        $response->assertViewIs('proyecto.index');
        //->with('proyectos', $proyecto);

        //$response->assertViewHas('proyectos', $proyecto);

        dd($proyecto);
    }

    /** @test */
    public function actualizar_proyectos()
    {
        // Se utiliza para desactivar el manejo de excepciones de laravel
        $this->withoutExceptionHandling();

        // Creo 1 registro de prueba en la base de datos, especificamente en la tabla proyecto
        $proyecto = Proyecto::factory(1)->create();

        // Metodo HTTP
        $response = $this->put("/proyecto/{$proyecto[0]->id}", [
            'nombre' => 'prueba',
            'descripcion' => 'descripcion_prueba',
        ]);

        $proyecto = Proyecto::findOrFail($proyecto[0]->id);
        // Verifica que los campos del proyecto coinciden con lo enviado
        $this->assertEquals($proyecto->nombre, 'prueba');
        $this->assertEquals($proyecto->descripcion, 'descripcion_prueba');

        $response->assertRedirect("/proyecto/{$proyecto->id}");

        //var_dump($proyecto);
    }

    /** @test */
    public function actualizar_proyectos_rutas()
    {

        $this->withoutExceptionHandling();

        //Creo 1 registro de prueba en la base de datos, especificamente en la tabla proyecto
        $proyecto = Proyecto::factory('1')->create();

        $response = $this->get("/proyecto/{$proyecto[0]->id}");

        $response->assertOk();

        $proyecto = Proyecto::first();


        $response->assertViewIs("proyecto.show");


        //dd($proyecto);
        //var_dump($proyecto);       
    }

    /** @test */
    public function eliminar_proyecto()
    {
        $this->withoutExceptionHandling();

        // Crear un proyecto de prueba en la base de datos
        $proyecto = Proyecto::factory()->create([
            'nombre' => 'Oscar',
            'descripcion' => 'Descripción_Oscar',
        ]);

        // Realizar solicitud DELETE para eliminar el proyecto
        $response = $this->delete('/proyecto/' . $proyecto->id);

        // Verificar que la respuesta sea correcta
        $response->assertOk();

        // Verificar que el proyecto no existe en la base de datos
        $this->assertDatabaseMissing('proyectos', [
            'id' => $proyecto->id,
            'nombre' => 'Oscar',
            'descripcion' => 'Descripción_Oscar',
        ]);
    }

        /** @test */
        public function proyecto_nombre_es_requerido()
        {
            $this->withoutExceptionHandling();

            $response = $this->post('/proyecto', [
                'nombre' => '',
                'descripcion' => 'Descripcion_prueba',
            ]);

            $response->assertSessionHasErrors(['nombre']);



        }


}
