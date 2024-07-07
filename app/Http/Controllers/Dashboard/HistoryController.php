<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Health;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $page = 'History';

        $data = Health::join('users', 'health.user_id', '=', 'users.user_id')
            ->select('users.*', 'health.*', 'health.created_at as tgl_periksa')
            ->get();
        return view('dashboard.history', compact('page', 'data'));
    }

    public function history()
    {
        $page = 'History';

        $user = Auth::user();
        $data = Health::join('users', 'health.user_id', '=', 'users.user_id')
            ->select('users.*', 'health.*', 'health.created_at as tgl_periksa')
            ->where('health.user_id', '=', $user->user_id)
            ->get();

        return view('dashboard.history-checking', compact('page', 'data'));
    }

    public function searchUser(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('nama', 'LIKE', "%{$query}%")
            ->where('level', 'User')
            ->where('status', 1)
            ->get(['user_id', 'nama']);

        $output = '';
        if ($users->count() > 0) {
            foreach ($users as $user) {
                $output .= '<a href="#" class="list-group-item list-group-item-action" data-id="' . $user->user_id . '">' . $user->nama . '</a>';
            }
        } else {
            $output .= '<p class="list-group-item no-click">No results found</p>';
        }

        return response($output);
    }


    public function getUserDetails(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id, ['no_hp', 'tgl_lahir']);

        return response()->json($user);
    }

    public function searchUserExport(Request $request)
    {
        $query1 = $request->input('query1');
        $users = User::where('nama', 'LIKE', "%{$query1}%")
            ->where('level', 'User')
            ->where('status', 1)
            ->get(['user_id', 'nama']);

        $output = '';
        if ($users->count() > 0) {
            foreach ($users as $user) {
                $output .= '<a href="#" class="list-group-item list-export list-group-item-action" data-id="' . $user->user_id . '">' . $user->nama . '</a>';
            }
        } else {
            $output .= '<p class="list-group-item list-export no-click">No results found</p>';
        }

        return response($output);
    }


    public function getUserExport(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id, ['no_hp', 'tgl_lahir']);

        return response()->json($user);
    }

    public function exportPDF(Request $request)
    {
        $user_id = $request->input('user_id_export');
        $health = Health::join('users', 'health.user_id', '=', 'users.user_id')
            ->select('users.*', 'health.*')
            ->where('health.user_id', $user_id)
            ->get();

        $data = User::where('user_id', $user_id)->first();
        if (!empty($data->tgl_lahir)) {
            $tanggal_lahir = Carbon::createFromFormat('Y-m-d', $data->tgl_lahir);
            $umur = $tanggal_lahir->diffInYears(Carbon::now());
        } else {
            $umur = null;
        }

        $pdf = PDF::loadView('template.health-document', compact('health', 'data', 'umur'));

        return $pdf->stream('Data_Health_' . $data->nama . '.pdf');
    }

    public function hapus($encryptedidHealth)
    {
        $idhealth = decrypt($encryptedidHealth);
        $health = Health::findOrFail($idhealth);
        $health->delete();
        toast('Data Health berhasil dihapus', 'success');
        return redirect()->back();
    }
}
