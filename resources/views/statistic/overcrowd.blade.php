@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="container">
        @if ($data && count($data) > 0)
            @foreach ($data as $item)
                <div class="alert alert-danger alert-dismissible fade show" role="alert" data-alert-id="{{ $item->id }}">
                    Overcrowd on {{ $item->deviceid }}:
                    {{ $item->peoplecount }} people in the area during {{ $item->time }} on {{ $item->date }}
                    <button type="button" class="btn-close dismiss-alert" aria-label="Close" data-alert-id="{{ $item->id }}"></button>
                </div>

                <script>
                    $(document).ready(function() {
                        $('.dismiss-alert[data-alert-id="{{ $item->id }}"]').on('click', function() {
                            var alertId = $(this).data('alert-id');
                            $(this).closest('.alert').remove(); // Dismiss the alert

                            // AJAX request to mark the alert as seen
                            $.ajax({
                                url: "{{ route('markasseen', ['alertsid' => $item->id]) }}",
                                method: 'GET',
                                data: {
                                    id: alertId
                                },
                                success: function(response) {
                                    console.log('Alert marked as seen');
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });
                        });
                    });
                </script>
            @endforeach
        @else
            <div class="alert alert-info" role="alert">
                No overcrowd alerts found.
            </div>
        @endif
    </div>


@endsection
