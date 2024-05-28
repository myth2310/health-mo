<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $page = 'History';

        $data = Health::join('users', 'health.user_id', '=', 'users.user_id')
            ->get();
        return view('dashboard.history', compact('page', 'data'));
    }

    public function history()
    {
        $page = 'History';

        $user = Auth::user();
        $data = Health::join('users', 'health.user_id', '=', 'users.user_id')
            ->where('health.user_id', '=', $user->user_id)
            ->get();

        return view('dashboard.history-checking', compact('page','data'));
    }
}
