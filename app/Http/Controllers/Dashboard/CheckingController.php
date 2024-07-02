<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use App\Models\Coba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckingController extends Controller
{
    public function index()
    {
        $page = 'Checking';
        $user = Auth::user();
        $healthData = Health::where('user_id', $user->user_id)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if ($healthData) {
            toast('Anda Telah Melakukan Pemeriksaan Kesehatan Hari Ini. Silakan Periksa Kembali Besok.', 'info');

            return redirect()->back();
        } else {
            return view('dashboard.checking', compact('page'));
        }
    }

    public function store(Request $request)
    {

        $healthData = Health::where('user_id', $request->input('user_id'))
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if ($healthData) {
            toast('Anda Telah Melakukan Pemeriksaan Kesehatan Hari Ini. Silakan Periksa Kembali Besok.', 'info');
            return redirect()->back();
        } else {
            $health = new Health();
            $health->user_id = $request->input('user_id');
            $health->save();


            return redirect()->route('checking', ['user_id' => $request->input('user_id')]);
        }
    }

    public function getHealthData(Request $request)
    {
        $userId = $request->query('user_id');
        $healthData = Health::where('user_id', $userId)
            ->whereDate('created_at', now()->toDateString())
            ->first();
        return response()->json($healthData);
    }

    public function rekomendasi()
    {
        $page = 'Hasil Rekomendasi';
        return view('dashboard.rekomendasi', compact('page'));
    }

    public function Healthstore(Request $request)
    {
        $userId = $request->input('user_id');
        $bpm = $request->input('bpm');
        $oksigen = $request->input('oksigen');

        $today = now()->toDateString();
        $healthData = Health::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->first();

        if ($healthData) {
            $healthData->update([
                'bpm' => $bpm,
                'oksigen' => $oksigen,
            ]);
        } else {
            $healthData = Health::create([
                'user_id' => $userId,
                'bpm' => $bpm,
                'oksigen' => $oksigen,
            ]);
        }

        return response()->json(['message' => 'Data successfully stored', 'data' => $healthData], 200);
    }
}
