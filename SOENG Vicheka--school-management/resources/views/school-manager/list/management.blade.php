<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management</title>
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
            margin-bottom: 24px;
        }

        h1 {
            margin: 0;
            font-size: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .card {
            display: block;
            padding: 20px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            text-decoration: none;
        }

        .card:hover {
            border-color: #2563eb;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
        }

        .card-title {
            display: block;
            margin-bottom: 8px;
            font-size: 18px;
            font-weight: 700;
        }

        .card-count {
            color: #667085;
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
            <h1>School Management</h1>
            <a class="link" href="{{ url('/') }}">Home</a>
        </div>

        <div class="grid">
            @foreach ($pages as $item)
                <a class="card" href="{{ route('list-management.detail', $item['route']) }}">
                    <span class="card-title">{{ $item['title'] }}</span>
                    <span class="card-count">{{ $item['count'] }} records</span>
                </a>
            @endforeach
        </div>
    </main>
</body>
</html>
