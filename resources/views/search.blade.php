@extends("main")

@section("content")
  <p class="message">{{$search}}</p>
  <div class="search-result">
    @foreach ($games as $game)
      @if ($game->discount_percent == 0)
        <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
          <div class="searched-game">
            <img src="{{Storage::url($game->url)}}" class="searched-game-poster">
            <p class="featured-game-title">{{$game->name}}</p>
            @if ($game->price != 0)
              <p class="featured-game-price">IDR {{number_format($game->price)}} </p>
            @else
              <p class="featured-game-price">FREE</p>
            @endif
          </div>
        </a>
      @elseif ($game->discount_percent != 0)
        <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
          <div class="searched-game">
            <img src="{{Storage::url($game->url)}}" class="searched-game-poster">
            <p class="featured-game-title">{{ $game->name }}</p>
            <div class="discount-container">
              <div class="discount-prices">
                <p class="searched-game-discounted" style="color: #9a9a9a">IDR {{number_format($game->price)}}</p>
                @if ($game->discounted_price == 0)
                  <p class="searched-game-new-price">FREE</p>
                @else
                    <p class="searched-game-new-price">IDR {{number_format($game->discounted_price)}}</p>
                @endif
              </div>
              <p class="discount-percent">{{$game->discount_percent}}%</p>
            </div>
          </div>
        </a>
      @endif
    @endforeach
    @if ($search == "")
    <div class="pagination">
        {{ $games->links() }}
    </div>
    @endif
  </div>
@endsection
