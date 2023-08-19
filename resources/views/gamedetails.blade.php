@extends("main")

@section("content")
  <p class="game-title">{{$game->name}}</p>
  <div class="main-detail">
    <div class="detail-content">
      <img src="{{Storage::url($game->banner)}}" class="banner">
      <p class="description">{{$game->description}}</p>
      <div class="genre-rating">
        <div class="genre">
          <p class="type">Genre</p>
          <p class="type-name">{{$game->genre_name}}</p>
        </div>
        <div class="rating">
          <p class="type">Rating</p>
          <p class="type-name">{{$game->rating}} / 5</p>
        </div>
      </div>
      <p class="specifications">Specifications</p>
      <div class="spec-container">
        <div class="windows-container">
          <p class="windows">WINDOWS</p>
        </div>
        <div class="spec-info">
          <p class="minimum">Minimum</p>
          <div class="spec-details">
            <p class="spec-type">OS</p>
            <p class="spec-type-name">{{$game->os}}</p>
          </div>
          <div class="spec-details">
            <p class="spec-type">Processor</p>
            <p class="spec-type-name">{{$game->cpu}}</p>
          </div>
          <div class="spec-details">
            <p class="spec-type">Memory</p>
            <p class="spec-type-name">{{$game->ram}} GB</p>
          </div>
          <div class="spec-details">
            <p class="spec-type">Storage</p>
            <p class="spec-type-name">{{$game->storage}} GB</p>
          </div>
          <div class="spec-details">
            <p class="spec-type">Graphics</p>
            <p class="spec-type-name">{{$game->gpu}}</p>
          </div>
          <div class="spec-details">
            <p class="spec-type">DirectX</p>
            <p class="spec-type-name">Version {{$game->directx}}</p>
          </div>
        </div>
      </div>
    </div>
    <aside class="detail-right">
      <div class="logo-container">
        <img src="{{Storage::url($game->logo)}}" class="game-logo">
      </div>
      @if ($game->price == 0)
        <p>Free</p>
      @elseif ($game->discount_percent == 0)
        <p>IDR {{number_format($game->price)}}</p>
      @elseif ($game->discount_percent > 0)
        <div class="price-list" style="display: flex; gap: 0.6rem; align-items: center">
          <p class="discounted-list" style="padding-inline: 0.7rem;">-{{$game->discount_percent}}%</p>
          <p class="featured-game-discounted" style="font-size: 1.2vw; color: #d1d1d1">IDR {{number_format($game->price)}}</p>
          @if($game->discount_percent == 100)
            <p class="" style="font-size: 1.2vw;">Free</p>
          @else
            <p class="" style="font-size: 1.2vw">IDR {{number_format($game->discounted_price)}}</p>
          @endif
        </div>
      @endif

      @if ($owned == null)
        <a href="{{route("checkoutpage", ["id" => $game->game_id])}}" class="buynow aside-button">
            <div><p>BUY NOW</p></div>
        </a>
        @if ($wishlist == null)
            <a href="{{route("addtowishlist", ["id" => $game->game_id])}}" class= "wishlist aside-button">
                <div>
                    <p>ADD TO WISHLIST</p>
                </div>
            </a>
        @else
            <a href="{{route("removefromwishlist", ["id" => $game->game_id])}}" class="wishlist-added wishlist aside-button">
                <div>
                    <p>ADDED TO WISHLIST</p>
                </div>
            </a>
        @endif
      @else
        <a class="buynow aside-button">
            <div><p>IN LIBRARY</p></div>
        </a>
      @endif

      <div class="more">
        <div class="more-game-details">
          <p class="type">Refund Type</p>
          <p>Earn 5% Back</p>
        </div>
        <div class="more-game-details">
          <p class="type">Developer</p>
          <p>{{$game->company}}</p>
        </div>
        <div class="more-game-details">
          <p class="type">Release Date</p>
          <p>{{$game->release_date}}</p>
        </div>
        <div class="more-game-details">
          <p class="type">Platform</p>
          <p>Windows</p>
        </div>
      </div>
    </aside>
  </div>
@endsection
