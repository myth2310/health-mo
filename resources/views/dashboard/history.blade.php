@extends('dashboard.layouts.app')

@section('content')
@include('sweetalert::alert')


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                    <div class="ms-auto d-flex">
                        <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa-solid fa-heart-pulse" style="margin-right: 10px;"></i>Mulai Checking Kesehatan
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="container  mb-4">
                    <p class="pt-4 mb-0 text-bold">Filter Data</p>
                    <form id="filterForm" action="/export-pdf" method="POST">
                        @csrf
                        <div class="row mb-4 p-2">
                            <div class="col-md-3 p-2">
                                <input type="text" class="form-control" id="nama_export" name="nama_export" placeholder="Masukan Nama" required>
                                <div id="namaListExport" class="list-group"></div>
                            </div>
                            <div class="col-md-2 p-2">
                                <input type="text" class="form-control" id="tgl_lahir_export" name="tgl_lahir_export" placeholder="Tanggal Lahir" readonly required>

                            </div>
                            <div class="col-md-3 p-2">
                                <input type="text" class="form-control" id="no_hp_export" name="no_hp_export" placeholder="No HP" readonly required>
                            </div>
                            <input type="text" id="user_id_export" name="user_id_export" style="display: none;" required>

                            <div class="col p-2">
                                <button type="submit" class="btn btn-primary export"><i class="fa-solid fa-file-export" style="margin-right: 10px;"></i>Export Data</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive p-0 mt-3">
                        <table id="example" class="table align-items-center mb-0">
                            <thead>
                                <tr class="text-center" style="font-weight: bold; font-size: 13px;">
                                    <th class="ps-2">#</th>
                                    <th class="ps-2">Nama</th>
                                    <th class="ps-2">Tanggal Checking</th>
                                    <th class="ps-2">Nilai BPM</th>
                                    <th class="ps-2">Oksigen</th>
                                    <th class="ps-2">Hasil</th>
                                    <th class="ps-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                ?>
                                @foreach($data as $data)
                                <tr>
                                    <td><span class="text-sm">{{$no++}}</span></td>
                                    <td><span class="text-sm" style="text-transform: capitalize;">{{$data->nama}}</span></td>
                                    <td> <span class="text-sm">{{ Carbon\Carbon::parse($data->tgl_periksa)->isoFormat('DD MMMM YYYY') }}</span></td>
                                    <td><span class="text-sm">{{$data->bpm}} BPM</span></td>
                                    <td><span class="text-sm">{{$data->oksigen}} %</span></td>
                                    <td>
                                        <?php
                                        $tanggal_lahir =  Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_lahir);
                                        $umur = $tanggal_lahir->diffInYears(Carbon\Carbon::now());
                                        ?>
                                        @if (
                                        (($umur < 1 && $data->bpm >= 100 && $data->bpm <= 170) || ($umur>= 1 && $umur <= 12 && $data->bpm >= 80 && $data->bpm <= 120) || ($umur>= 13 && $umur <= 60 && $data->bpm >= 60 && $data->bpm <= 100)) && ($data->oksigen >= 95 && $data->oksigen <= 100) ) <span class="badge text-bg-success text-white p-2" style="font-size: 10px;">Hasil Normal</span>
                                                                    @else
                                                                    <span class="badge text-bg-danger text-white p-2" style="font-size: 10px;">Hasil Tidak Normal</span>
                                                                    @endif

                                    </td>
                                    <td class="text-sm font-weight-semibold text-dark">
                                        <button class="btn-sm btn-success text-white" data-bs-toggle="modal" data-bs-target="#ModalProfil{{$data->health_id}}">
                                            <i class="fa-solid fa-clipboard" style="color: #ffffff; margin-right: 8px;"></i>Hasil Rekomendasi
                                        </button>
                                        <a data-id="{{ encrypt($data->health_id) }}" data-nama="{{$data->nama}}" class="btn-sm btn-danger p-2 delete"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a>

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
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm">
                                                            <span class="text-secondary">Nama :</span> &nbsp; {{$data->nama}}
                                                        </li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                                            <span class="text-secondary">Umur :</span> &nbsp; {{$umur}} Tahun
                                                        </li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                                            @if (
                                                            (($umur < 1 && $data->bpm >= 100 && $data->bpm <= 170) || ($umur>= 1 && $umur <= 12 && $data->bpm >= 80 && $data->bpm <= 120) || ($umur>= 13 && $umur <= 60 && $data->bpm >= 60 && $data->bpm <= 100)) && ($data->oksigen >= 95 && $data->oksigen <= 100) ) <div class="alert alert-primary" style="font-size: 15px; font-family: Arial, Helvetica, sans-serif;" role="alert">
                                                                                        Untuk mempertahankan kesehatan yang optimal, teruslah menjaga pola makan seimbang dengan banyak buah,
                                                                                        sayur, protein sehat, dan biji-bijian. Tetaplah aktif dengan rutin berolahraga seperti jalan cepat atau berenang selama 150 menit per minggu,
                                                                                        serta lakukan latihan kekuatan dua kali seminggu. Jangan lupa untuk tetap terhidrasi dengan baik,
                                                                                        batasi konsumsi gula dan garam, serta pastikan Anda mendapatkan istirahat yang cukup setiap malam.
                                                                                        Terus pertahankan gaya hidup sehat ini untuk menjaga kesehatan jantung dan paru-paru Anda.
                                                </div>
                                                @else
                                                <div class="alert alert-danger" style="font-size: 15px; font-family: Arial, Helvetica, sans-serif;" role="alert">
                                                    Segera konsultasikan dengan dokter untuk evaluasi lebih lanjut.
                                                    Sementara itu, cobalah untuk makan makanan seimbang yang kaya buah, sayur,
                                                    biji-bijian, dan protein sehat. Batasi asupan garam dan gula.
                                                    Mulailah dengan olahraga ringan seperti berjalan kaki atau bersepeda selama 20-30 menit,
                                                    3-5 kali seminggu, dan tambahkan latihan pernapasan dalam seperti yoga.
                                                    Pastikan Anda tetap terhidrasi dengan baik dan mendapatkan istirahat yang cukup.
                                                    Tetap pantau kondisi Anda dan ikuti semua saran medis yang diberikan oleh dokter untuk penanganan lebih lanjut jika dirasa tubuh Anda mengalami gangguan yang berlebih.
                                                </div>
                                                @endif

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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Checking Health</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="hiddenForm" action="/insert-health-data" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" required>
                            <div id="namaList" class="list-group"></div>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" readonly required>
                        </div>
                        <input type="text" id="user_id" name="user_id" style="display: none;" required>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning text-white"><i class="fa-solid fa-heart-pulse" style="color: #ffffff; margin-right: 8px;"></i>Checking Health</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<script>
    $(document).ready(function() {
        // Event handler untuk form hidden
        $('#nama').on('input', function() {
            let query = $(this).val();
            if (query.length > 2) {
                $.ajax({
                    url: '{{ url("/search-user") }}',
                    method: 'POST',
                    data: {
                        query: query,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#namaList').html(data);
                    }
                });
            } else {
                $('#namaList').html('');
            }
        });

        $('#hiddenForm').on('click', '.list-group-item', function() {
            let user_id = $(this).data('id');
            $('#user_id').val(user_id);
            $('#nama').val($(this).text());
            $('#namaList').html('');

            $.ajax({
                url: '{{ url("/get-user-details") }}',
                method: 'POST',
                data: {
                    user_id: user_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#no_hp').val(data.no_hp);
                    $('#tgl_lahir').val(data.tgl_lahir);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        });

        // Event handler untuk form filter
        $('#nama_export').on('input', function() {
            let query1 = $(this).val();
            if (query1.length > 2) {
                $.ajax({
                    url: '{{ url("/search-user-export") }}',
                    method: 'POST',
                    data: {
                        query: query1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#namaListExport').html(data);
                    }
                });
            } else {
                $('#namaListExport').html('');
            }
        });

        $('#filterForm').on('click', '.list-group-item', function() {
            let user_id = $(this).data('id');
            $('#user_id_export').val(user_id);
            $('#nama_export').val($(this).text());
            $('#namaListExport').html('');

            $.ajax({
                url: '{{ url("/get-user-export") }}',
                method: 'POST',
                data: {
                    user_id: user_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#no_hp_export').val(data.no_hp);
                    $('#tgl_lahir_export').val(data.tgl_lahir);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            e.preventDefault();
            var healthid = $(this).data('id');
            var nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Data History',
                text: "Apakah Anda yakin hapus data health '" + nama + "'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'red',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/hapus-health/" + healthid;
                    Swal.fire("Data Health berhasil dihapus", {
                        icon: "success",
                    });
                } else {
                    Swal.fire("Data batal dihapus");
                }
            });
        });
    });
</script>

<style>
    .no-click {
        pointer-events: none;
        color: #999;
    }
</style>

@endsection