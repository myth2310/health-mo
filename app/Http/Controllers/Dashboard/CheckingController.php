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

            // Arahkan pengguna ke halaman checking dengan user_id
            return redirect()->route('checking', ['user_id' => $request->input('user_id')]);
        }
    }


    public function getHealthData(Request $request)
    {
        $userId = $request->query('user_id'); // Mengambil user_id dari query parameter
        $healthData = Health::where('user_id', $userId)
            ->whereDate('created_at', now()->toDateString())
            ->first();
        return response()->json($healthData);
    }


    // public function getHealthData()
    // {
    //     $user = Auth::user();
    //     $healthData = Health::where('user_id', $user->user_id)
    //         ->whereDate('created_at', now()->toDateString())
    //         ->first();
    //     return response()->json($healthData);
    // }

    public function storeHealthData(Request $request)
    {
        $request->validate([
            'bpm' => 'required|numeric',
            'oksigen' => 'required|numeric',
        ]);

        $user = Auth::user();
        $user_id = $request->user_id;
        $bpm = $request->bpm;
        $oksigen = $request->oksigen;

        $today = now()->toDateString();

        $healthData = Health::where('user_id', $user_id)
            ->whereDate('created_at', $today)
            ->first();

        if ($healthData) {
            $healthData->update([
                'bpm' => $bpm,
                'oksigen' => $oksigen
            ]);
        } else {
            $healthData = new Health();
            $healthData->user_id = $user_id;
            $healthData->bpm = $bpm;
            $healthData->oksigen = $oksigen;
            $healthData->save();
        }
        return response()->json(['message' => 'Data berhasil disimpan atau diperbarui'], 201);
    }

    public function storeHealthData1(Request $request)
    {
        $bpm = $request->bpm;
        $oksigen = $request->oksigen;

        $today = now()->toDateString();

        $healthData = Coba::whereDate('created_at', $today)
            ->first();

        if ($healthData) {
            $healthData->update([
                'bpm' => $bpm,
                'oksigen' => $oksigen
            ]);
        } else {
            $healthData = new Coba();
            $healthData->bpm = $bpm;
            $healthData->oksigen = $oksigen;
            $healthData->save();
        }
        return response()->json(['message' => 'Data berhasil disimpan atau diperbarui'], 201);
    }

    public function storeHealth()
    {
        $today = now()->toDateString();

        $healthData = Coba::whereDate('created_at', $today)
            ->first();

        if ($healthData) {
            $healthData->update([
                'bpm' => request()->bpm,
                'oksigen' => request()->oksigen
            ]);
        } else {
            $healthData = new Coba();
            $healthData->bpm = request()->bpm;
            $healthData->oksigen = request()->oksigen;
            $healthData->save();
        }
    }


    public function rekomendasi()
    {
        $page = 'Hasil Rekomendasi';
        return view('dashboard.rekomendasi', compact('page'));
    }
}
