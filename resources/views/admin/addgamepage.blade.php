<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Game</title>
    <link rel="icon" href="{{asset("images/epic-logo-white.png")}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset("css/addgame.css")}}">
</head>
<body>
    <div class="admin-header">
        <div class="header-left">
          <h1>Admin</h1>
          <a href="{{route("adminpage")}}" class="btn btn-primary">Home</a>
          <a href="{{route("addgamepage")}}" class="btn btn-primary">Add Game</a>
        </div>
        <a href="{{route("main")}}" class="btn btn-primary" style="background-color: red; border: none;">Logout</a>
    </div>
    <div class="">
        <h1 class="my-4">Add Game</h1>
        <form action="{{route("addgame")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="" class="form-label">Game Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{ old('name') }}">
            </div>
            @error('name')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Genre</label>
                <select class="form-select" aria-label="Default select example" name="genre">
                    @foreach ($genres as $genre)
                        <option value="{{$genre->genre_id}}">{{$genre->genre_name}}</option>

                    @endforeach
                </select>
            </div>
            @error('genre')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Game Developer</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="company" value="{{ old('company') }}">
            </div>
            @error('company')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Price</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="price" value="{{ old('price')}}">
            </div>
            @error('price')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Discount Percent</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="discount" value="{{ old('discount')}}">
            </div>
            @error('discount')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Description</label>
                <textarea name="desc" cols="30" rows="5" class="form-control">{{old("desc")}}</textarea>
            </div>
            @error('desc')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Release Date</label>
                <input type="date" class="form-control" id="exampleInputEmail1" name="release" value="{{ old('release')}}">
            </div>
            @error('release')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Game Poster</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name="game_poster">
            </div>
            @error('game_poster')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Game Logo</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name="game_logo">
            </div>
            @error('game_logo')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Game Banner</label>
                <input type="file" class="form-control" id="exampleInputEmail1" name="game_banner">
            </div>
            @error('game_banner')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror
            <h2 class="" style="margin-top: 3rem; margin-bottom: 2rem;">Specifications</h2>
            <div class="mb-3">
                <label for="" class="form-label">Operating System</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="os" value="{{ old('os') }}">
            </div>
            @error('os')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Processor</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="cpu" value="{{ old('cpu') }}">
            </div>
            @error('cpu')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Graphics</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="gpu" value="{{ old('gpu') }}">
            </div>
            @error('gpu')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">RAM</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="ram" value="{{ old('ram') }}">
            </div>
            @error('ram')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">Storage</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="storage" value="{{ old('storage') }}">
            </div>
            @error('storage')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <div class="mb-3">
                <label for="" class="form-label">DirectX Version</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="directx" value="{{ old('directx') }}">
            </div>
            @error('directx')
            <div class="alert alert-danger" role="alert">
                {{$message}}
            </div>
            @enderror

            <button type="submit" class="btn btn-primary" style="margin-block: 2rem;">Submit</button>
        </form>
    </div>
</body>
</html>
