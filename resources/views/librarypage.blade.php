@extends("main")

@section("content")
  <p class="wishlist-title">Library</p>
  <div class="library-grid">
    @foreach ($games as $game)
        <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
            <div class="searched-game">
                <img src="{{Storage::url($game->url)}}" class="searched-game-poster">
                <p class="library-name">{{$game->name}}</p>
            </div>
        </a>
    @endforeach
  </div>
@endsection
