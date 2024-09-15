@extends('layouts.master')
@section('title', 'New Booking')
@section('content')
    <div>
        <!--begin::Toolbar-->
        <div class="mb-5">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-500">
                                <i class="bi bi-house fs-3 text-gray-400 me-n1"></i>
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="{{ route('admin.bookings.index') }}" class="text-gray-500">
                                Bookings
                            </a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            New Booking
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0 mb-3">
                        New Booking
                    </h1>
                    <p class="text-muted">
                        Here you can create a new booking. please fill in the form below.
                    </p>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->

                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div class="my-3">
            <form action="{{ route('admin.bookings.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="room_id" class="form-label">Room</label>
                            <select name="room_id" id="room_id" class="form-select">
                                <option value="">Select Room</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}"
                                            data-details-url="{{ route('admin.rooms.details', encodeId($room->id)) }}"
                                    >{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="purpose]" class="form-label">Purpose</label>
                            <textarea name="purpose" id="purpose" class="form-control"></textarea>
                        </div>

                        <div class="my-5 d-inline-flex gap-4">
                            <button type="submit" class="btn btn-primary">Create Booking</button>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        {{--                        room details--}}
                        <div class="card card-body">
                            <h3 class="fw-bold">Room Details</h3>
                            <p class="small text-muted">
                                Below are the details of the room you selected.
                            </p>

                            <div id="room_details"></div>
                        </div>

                    </div>
                </div>

            </form>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function () {
            $('#room_id').on('change', function () {
                let url = $(this).find(':selected').data('details-url');

                if (url) {
                    let $roomDetails = $('#room_details');
                    // add a loader inside the room details
                    $roomDetails.html(`<div class="d-flex justify-content-center">
  <div class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>`);
                    // fetch the room details
                    $.get(url, function (response) {
                        $roomDetails.html(response);
                    });

                }
            });
        });
    </script>

@endpush
