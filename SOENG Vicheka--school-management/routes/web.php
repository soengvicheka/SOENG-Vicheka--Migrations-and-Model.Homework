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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

Route::get('/list-management/{page}/create', function (string $page) {
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

    $title = 'Add ' . str($page)->replace('-', ' ')->singular()->title();
    $generations = Generation::latest()->get();
    $students = Student::latest()->get();
    $teachers = Teacher::latest()->get();
    $terms = Term::latest()->get();
    $classes = ClassRoom::latest()->get();
    $subjects = Subject::latest()->get();

    return view('school-manager.list.create', compact(
        'page',
        'title',
        'generations',
        'students',
        'teachers',
        'terms',
        'classes',
        'subjects',
    ));
})->name('list-management.create');

Route::post('/list-management/{page}', function (Request $request, string $page) {
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

    match ($page) {
        'teachers' => Teacher::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'profile' => $request->input('profile'),
            'password' => Hash::make($request->input('password', 'password')),
        ]),
        'students' => Student::create([
            'student_id' => $request->input('student_id'),
            'profile' => $request->input('profile'),
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password', 'password')),
            'province' => $request->input('province'),
            'generation_id' => $request->input('generation_id'),
        ]),
        'generations' => Generation::create([
            'name' => $request->input('name'),
        ]),
        'terms' => Term::create([
            'name' => $request->input('name'),
            'generation_id' => $request->input('generation_id'),
        ]),
        'classes' => ClassRoom::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]),
        'subjects' => Subject::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]),
        'student-classes' => StudentClass::create([
            'student_id' => $request->input('student_id'),
            'class_id' => $request->input('class_id'),
        ]),
        'teacher-class-subjects' => TeacherClassSubject::create([
            'teacher_id' => $request->input('teacher_id'),
            'class_id' => $request->input('class_id'),
            'subject_id' => $request->input('subject_id'),
        ]),
        'add-class-to-terms' => AddClassToTerm::create([
            'term_id' => $request->input('term_id'),
            'class_id' => $request->input('class_id'),
        ]),
    };

    return redirect()->route('list-management.detail', $page);
})->name('list-management.store');

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
