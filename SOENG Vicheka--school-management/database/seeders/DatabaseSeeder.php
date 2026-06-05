<?php

namespace Database\Seeders;

use App\Models\AddClassToTerm;
use App\Models\ClassRoom;
use App\Models\Generation;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClassSubject;
use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $generation = Generation::firstOrCreate([
            'name' => 'Generation 2026',
        ]);

        $term = Term::firstOrCreate([
            'name' => 'Term 1',
            'generation_id' => $generation->id,
        ]);

        $class = ClassRoom::firstOrCreate(
            ['name' => 'Web Development A'],
            ['description' => 'Main class for generation 2026']
        );

        $subject = Subject::firstOrCreate(
            ['name' => 'Laravel'],
            ['description' => 'Laravel migrations and models']
        );

        $teacher = Teacher::firstOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'first_name' => 'Sok',
                'last_name' => 'Dara',
                'phone' => '012345678',
                'profile' => 'teacher-profile.jpg',
                'password' => Hash::make('password'),
            ]
        );

        $student = Student::firstOrCreate(
            ['student_id' => 'STU001'],
            [
                'profile' => 'student-profile.jpg',
                'last_name' => 'Soeng',
                'first_name' => 'Vicheka',
                'gender' => 'Male',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'province' => 'Phnom Penh',
                'generation_id' => $generation->id,
            ]
        );

        StudentClass::firstOrCreate([
            'class_id' => $class->id,
            'student_id' => $student->id,
        ]);

        AddClassToTerm::firstOrCreate([
            'term_id' => $term->id,
            'class_id' => $class->id,
        ]);

        TeacherClassSubject::firstOrCreate([
            'subject_id' => $subject->id,
            'class_id' => $class->id,
            'teacher_id' => $teacher->id,
        ]);
    }
}
