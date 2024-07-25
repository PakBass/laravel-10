<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Belajar CRUD Laravel 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .image-style {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body style="background: lightgray">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="image-style">
                            <img src="{{ asset('storage/posts/' . $post->image) }}"
                            alt="gambar" class="rounded text-center"
                            style="width: 50%"; height="100%";>
                        </div>
                        <h4 class="card-title my-3">{{ $post->title }}</h4>
                        <p class="card-text">
                            {!! $post->content !!}
                        </p>
                        <button type="reset" class="btn btn-outline-dark" onclick="goback()">KEMBALI</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function goback() {
            window.history.back();
        }
    </script>
</html>