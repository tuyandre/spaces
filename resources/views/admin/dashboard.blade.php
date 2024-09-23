@extends('layouts.master')
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
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">Dashboard</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <i class="bi bi-chevron-right fs-4 text-gray-700 mx-n1"></i>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-gray-700">
                            Analytics
                        </li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">
                        Dashboard
                    </h1>
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
            <livewire:dashboard.room-statistics/>
            <div class="row">
                <!-- Recent Booking -->
                <div class="col-lg-12 mb-4">
                    <div class="card border tw-border-zinc-300">
                        <div class="card-body">
                            <h3>
                                Recent Booking
                            </h3>
                            <p>
                                Below are the recent bookings made by the users.
                            </p>
                            <livewire:dashboard.recent-booking/>
                        </div>
                    </div>
                </div>
                <!-- Room Statistics -->
            </div>
            <div class="row">
                <!-- Room Status Overview -->
                <div class="col-lg-6 mb-4">
                    <div class="card border tw-border-zinc-300">
                        <div class="card-body">
                            <h4>
                                Room Status Overview
                            </h4>
                            <p>
                                Below are the recent room status overview.
                            </p>
                            <livewire:dashboard.room-status-overview/>
                        </div>
                    </div>
                </div>
                <!-- Upcoming Maintenance -->
                <div class="col-lg-6 mb-4">
                    <div class="card border tw-border-zinc-300 h-100">
                        <div class="card-body">
                            <h4>
                                Upcoming Maintenance
                            </h4>
                            <livewire:dashboard.upcoming-maintenance/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')

@endpush
