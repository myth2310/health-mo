@extends('dashboard.layouts.app')

@section('content')
<style>
    /* CSS untuk loading spinner */
    .loader-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .loader {
        border: 8px solid #f3f3f3; /* Warna garis */
        border-top: 8px solid #3498db; /* Warna garis yang berputar */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite; /* Animasi berputar */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

@php
$userId = request()->query('user_id');
@endphp

<div id="loading" class="loader-container" style="display: none;">
    <div class="loader"></div>
</div>

<form id="healthDataForm">
    @csrf
    <input id="userId" name="user_id" value="{{ $userId }}" type="hidden">
    <input hidden type="text" class="heartRateValueField" name="bpm" id="heart-rate-input">
    <input hidden type="text" class="oxygenValueField" name="oksigen" id="spo2-input">
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
                        <h3 class="heartRateValue">Loading...</h3>
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
                        <h3 class="oxygenValue">Loading...</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchSensorData() {
            return $.ajax({
                url: '/fetch-data',
                method: 'GET'
            });
        }

        function fetchDataAndUpdateChart() {
            fetchSensorData().done(function(data) {
                var bpmValue = data.BPM;
                var oxygenValue = data.SpO2;

                $('.heartRateValue').text(bpmValue + " BPM");
                $('.oxygenValue').text(oxygenValue + " %");

                $('.heartRateValueField').val(bpmValue);
                $('.oxygenValueField').val(oxygenValue);

                updateChart(bpmValue, oxygenValue);
            }).fail(function() {
                console.error("Error fetching data");
                $('.heartRateValue').text("Failed to load data");
                $('.oxygenValue').text("Failed to load data");

                $('.heartRateValueField').val(0);
                $('.oxygenValueField').val(0);

                updateChart(0, 0);
            });
        }

        function updateChart(bpm, oxygen) {
            myBPMChart.data.datasets[0].data = [bpm, 100 - bpm];
            myBPMChart.update();
            myOxygenChart.data.datasets[0].data = [oxygen, 100 - oxygen];
            myOxygenChart.update();
        }

        function postFormData() {
            var formData = $('#healthDataForm').serialize();
            $.ajax({
                url: "/store/data",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    console.log("Data successfully posted", response);
                },
                error: function(xhr, status, error) {
                    console.error("Error posting data:", error);
                }
            });
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

        var fetchDataInterval = setInterval(fetchDataAndUpdateChart, 5000);
        var postDataInterval = setInterval(postFormData, 10000);

        setTimeout(function() {
            clearInterval(fetchDataInterval);
            clearInterval(postDataInterval);
            $('#loading').show(); // Tampilkan loading spinner
            var userId = $('#userId').val();
            window.location.href = "/hasil-rekomendasi?user_id=" + userId;
        }, 60000);
    });
</script>

@endsection
