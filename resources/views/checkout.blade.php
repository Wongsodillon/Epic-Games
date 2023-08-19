@extends("main")

@section("content")
  <div class="checkout-page">
    <div class="payment-methods">
      <div class="checkout-top">
        <div class="checkout-title">
          <p>CHECKOUT</p>
        </div>
        <div class="user-checkout">
          <p>{{Auth::user()->username}}</p>
        </div>
      </div>
    </div>
    <div class="order-details">
      <p class="order-title">ORDER SUMMARY</p>
      <div class="order-game-container">
        <img src="{{Storage::url($game->url)}}" class="order-image">
        <div class="order-detail">
          <p class="order-name">{{$game->name}}</p>
          <p class="order-company">{{$game->company}}</p>
        </div>
      </div>
      <div class="price-calc">
        <div class="order-price-detail">
          <p class="order-price-title">Price</p>
          <p class="order-price-value">IDR {{number_format($game->price)}}</p>
        </div>
        <div class="order-price-detail">
          <p class="order-discount-title">Discount</p>
          <p class="order-discount-value">{{$game->discount_percent}}%</p>
        </div>
      </div>
      <div class="order-price-totalling">
        <p class="order-price-title">Total</p>
        <p class="order-price-total">IDR {{number_format($game->discounted_price)}}</p>
      </div>
      <form action="{{route("addtolibrary", ["id" => $game->game_id])}}" method="POST" class="agreetnc">
        @csrf
        @error("agree")
            <p style="color: red; font-size: 1vw; margin: 0rem; padding: 0; margin-top: 0.4rem; margin-left: 0.15rem;"> {{$message}}</p>
        @enderror
        <label for="">
          <input type="checkbox" class="checkbox" name="agree">
          Click here to agree to share your email with <strong>{{$game->company}}. {{$game->company}}</strong> will use your email address for marketing and otherwise in accordance with its privacy policy, so we encourage you to read it
        </label>
        <input type="submit" class="place-order" value="PLACE ORDER">
      </form>
    </div>
  </div>
@endsection
