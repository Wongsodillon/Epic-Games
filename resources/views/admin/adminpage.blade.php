<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset("css/adminpage.css")}}">
  <link rel="icon" href="{{asset("images/epic-logo-white.png")}}">
</head>
<body>
  <div class="admin-header">
    <div class="header-left">
      <h1>Admin</h1>
      <a href="" class="btn btn-primary">Home</a>
      <a href="{{route("addgamepage")}}" class="btn btn-primary">Add Game</a>
    </div>
    <a href="{{route("main")}}" class="btn btn-primary" style="background-color: red; border: none;">Logout</a>
  </div>
  @hasSection("admincontent")
    @yield("admincontent")
  @else
    <div class="search-browse">
      <form action="{{route("adminsearch")}}" method="">
        @csrf
        <input type="text" name="search" placeholder="Search games" class="input-container">
      </form>
    </div>
    <main>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Game ID</th>
            <th scope="col">Name</th>
            <th scope="col">Company</th>
            <th scope="col">Genre</th>
            <th scope="col">Edit</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($games as $game)
            <tr>
              <td>{{$game->game_id}}</td>
              <td>{{$game->name}}</td>
              <td>{{$game->company}}</td>
              <td>{{$game->genre_name}}</td>
              <td>
                <a href="{{route("updategamepage", $game->game_id)}}" class="btn btn-primary">Edit</a>
                <form action="{{route("deletegame", ["id" => $game->game_id])}}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary" style="background-color: red; border: none; margin-left:1rem;">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </main>
  @endif
</body>
</html>
