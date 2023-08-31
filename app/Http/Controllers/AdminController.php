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

class AdminController extends Controller
{
    public function adminPage() {
        $games = DB::table("games")->join("genre", "games.genre_id", "=", "genre.genre_id")
        ->orderBy("game_id", "asc")->paginate(10);
        return view("admin.adminpage", compact("games"));
    }
    public function adminSearch(Request $request) {
        $games = Game::join("genre", "games.genre_id", "=", "genre.genre_id")
            ->where("name", "LIKE", "%".$request->search."%")
            ->orWhere("company", "LIKE", $request->search."%")
            ->orWhere("genre_name", "LIKE", $request->search."%")
            ->paginate(10);
        return view("admin.adminpage", compact("games"));
    }
    public function addGamePage() {
        $genres = DB::table("genre")->get();
        return view("admin.addgamepage", compact("genres"));
    }
    public function addGame(Request $request) {
        $rules = [
            "name" => "required|min:3|max:50|unique:games",
            "company" => "required|min:3|max:50",
            "genre" => "required",
            "price" => "required|numeric|min:0",
            "discount" => "required|numeric|min:0|max:100",
            "desc" => "required|min:10|max:1000",
            "release" => "required|date",
            "os" => "required",
            "cpu" => "required",
            "gpu" => "required",
            "ram" => "required|min:0",
            "storage" => "required|min:0",
            "directx" => "required|min:0",
            "game_poster" => "required|mimes:jpeg,png,jpg,gif,svg,avif",
            "game_logo" => "required|mimes:jpeg,png,jpg,gif,svg,avif",
            "game_banner" => "required|mimes:jpeg,png,jpg,gif,svg,avif",
        ];
        $validation = Validator::make($request->all(), $rules);
        if($validation->fails()){
            $errors = $validation->errors();
            return back()->withErrors($validation)->withInput();
        }

        $game_poster = $request->file("game_poster");
        $game_logo = $request->file("game_logo");
        $game_banner = $request->file("game_banner");

        $game_name = $request->name;
        $game_poster_name = $game_name.".".$game_poster->getClientOriginalExtension();
        $game_logo_name = $game_name.".".$game_logo->getClientOriginalExtension();
        $game_banner_name = $game_name.".".$game_banner->getClientOriginalExtension();

        Storage::putFileAs("public/images", $game_poster, $game_poster_name);
        Storage::putFileAs("public/logo", $game_logo, $game_logo_name);
        Storage::putFileAs("public/banner", $game_banner, $game_banner_name);

        $game_poster_url = "images/".$game_poster_name;
        $game_logo_url = "logo/".$game_logo_name;
        $game_banner_url = "banner/".$game_banner_name;

        $data = [
            "name" => $request->name,
            "genre_id" => $request->genre,
            "price" => $request->price,
            "discount_percent" => $request->discount,
            "description" => $request->desc,
            "company" => $request->company,
            "url" => $game_poster_url,
            "logo" => $game_logo_url,
            "banner" => $game_banner_url,
            "release_date" => $request->release,
            "os" => $request->os,
            "cpu" => $request->cpu,
            "gpu" => $request->gpu,
            "ram" => $request->ram,
            "storage" => $request->storage,
            "directx" => $request->directx,
            "downloads" => 0,
            "rating" => 0,
            "created_at" => Carbon::now()->format("Y-m-d H:i:s"),
            "updated_at" => Carbon::now()->format("Y-m-d H:i:s")
        ];
        DB::table("games")->insert($data);
        return redirect()->route("adminpage");
    }
    public function deleteGame($id) {
        $game = Game::find($id);
        DB::table("wishlist")->where("game_id", "=", $id)->delete();
        DB::table("transaction")->where("game_id", "=", $id)->delete();
        $game->delete();
        if (Storage::disk("public")->exists($game->url)) {
            Storage::disk("public")->delete($game->url);
        }
        if (Storage::disk("public")->exists($game->logo)) {
            Storage::disk("public")->delete($game->logo);
        }
        if (Storage::disk("public")->exists($game->banner)) {
            Storage::disk("public")->delete($game->banner);
        }
        return redirect()->route("adminpage");
    }
    public function updateGamePage($id) {
        $game = Game::join("genre", "genre.genre_id", "=", "games.genre_id")
            ->where("game_id", "=", $id)
            ->first();
        $genres = DB::table("genre")->get();
        return view("admin.updategamepage", compact("game", "genres"));
    }
    public function updateGame(Request $request, $id) {
        $rules = [
            "name" => "required|min:3|max:50",
            "company" => "required|min:3|max:50",
            "genre" => "required",
            "price" => "required|numeric|min:0",
            "discount" => "required|numeric|min:0|max:100",
            "desc" => "required|min:10|max:1000",
            "release" => "required|date",
            "os" => "required",
            "cpu" => "required",
            "gpu" => "required",
            "ram" => "required|min:0",
            "storage" => "required|min:0",
            "directx" => "required|min:0",
        ];
        $game = Game::find($id);
        if ($game->name != $request->name) {
            $rules["name"] .= "|unique:games";
        }
        $validation = Validator::make($request->all(), $rules);
        if($validation->fails()){
            $errors = $validation->errors();
            return back()->withErrors($validation)->withInput();
        }
        $game->name = $request->name;
        $game->genre_id = $request->genre;
        $game->price = $request->price;
        $game->discount_percent = $request->discount;
        $game->description = $request->desc;
        $game->company = $request->company;
        $game->release_date = $request->release;
        $game->os = $request->os;
        $game->cpu = $request->cpu;
        $game->gpu = $request->gpu;
        $game->ram = $request->ram;
        $game->storage = $request->storage;
        $game->directx = $request->directx;
        $game->updated_at = Carbon::now()->format("Y-m-d H:i:s");
        $game->save();
        return redirect()->route("adminpage");
    }
}
