<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .action-buttons .btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .action-buttons .btn i {
            margin-right: 5px;
        }
        .done-text {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-warning">
        <div class="container-fluid">
            <a class="navbar-brand h1" href="{{ route('posts.index') }}">CRUDPosts</a>
            <div class="justify-end">
                <div class="col">
                    <a class="btn btn-sm btn-success" href="{{ route('posts.create') }}">Add Post</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-sm">
                    <div class="card mb-3">
                        <div class="card-header">
                          <h5 class="card-title {{ $post->is_done ? 'done-text' : '' }}" id="title-{{ $post->id }}">{{ $post->title }}</h5>
                        </div>
                        <div class="card-body">
                          <p class="card-text {{ $post->is_done ? 'done-text' : '' }}" id="body-{{ $post->id }}">{{ $post->body }}</p>
                        </div>
                        <div class="card-footer">
                            <div class="action-buttons">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                                <button data-post-id="{{ $post->id }}" class="btn btn-success btn-sm mark-as-done">
                                    <i class="fas fa-check"></i> Done
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.mark-as-done').on('click', function() {
                var postId = $(this).data('post-id');
                $.ajax({
                    url: '/posts/' + postId + '/done',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#title-' + postId).addClass('done-text');
                            $('#body-' + postId).addClass('done-text');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>