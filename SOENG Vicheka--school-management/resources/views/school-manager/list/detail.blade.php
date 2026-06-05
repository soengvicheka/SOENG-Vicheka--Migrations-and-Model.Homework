<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
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

        .links {
            display: flex;
            gap: 12px;
        }

        .link {
            color: #2563eb;
            text-decoration: none;
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

        .badge {
            display: inline-block;
            margin: 2px;
            padding: 4px 8px;
            border-radius: 999px;
            background: #e8f2ff;
            color: #1d4f8f;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <main class="page">
        <div class="header">
            <h1>{{ $title }}</h1>
            <div class="links">
                <a class="link" href="{{ route('list-management') }}">Back</a>
                <a class="link" href="{{ url('/') }}">Home</a>
            </div>
        </div>

        <div class="table-wrap">
            @if ($data->isEmpty())
                <div class="empty">No records found yet.</div>
            @elseif ($page === 'teachers')
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
                        @foreach ($data as $teacher)
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
            @elseif ($page === 'students')
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
                        @foreach ($data as $student)
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
            @elseif ($page === 'generations')
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
                        @foreach ($data as $generation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $generation->name }}</td>
                                <td>{{ $generation->students->count() }}</td>
                                <td>{{ $generation->terms->pluck('name')->join(', ') ?: 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif ($page === 'terms')
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
                        @foreach ($data as $term)
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
            @elseif ($page === 'classes')
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
                        @foreach ($data as $class)
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
            @elseif ($page === 'subjects')
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
                        @foreach ($data as $subject)
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
            @elseif ($page === 'student-classes')
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $studentClass)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $studentClass->student?->first_name ?? 'N/A' }} {{ $studentClass->student?->last_name }}</td>
                                <td>{{ $studentClass->classRoom?->name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif ($page === 'teacher-class-subjects')
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
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->teacher?->first_name ?? 'N/A' }} {{ $item->teacher?->last_name }}</td>
                                <td>{{ $item->classRoom?->name ?? 'N/A' }}</td>
                                <td>{{ $item->subject?->name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif ($page === 'add-class-to-terms')
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Term</th>
                            <th>Class</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
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
    </main>
</body>
</html>
