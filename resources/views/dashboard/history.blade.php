@extends('dashboard.layouts.app')
@section('content')


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0 bg-primary text-white">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0 text-white">History Checking Health</h6>
                        <p class="text-sm">See information about all health history</p>
                    </div>

                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="container  mb-4">
                    <div class="table-responsive p-0 mt-3">
                        <table id="example" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Nama</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Tanggal Checking</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Nilai BMI</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Oksigen</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Hasil</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $data)
                                <tr>
                                    <td>
                                        <span class="text-sm">{{$data->nama}}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm">{{ Carbon\Carbon::parse($data->create_at)->isoFormat('DD MMMM YYYY') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm">{{$data->bpm}} BPM</span>
                                    </td>
                                    <td>
                                        <span class="text-sm">{{$data->oksigen}} %</span>
                                    </td>
                                    <td>
                                        <?php
                                        $tanggal_lahir =  Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_lahir);
                                        $umur = $tanggal_lahir->diffInYears(Carbon\Carbon::now());
                                        ?>
                                        @if (
                                        ($umur >= 6 && $umur <= 10 && $data->bpm >= 70 && $data->bpm <= 110) || ($umur>= 11 && $umur <= 14 && $data->bpm >= 60 && $data->bpm <= 105) || ($umur>= 15 && $umur <= 19 && $data->bpm >= 60 && $data->bpm <= 100) || ($umur>= 20 && $umur <= 35 && $data->bpm >= 95 && $data->bpm <= 170) || ($umur>= 36 && $umur <= 50 && $data->bpm >= 85 && $data->bpm <= 155) || ($umur>= 51 && $data->bpm >= 80 && $data->bpm <= 130) && ($data->oksigen >= 95 && $data->oksigen <= 100) ) <span class="badge text-bg-success text-white p-2" style="font-size: 10px;">Hasil Normal</span>
                                                                                    @else
                                                                                    <span class="badge text-bg-danger text-white p-2" style="font-size: 10px;">Hasil Tidak Normal</span>
                                                                                    @endif

                                    </td>
                                    <td class="text-sm font-weight-semibold text-dark">
                                        <button class="btn-sm btn-success text-white" data-bs-toggle="modal" data-bs-target="#ModalProfil{{$data->health_id}}"><i class="fa-solid fa-clipboard" style="color: #ffffff; margin-right: 8px;"></i>Hasil Rekomendasi</button>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="ModalProfil{{$data->health_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hasil Rekomendasi</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <ul class="list-group pl-3">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm"><span class="text-secondary">Nama :</span> &nbsp; {{$data->nama}}</li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">Umur :</span> &nbsp; {{$umur}} Tahun</li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
    <div class="alert alert-primary" style="font-size: 15px; font-family: Arial, Helvetica, sans-serif;" role="alert">
        @if (
            ($umur >= 6 && $umur <= 10 && $data->bpm >= 70 && $data->bpm <= 110) ||
            ($umur >= 11 && $umur <= 14 && $data->bpm >= 60 && $data->bpm <= 105) ||
            ($umur >= 15 && $umur <= 19 && $data->bpm >= 60 && $data->bpm <= 100) ||
            ($umur >= 20 && $umur <= 35 && $data->bpm >= 95 && $data->bpm <= 170) ||
            ($umur >= 36 && $umur <= 50 && $data->bpm >= 85 && $data->bpm <= 155) ||
            ($umur >= 51 && $data->bpm >= 80 && $data->bpm <= 130) &&
            ($data->oksigen >= 95 && $data->oksigen <= 100)
        )
            Untuk mempertahankan kesehatan yang optimal, teruslah menjaga pola makan seimbang dengan banyak buah, sayur, protein sehat, dan biji-bijian. Tetaplah aktif dengan rutin berolahraga seperti jalan cepat atau berenang selama 150 menit per minggu, serta lakukan latihan kekuatan dua kali seminggu. Jangan lupa untuk tetap terhidrasi dengan baik, batasi konsumsi gula dan garam, serta pastikan Anda mendapatkan istirahat yang cukup setiap malam. Terus pertahankan gaya hidup sehat ini untuk menjaga kesehatan jantung dan paru-paru Anda.
        @else
            Segera konsultasikan dengan dokter untuk evaluasi lebih lanjut. Sementara itu, cobalah untuk makan makanan seimbang yang kaya buah, sayur, biji-bijian, dan protein sehat. Batasi asupan garam dan gula. Mulailah dengan olahraga ringan seperti berjalan kaki atau bersepeda selama 20-30 menit, 3-5 kali seminggu, dan tambahkan latihan pernapasan dalam seperti yoga. Pastikan Anda tetap terhidrasi dengan baik dan mendapatkan istirahat yang cukup. Tetap pantau kondisi Anda dan ikuti semua saran medis yang diberikan oleh dokter untuk penanganan lebih lanjut jika dirasa tubuh Anda mengalami gangguan yang berlebih.
        @endif
    </div>
</li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<script>
    $(document).ready(function() {
        $('.upprove').click(function(e) {
            e.preventDefault();
            var usersid = $(this).data('id');
            var nama = $(this).data('nama');

            Swal.fire({
                title: 'Aktivasi Akun',
                text: "Apakah Anda yakin aktivasi akun '" + nama + "'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'red',
                confirmButtonText: 'Ya, aktivasi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/edit-users/" + usersid;
                    Swal.fire("Data berhasil dihapus", {
                        icon: "success",
                    });
                } else {
                    Swal.fire("Data batal diupprove");
                }
            });
        });
    });
</script>




@endsection