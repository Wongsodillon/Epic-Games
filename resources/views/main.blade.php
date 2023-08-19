<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Epic Games</title>
  <link rel="stylesheet" href="{{asset("css/navbar.css")}}">
  <link rel="stylesheet" href="{{asset("css/homePage.css")}}">
  <link rel="icon" href="{{asset("images/epic-logo-white.png")}}">
  <link rel="stylesheet" href="{{asset("css/gamedetail.css")}}">
  <link rel="stylesheet" href="{{asset("css/search.css")}}">
  <link rel="stylesheet" href="{{asset("css/wishlist.css")}}">
  <link rel="stylesheet" href="{{asset("css/checkout.css")}}">
  <link rel="stylesheet" href="{{asset("css/library.css")}}">
</head>
<body>
  <nav>
  @guest
    <div class="nav-left">
      <a href="/">
        <div>Store</div>
      </a>
      <a href="">
        <div>FAQ</div>
      </a>
      <a href="">
        <div>Help</div>
      </a>
    </div>
    <div class="nav-right">
      <a href="{{route("loginpage")}}">
        <div>Sign In</div>
      </a>
      <a href="{{route("registerpage")}}">
        <div>Sign Up</div>
      </a>
    </div>
  @else
    <div class="nav-left">
      <a href="{{route("home")}}">
        <div>Store</div>
      </a>
      <a href="">
        <div>FAQ</div>
      </a>
      <a href="">
        <div>Help</div>
      </a>
    </div>
    <div class="nav-right">
      <a href="{{route("loginpage")}}">
        <div>{{auth()->user()->username}}</div>
      </a>
      <a href="{{route("main")}}">
        <div>Log Out</div>
      </a>
    </div>
  @endguest
  </nav>
  <main>
      <div class="search-section">
        <div class="search-browse">
          <form action="{{route("search")}}" method="">
            @csrf
            <input type="text" name="search" placeholder="Search games" class="input-container">
          </form>
          <div style="display: flex; gap: 2rem">
            <a href="{{route("home")}}">
              Discover
            </a>
            <a href="{{route("browse")}}">
              Browse
            </a>
          </div>
        </div>
        <div class="wishlib">
          <a href="{{route("wishlistpage")}}">
            Wishlist
          </a>
          <a href="{{route("librarypage")}}">
            Library
          </a>
        </div>
      </div>
      @hasSection("content")
        <div class="content-container">
            @yield("content")
        </div>
      @else
        <a href="{{route("gamedetails", ["id" => $highlight->game_id])}}">
          <div class="featured-container">
            <img src="{{Storage::url($highlight->banner)}}" class="featured-img">
            <div class="highlight-details">
                <img src="{{Storage::url($highlight->logo)}}" class="highlight-logo">
                @if ($highlight->price == 0)
                    <p class="highlight-price" style="font-weight: bold;">FREE</p>
                @elseif ($highlight->discount_percent != 0)
                    <div class="highlight-discounts">
                        <p class="highlight-price disc">IDR {{number_format($highlight->price)}}</p>
                        <p class="highlight-price">IDR {{number_format($highlight->discounted_price)}}</p>
                    </div>
                @else
                    <p class="highlight-price">STARTING AT<strong style="font-size: 1.75rem;">    IDR {{number_format($highlight->discounted_price)}}</strong> </p>
                @endif
                <a href="{{route("gamedetails", ["id" => $highlight->game_id])}}" class="buy-highlight">
                    @if ($highlight->release_date > now())
                        COMING SOON
                    @elseif($highlight->price == 0)
                        PLAY FOR FREE
                    @else
                        BUY NOW
                    @endif
                </a>
            </div>
          </div>
        </a>
        <div class="featured-container">
          <div class="featured-top">
            <p>Featured</p>
            <a href="" class="view-more">View More</a>
          </div>
          <div class="featured-games">
            @foreach ($featuredGames as $game)
              @if ($game->discount_percent == 0)
                <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
                  <div class="featured-game">
                    <img src="{{Storage::url($game->url)}}" class="featured-game-poster">
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
                  <div class="featured-game">
                    <img src="{{Storage::url($game->url)}}" class="featured-game-poster">
                    <p class="featured-game-title">{{ $game->name }}</p>
                    <div class="discount-container">
                      <div class="discount-prices">
                        <p class="featured-game-discounted" style="color: #9a9a9a">IDR {{number_format($game->price)}}</p>
                        @if ($game->discounted_price == 0)
                          <p class="featured-game-new-price">FREE</p>
                        @else
                          <p class="featured-game-new-price">IDR {{number_format($game->discounted_price)}}</p>
                        @endif
                      </div>
                      <p class="discount-percent">{{$game->discount_percent}}%</p>
                    </div>
                  </div>
                </a>
              @endif
            @endforeach
          </div>
        </div>
        <div class="free-container">
          <div class="featured-top">
            <div class="free-games">
              <img src="{{asset("images/free-icon.png")}}" class="free-icon">
              <p>Free Games</p>
            </div>
          </div>
          <div class="free-games">
            @foreach ($currentlyFree as $game)
              <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
                <div class="featured-game">
                  <div class="img-container">
                    <img src="{{Storage::url($game->url)}}" class="featured-game-poster">
                    <div class="free-now">
                      <p>FREE NOW</p>
                    </div>
                  </div>
                    <p class="this-game-title">{{$game->name}}</p>
                    <p class="this-game-is-free">IDR {{number_format($game->price)}}</p>
                </div>
              </a>
            @endforeach
          </div>
        </div>
        <div class="featured-container">
          <div class="featured-top">
            <p>Games on Sale</p>
            <a href="" class="view-more">View More</a>
          </div>
          <div class="featured-games">
            @foreach ($gamesOnSale as $game)
            <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
              <div class="featured-game">
                <img src="{{Storage::url($game->url)}}" class="featured-game-poster">
                <p class="featured-game-title">{{ $game->name }}</p>
                <div class="discount-container">
                  <div class="discount-prices">
                    <p class="featured-game-discounted" style="color: #9a9a9a">IDR {{number_format($game->price)}}</p>
                    @if ($game->discounted_price == 0)
                      <p class="featured-game-new-price">FREE</p>
                    @else
                      <p class="featured-game-new-price">IDR {{number_format($game->discounted_price)}}</p>
                    @endif
                  </div>
                  <p class="discount-percent">{{$game->discount_percent}}%</p>
                </div>
              </div>
            </a>
            @endforeach
          </div>
        </div>
        <div class="categorized">
          <div class="category-games-container">
            <div class="top-section">
              <p>Best Games</p>
              <a href="" class="view-more">View More</a>
            </div>
            @foreach ($bestGames as $game)
              <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
                <div class="game">
                  <img src="{{Storage::url($game->url)}}" class="game-image">
                  <div class="game-info">
                    <p class="game-name">{{$game->name}}</p>
                    @if ($game->price == 0)
                      <p class="game-price">Free</p>
                    @elseif ($game->discount_percent == 0)
                      <p class="game-price">IDR {{number_format($game->price)}}</p>
                    @else
                      <div class="price-list" style="display: flex; gap: 0.6rem; align-items: center">
                        <p class="discounted-list" style=";">-{{$game->discount_percent}}%</p>
                        <p class="featured-game-discounted" style="font-size: 0.87vw">IDR {{number_format($game->price)}}</p>
                        <p class="" style="font-size: 0.87vw">IDR {{number_format($game->discounted_price)}}</p>
                      </div>
                    @endif
                  </div>
                </div>
              </a>
            @endforeach

          </div>
          <div class="category-games-container">
            <div class="top-section">
              <p>Most Played</p>
              <a href="" class="view-more">View More</a>
            </div>
            @foreach ($mostPlayed as $game)
              <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
                <div class="game">
                  <img src="{{Storage::url($game->url)}}" class="game-image">
                  <div class="game-info">
                    <p class="game-name">{{$game->name}}</p>
                    @if ($game->price == 0)
                      <p class="game-price">Free</p>
                    @elseif ($game->discount_percent == 0)
                      <p class="game-price">IDR {{number_format($game->price)}}</p>
                    @else
                      <div class="price-list" style="display: flex; gap: 0.6rem; align-items: center">
                        <p class="discounted-list" style=";">-{{$game->discount_percent}}%</p>
                        <p class="featured-game-discounted" style="font-size: 0.87vw">IDR {{number_format($game->price)}}</p>
                        <p class="" style="font-size: 0.87vw">IDR {{number_format($game->discounted_price)}}</p>
                      </div>
                    @endif
                  </div>
                </div>
              </a>
            @endforeach
          </div>
          <div class="category-games-container">
            <div class="top-section">
              <p>New Releases</p>
              <a href="" class="view-more">View More</a>
            </div>
            @foreach ($newRelease as $game)
              <a href="{{route("gamedetails", ["id" => $game->game_id])}}">
                <div class="game">
                  <img src="{{Storage::url($game->url)}}" class="game-image">
                  <div class="game-info">
                    <p class="game-name">{{$game->name}}</p>
                    @if ($game->price == 0)
                      <p class="game-price">Free</p>
                    @elseif ($game->discount_percent == 0)
                      <p class="game-price">IDR {{number_format($game->price)}}</p>
                    @else
                      <div class="price-list" style="display: flex; gap: 0.6rem; align-items: center">
                        <p class="discounted-list" style=";">-{{$game->discount_percent}}%</p>
                        <p class="featured-game-discounted" style="font-size: 0.87vw">IDR {{number_format($game->price)}}</p>
                        <p class="" style="font-size: 0.87vw">IDR {{number_format($game->discounted_price)}}</p>
                      </div>
                    @endif
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif
  </main>
<script src="{{asset("javascript/main.js")}}"></script>
</body>
</html>
