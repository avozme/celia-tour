<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("options")->insert([
                'id'=>'1',
                'key'=>'Meta título',
                'value'=>'Palabras clave para el meta título',
                'type'=>'text'

        ]);

        DB::table("options")->insert([
                'id'=>'2',
                'key'=>'Meta descripción',
                'value'=>'Palabras clave para la meta descripción',
                'type'=>'text'
        ]);

        DB::table("options")->insert([
                'id'=>'3',
                'key'=>'Propietario legal de la web',
                'value'=>'Aquí va el aviso legal',
                'type'=>'textarea'
        ]);

        DB::table("options")->insert([
                'id'=>'4',
                'key'=>'Imagen de icono',
                'value'=>'celia-logo.png',
                'type'=>'file'
        ]);

        DB::table("options")->insert([
                'id'=>'18',
                'key'=>'Imagen de portada',
                'value'=>'celia-vinas.jpg',
                'type'=>'file'
        ]);

        DB::table("options")->insert([
                'id'=>'7',
                'key'=>'Título de la web',
                'value'=>'Este es el título de la web',
                'type'=>'text'

        ]);

        DB::table("options")->insert([
                'id'=>'8',
                'key'=>'Texto visita libre',
                'value'=>'Este es el texto de la visita libre',
                'type'=>'textarea'

        ]);

        DB::table("options")->insert([
                'id'=>'9',
                'key'=>'Texto visita guiada',
                'value'=>'Este es el texto de la visita guiada',
                'type'=>'textarea'

        ]);

        DB::table("options")->insert([
                'id'=>'10',
                'key'=>'Texto puntos destacados',
                'value'=>'Este es el texto de los puntos destacados',
                'type'=>'textarea'

        ]);

        DB::table("options")->insert([
                'id'=>'11',
                'key'=>'Tipo de fuente',
                'value'=>'Spartan',
                'type'=>'list'

        ]);

        DB::table("options")->insert([
                'id'=>'12',
                'key'=>'Color de fuente',
                'value'=>'#000000',
                'type'=>'color'

        ]);

        DB::table("options")->insert([
                'id'=>'13',
                'key'=>'Mostrar botón "Historia"',
                'value'=>'Si',
                'type'=>'boton'

        ]);

        DB::table("options")->insert([
                'id'=>'14',
                'key'=>'Texto panel historia',
                'value'=>'Este es el texto del panel historia',
                'type'=>'textarea'

        ]);

        DB::table("options")->insert([
                'id'=>'15',
                'key'=>'Seleccionar ascensor o mapa',
                'value'=>'Mapa',
                'type'=>'selector'

        ]);

        DB::table("options")->insert([
                'id'=>'16',
                'key'=>'Creditos adicionales de la documentación',
                'value'=>'Aquí van las personas que han ayudado con el celia tour',
                'type'=>'text'

        ]);

        DB::table("options")->insert([
                'id'=>'17',
                'key'=>'Tipo de portada',
                'value'=>'Estatica',
                'type'=>'info'

        ]);
    }
}
