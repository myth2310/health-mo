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
                            <h5 class="font-weight-black text-dark">Mencari Akun Anda</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('check-email') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <input name="email" type="email" class="form-control" placeholder="Masukan Email Anda" aria-label="Email" aria-describedby="email-addon" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100 mt-4 mb-3">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-xs mx-auto">
                                Sudah Punya Akun ?
                                <a href="/sign-in" class="text-dark font-weight-bold">Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection