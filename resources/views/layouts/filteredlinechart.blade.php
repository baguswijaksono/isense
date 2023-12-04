<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="lineChart"></canvas>
            </div>
            <script>
                var ctx = document.getElementById('lineChart').getContext('2d');

                var data = {
                    labels: [
                        @foreach ($data as $cdStat)
                            '{{ date('H:i', strtotime($cdStat->time)) }}',
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
            </script>
