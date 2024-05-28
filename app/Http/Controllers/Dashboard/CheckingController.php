<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckingController extends Controller
{
    public function index()
    {
        $page = 'Checking';
        return view('dashboard.checking', compact('page'));
    }

    public function getHealthData()
    {
        $user = Auth::user();
        $healthData = Health::where('user_id', $user->user_id)
            ->whereDate('created_at', now()->toDateString())
            ->first();
        return response()->json($healthData);
    }

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
    
    
}
