<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="icon" href="{{asset("images/epic-logo-white.png")}}">
  <link rel="stylesheet" href="{{asset("css/loginpage.css")}}">
</head>
<body>
  <main>
    <img src="{{asset("images/epic-logo-white.png")}}" class="epic-logo">
    <p class="slogan">Sign in with an Epic Games Account</p>
    <form action="{{route("login")}}" method="POST">
      @csrf
      <input type="text" class="emailf" placeholder="Email Address" name="username" value="{{old("username")}}">
      <input type="password" class="passf" placeholder="Password" name="password">
      @if ($errors->any())
        <p style="color: red; margin: 0 0 -1rem 0;">
          {{$errors->first()}}
        </p>
      @endif
      <input type="submit" value="LOG IN" class="login-button">
    </form>
    <p class="gosignup">Don't have an Epic Games Account? <a href="registerpage"><strong>Sign Up</strong></a> </p>
  </main>
</body>
</html>
