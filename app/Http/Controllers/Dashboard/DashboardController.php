<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $page = 'Dashboard';

        $totalUser = User::where('level', 'User')
            ->where('status', 1)
            ->count();

        $totalUsertTeraktivasi = User::where('level', 'User')
            ->where('status', 0)
            ->count();

        $user = Auth::user();
        $data = User::where('level', 'User')
            ->where('user_id', $user->user_id)
            ->first();
        if (!empty($data->tgl_lahir)) {
            $tanggal_lahir = Carbon::createFromFormat('Y-m-d', $data->tgl_lahir);
            $umur = $tanggal_lahir->diffInYears(Carbon::now());
        } else {
            $umur = null;
        }

        $health = Health::join('users', 'health.user_id', '=', 'users.user_id')
            ->where('users.user_id', $user->user_id)
            ->orderBy('health.created_at', 'desc')
            ->first();

            
        return view('dashboard.dashboard', compact('page', 'totalUser', 'totalUsertTeraktivasi', 'data', 'umur', 'health'));
    }

    public function getUsersPerMonthData()
    {
        $usersPerMonth = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();

        return response()->json($usersPerMonth);
    }


    public function update(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user = Auth::user();
        $user->nama = $request->input('nama');
        $user->no_hp = $request->input('no_hp');
        $user->tgl_lahir = $request->input('tgl_lahir');
        $user->jenis_kelamin = $request->input('jenis_kelamin');
        $user->riwayat_penyakit = $request->input('riwayat_penyakit');

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::delete('public' . $user->foto);
            }
            $path = $request->file('foto')->store('profile_photos', 'public');
            $user->foto = $path;
        }

        $user->save();
        toast('Profil Berhasil diedit!', 'success');
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
