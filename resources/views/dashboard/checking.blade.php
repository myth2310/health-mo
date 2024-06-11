@extends('dashboard.layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $userId = request()->query('user_id');
@endphp

<form action="">
    <input type="text" value="{{$userId}}">
    <input type="text" class="heartRateValue" >
    <input type="text"  class="oxygenValue">
</form>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body" style="width: 100%; height: 10%;">
                <h5 class="text-center">Detak Jantung / Menit</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <canvas id="bpm-chart"></canvas>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <p style="font-weight: bold;">Heart Rate</p>
                        <h3 class="heartRateValue">Loading...</h3> <!-- Placeholder for BPM value -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body" style="width: 100%; height: 10%;">
                <h5 class="text-center">Kadar Oksigen / Menit</h5>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <canvas id="oxygen-chart"></canvas>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <p style="font-weight: bold;">Kadar Oksigen</p>
                        <h3 class="oxygenValue">Loading...</h3> <!-- Placeholder for oxygen value -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>
<script>
    $(document).ready(function() {
        function fetchDataAndUpdateChart() {
            $.ajax({
                url: "/health/data",
                method: "GET",
                success: function(response) {
                    var bpmValue = response && response.bpm !== undefined ? response.bpm : 0;
                    var oxygenValue = response && response.oksigen !== undefined ? response.oksigen : 0;
                    $('.heartRateValue').text(bpmValue + " BPM");
                    $('.oxygenValue').text(oxygenValue + " %");
                    updateChart(bpmValue, oxygenValue);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $('.heartRateValue').text("Failed to load data");
                    $('.oxygenValue').text("Failed to load data");
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

        setTimeout(function() {
            window.location.href = "/hasil-rekomendasi";
        }, 60000);
    });
</script>
@endsection
