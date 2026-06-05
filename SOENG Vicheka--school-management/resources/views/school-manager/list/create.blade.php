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
            max-width: 720px;
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

        form {
            display: grid;
            gap: 14px;
            padding: 22px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #ffffff;
        }

        label {
            display: grid;
            gap: 6px;
            font-weight: 700;
        }

        input,
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font: inherit;
        }

        button {
            width: fit-content;
            padding: 10px 16px;
            border: 0;
            border-radius: 6px;
            background: #2563eb;
            color: #ffffff;
            font-weight: 700;
            cursor: pointer;
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
            <h1>{{ $title }}</h1>
            <a class="link" href="{{ route('list-management.detail', $page) }}">Back</a>
        </div>

        <form method="POST" action="{{ route('list-management.store', $page) }}">
            @csrf

            @if ($page === 'teachers')
                <label>First Name <input name="first_name" required></label>
                <label>Last Name <input name="last_name" required></label>
                <label>Email <input type="email" name="email" required></label>
                <label>Phone <input name="phone" required></label>
                <label>Profile <input name="profile"></label>
                <label>Password <input type="password" name="password" required></label>
            @elseif ($page === 'students')
                <label>Student ID <input name="student_id" required></label>
                <label>Profile <input name="profile"></label>
                <label>Last Name <input name="last_name" required></label>
                <label>First Name <input name="first_name" required></label>
                <label>Gender
                    <select name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </label>
                <label>Email <input type="email" name="email" required></label>
                <label>Password <input type="password" name="password" required></label>
                <label>Province <input name="province" required></label>
                <label>Generation
                    <select name="generation_id" required>
                        @foreach ($generations as $generation)
                            <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                        @endforeach
                    </select>
                </label>
            @elseif ($page === 'generations')
                <label>Name <input name="name" required></label>
            @elseif ($page === 'terms')
                <label>Name <input name="name" required></label>
                <label>Generation
                    <select name="generation_id" required>
                        @foreach ($generations as $generation)
                            <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                        @endforeach
                    </select>
                </label>
            @elseif ($page === 'classes')
                <label>Name <input name="name" required></label>
                <label>Description <textarea name="description"></textarea></label>
            @elseif ($page === 'subjects')
                <label>Name <input name="name" required></label>
                <label>Description <textarea name="description"></textarea></label>
            @elseif ($page === 'student-classes')
                <label>Student
                    <select name="student_id" required>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Class
                    <select name="class_id" required>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </label>
            @elseif ($page === 'teacher-class-subjects')
                <label>Teacher
                    <select name="teacher_id" required>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Class
                    <select name="class_id" required>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Subject
                    <select name="subject_id" required>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </label>
            @elseif ($page === 'add-class-to-terms')
                <label>Term
                    <select name="term_id" required>
                        @foreach ($terms as $term)
                            <option value="{{ $term->id }}">{{ $term->name }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Class
                    <select name="class_id" required>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </label>
            @endif

            <button type="submit">Save</button>
        </form>
    </main>
</body>
</html>
