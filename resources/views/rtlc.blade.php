<!DOCTYPE html>
<html>
<head>
    <title>Real-time Update {{$deviceid}}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div id="deviceIDContainer" style="display: none">{{$deviceid}}</div>
    <canvas id="lineChart"></canvas>

    <script>
        var ctx = document.getElementById('lineChart').getContext('2d');

        var data = {
            labels: [],
            datasets: [{
                label: 'People on Crowd',
                data: [],
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                borderWidth: 2,
            }]
        };

        var options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        var lineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });

        var deviceIdValue = document.getElementById('deviceIDContainer').innerText;

        function fetchDataAndUpdateComponent() {
            $.ajax({
                
                url: '/realtime/' + deviceIdValue,
                method: 'GET',
                success: function (response) {
                    var newData = response.data;
                    lineChart.data.labels = [];
                    lineChart.data.datasets[0].data = [];

                    newData.forEach(function (item) {
                        lineChart.data.labels.push(item.time);
                        lineChart.data.datasets[0].data.push(item.peoplecount);
                    });
                    lineChart.update();
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        setInterval(fetchDataAndUpdateComponent, 3000);
        fetchDataAndUpdateComponent();
    </script>

</body>
</html>
