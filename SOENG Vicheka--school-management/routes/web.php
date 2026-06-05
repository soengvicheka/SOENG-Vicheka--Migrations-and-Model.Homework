<?php

use Illuminate\Support\Facades\Route;
use App\Models\AddClassToTerm;
use App\Models\ClassRoom;
use App\Models\Generation;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClassSubject;
use App\Models\Term;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list-management', function () {
    $generations = Generation::with(['students', 'terms'])->latest()->get();
    $teachers = Teacher::with('teacherClassSubjects.classRoom', 'teacherClassSubjects.subject')->latest()->get();
    $students = Student::with(['generation', 'studentClasses.classRoom'])
        ->latest()
        ->get();
    $terms = Term::with(['generation', 'addClassToTerms.classRoom'])->latest()->get();
    $classes = ClassRoom::with(['studentClasses.student', 'teacherClassSubjects.teacher', 'addClassToTerms.term'])->latest()->get();
    $subjects = Subject::with('teacherClassSubjects.teacher', 'teacherClassSubjects.classRoom')->latest()->get();
    $studentClasses = StudentClass::with(['student', 'classRoom'])->latest()->get();
    $teacherClassSubjects = TeacherClassSubject::with(['teacher', 'classRoom', 'subject'])->latest()->get();
    $addClassToTerms = AddClassToTerm::with(['term', 'classRoom'])->latest()->get();

    return view('school-manager.list.management', compact(
        'generations',
        'teachers',
        'students',
        'terms',
        'classes',
        'subjects',
        'studentClasses',
        'teacherClassSubjects',
        'addClassToTerms',
    ));
})->name('list-management');
