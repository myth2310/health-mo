<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use App\Models\IpEsp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $datausers = DB::table('users')
            ->select(DB::raw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m-01") as month'))
            ->where('level','User')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $labels = $datausers->pluck('month')->map(function ($date) {
            return Carbon::parse($date)->format('M Y');
        });
        $jumlah = $datausers->pluck('count');



        return view('dashboard.dashboard', compact('page', 'totalUser', 'totalUsertTeraktivasi', 'data', 'umur', 'health', 'labels', 'jumlah'));
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
                Storage::delete('public/profile_photos' . $user->foto);
            }
            $path = $request->file('foto')->store('profile_photos', 'public');
            $user->foto = $path;
        }

        $user->save();
        toast('Profil Berhasil diedit!', 'success');
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function coba(){
    
      return view('dashboard.coba');
    }

    public function fetchData()
{
    try {
        $ipesp = IpEsp::where('ipesp_id', 1)->first();

        if (!$ipesp) {
            return response()->json(['error' => 'Data IP Esp tidak ditemukan'], 404);
        }
        $response = Http::get($ipesp->ip_esp);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Gagal mendapatkan data dari Esp'], $response->status());
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    }
}

}
