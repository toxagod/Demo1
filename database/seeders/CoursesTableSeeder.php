<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Курс1',
                'description' => 'Описание1'
            ],
            [
                'name' => 'Курс2',
                'description' => 'Описание2'
            ],
            [
                'name' => 'Курс3',
                'description' => 'Описание3'
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
