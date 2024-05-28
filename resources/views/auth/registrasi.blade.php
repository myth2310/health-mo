@extends('auth.layouts.app')
@section('content')
@include('sweetalert::alert')

<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="position-absolute w-40 top-0 start-0 h-100 d-md-block d-none">
                        <div class="oblique-image position-absolute d-flex fixed-top ms-auto h-100 z-index-0 bg-cover me-n8" style="background-color: rgb(196, 194, 191);">
                        <img src="../assets/img/bg2.svg" alt="Icon" style="width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-3">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h3 class="font-weight-black text-dark display-6">Sign up</h3>
                            <p style="font-size: 14px;" class="mb-0">Tingkatkan kualitas hidup anda dengan cek kesehatan anda!</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('register.user') }}" method="post">
                                @csrf
                                <label>Nama</label>
                                <div class="mb-3">
                                    <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" aria-label="Name" aria-describedby="name-addon" required>
                                </div>
                                <label>Email</label>
                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="Masukan Email" aria-label="Email" aria-describedby="email-addon" required>
                                </div>
                                <div class="mb-3">
                                    <label>No HP</label>
                                    <input type="text" min="14" name="no_hp" class="form-control" placeholder="Masukan No HP" aria-label="Password" aria-describedby="password-addon" required>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" class="form-control" aria-describedby="password-addon" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin" aria-label="Default select example" required>
                                            <option selected disabled value="">Choose...</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Riwayat Penyakit</label>
                                    <select class="form-select" name="riwayat_penyakit" aria-label="Default select example" required>
                                        <option selected disabled value="">Choose..</option>
                                        <option value="tidak ada riwayat">Tidak Ada Riwayat</option>
                                        <option value="asma">Asma</option>
                                        <option value="hipertensi">Hipertensi</option>
                                        <option value="diabetes">Diabetes</option>
                                        <option value="kanker">Kanker</option>
                                        <option value="jantung">Penyakit Jantung</option>
                                        <option value="ginjal">Penyakit Ginjal</option>
                                        <option value="gangguan_mood">Gangguan Mood</option>
                                        <option value="stroke">Stroke</option>
                                        <option value="asma">Asma</option>
                                        <option value="alergi">Alergi</option>
                                        <option value="asma">Demam Berdarah</option>
                                        <option value="asma">Tuberkulosis</option>
                                        <option value="asma">Hepatitis</option>
                                    </select>
                                </div>

                                <label>Password</label>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Masukan Password" aria-label="Password" aria-describedby="password-addon" required>
                                </div>
                                <div class="form-check form-check-info text-left mb-0">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="font-weight-normal text-dark mb-0" for="flexCheckDefault">
                                        I agree the <a href="javascript:;" class="text-dark font-weight-bold">Terms and Conditions</a>.
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Daftar</button>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-xs mx-auto">
                                Sudah punya akun ?
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