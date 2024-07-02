@extends('auth.layouts.app')
@section('content')
@include('sweetalert::alert')

<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-5">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-black text-dark display-6">Welcome back</h3>
                            <p class="mb-0">Tingkatkan kualitas hidup anda dengan cek kesehatan anda sekarang!</p>
                        </div>
                        <div class="card-body">
                            <form action="/login" method="post">
                                @csrf
                                <label>Email</label>
                                <div class="mb-3">
                                    <input name="email" type="email" class="form-control" placeholder="Masukan Email" aria-label="Email" aria-describedby="email-addon" required>
                                </div>
                                <label>Password</label>
                                <div class="mb-3">
                                    <input name="password" type="password" class="form-control" placeholder="Masukan Password" aria-label="Password" aria-describedby="password-addon" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-xs mx-auto">
                                Belum mempunyai akun ?
                                <a href="/sign-up" class="text-dark font-weight-bold">Daftar</a>
                            </p>
                            <p class="mb-4 text-xs mx-auto">
                                <a href="/sign-in/identify" class="text-dark font-weight-bold">Lupa Kata Sandi ?</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="position-absolute w-40 top-0 end-0 h-100 d-md-block d-none">
                        <div class="oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 bg-cover ms-n8" style="background-color: #fafafa">
                        <img src="../assets/img/bg2.svg" alt="Icon" style="width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection