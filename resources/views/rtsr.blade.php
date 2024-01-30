<!DOCTYPE html>
<html>
<head>
    <title>Real-time Update {{$deviceid}}</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <div id="rtsr" style="display: none">{{$deviceid}}</div>

    <div id="statistics">
        <p>Lowest People Count: <span id="lowestCount"></span></p>
        <p>Greatest People Count: <span id="greatestCount"></span></p>
        <p>Time Of Greatest People Count: <span id="timeOfGreatestCount"></span></p>
        <p>Time Of Lowest People Count: <span id="timeOfLowestCount"></span></p>
        <p>Average People Count: <span id="averageCount"></span></p>
        <p>Total Data Records: <span id="totalRecords"></span></p>
    </div>

    <script>
        function fetchDataAndUpdateComponent() {
            $.ajax({
                url: '/realtime/' + $('#rtsr').text(),
                method: 'GET',
                success: function(response) {
                    updateStatistics(response.data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        function updateStatistics(data) {
            const counts = data.map(entry => parseInt(entry.peoplecount)); // Parse as integers
            const lowestCount = Math.min(...counts);
            const greatestCount = Math.max(...counts);

            const entryOfLowestCount = data.find(entry => parseInt(entry.peoplecount) === lowestCount);
            const entryOfGreatestCount = data.find(entry => parseInt(entry.peoplecount) === greatestCount);

            const timeOfLowestCount = entryOfLowestCount ? entryOfLowestCount.time : 'N/A';
            const timeOfGreatestCount = entryOfGreatestCount ? entryOfGreatestCount.time : 'N/A';

            const totalRecords = data.length;
            const totalPeople = counts.reduce((sum, count) => sum + count, 0);
            const averageCount = totalPeople / totalRecords;

            $('#lowestCount').text(lowestCount);
            $('#greatestCount').text(greatestCount);
            $('#timeOfLowestCount').text(timeOfLowestCount);
            $('#timeOfGreatestCount').text(timeOfGreatestCount);
            $('#averageCount').text(averageCount.toFixed(2)); // Fix the formatting to two decimal places
            $('#totalRecords').text(totalRecords);
        }

        setInterval(fetchDataAndUpdateComponent, 3000);
        fetchDataAndUpdateComponent();
    </script>

</body>
</html>
