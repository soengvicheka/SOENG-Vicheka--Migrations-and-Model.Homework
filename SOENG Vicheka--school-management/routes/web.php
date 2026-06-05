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
    $pages = [
        ['title' => 'Teachers', 'route' => 'teachers', 'count' => Teacher::count()],
        ['title' => 'Students', 'route' => 'students', 'count' => Student::count()],
        ['title' => 'Generations', 'route' => 'generations', 'count' => Generation::count()],
        ['title' => 'Terms', 'route' => 'terms', 'count' => Term::count()],
        ['title' => 'Classes', 'route' => 'classes', 'count' => ClassRoom::count()],
        ['title' => 'Subjects', 'route' => 'subjects', 'count' => Subject::count()],
        ['title' => 'Student Classes', 'route' => 'student-classes', 'count' => StudentClass::count()],
        ['title' => 'Teacher Class Subjects', 'route' => 'teacher-class-subjects', 'count' => TeacherClassSubject::count()],
        ['title' => 'Add Class To Terms', 'route' => 'add-class-to-terms', 'count' => AddClassToTerm::count()],
    ];

    return view('school-manager.list.management', compact('pages'));
})->name('list-management');

Route::get('/list-management/{page}', function (string $page) {
    abort_unless(in_array($page, [
        'teachers',
        'students',
        'generations',
        'terms',
        'classes',
        'subjects',
        'student-classes',
        'teacher-class-subjects',
        'add-class-to-terms',
    ], true), 404);

    $data = match ($page) {
        'teachers' => Teacher::with('teacherClassSubjects.classRoom', 'teacherClassSubjects.subject')->latest()->get(),
        'students' => Student::with(['generation', 'studentClasses.classRoom'])->latest()->get(),
        'generations' => Generation::with(['students', 'terms'])->latest()->get(),
        'terms' => Term::with(['generation', 'addClassToTerms.classRoom'])->latest()->get(),
        'classes' => ClassRoom::with(['studentClasses.student', 'teacherClassSubjects.teacher', 'addClassToTerms.term'])->latest()->get(),
        'subjects' => Subject::with('teacherClassSubjects.teacher', 'teacherClassSubjects.classRoom')->latest()->get(),
        'student-classes' => StudentClass::with(['student', 'classRoom'])->latest()->get(),
        'teacher-class-subjects' => TeacherClassSubject::with(['teacher', 'classRoom', 'subject'])->latest()->get(),
        'add-class-to-terms' => AddClassToTerm::with(['term', 'classRoom'])->latest()->get(),
    };

    $title = str($page)->replace('-', ' ')->title();

    return view('school-manager.list.detail', compact('page', 'title', 'data'));
})->name('list-management.detail');
