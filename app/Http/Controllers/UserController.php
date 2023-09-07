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
    public function profilePage() {
        return view("profile");
    }
    public function paymentPage() {
        return view("payments");
    }
    public function transactionPage() {
        // sort them based of created_at
        $transactions = DB::table("transaction")
            ->join("games", "transaction.game_id", "=", "games.game_id")
            ->selectRaw("transaction.*, games.name")
            ->where("user_id", "=", Auth::user()->user_id)
            ->orderBy("transaction.created_at", "desc")
            ->get();
        return view("transactions", compact("transactions"));
    }
    public function updateProfile(Request $request) {
        $rules = [
            "username" => "required|min:3|max:20",
            "email" => "required|email",
        ];
        if (Auth::user()->username != $request->username) {
            $rules["username"] .= "|unique:users";
        }
        if (Auth::user()->email != $request->email) {
            $rules["email"] .= "|unique:users";
        }
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return back()->withErrors($validation);
        }
        $user = User::find(Auth::user()->user_id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        return back()->with("updated", "Profile updated successfully");
    }
    public function updatePassword(Request $request) {
        $rules = [
            "current_password" => "required",
            "new_password" => "required|min:6|max:20",
            "retyped" => "required|same:new_password"
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return back()->withErrors($validation);
        }
        $user = User::find(Auth::user()->user_id);
        if (password_verify($request->current_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return back()->with("success", "Password updated successfully");
        }
        return back()->with(["error" => "Current password is incorrect"]);
    }
}
