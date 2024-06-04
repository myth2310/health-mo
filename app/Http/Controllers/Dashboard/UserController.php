<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $page = 'Management User';

        $user = User::where('level', 'User')->get();
        return view('dashboard.user', compact('page', 'user'));
    }

    public function sendMail($encryptedUserId)
    {
        try {
            $userId = decrypt($encryptedUserId);
            $user = User::findOrFail($userId);
    
            $data = [
                'nama' => $user->nama,
                'email' => $user->email, 
            ];
    
            Mail::to($data['email'])->send(new SendEmail($data));
    
            $user->status = 1;
            $user->save();
    
            toast('Akun berhasil diaktivasi', 'success');
            return redirect()->back();
        } catch (\Exception $e) {
            toast('Terjadi kesalahan saat mengirim email', 'error');
            return redirect()->back();
        }
    }
    
    public function hapus($encryptedUserId){
        $userId = decrypt($encryptedUserId);
        $user = User::findOrFail($userId);
        $user->delete();
        toast('Akun berhasil dihapus', 'success');
        return redirect()->back();
    }
}
