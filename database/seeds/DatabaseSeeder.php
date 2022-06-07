<?php

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
        factory(\App\User::class)->create(
        [
        'name'=>'admin',
        'surname' =>'admin',    
        'email'=>'admin@admin.com',
        'password'=>bcrypt('12345678'),
        'dni'=>'7664779Q',
        ]);
    
        factory(\App\Alumnos::class, 20)->create();
        factory(\App\Autorizados::class, 20)->create();
        
    }
}
