@extends('dashboard.layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
$userId = request()->query('user_id');
@endphp

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <p style="font-weight: bold;">Hasil Rekomendasi</p>
                <hr class="mb-4">
                <p><span class="badge text-bg-success text-white" id="health-result"></span></p>
                <div class="alert alert-success" role="alert" id="health-recommendation"></div>
                <div class="data-display">
                    <p>Heart Rate: <span class="heartRateValue"></span></p>
                    <p>Oxygen Level: <span class="oxygenValue"></span></p>
                    <p>Age: <span class="ageValue"></span></p>
                </div>
                <div class="justify-content-end mt-3">
                    <a href="/history" class="btn btn-danger">Keluar<i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function fetchDataAndUpdateRecommendation() {
            var userId = "{{ $userId }}";
            $.ajax({
                url: "/health/data",
                method: "GET",
                data: {
                    user_id: userId
                },
                success: function(response) {
                    var bpmValue = response && response.bpm !== undefined ? response.bpm : 0;
                    var oxygenValue = response && response.oksigen !== undefined ? response.oksigen : 0;
                    var ageValue = response && response.age !== undefined ? response.age : "N/A";
                    $('.heartRateValue').text(bpmValue + " BPM");
                    $('.oxygenValue').text(oxygenValue + " %");
                    $('.ageValue').text(ageValue + " years");
                    showHealthRecommendation(bpmValue, oxygenValue, ageValue);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $('.heartRateValue').text(0);
                    $('.oxygenValue').text(0);
                    $('.ageValue').text(0);
                },
            });
        }

        function showHealthRecommendation(bpmValue, oxygenValue, ageValue) {
            var recommendation = "";
            var result = "";

            // Check heart rate based on age group
            var normalHeartRate = false;
            if ((ageValue < 1 && bpmValue >= 100 && bpmValue <= 170) ||
                (ageValue >= 1 && ageValue <= 12 && bpmValue >= 80 && bpmValue <= 120) ||
                (ageValue >= 13 && bpmValue <= 60 && bpmValue <= 100)) {
                normalHeartRate = true;
            }
            var normalOxygenSaturation = (oxygenValue >= 95 && oxygenValue <= 100);

            if (normalHeartRate && normalOxygenSaturation) {
                recommendation += "Untuk mempertahankan kesehatan yang optimal, teruslah menjaga pola makan seimbang dengan banyak buah, sayur, protein sehat, dan biji-bijian. Tetaplah aktif dengan rutin berolahraga seperti jalan cepat atau berenang selama 150 menit per minggu, serta lakukan latihan kekuatan dua kali seminggu. Jangan lupa untuk tetap terhidrasi dengan baik, batasi konsumsi gula dan garam, serta pastikan Anda mendapatkan istirahat yang cukup setiap malam. Terus pertahankan gaya hidup sehat ini untuk menjaga kesehatan jantung dan paru-paru Anda.";
                result = "Selamat, hasil deteksi detak jantung dan kadar oksigen Anda normal!";
            } else {
                recommendation += "Segera konsultasikan dengan dokter untuk evaluasi lebih lanjut. Sementara itu, cobalah untuk makan makanan seimbang yang kaya buah, sayur, biji-bijian, dan protein sehat. Batasi asupan garam dan gula. Mulailah dengan olahraga ringan seperti berjalan kaki atau bersepeda selama 20-30 menit, 3-5 kali seminggu, dan tambahkan latihan pernapasan dalam seperti yoga. Pastikan Anda tetap terhidrasi dengan baik dan mendapatkan istirahat yang cukup. Tetap pantau kondisi Anda dan ikuti semua saran medis yang diberikan oleh dokter. Penanganan lebih lanjut jika dirasa tubuh anda mengalami gangguan yang berlebih.";
                result = "Hasil deteksi menunjukkan bahwa detak jantung dan kadar oksigen Anda tidak normal.";
            }

            document.getElementById("health-recommendation").innerText = recommendation;
            document.getElementById("health-result").innerText = "Hasil: " + result;
        }


        fetchDataAndUpdateRecommendation();
    });
</script>
@endsection