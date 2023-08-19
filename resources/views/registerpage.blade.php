<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Register</title>
  <link rel="icon" href="{{asset("images/epic-logo-white.png")}}">
  <link rel="stylesheet" href="{{asset("css/registerpage.css")}}">
</head>
<body>
  <main>
    <img src="{{asset("images/epic-logo-white.png")}}" class="epic-logo">
    <p class="slogan">Sign up to Epic Games</p>
    <form action="{{route("register")}}" method="POST">
      @csrf
      <div>
        {{-- give old value --}}
        <input type="text" class="userf" placeholder="Username" name="username" value="{{ old("username") }}">
        @error('username')
          <p style="color: red; font-size: 0.75vw; margin: 0rem; padding: 0; margin-top: 0.4rem; margin-left: 0.15rem;"> {{$message}}</p>
        @enderror
      </div>
      <div>
          <input type="email" class="emailf" placeholder="Email Address" name="email" value="{{old("email")}}">
        @error('email')
          <p style="color: red; font-size: 0.75vw; margin: 0rem; padding: 0; margin-top: 0.4rem; margin-left: 0.15rem;  "> {{$message}}</p>
        @enderror
      </div>
      <div>
        <input type="password" class="passf" placeholder="Password" name="password" value="{{old("password")}}">
        @error('password')
          <p style="color: red; font-size: 0.75vw; margin: 0rem; padding: 0; margin-top: 0.4rem; margin-left: 0.15rem;  "> {{$message}}</p>
        @enderror
      </div>
      <div>
        <input type="password" class="confirmf" placeholder="Confirm Password" name="confirm_password" value="{{old("confirm_password")}}">
        @error('confirm_password')
          <p style="color: red; font-size: 0.75vw; margin: 0rem; padding: 0; margin-top: 0.4rem; margin-left: 0.15rem;  "> {{$message}}</p>
        @enderror
      </div>
      <input type="submit" value="REGISTER" class="login-button">
    </form>
    <p class="gosignup">Already have an Epic Games Account? <a href="loginpage"><strong>Sign In</strong></a> </p>
  </main>
</body>
</html>
