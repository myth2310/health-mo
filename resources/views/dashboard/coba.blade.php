<!DOCTYPE html>
<html>
<head>
    <title>Heart Rate Monitor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchSensorData() {
                $.ajax({
                    url: '/fetch-data',
                    method: 'GET',
                    success: function(data) {
                        $('#heart-rate-input').val(data.BPM);
                        $('#spo2-input').val(data.SpO2);
                    },
                    error: function() {
                        $('#heart-rate-input').val('Error');
                        $('#spo2-input').val('Error');
                    }
                });
            }

            fetchSensorData(); // Initial fetch
            setInterval(fetchSensorData, 1000); // Fetch every second
        });
    </script>
</head>
<body>
    <div>
        <label for="heart-rate-input">Heart Rate (BPM):</label>
        <input type="text" id="heart-rate-input" readonly>
    </div>
    <div>
        <label for="spo2-input">SpO2 (%):</label>
        <input type="text" id="spo2-input" readonly>
    </div>
</body>
</html>
