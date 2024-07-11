@extends('dashboard.layouts.app')
@section('content')
@include('sweetalert::alert')


<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div>
                        <h6 class="font-weight-semibold text-lg mb-0">Daftar Users</h6>
                        <p class="text-sm">See information about all users</p>
                    </div>

                </div>
            </div>
            <div class="card-body px-0 py-0">
                <div class="container  mb-4">
                    <div class="table-responsive p-0 mt-3">
                        <table id="example" class="table align-items-center mb-0">
                            <thead>
                                <tr class="text-center" style="font-weight: bold; font-size: 12px;">
                                    <th class="ps-2">#</th>
                                    <th class="ps-2">Nama</th>
                                    <th class="ps-2">Status</th>
                                    <th class="ps-2">Email</th>
                                    <th class="ps-2">No HP</th>
                                    <th class="ps-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                ?>
                                @foreach($user as $data)
                                <tr>
                                    <td>
                                        <span class="text-sm">{{$no++}}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm" style="text-transform: capitalize;">{{$data->nama}}</span>
                                    </td>
                                    <td>
                                        @if($data->status == 1)
                                        <span class="badge badge-sm border border-success text-success bg-success border-radius-sm">
                                            
                                            Akun teraktivasi
                                        </span>
                                        @else
                                        <span class="badge badge-sm border border-danger text-danger bg-danger border-radius-sm">
                                           
                                            Belum teraktivasi
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-sm">{{$data->email}}</span>
                                    </td>
                                    <td>
                                        <span class="text-sm">{{$data->no_hp}}</span>
                                    </td>
                                    <td class="text-sm font-weight-semibold text-dark">
                                        <button class="btn-sm btn-warning" data-bs-toggle="modal" data-nama="{{$data->nama}}" data-bs-target="#ModalProfil{{$data->user_id}}"><i class="fa-solid fa-address-card" style="color: #ffffff;"></i></button>
                                        @if($data->status == 0)
                                        <button id="upprove" data-id="{{ encrypt($data->user_id) }}" data-nama="{{$data->nama}}" class="btn-sm btn-success upprove"><i class="fa-solid fa-check"></i></button>
                                        @endif
                                        <a data-id="{{ encrypt($data->user_id) }}" data-nama="{{$data->nama}}" class="btn-sm btn-danger p-2 delete"><i class="fa-solid fa-trash" style="color: #ffffff;"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="ModalProfil{{$data->user_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Profile information</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <ul class="list-group pl-3">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm" style="text-transform: capitalize;"><span class="text-secondary">Nama :</span> &nbsp; {{$data->nama}}</li>
                                                        <hr class="mb-0">

                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">Tanggal Lahir :</span> &nbsp; {{ Carbon\Carbon::parse($data->tgl_lahir)->isoFormat('DD MMMM YYYY') }}</li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">Jenis Kelamin :</span> &nbsp; {{$data->jenis_kelamin}}</li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">Email :</span> &nbsp; {{$data->email}}</li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">No HP :</span> &nbsp; {{$data->no_hp}}</li>
                                                        <hr class="mb-0">
                                                        <?php
                                                        $tanggal_lahir =  Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_lahir);
                                                        $umur = $tanggal_lahir->diffInYears(Carbon\Carbon::now());
                                                        ?>
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">Umur :</span> &nbsp; {{$umur}} Tahun</li>
                                                        <hr class="mb-0">
                                                        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm"><span class="text-secondary">Riwayat Penyakit :</span> &nbsp;
                                                            <span class="badge text-bg-warning text-white p-2" style="font-size: 15px; text-transform: capitalize;">{{$data->riwayat_penyakit}}</span>
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
                    window.location = "/activasi/" + usersid;
                    Swal.fire("Akun berhasil terakativasi", {
                        icon: "success",
                    });
                } else {
                    Swal.fire("Akun batal diaktivasi");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.delete').click(function(e) {
            e.preventDefault();
            var usersid = $(this).data('id');
            var nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Akun',
                text: "Apakah Anda yakin hapus akun '" + nama + "'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: 'red',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "/hapus-user/" + usersid;
                    Swal.fire("Akun berhasil dihapus", {
                        icon: "success",
                    });
                } else {
                    Swal.fire("Akun batal dihapus");
                }
            });
        });
    });
</script>




@endsection