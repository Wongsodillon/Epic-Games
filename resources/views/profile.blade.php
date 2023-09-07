<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Epic Games</title>
    <link rel="icon" href="{{asset("images/epic-logo-white.png")}}">
    <link rel="stylesheet" href="{{asset("css/profile.css")}}">
    <link rel="stylesheet" href="{{asset("css/navbar.css")}}">
    <link rel="stylesheet" href="{{asset("css/payments.css")}}">
    <link rel="stylesheet" href="{{asset("css/transactions.css")}}">
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="{{route("home")}}"><div>Store</div></a>
            <a href=""><div>FAQ</div></a>
            <a href=""><div>Help</div></a>
        </div>
        <div class="nav-right">
            <a href="{{route("profile")}}"><div>{{auth()->user()->username}}</div></a>
            <a href="{{route("main")}}"><div>Log Out</div></a>
        </div>
    </nav>
    <main>
        <div class="sidebar">
            <a href="{{route("profile")}}" class="side-link">
                <div class="side-content ">
                    <p>ACCOUNT SETTINGS</p>
                </div>
            </a>
            <a href="{{route("transactions")}}" class="side-link">
                <div class="side-content">
                    <p>TRANSACTIONS</p>
                </div>
            </a>
        </div>
        <div class="content-container">
            @hasSection("profile-content")
                @yield("profile-content")
            @else
                <div class="content">
                    <div class="section-container">
                        <p class="title">Account Settings</p>
                        <p class="section-info">Manage your account details</p>
                        <p class="section-header">Account Information</p>
                        <p class="account-id"><strong>ID: </strong> {{Auth::user()->user_id}}</p>
                    </div>
                    <form class="dual-form" method="POST" action="{{route("updateprofile")}}">
                        @csrf
                        <div class="form-container">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form" value="{{Auth::user()->username}}" name="username">
                            @error('username')
                            <p class="error-message" style="margin-top: 0.55rem">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                        <div class="form-container">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form" value="{{Auth::user()->email}}" name="email">
                            @error('email')
                            <p class="error-message" style="margin-top: 0.55rem">
                                {{$message}}
                            </p>
                            @enderror
                        </div>
                        <input type="submit" value="SAVE CHANGES" class="save-changes">
                    </form>
                    @if(session('updated'))
                        <div class="alert alert-success">
                            {{ session('updated') }}
                        </div>
                    @endif
                    <div class="section-container">
                        <p class="title">Change Your Password</p>
                        <p class="section-info">For your security, we highly recommend that you choose a unique password that you don't use for any other online account.</p>
                    </div>
                    <form class="passwords" method="POST" action="{{route("updatepassword")}}">
                        @csrf
                        <div class="form-container">
                            <p class="form-label-2">CURRENT PASSWORD</p>
                            <input type="password" class="form-2" value="" name="current_password">
                        </div>
                        @error('current_password')
                        <p class="error-message">
                            {{$message}}
                        </p>
                        @enderror
                        @if(session('error'))
                            <div class="error-message">
                                {{ session("error") }}
                            </div>
                        @endif
                        <div class="form-container">
                            <p class="form-label-2">NEW PASSWORD</p>
                            <input type="password" class="form-2" value="" name="new_password">
                        </div>
                        @error('new_password')
                        <p class="error-message">
                            {{$message}}
                        </p>
                        @enderror
                        <div class="form-container">
                            <p class="form-label-2">RETYPE PASSWORD</p>
                            <input type="password" class="form-2" value="" name="retyped">
                        </div>
                        @error('retyped')
                        <p class="error-message">
                            {{$message}}
                        </p>
                        @enderror
                        <input type="submit" value="SAVE CHANGES" class="save-changes">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            @endif
        </div>
    </main>
<script src="{{asset("javascript/profile.js")}}"></script>
</body>
</html>
