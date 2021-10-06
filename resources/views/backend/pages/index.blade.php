@extends('backend.layouts.app')

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left">
                <h3>Admin Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i data-feather="home"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-content')

{{-- if (!auth()->user()->can('superadmin_dashboard.view')) {
    abort(403, 'Unauthorized action.');
} --}}

<div class="row">
    <div class="col-xl-8 xl-100 dashboard-page">
        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-widget-dashboard">
                            <div class="media" onclick='location.href="{{ route('admin.contacts.index') }}"'>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0 f-w-600">
                                        <span class="counter">
                                            {{ $total_contacts }}
                                        </span>
                                    </h5>
                                    <p>Total Contacts</p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $total_pending_contacts }}
                                        </span>
                                        Pending Contacts
                                    </p>
                                </div><i data-feather="user"></i>
                            </div>
                            <div class="dashboard-chart-container">
                                <div class="small-chart-gradient-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Single item -->

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-widget-dashboard">
                            <div class="media" onclick='location.href="{{ route('admin.sites.index') }}"'>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0 f-w-600">
                                        <span class="counter">
                                            {{ $total_sites }}
                                        </span>
                                    </h5>
                                    <p>Total Sites</p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $total_pending_sites }}
                                        </span>
                                        Pending Sites
                                    </p>
                                </div><i data-feather="info"></i>
                            </div>
                            <div class="dashboard-chart-container">
                                <div class="small-chart-gradient-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Single item -->

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-widget-dashboard">
                            <div class="media" onclick='location.href="{{ route('admin.projects.index') }}"'>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0 f-w-600">
                                        <span class="counter">
                                            {{ $total_projects }}
                                        </span>
                                    </h5>
                                    <p>Total Projects</p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $total_pending_projects }}
                                        </span>
                                        Pending Projects
                                    </p>
                                </div><i data-feather="shopping-cart"></i>
                            </div>
                            <div class="dashboard-chart-container">
                                <div class="small-chart-gradient-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Single item -->

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-widget-dashboard">
                            <div class="media" onclick='location.href="{{ route('admin.sites.index') }}"'>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0 f-w-600">
                                        <span class="counter">
                                            {{ $total_complains }}
                                        </span>
                                    </h5>
                                    <p>Total Complains</p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $total_pending_complains }}
                                        </span>
                                        Pending Complains
                                    </p>
                                </div><i data-feather="bell"></i>
                            </div>
                            <div class="dashboard-chart-container">
                                <div class="small-chart-gradient-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Single item -->

             <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-widget-dashboard">
                            <div class="media" onclick='location.href="{{ route('admin.reports.index') }}"'>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0 f-w-600">
                                        <span class="counter">
                                            {{ $total_test_report }}
                                        </span>
                                    </h5>
                                    <p>Total Test Reports</p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $total_test_report }}
                                        </span>
                                       Test Reports
                                    </p>
                                </div><i data-feather="folder"></i>
                            </div>
                            <div class="dashboard-chart-container">
                                <div class="small-chart-gradient-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Single item -->


            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-widget-dashboard">
                            <div class="media" onclick='location.href="{{ route('admin.brand_requisitions.index') }}"'>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-0 f-w-600">
                                        <span class="counter">
                                            {{ $brand_requisition }}
                                        </span>
                                    </h5>
                                    <p>Total Brnad Requisition</p>
                                    <p>
                                        <span class="badge badge-info">
                                            {{ $brand_requisition }}
                                        </span>
                                       Brand Requsition
                                    </p>
                                </div><i data-feather="package"></i>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

        </div>
    </div>
</div> <!-- end .row -->


@endsection