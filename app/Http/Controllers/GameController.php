<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function getFeaturedGames() {
        $featuredGames = [];
        if (!Session::get('randomizeFeatured')) {
            $featuredGames = DB::table("games")
                ->inRandomOrder()
                ->where("downloads", ">", "0")
                ->where("discount_percent", "<", "100")
                ->limit(5)
                ->select("*",
                    DB::raw("CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
                )->get();
            Session::put('randomizeFeatured', true);
            Session::put("featuredGames", $featuredGames);
        } else {
            $featuredGames = Session::get("featuredGames");
        }
        return $featuredGames;
    }
    public function getFreeGames() {
        $currentlyFree = DB::table("games")->where("discount_percent", 100)->limit(4)->get();
        return $currentlyFree;
    }
    public function getGamesOnSale() {
        $gamesOnSale = [];
        if (!Session::get("randomizeSale")) {
            $gamesOnSale = DB::table("games")
                ->inRandomOrder()
                ->where("discount_percent", ">", 49)
                ->where("discount_percent", "<", 100)
                ->limit(5)
                ->select("*",
                    DB::raw("CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
                )->get();
            Session::put('randomizeSale', true);
            Session::put("gamesOnSale", $gamesOnSale);
        } else {
            $gamesOnSale = Session::get("gamesOnSale");
        }
        return $gamesOnSale;
    }
    public function getBestGames() {
        $bestGames = Game::selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->orderBy("rating", "desc")
            ->limit(5)->get();
        return $bestGames;
    }
    public function getMostPlayed() {
        $mostPlayed = Game::selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->orderBy("downloads", "desc")
            ->limit(5)->get();
        return $mostPlayed;
    }
    public function getNewRelease() {
        $newRelease = Game::selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->orderBy("release_date", "desc")
            ->orderBy("rating", "desc")
            ->where("downloads", ">", "0")
            ->limit(5)->get();
        return $newRelease;
    }
    public function getHighlights() {
        $games = [11,15,18,24,21,35,36,28,33,45,40,43,42,52,53];
        $highlight = Game::selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->inRandomOrder()
            ->whereIn("game_id", $games)
            ->first();
        return $highlight;
    }
    public function guestPage() {
        Auth::logout();
        Session::put("randomizeFeatured", false);
        Session::put("randomizeSale", false);
        $featuredGames = $this->getFeaturedGames();
        $currentlyFree = $this->getFreeGames();
        $gamesOnSale = $this->getGamesOnSale();
        $bestGames = $this->getBestGames();
        $mostPlayed = $this->getMostPlayed();
        $newRelease = $this->getNewRelease();
        $highlight = $this->getHighlights();
        return view("main", compact("featuredGames", "currentlyFree", "gamesOnSale", "bestGames", "mostPlayed", "newRelease", "highlight"));
    }
    public function logout() {
        Auth::logout();
        return redirect()->route("home");
    }
    public function userPage() {
        $user = Auth::user();
        $featuredGames = $this->getFeaturedGames();
        $currentlyFree = $this->getFreeGames();
        $gamesOnSale = $this->getGamesOnSale();
        $bestGames = $this->getBestGames();
        $mostPlayed = $this->getMostPlayed();
        $newRelease = $this->getNewRelease();
        $highlight = $this->getHighlights();
        return view("main", compact("user", "featuredGames", "currentlyFree", "gamesOnSale", "bestGames", "mostPlayed", "newRelease", "highlight"));
    }
    public function gameDetails($id) {
        $game = Game::join("genre", "games.genre_id", "=", "genre.genre_id")
            ->selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->where("game_id", "=",$id)
            ->first();
        // check if user has added to wishlist
        $wishlist = DB::table("wishlist")
            ->where("user_id", "=", Auth::user()->user_id)
            ->where("game_id", "=", $id)->first();
        $owned = DB::table("transaction")
            ->where("user_id", "=", Auth::user()->user_id)
            ->where("game_id", "=", $id)->first();
        return view("gamedetails", compact("game", "wishlist", "owned"));
    }
    public function search(Request $request) {
        if ($request->search == null) {
            return redirect()->route("home");
        }
        $games = Game::selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
        ->where("name", "LIKE", "%".$request->search."%")
        ->orWhere("company", "LIKE", $request->search."%")->get();
        $search = "Result for: ".$request->search;
        return view("search", compact("games", "search"));
    }
    public function browse()
    {
        $games = Game::selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->orderBy("name", "asc")
            ->paginate(8);
        $search = "";
        return view("search", compact("games", "search"));
    }
    public function wishlistPage() {
        $wishlist = Game::join("wishlist", "games.game_id", "=", "wishlist.game_id")
            ->selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->where("user_id", "=", Auth::user()->user_id)
            ->get();
        return view("wishlistpage", compact("wishlist"));
    }
    public function addToWishlist($game_id) {
        $user_id = Auth::user()->user_id;
        DB::table("wishlist")->insert([
            "user_id" => $user_id,
            "game_id" => $game_id,
            "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        return redirect()->back();
    }
    public function removeFromWishlist($game_id) {
        $user_id = Auth::user()->user_id;
        DB::table("wishlist")
            ->where("user_id", "=", $user_id)
            ->where("game_id", "=", $game_id)
            ->delete();
        return back();
    }
    public function checkoutPage($game_id) {
        $checker = DB::table("transaction")
            ->where("user_id", "=", Auth::user()->user_id)
            ->where("game_id", "=", $game_id)->first();
        if ($checker != null) {
            return redirect()->route("gamedetails", $game_id);
        }
        $user = Auth::user();
        $game = Game::selectraw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->where("game_id", "=", $game_id)
            ->first();
        return view("checkout", compact("game", "user"));
    }
    public function addToLibrary(Request $request, $game_id) {
        $agreecheck = ["agree" => "required"];
        $validation = Validator::make($request->all(), $agreecheck);
        if ($validation->fails()) {
            return back()->withErrors($validation);
        }
        $user_id = Auth::user()->user_id;
        // validate if exists in transaction table
        $checker = DB::table("transaction")
            ->where("user_id", "=", $user_id)
            ->where("game_id", "=", $game_id)->first();
        if ($checker == null) {
            DB::table("transaction")->insert([
                "user_id" => $user_id,
                "game_id" => $game_id,
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            DB::table("wishlist")
                ->where("user_id", "=", $user_id)
                ->where("game_id", "=", $game_id)
                ->delete();
        }
        return redirect()->route("home");
    }
    public function libraryPage() {
        $games = Game::join("transaction", "games.game_id", "=", "transaction.game_id")
            ->selectRaw("*, CAST(price - (price * (discount_percent / 100)) AS SIGNED) as discounted_price")
            ->where("user_id", "=", Auth::user()->user_id)
            ->get();
        return view("librarypage", compact("games"));
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