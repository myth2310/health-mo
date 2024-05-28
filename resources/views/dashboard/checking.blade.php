@extends('dashboard.layouts.app')
@section('content')


<!-- <div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body" style="width: 100%; height: 10%;">
                <h5 class="text-center">Detak Jantung / (Minute)</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <canvas id="bpm-chart"></canvas>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <p style="font-weight: bold;">Heart Rate</p>
                        <h3 id="heartRateValue">75 BPM</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body" style="width: 100%; height: 10%;">
                <h5 class="text-center">Kadar Oksigen / (Minute)</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <canvas id="bpm-chart1"></canvas>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <p style="font-weight: bold;">Kadar Oksigen</p>
                        <h3 id="heartRateValue">75 %</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p style="font-weight: bold;">Hasil Rekomendasi</p>
                <hr class="mb-4">
                <p>Hasil : <span class="badge text-bg-success text-white">Kondisi Normal</span></p>
                <div class="alert alert-success" role="alert" id="health-recommendation">
                </div>
                <div class="justify-content-end mt-3">
                    <button class="btn btn-danger">Keluar<i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    // Data untuk chart
    var data = {
        labels: [],
        datasets: [{
            data: [80, 20], // Ganti dengan nilai BPM dan sisa
            backgroundColor: [
                '#ff66cc',
                '#ffffff' // Warna putih untuk bagian sisa
            ],
            hoverBackgroundColor: [
                '#ff66cc',
                '#ffffff'
            ]
        }]
    };
    var options = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        }
    };


    var ctx = document.getElementById("bpm-chart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });
</script>

<script>
    var data = {
        labels: [],
        datasets: [{
            data: [80, 20],
            backgroundColor: [
                '#ff66cc',
                '#ffffff'
            ],
            hoverBackgroundColor: [
                '#ff66cc',
                '#ffffff'
            ]
        }]
    };

    var options = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        }
    };

    var ctx = document.getElementById("bpm-chart1").getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
    });
</script> -->

<!-- Pastikan Anda sudah memuat jQuery dan Chart.js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body" style="width: 100%; height: 10%;">
                <h5 class="text-center">Detak Jantung / (Minute)</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <canvas id="bpm-chart"></canvas>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <p style="font-weight: bold;">Heart Rate</p>
                        <h3 id="heartRateValue">Loading...</h3> <!-- Placeholder for BPM value -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body" style="width: 100%; height: 10%;">
                <h5 class="text-center">Kadar Oksigen / (Minute)</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <canvas id="oxygen-chart"></canvas>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <p style="font-weight: bold;">Kadar Oksigen</p>
                        <h3 id="oxygenValue">Loading...</h3> <!-- Placeholder for oxygen value -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p style="font-weight: bold;">Hasil Rekomendasi</p>
                <hr class="mb-4">
                <p><span class="badge text-bg-success text-white" id="health-result"></span></p>
                <div class="alert alert-success" role="alert" id="health-recommendation">
                </div>
                <div class="justify-content-end mt-3">
                    <button class="btn btn-danger">Keluar<i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Fungsi untuk mengambil data dari server
        function fetchDataAndUpdateChart() {
    $.ajax({
        url: "/health/data",
        method: "GET",
        success: function(response) {
            // Memperbarui nilai BPM dan kadar oksigen di HTML
            var bpmValue = response && response.bpm !== undefined ? response.bpm : 0;
            var oxygenValue = response && response.oksigen !== undefined ? response.oksigen : 0;
            $('#heartRateValue').text(bpmValue + " BPM");
            $('#oxygenValue').text(oxygenValue + " %");
            updateChart(bpmValue, oxygenValue);
            showHealthRecommendation(bpmValue, oxygenValue); // Memanggil fungsi rekomendasi
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
            $('#heartRateValue').text("Failed to load data");
            $('#oxygenValue').text("Failed to load data");
            updateChart(0, 0);
        },
        complete: function() {
            setTimeout(fetchDataAndUpdateChart, 1000);
        }
    });
}


        function updateChart(bpm, oxygen) {
            myBPMChart.data.datasets[0].data = [bpm, 100 - bpm];
            myBPMChart.update();
            myOxygenChart.data.datasets[0].data = [oxygen, 100 - oxygen];
            myOxygenChart.update();
        }

        var ctxBPM = document.getElementById("bpm-chart").getContext("2d");
        var myBPMChart = new Chart(ctxBPM, {
            type: 'doughnut',
            data: {
                labels: ['BPM', ''],
                datasets: [{
                    data: [0, 100],
                    backgroundColor: ['#ff66cc', '#ffffff'],
                    hoverBackgroundColor: ['#ff66cc', '#ffffff']
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                }
            }
        });
        var ctxOxygen = document.getElementById("oxygen-chart").getContext("2d");
        var myOxygenChart = new Chart(ctxOxygen, {
            type: 'doughnut',
            data: {
                labels: ['Oxygen', ''],
                datasets: [{
                    data: [0, 100],
                    backgroundColor: ['#66ccff', '#ffffff'],
                    hoverBackgroundColor: ['#66ccff', '#ffffff']
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                }
            }
        });
        fetchDataAndUpdateChart();

        function showHealthRecommendation(bpmValue, kadarValue) {
            var recommendation = "";
            var result = "Kondisi Normal";

            if (bpmValue < 60 || bpmValue > 100) {
                recommendation += "Nilai BPM di luar kisaran normal (60-100 BPM). Periksakan ke dokter jika diperlukan. ";
                result = "BPM di luar kisaran normal";
            }
            if (kadarValue < 70 || kadarValue > 140) {
                recommendation += "Nilai kadar di luar kisaran normal (70-140 mg/dL). Periksakan ke dokter jika diperlukan. ";
                result = "Kadar di luar kisaran normal";
            }
            if (recommendation === "") {
                recommendation = "Nilai BPM dan kadar dalam kisaran normal. Tetap pertahankan gaya hidup sehat!";
            }

            document.getElementById("health-recommendation").innerText = recommendation;
            document.getElementById("health-result").innerText = "Hasil : " + result;
        }
    });
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        saveOrUpdateHealthData(2, 80, 95);
    });

    function saveOrUpdateHealthData(user_id, bpm, oksigen) {
        $.ajax({
            url: "/health/store",
            method: "POST",
            data: {
                user_id: user_id,
                bpm: bpm,
                oksigen: oksigen
            },
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
</script>

@endsection