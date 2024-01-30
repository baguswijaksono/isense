<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="lineChart"></canvas>
<script>
    var ctx = document.getElementById('lineChart').getContext('2d');

    var data = {
        labels: [
            @foreach ($data as $cdStat)
                '{{ date('H:i:s', strtotime($cdStat->time)) }}',
            @endforeach
        ],
        datasets: [{
                label: 'People on Crowd',
                data: [
                    @foreach ($data as $cdStat)
                        {{ $cdStat->peoplecount }},
                    @endforeach
                ],
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                borderWidth: 2,
            },
            {
                label: 'People without mask',
                data: [
                    @foreach ($data as $cdStat)
                        {{ $cdStat->people_without_mask }},
                    @endforeach
                ],
                borderColor: 'red',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                borderWidth: 2,
            },
            {
                label: 'People with mask',
                data: [
                    @foreach ($data as $cdStat)
                        {{ $cdStat->people_with_mask }},
                    @endforeach
                ],
                borderColor: 'green',
                backgroundColor: 'rgba(0, 255, 0, 0.2)',
                borderWidth: 2,
            },
            {
                label: 'Max Crowd Boundaries',
                data: [
                    @foreach ($data as $cdStat)
                        {{ $maxcrowd }},
                    @endforeach
                ],
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
</script>
