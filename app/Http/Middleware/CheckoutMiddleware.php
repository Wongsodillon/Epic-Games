<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CheckoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $game = Game::find($request->route("id"));
        $valid = DB::table("games")->join("transaction", "games.game_id", "=", "transaction.game_id")
            ->where("transaction.user_id", "=", Auth::user()->user_id)
            ->where("transaction.game_id", "=", $game->game_id)
            ->exists();
        $valid2 = DB::table("games")->where("game_id", "=", $game->game_id)
            ->where("games.release_date", ">", Carbon::now()->format("Y-m-d H:i:s"))
            ->exists();
        if ($valid || $valid2) {
            return redirect()->route("gamedetails", $game->game_id);
        }
        return $next($request);
    }
}
