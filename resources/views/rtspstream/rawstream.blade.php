@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        .iframe-container {
            width: 100%;
            height: 250px;
        }

        .iframe-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="ratio ratio-16x9" style="width: 820px;">
                    <video id="video" autoplay="true" controls="controls"></video>
                    <script>
                        if (Hls.isSupported()) {
                            var video = document.getElementById('video');
                            var hls = new Hls();
                            // bind them together
                            hls.attachMedia(video);
                            hls.on(Hls.Events.MEDIA_ATTACHED, function() {
                                console.log("video and hls.js are now bound together !");
                                hls.loadSource("{{ $data->raw_url }}");
                                hls.on(Hls.Events.MANIFEST_PARSED, function(event, data) {
                                    console.log("manifest loaded, found " + data.levels.length + " quality level");
                                });
                            });
                        }
                    </script>
                </div>
                <div class="video-info">
                    <div class="row justify-content-between">
                        <div class="col p-2">
                            <h1 class="video-title">{{ $data->name }}</h1>
                        </div>
                        <div class="col-1 p-2">
                            <a href="{{ route('cdstatisticfilt', ['id' => $data->name]) }}" class="btn btn-dark btn-sm" >Stat</a>
                        </div>
                    </div>
                    <p class="video-description">{{ $data->description }}</p>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Select Stream</label>
                    <select id="streamSelect" class="form-select" aria-label="Default select example">
                        <option selected>{{ $data->name }}</option>
                        @foreach ($listdata as $astream)
                            @if ($data->name != $astream->name)
                                <option value="{{ $astream->id }}">{{ $astream->name }}</option>
                            @else
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="iframe-container">
                    <iframe src="/rtlc/{{ $data->name }}" frameborder="0"></iframe>
                </div>
                <div class="iframe-container">
                    <iframe src="/rtsr/{{ $data->name }}" frameborder="0"></iframe>
                </div>
                <script>
                    var streamSelect = document.getElementById("streamSelect");
                    streamSelect.addEventListener("change", function() {
                        var selectedValue = streamSelect.value;
                        if (selectedValue !== "Select Another Stream") {
                            window.location.href = "/stream/" + selectedValue + "/raw";
                        }
                    });
                </script>
            </div>

  <!-- Alert container -->
  <div class="container mt-3">
    <div id="alertContainer"></div>
  </div>

  <!-- jQuery and Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Your custom JavaScript -->
<!-- Your custom JavaScript -->
<script>
  // Function to fetch data from the API endpoint
  function fetchData() {
    $.ajax({
      url: 'http://127.0.0.1:8000/alerts/{{ $data->name }}',
      method: 'GET',
      success: function(response) {
        const { data } = response;

        const alertHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Overcrowd on ${data.deviceid} ${data.peoplecount} people in the area during ${data.time} on ${data.date}
            <button type="button" class="btn-close dismiss-alert" data-dismiss="alert" aria-label="Close" data-id="${data._id}">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        `;

        $('#alertContainer').html(alertHTML);
      },
      error: function(error) {
        console.error('Error fetching data:', error);
      }
    });
  }

  // Function to mark the alert as seen
  function markAsSeen(alertId) {
    $.ajax({
      url: `/markasseen/${alertId}`,
      method: 'GET',
      success: function(response) {
        // Handle success if needed
      },
      error: function(error) {
        console.error('Error marking as seen:', error);
      }
    });
  }

  // Event listener for close button clicks within the alert container
  $(document).on('click', '.dismiss-alert', function() {
    const alertId = $(this).data('id');
    markAsSeen(alertId);
    $(this).closest('.alert').hide(); // or .remove() if you want to remove it
  });

  // Call fetchData function when the page loads
  $(document).ready(function() {
    fetchData(); // Fetch data initially
    // Refresh data every 10 seconds
    setInterval(fetchData, 10000);
  });
</script>



        </div>
    </div>
@endsection