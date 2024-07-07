<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Record {{$data->nama}}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
      
        h1 {
            color: #007bff;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-title {
            color: #28a745;
            font-weight: bold;
        }
        .table th {
           
            color: #fff;
        }
        .table td {
            background-color: #e9ecef;
        }
        .text-normal {
            color: #28a745;
            font-weight: bold;
        }
        .text-not-normal {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1 class="text-center mb-4">Health Records</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Personal Information</h5>
            <p><strong>Nama : </strong>{{$data->nama}}</p>
            <p><strong>Tanggal Lahir : </strong>{{ Carbon\Carbon::parse($data->tgl_lahir)->isoFormat('DD MMMM YYYY') }}</p>
            <p><strong>Umur : </strong> {{$umur}} Tahun</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="example" class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Tanggal Checking</th>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Nilai BPM</th>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Oksigen</th>
                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($health as $data)
                    <tr>
                        <td><span class="text-sm">{{ Carbon\Carbon::parse($data->created_at)->isoFormat('DD MMMM YYYY') }}</span></td>
                        <td><span class="text-sm">{{$data->bpm}} BPM</span></td>
                        <td><span class="text-sm">{{$data->oksigen}} %</span></td>
                        <td>
                            <?php
                            $tanggal_lahir =  Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_lahir);
                            $umur = $tanggal_lahir->diffInYears(Carbon\Carbon::now());
                            ?>
                            @if (
                            (($umur < 1 && $data->bpm >= 100 && $data->bpm <= 170) || ($umur>= 1 && $umur <= 12 && $data->bpm >= 80 && $data->bpm <= 120) || ($umur>= 13 && $umur <= 60 && $data->bpm >= 60 && $data->bpm <= 100)) && ($data->oksigen >= 95 && $data->oksigen <= 100) ) 
                            <span class="text-normal">Normal</span>
                            @else
                            <span class="text-not-normal">Tidak Normal</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
