@extends("main")

@section("content")
  <p class="wishlist-title">Wishlist</p>
  <div class="wishlists">
    @foreach ($wishlist as $game)
      <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
        <div class="wishlist2">
          <img src="{{Storage::url($game->url)}}" class="wishlist-poster">
          <div class="wish-details" >
            <div class="wishlist-header">
              <p class="wishlist-name">{{$game->name}}</p>
              @if ($game->discount_percent == 0)
                @if ($game->price != 0)
                  <p class="wishlist-price">IDR {{number_format($game->price)}}</p>
                @else
                  <p class="wishlist-price">Free</p>
                @endif
              @else
                <div class="wishlist-price-detail">
                  <p class="wishlist-percent">{{$game->discount_percent}}%</p>
                  <p class="wishlist-discounting">IDR {{number_format($game->price)}}</p>
                    @if ($game->discounted_price == 0)
                      <p class="wishlist-new-price">Free</p>
                    @else
                      <p class="wishlist-new-price">IDR {{number_format($game->discounted_price)}}</p>
                    @endif
                </div>
              @endif
              <p class="wishlist-company">{{$game->company}}</p>
            </div>
            <div class="wishlist-buttons">
              <a href="{{route("removefromwishlist", ["id" => $game->game_id])}}" class="remove-wishlist">Remove</a>
              @if ($game->release_date < now())
                <a href="{{route("checkoutpage", ["id" => $game->game_id])}}" class="buy-wishlist">Buy Now</a>
              @else
                <a class="buy-wishlist">Coming Soon</a>
              @endif
            </div>
          </div>
        </div>
      </a>
    @endforeach
  </div>
@endsection
