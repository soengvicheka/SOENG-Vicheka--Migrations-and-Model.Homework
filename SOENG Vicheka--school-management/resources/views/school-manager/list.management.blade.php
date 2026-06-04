<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= <div class="container">
            <a href="{{route('categories.create')}}" class="btn btn-info">Create+</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Class</th>
                    <th>BOD</th>
                    <th>Sex</th>
                    <th>Place Of birth</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $index => $category)
                    <tr>
                        <td>{{ $firstname->first_name}}</td>
                        <td>{{ $lastname->last_name }}</td>
                        <td>{{ $class->clsses}}</td>
                        <td>{{ $BOD->birthday}}</td>
                        <td>{{ $class->clsses}}</td>
                        <td>{{ $Place of birth ->POB}}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <a href="" data-bs-toggle="modal" data-bs-target="#category{{ $category->id }}">
                               <i class="fa-sharp fa-solid fa-eye"></i>
                            </a>
                            |
                           <a href="{{route('categories.edit', $category->id)}}">
                                <i class="fa-solid fa-pen-to-square"></i>
                           </a>|
                           <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0"
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                           </form>

                            <!-- Modal -->
                            <div class="modal fade" id="category{{ $category->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ $category->category_name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $category->description }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>