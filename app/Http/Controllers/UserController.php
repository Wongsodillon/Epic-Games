<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Game;

class UserController extends Controller
{
    public function login(Request $request) {
        $request->setMethod('POST');
        // dd($request);
        $credential = ["username" => $request->username, "password" => $request->password];
        if (Auth::attempt($credential)) {
            if (Auth::user()->role == "admin") {
                // dd($request->all());
                return redirect()->route("adminpage");
            }
            return redirect()->route("home");
        }
        return back()->withErrors(["error" => "Username or password is incorrect"])->withInput();
    }
    public function loginPage() {
        return view("loginpage");
    }
    public function register(Request $request) {
        $rules = [
            "username" => "required|min:3|max:20|unique:users",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|max:20",
            "confirm_password" => "required|same:password"
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return back()->withErrors($validation);
        }
        $data = [
            "username" => $request->username,
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "balance" => 0,
            "role" => "user",
            "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
        ];
        DB::table("users")->insert($data);
        return redirect()->route("loginpage");
    }
    public function registerPage() {
        return view("registerpage");
    }
    public function adminPage() {
        $games = DB::table("games")->join("genre", "games.genre_id", "=", "genre.genre_id")
        ->orderBy("game_id", "asc")->get();
        return view("admin.adminpage", compact("games"));
    }
    public function adminSearch(Request $request) {
        $games = Game::join("genre", "games.genre_id", "=", "genre.genre_id")
            ->where("name", "LIKE", "%".$request->search."%")
            ->orWhere("company", "LIKE", $request->search."%")
            ->orWhere("genre_name", "LIKE", $request->search."%")
            ->get();
        return view("admin.adminpage", compact("games"));
    }
}
