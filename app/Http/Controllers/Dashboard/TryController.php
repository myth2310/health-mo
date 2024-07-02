<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryController extends Controller
{
    // public function storeHealthData(Request $request)
    // {
    //     $request->validate([
    //         'bpm' => 'required|numeric',
    //         'oksigen' => 'required|numeric',
    //     ]);

    //     $user = Auth::user();
    //     $user_id = $request->user_id;
    //     $bpm = $request->bpm;
    //     $oksigen = $request->oksigen;

    //     $today = now()->toDateString();

    //     $healthData = Health::where('user_id', $user_id)
    //         ->whereDate('created_at', $today)
    //         ->first();

    //     if ($healthData) {
    //         $healthData->update([
    //             'bpm' => $bpm,
    //             'oksigen' => $oksigen
    //         ]);
    //     } else {
    //         $healthData = new Health();
    //         $healthData->user_id = $user_id;
    //         $healthData->bpm = $bpm;
    //         $healthData->oksigen = $oksigen;
    //         $healthData->save();
    //     }
    //     return response()->json(['message' => 'Data berhasil disimpan atau diperbarui'], 201);
    // }

    public function index()
    {
        return view('dashboard.try');
    }

    public function storeHealthData(Request $request)
    {
        $request->validate([
            'bpm' => 'required|numeric',
            'oksigen' => 'required|numeric',
        ]);

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

    public function startDataCollection(Request $request)
    {
        $userId = $request->input('user_id');
        
        // Check if request expects JSON response
        if ($request->expectsJson()) {
            return response()->json(['user_id' => $userId]);
        }
    
        // Return view with user_id
        return view('Dashboard.try-checking', compact('userId'));
    }

    public function getHealthData($userId)
    {
        $healthData = Health::where('user_id', $userId)
            ->whereDate('created_at', now()->toDateString())
            ->first();
        return response()->json($healthData);
    }
}
