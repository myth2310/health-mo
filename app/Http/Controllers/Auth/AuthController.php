<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registrasi()
    {
        return view('auth.registrasi');
    }
    public function checkEmail()
    {
        return view('auth.check-email');
    }
    public function showResetForm(Request $request)
    {
        $email = $request->input('email');
        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->password = bcrypt($request->input('password'));
            $user->save();

            toast('Password berhasil diubah!', 'success');
            return redirect('/sign-in')->with('success', 'Password berhasil diubah!');
        } else {
            toast('Email tidak ditemukan!', 'warning');
            return redirect()->back()->with('error', 'Email tidak ditemukan!');
        }
    }


    public function checkEmailAndRedirect(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            return redirect()->route('password.reset', ['email' => $request->input('email')]);
        } else {
            toast('Email tidak ditemukan!', 'warning');
            return redirect()->back()->with('error', 'Email tidak ditemukan!');
        }
    }


    public function create(Request $request)
    {
        $existingUser = User::where('email', $request->input('email'))->first();
        if ($existingUser) {
            toast('Email sudah terdaftar!', 'warning');
            return redirect()->back()->with('error', 'Email sudah terdaftar!');
        }

        if (strlen($request->input('password')) < 6) {
            toast('Password harus memiliki minimal 6 karakter.', 'warning');
            return redirect()->back()->with('error', 'Password harus memiliki minimal 6 karakter.');
        }

        $user = new User();
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');
        $user->tgl_lahir = $request->input('tgl_lahir');
        $user->jenis_kelamin = $request->input('jenis_kelamin');
        $user->riwayat_penyakit = $request->input('riwayat_penyakit');
        $user->status = 0;
        $user->level = 'User';
        $password = $request->input('password');
        $user->password = bcrypt($password);
        $user->save();

        toast('Anda Berhasil Membuat Akun, Tunggu Aktivasi Admin!', 'success');
        return redirect('/sign-in');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if (($user->level == 'Admin' || $user->level == 'User') && $user->status == 1) {
                toast('Anda Berhasil Login!', 'success');
                return redirect('/');
            } elseif ($user->status == 0) {
                Auth::logout();
                toast('Akun Anda belum diaktivasi oleh admin', 'warning');
                return redirect('/sign-in')->with('warning', 'Akun Anda belum diaktivasi oleh admin');
            } else {
                Auth::logout();
                toast('Pengguna tidak valid!', 'error');
                return redirect('/sign-in')->with('error', 'Pengguna tidak valid');
            }
        } else {
            toast('Email atau Password Salah!', 'warning');
            return redirect('/sign-in')->with('error', 'Email atau Password Salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/sign-in');
    }
}
