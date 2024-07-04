@extends('auth.layouts.app')
@section('content')
@include('sweetalert::alert')

<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 d-flex flex-column mx-auto">
                    <div class="card mt-5">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h5 class="font-weight-black text-dark">Ganti Akun Sandi Anda</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" name="password" id="password" placeholder="Masukan Password Baru Anda" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru Anda" id="password_confirmation" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Ganti Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection