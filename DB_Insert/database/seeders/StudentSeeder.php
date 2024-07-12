<?php

namespace Database\Seeders;

use App\Models\student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for($i=0;$i<10;$i++)
        {
            student::create([
                'name'=>fake()->name(),
                'email'=>fake()->unique()->email()
            ]);
        }



        /* $json = File::get(path:'/database/json/students.json');
            $students=collect(json_decode($json));

            $students->each(function($student)
            {
                student::create([
                    'name'=>$student->name,
                    'email'=>$student->email
                ]);

            }); */
        /*  student::Create([
            'name'=>'Pranta Hossen',
            'email'=>'prantahossen@gmail.com',
            'cgpa'=>3.80
        ]); */
}
}
