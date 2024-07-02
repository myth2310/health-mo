<!DOCTYPE html>
<html>
<head>
    <title>Checking</title>
</head>
<body>
    <h1>Checking</h1>
    <p>User ID: {{ $userId }}</p>
    <div>
        <p>BPM: <span id="bpm">Loading...</span></p>
        <p>SpO2: <span id="spo2">Loading...</span></p>
    </div>

    <script>
        const userId = '{{ $userId }}';

        function fetchData() {
            fetch(`/get-data/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('bpm').innerText = data.bpm;
                        document.getElementById('spo2').innerText = data.oksigen;
                    } else {
                        document.getElementById('bpm').innerText = 'No data';
                        document.getElementById('spo2').innerText = 'No data';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('bpm').innerText = 'Error';
                    document.getElementById('spo2').innerText = 'Error';
                });
        }

        setInterval(fetchData, 1000); // Fetch data every second
    </script>
</body>
</html>
