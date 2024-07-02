@extends('dashboard.layouts.app')
@section('content')
@include('sweetalert::alert')

@if(auth()->user()->level=="User")
<div class="row">
    <div class="col-md-12">
        <div class="d-md-flex align-items-center mb-3 mx-2">
            <div class="mb-md-0 mb-3">
                <h3 class="font-weight-bold mb-0">Selamat Datang, di Health Mo ✋</h3>
                <p class="mb-0">Tingkatkan kualitas hidup anda dengan cek kesehatan anda sekarang!</p>
            </div>

            <button type="button" class="btn btn-success btn-icon d-flex ms-md-auto me-2" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fa-regular fa-address-card" style="margin-right: 10px;"></i>Edit Profil
            </button>
            <button type="button" class="btn btn-primary  btn-icon" data-bs-toggle="modal" data-bs-target="#healthInfoModal">
                <i class="fa-solid fa-circle-info" style="margin-right: 10px;"></i>Informasi Kesehatan
            </button>
        </div>
    </div>
</div>
<hr class="my-0 mb-4">

<div class="row mt-2 mb-2">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col profil-image">
                            <div class="mt-3">
                                <img style="width: 500px; height: 200px; object-fit: contain; object-position: top;" src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('assets/img/icon-profil.png') }}" class="img-fluid" alt="Profile Picture">
                            </div>

                        </div>
                        <div class="col mt-4">
                            <div class="profil" style="font-weight: 700;">
                                <h3 class="font-weight-bold mb-0" style="text-transform: uppercase;">{{$data->nama}}
                                </h3>
                                <p class="text-secondary text-sm font-weight-normal">{{$umur}} Tahun</p>
                                <p class="text-secondary text-sm font-weight-normal mt-2" style="text-transform: capitalize;"><i class="fa-solid fa-notes-medical" style="margin-right: 8px;"></i>{{$data->riwayat_penyakit}}</p>
                            </div>
                            <!-- <button class="btn btn-warning checking"><i class="fa-solid fa-heart-pulse" style="color: #ffffff; margin-right: 8px;"></i>Checking Health</button> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="justify-content-center align-items-center mt-3">
                        <p class="text-dark" style="font-weight: 400;"><i class="fa-solid fa-clock-rotate-left" style="margin-right: 8px;"></i>History terakhir</p>
                        <hr>
                        @if($health)
                        <ul class="list-group pl-3">
                            <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span class="text-secondary">Nilai BMI :</span> &nbsp; {{ $health->bpm }} BPM</li>
                            <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span class="text-secondary">Oksigen :</span> &nbsp; {{ $health->oksigen }} %</li>
                            <hr class="mb-0">
                            <?php
                            $tanggal_lahir =  Carbon\Carbon::createFromFormat('Y-m-d', $health->tgl_lahir);
                            $umur = $tanggal_lahir->diffInYears(Carbon\Carbon::now());
                            ?>
                            <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary"></span> &nbsp;
                                @if (
                                ($umur >= 6 && $umur <= 10 && $health->bpm >= 70 && $health->bpm <= 110) || ($umur>= 11 && $umur <= 14 && $health->bpm >= 60 && $health->bpm <= 105) || ($umur>= 15 && $umur <= 19 && $health->bpm >= 60 && $health->bpm <= 100) || ($umur>= 20 && $umur <= 35 && $health->bpm >= 95 && $health->bpm <= 170) || ($umur>= 36 && $umur <= 50 && $health->bpm >= 85 && $health->bpm <= 155) || ($umur>= 51 && $health->bpm >= 80 && $health->bpm <= 130) ) <span class="badge text-bg-success text-white p-2" style="font-size: 10px;">Hasil Normal</span>
                                                                            @else <span class="badge text-bg-danger text-white p-2" style="font-size: 10px;">Hasil Tidak Normal</span> @endif
                            </li>
                        </ul>
                        @else
                        <p style="font-size: 12px;"><i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i>Belum ada data checking health terbaru</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
 <!-- Modal -->
 <div class="modal fade" id="healthInfoModal" tabindex="-1" role="dialog" aria-labelledby="healthInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="healthInfoModalLabel"><i class="fa-solid fa-circle-info" style="margin-right: 10px;"></i>Informasi Kesehatan</h5>
                </div>
                <div class="modal-body">
                    <h6>Data Denyut Jantung:</h6>
                    <ul>
                        <li>Anak usia 6-10 tahun: 70-110 bpm</li>
                        <li>Anak usia 11-14 tahun: 60-105 bpm</li>
                        <li>Anak usia 15 tahun ke atas: 60-100 bpm</li>
                        <li>Orang dewasa usia 20-35 tahun: 95-170 bpm</li>
                        <li>Orang dewasa usia 35-50 tahun: 85-155 bpm</li>
                        <li>Orang dewasa berusia 60 tahun: 80-130 bpm</li>
                    </ul>
                    <h6>Saturasi Oksigen:</h6>
                    <ul>
                        <li>Saturasi oksigen normal: 95-100%</li>
                        <li>Saturasi oksigen rendah: Di bawah 95%</li>
                    </ul>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editProfileModalLabel">Edit Profil</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="profilePhoto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="profilePhoto" name="foto" accept="image/jpeg, image/png">
                    </div>
                    <div class="mb-3">
                        <img id="profilePhotoPreview" src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : asset('assets/img/icon-profil.png') }}" alt="Profile Photo" class="img-thumbnail" style="max-width: 150px;">
                    </div>
                    <div class="mb-3">
                        <label for="profileName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="profileName" name="nama" value="{{ old('nama', auth()->user()->nama) }}">
                    </div>
                    <div class="mb-3">
                        <label for="profileEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profileEmail" name="email" value="{{ old('email', auth()->user()->email) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="profilePhone" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="profilePhone" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}">
                    </div>
                    <div class="mb-3">
                        <label for="profileBirthday" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="profileBirthday" name="tgl_lahir" value="{{ old('tgl_lahir', auth()->user()->tgl_lahir) }}">
                    </div>
                    <div class="mb-3">
                        <label for="profileGender" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="profileGender" name="jenis_kelamin">
                            <option value="Laki-laki" {{ auth()->user()->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ auth()->user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profileMedicalHistory" class="form-label">Riwayat Penyakit</label>
                        <select class="form-select" name="riwayat_penyakit" aria-label="Default select example" required>
                            <option value="{{ old('riwayat_penyakit', auth()->user()->riwayat_penyakit) }}" selected>
                                {{ old('riwayat_penyakit', auth()->user()->riwayat_penyakit) }}
                            </option>
                            @php
                            $riwayat_penyakit_options = [
                            "tidak ada riwayat" => "Tidak Ada Riwayat",
                            "asma" => "Asma",
                            "hipertensi" => "Hipertensi",
                            "diabetes" => "Diabetes",
                            "kanker" => "Kanker",
                            "jantung" => "Penyakit Jantung",
                            "ginjal" => "Penyakit Ginjal",
                            "gangguan_mood" => "Gangguan Mood",
                            "stroke" => "Stroke",
                            "alergi" => "Alergi",
                            "demam_berdarah" => "Demam Berdarah",
                            "tuberkulosis" => "Tuberkulosis",
                            "hepatitis" => "Hepatitis"
                            ];
                            $selected_riwayat_penyakit = old('riwayat_penyakit', auth()->user()->riwayat_penyakit);
                            @endphp
                            @foreach ($riwayat_penyakit_options as $value => $label)
                            @if ($value != $selected_riwayat_penyakit)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" form="editProfileForm" class="btn btn-primary">Edit Profil</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('profilePhoto').addEventListener('change', function(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePhotoPreview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

@endif


@if(auth()->user()->level=="Admin")
<div class="row">
    <div class="col-xl-6 col-sm-6 mb-xl-0">
        <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
                <div class="icon icon-shape icon-sm bg-warning text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M211.2 96a64 64 0 1 0 -128 0 64 64 0 1 0 128 0zM32 256c0 17.7 14.3 32 32 32h85.6c10.1-39.4 38.6-71.5 75.8-86.6c-9.7-6-21.2-9.4-33.4-9.4H96c-35.3 0-64 28.7-64 64zm461.6 32H576c17.7 0 32-14.3 32-32c0-35.3-28.7-64-64-64H448c-11.7 0-22.7 3.1-32.1 8.6c38.1 14.8 67.4 47.3 77.7 87.4zM391.2 226.4c-6.9-1.6-14.2-2.4-21.6-2.4h-96c-8.5 0-16.7 1.1-24.5 3.1c-30.8 8.1-55.6 31.1-66.1 60.9c-3.5 10-5.5 20.8-5.5 32c0 17.7 14.3 32 32 32h224c17.7 0 32-14.3 32-32c0-11.2-1.9-22-5.5-32c-10.8-30.7-36.8-54.2-68.9-61.6zM563.2 96a64 64 0 1 0 -128 0 64 64 0 1 0 128 0zM321.6 192a80 80 0 1 0 0-160 80 80 0 1 0 0 160zM32 416c-17.7 0-32 14.3-32 32s14.3 32 32 32H608c17.7 0 32-14.3 32-32s-14.3-32-32-32H32z" />
                    </svg>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="w-100">
                            <p class="text-sm text-secondary mb-1">Users Teraktivasi</p>
                            <h4 class="mb-2 font-weight-bold">{{$totalUser}}</h4>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-sm-6 mb-xl-0">
        <div class="card border shadow-xs mb-4">
            <div class="card-body text-start p-3 w-100">
                <div class="icon icon-shape icon-sm bg-danger text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L353.3 251.6C407.9 237 448 187.2 448 128C448 57.3 390.7 0 320 0C250.2 0 193.5 55.8 192 125.2L38.8 5.1zM264.3 304.3C170.5 309.4 96 387.2 96 482.3c0 16.4 13.3 29.7 29.7 29.7H514.3c3.9 0 7.6-.7 11-2.1l-261-205.6z" />
                    </svg>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="w-100">
                            <p class="text-sm text-secondary mb-1">Users Belum Teraktivasi</p>
                            <h4 class="mb-2 font-weight-bold">{{$totalUsertTeraktivasi}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-xs border">
            <div class="card-header pb-0 mb-4">
                <div class="d-sm-flex align-items-center mb-3">
                    <div>
                        <h6 class="font-weight-bold text-lg mb-0">Jumlah Pengguna / Bulan</h6>
                        <p class="text-sm mb-sm-0 mb-2">Here you have details about the balance.</p>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 mt-4">
                <div class="chart mt-n6">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif



<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('.checking').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Mulai Pemeriksaan',
                text: "Catatan: Pastikan sistem terhubung dengan alat.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'red',
                confirmButtonText: 'Mulai Pemeriksaan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/checking";
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');

    const labels = @json($labels);
    const data = @json($jumlah);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Users',
                data: data,
                borderWidth: 1,
                backgroundColor: 'rgba(0, 0, 0, 0.2)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection