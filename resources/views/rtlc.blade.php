<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div id="deviceIDContainer" style="display: none">{{ $deviceid }}</div>
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
            },
            {
                label: 'People Without Mask',
                data: [],
                borderColor: 'red',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                borderWidth: 2,
            },
            {
                label: 'People With Mask',
                data: [],
                borderColor: 'green',
                backgroundColor: 'rgba(0, 255, 0, 0.2)',
                borderWidth: 2,
            },
            {
                label: 'Max Crowd Boundaries',
                data: [],
                borderColor: 'yellow',
                backgroundColor: 'rgba(255, 255, 0, 0.2)',
                borderWidth: 2,
            }
        ]
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
            success: function(response) {
                var newData = response.data;
                lineChart.data.labels = [];
                var maxCrowdValue = {{$maxcrowd}};

                // Resetting data arrays for all datasets
                for (var i = 0; i < lineChart.data.datasets.length; i++) {
                    lineChart.data.datasets[i].data = [];
                }

                newData.forEach(function(item, index) {
                    lineChart.data.labels.push(item.time);

                    // Pushing data to respective datasets
                    lineChart.data.datasets[0].data.push(item.peoplecount);
                    lineChart.data.datasets[2].data.push(item
                    .people_with_mask); // Replace 'anotherDataSetValue' with your second dataset value
                    lineChart.data.datasets[1].data.push(item
                    .people_without_mask); // Replace 'yetAnotherDataSetValue' with your third dataset value
                    lineChart.data.datasets[3].data.push(maxCrowdValue);
                });


                lineChart.update();
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    setInterval(fetchDataAndUpdateComponent, 5000);
    fetchDataAndUpdateComponent();
</script>
