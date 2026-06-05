<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management List</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #1f2937;
        }

        .page {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        .section {
            margin-bottom: 28px;
        }

        h2 {
            margin: 0 0 12px;
            font-size: 20px;
        }

        .table-wrap {
            overflow-x: auto;
            background: #ffffff;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        th,
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5eaf0;
            text-align: left;
        }

        th {
            background: #eef3f7;
            font-size: 13px;
            text-transform: uppercase;
            color: #4b5563;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        .empty {
            padding: 28px;
            text-align: center;
            color: #667085;
        }

        .classes {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 999px;
            background: #e8f2ff;
            color: #1d4f8f;
            font-size: 13px;
        }

        .link {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <main class="page">
        <div class="header">
            <h1>School Management Data</h1>
            <a class="link" href="{{ url('/') }}">Home</a>
        </div>

        <section class="section">
            <h2>Teachers</h2>
            <div class="table-wrap">
                @if ($teachers->isEmpty())
                    <div class="empty">No teachers found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Profile</th>
                                <th>Classes / Subjects</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>{{ $teacher->profile ?? 'N/A' }}</td>
                                    <td>
                                        @forelse ($teacher->teacherClassSubjects as $item)
                                            <span class="badge">{{ $item->classRoom?->name ?? 'N/A' }} - {{ $item->subject?->name ?? 'N/A' }}</span>
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Students</h2>
            <div class="table-wrap">
                @if ($students->isEmpty())
                    <div class="empty">No students found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Province</th>
                                <th>Generation</th>
                                <th>Classes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->student_id }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->province }}</td>
                                    <td>{{ $student->generation?->name ?? 'N/A' }}</td>
                                    <td>
                                        @forelse ($student->studentClasses as $studentClass)
                                            <span class="badge">{{ $studentClass->classRoom?->name ?? 'N/A' }}</span>
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Generations</h2>
            <div class="table-wrap">
                @if ($generations->isEmpty())
                    <div class="empty">No generations found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Students</th>
                                <th>Terms</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generations as $generation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $generation->name }}</td>
                                    <td>{{ $generation->students->count() }}</td>
                                    <td>{{ $generation->terms->pluck('name')->join(', ') ?: 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Terms</h2>
            <div class="table-wrap">
                @if ($terms->isEmpty())
                    <div class="empty">No terms found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Generation</th>
                                <th>Classes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($terms as $term)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $term->name }}</td>
                                    <td>{{ $term->generation?->name ?? 'N/A' }}</td>
                                    <td>
                                        @forelse ($term->addClassToTerms as $item)
                                            <span class="badge">{{ $item->classRoom?->name ?? 'N/A' }}</span>
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Classes</h2>
            <div class="table-wrap">
                @if ($classes->isEmpty())
                    <div class="empty">No classes found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Students</th>
                                <th>Teachers</th>
                                <th>Terms</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $class)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->description ?? 'N/A' }}</td>
                                    <td>{{ $class->studentClasses->pluck('student.first_name')->filter()->join(', ') ?: 'N/A' }}</td>
                                    <td>{{ $class->teacherClassSubjects->pluck('teacher.first_name')->filter()->join(', ') ?: 'N/A' }}</td>
                                    <td>{{ $class->addClassToTerms->pluck('term.name')->filter()->join(', ') ?: 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Subjects</h2>
            <div class="table-wrap">
                @if ($subjects->isEmpty())
                    <div class="empty">No subjects found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Teachers / Classes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->description ?? 'N/A' }}</td>
                                    <td>
                                        @forelse ($subject->teacherClassSubjects as $item)
                                            <span class="badge">{{ $item->teacher?->first_name ?? 'N/A' }} - {{ $item->classRoom?->name ?? 'N/A' }}</span>
                                        @empty
                                            N/A
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Student Classes</h2>
            <div class="table-wrap">
                @if ($studentClasses->isEmpty())
                    <div class="empty">No student class records found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentClasses as $studentClass)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $studentClass->student?->first_name ?? 'N/A' }} {{ $studentClass->student?->last_name }}</td>
                                    <td>{{ $studentClass->classRoom?->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Teacher Class Subjects</h2>
            <div class="table-wrap">
                @if ($teacherClassSubjects->isEmpty())
                    <div class="empty">No teacher class subject records found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Teacher</th>
                                <th>Class</th>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teacherClassSubjects as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->teacher?->first_name ?? 'N/A' }} {{ $item->teacher?->last_name }}</td>
                                    <td>{{ $item->classRoom?->name ?? 'N/A' }}</td>
                                    <td>{{ $item->subject?->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>

        <section class="section">
            <h2>Add Class To Terms</h2>
            <div class="table-wrap">
                @if ($addClassToTerms->isEmpty())
                    <div class="empty">No class term records found yet.</div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Term</th>
                                <th>Class</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addClassToTerms as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->term?->name ?? 'N/A' }}</td>
                                    <td>{{ $item->classRoom?->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </section>
    </main>
</body>
</html>
