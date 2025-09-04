<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thank;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ThankController extends Controller
{
    public function index()
    {
        $total = Thank::count();
        $today = Thank::whereDate('created_at', Carbon::today())->count();

        // ランキング（直近100件から上位ユーザー集計）
        $ranking = Thank::select('user', DB::raw('COUNT(*) as count'))
            ->groupBy('user')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('thanks.index', compact('total', 'today', 'ranking'));
    }

    public function increment(Request $request)
    {
        $user = $request->ip(); // 簡易的にIPをユーザー識別に
        Thank::create(['user' => $user]);

        $total = Thank::count();
        $today = Thank::whereDate('created_at', Carbon::today())->count();

        return response()->json(['total' => $total, 'today' => $today]);
    }
}
