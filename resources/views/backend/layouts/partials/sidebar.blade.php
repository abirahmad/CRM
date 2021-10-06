<!-- Page Sidebar Start-->
<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper">
            <a href="{{ route('admin.index') }}">
                <img src="{{ asset('public/img/logo-main.png') }}" alt="" />
            </a>
        </div>
    </div>
    <div class="sidebar custom-scrollbar">
        <div class="sidebar-user text-center">
            <div><img class="img-60 rounded-circle" src="{{ asset('public/backend/images/user/1.jpg') }}" alt="#">
                <div class="profile-edit"><a href="#" target="_blank"><i data-feather="edit"></i></a></div>
            </div>
            <h6 class="mt-3 f-14">{{ Auth::guard('admin')->user()->name }}</h6>
            <p></p>
        </div>
        
        @if(Auth::guard('admin')->user()->username != 'testakij')
            <ul class="sidebar-menu">
            <li class="{{ Route::is('admin.index') ? 'active' : '' }}"><a class="sidebar-header"
                        href="{{ route('admin.index') }}"><i data-feather="home"></i><span> Dashboard</span></a></li>
                {{--  
            <li class="{{ (Route::is('admin.employers.index')) || (Route::isin.employers.create')) ? 'active' : '' }}"><a
                    class="sidebar-header" href="#"><i data-feather="user"></i><span>Employers</span><i
                        class="fa fa-angle-right pull-right"></i></a>('adm
                <ul class="sidebar-submenu">
                    <li class="{{ (Route::is('admin.employers.index')) ? 'active' : '' }}"><a
                            href="{{ route('admin.employers.index') }}"><i class="fa fa-chevron-right"></i> Employer
                            List</a></li>
                    <li class="{{ (Route::is('admin.employers.create')) ? 'active' : '' }}"><a
                            href="{{ route('admin.employers.create') }}"><i class="fa fa-chevron-right"></i> Add New
                            Employer</a></li>
                </ul>
                </li> --}}
    
                {{--  <li class="{{ (Route::is('admin.jobs.index')) || (Route::is('admin.jobs.create')) ? 'active' : '' }}"><a
                    class="sidebar-header" href="#"><i data-feather="chevron-right"></i><span>Jobs</span><i
                        class="fa fa-angle-right pull-right"></i></a>
                <ul class="sidebar-submenu">
                    <li class="{{ (Route::is('admin.jobs.index')) ? 'active' : '' }}"><a
                            href="{{ route('admin.jobs.index') }}"><i class="fa fa-chevron-right"></i> All Job List</a></li>
                    <li class="{{ (Route::is('admin.jobs.create')) ? 'active' : '' }}"><a
                            href="{{ route('admin.jobs.create') }}"><i class="fa fa-chevron-right"></i> Add New Job</a></li>
                </ul>
                </li> --}}
    
    
                <!-- Contact -->
                <li
                    class="{{ (Route::is('admin.contacts.index')) || (Route::is('admin.contacts.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#"><i data-feather="chevron-right"></i><span>contacts</span><i
                            class="fa fa-angle-right pull-right"></i></a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.contacts.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.contacts.index') }}"><i class="fa fa-chevron-right"></i> All Contact
                                List</a></li>
                    </ul>
                </li>
    
    
                <!-- Site & Project -->
                <li class="{{ (Route::is('admin.sites.index')) || (Route::is('admin.sites.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#"><i data-feather="chevron-right"></i><span>Sites & Projects</span><i
                            class="fa fa-angle-right pull-right"></i></a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.sites.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.sites.index') }}"><i class="fa fa-chevron-right"></i>
                                All Site List</a>
                        </li>
                        <li class="{{ (Route::is('admin.projects.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.projects.index') }}"><i class="fa fa-chevron-right"></i>
                                All Project Entry</a>
                        </li>
                    </ul>
                </li>
    
                <!-- Order -->
                <li class="{{ (Route::is('admin.orders.index')) || (Route::is('admin.orders.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#">
                        <i data-feather="chevron-right"></i><span>Orders</span><i class="fa fa-angle-right pull-right"></i>
                    </a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.orders.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.orders.index') }}"><i class="fa fa-chevron-right"></i>
                                All Order List</a>
                        </li>
                    </ul>
                </li>
                
                
                <!-- Test Reports -->
                <li class="{{ (Route::is('admin.reports.index')) || (Route::is('admin.reports.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#">
                        <i data-feather="chevron-right"></i><span>Test Reports</span><i
                            class="fa fa-angle-right pull-right"></i>
                    </a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.reports.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.reports.index') }}"><i class="fa fa-chevron-right"></i>
                                All Reports</a>
                        </li>
                    </ul>
                </li>
                
                 <!-- Brand Requisition -->
                <li class="{{ (Route::is('admin.brand_requisitions.index')) || (Route::is('admin.brand_requisitions.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#">
                        <i data-feather="chevron-right"></i><span>Brand Requisition</span><i
                            class="fa fa-angle-right pull-right"></i>
                    </a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.brand_requisitions.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.brand_requisitions.index') }}"><i class="fa fa-chevron-right"></i>
                                All Requisitions</a>
                        </li>
                    </ul>
                </li>
                
    
                <!-- Complains -->
                <li
                    class="{{ (Route::is('admin.complains.index')) || (Route::is('admin.complains.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#">
                        <i data-feather="chevron-right"></i><span>Complains</span><i
                            class="fa fa-angle-right pull-right"></i>
                    </a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.complains.index')) ? 'active' : '' }}"><a
                                href="{{ route('admin.complains.index') }}"><i class="fa fa-chevron-right"></i>
                                All Complains</a>
                        </li>
                    </ul>
                </li>
                
                <!-- More -->
                <li class="{{ (Route::is('admin.surveys.index')) || (Route::is('admin.surveys.create')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#">
                        <i data-feather="chevron-right"></i><span>More</span><i
                            class="fa fa-angle-right pull-right"></i>
                    </a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.surveys.index')) ? 'active' : '' }}">
                            <a href="{{ route('admin.surveys.index') }}"><i class="fa fa-chevron-right"></i> Survey Lists</a>
                        </li>
                    </ul>
                    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.videos.index')) ? 'active' : '' }}">
                            <a href="{{ route('admin.videos.index') }}"><i class="fa fa-chevron-right"></i> Video Lists</a>
                        </li>
                    </ul>
                    
                    @if(Auth::guard('admin')->user()->unit_id == 4 || Auth::guard('admin')->user()->unit_id == 200)
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.vehicle_tracking')) ? 'active' : '' }}">
                            <a href="{{ route('admin.vehicle_tracking') }}"><i class="fa fa-chevron-right"></i> Vehicle Tracking</a>
                        </li>
                    </ul>
                    @endif
                    
                    
                    @if(Auth::guard('admin')->user()->unit_id == 116)
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.arl_tracking')) ? 'active' : '' }}">
                            <a href="{{ route('admin.arl_tracking') }}"><i class="fa fa-chevron-right"></i> All Tracking</a>
                        </li>
                    </ul>
                    @endif
                    
                    @if(Auth::guard('admin')->user()->unit_id == 2 || Auth::guard('admin')->user()->unit_id == 200)
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.outlet_tracking')) ? 'active' : '' }}">
                            <a href="{{ route('admin.outlet_tracking') }}"><i class="fa fa-chevron-right"></i> Outlet Tracking</a>
                        </li>
                    </ul>
                    @endif
                    
                    @if(Auth::guard('admin')->user()->unit_id == 17 || Auth::guard('admin')->user()->unit_id == 200)
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.vessel_tracking')) ? 'active' : '' }}">
                            <a href="{{ route('admin.vessel_tracking') }}"><i class="fa fa-chevron-right"></i> Vessel Tracking</a>
                        </li>
                        <li class="{{ (Route::is('admin.vessel_tracking')) ? 'active' : '' }}">
                            <a href="{{ route('admin.vessel_tracking_live') }}"><i class="fa fa-chevron-right"></i> Live Vessel Tracking</a>
                        </li>
                    </ul>
                    @endif
                    
                    @if (Auth::guard('admin')->user()->can('login_attempts.view') || (Auth::guard('admin')->user()->is_central_admin == 1))
                        <ul class="sidebar-submenu">
                            <li class="{{ (Route::is('admin.applications.loginStatistics')) ? 'active' : '' }}">
                                <a href="{{ route('admin.applications.loginStatistics') }}"><i class="fa fa-chevron-right"></i> Application statistics</a>
                            </li>
                        </ul>
                    @endif
                      
                    {{-- @if (Auth::guard('admin')->user()->can('login_attempts.view') || (Auth::guard('admin')->user()->is_central_admin == 1)) --}}
                        <ul class="sidebar-submenu">
                            <li class="{{ (Route::is('admin.iapp.deviceRegistration')) ? 'active' : '' }}">
                                <a href="{{ route('admin.iapp.deviceRegistration') }}"><i class="fa fa-chevron-right"></i> Device Registration</a>
                            </li>
                        </ul>
                    {{-- @endif --}}
                </li>


                <li class="{{ (Route::is('admin.trips.index')) || (Route::is('admin.trips.show')) ? 'active' : '' }}">
                    <a class="sidebar-header" href="#">
                        <i data-feather="chevron-right"></i><span>Trip</span><i
                            class="fa fa-angle-right pull-right"></i>
                    </a>
    
                    <ul class="sidebar-submenu">
                        <li class="{{ (Route::is('admin.trips.index')) ? 'active' : '' }}">
                            <a href="{{ route('admin.trips.index') }}"><i class="fa fa-chevron-right"></i> Trip List</a>
                        </li>
                    </ul>
                </li>
    
                <li><a class="sidebar-header" href="" target="_blank"><i data-feather="settings"></i><span>
                            Settings</span></a></li>
            </ul>
            
        @else
         <ul class="sidebar-menu">
            <li class="">
                <a href="https://crm.akij.net/all-users?installed=no" class="text-white"><i class="fa fa-chevron-right"></i> Not Installed User</a>
                <a href="https://crm.akij.net/all-users?installed=yes" class="text-white"><i class="fa fa-chevron-right"></i> Installed User</a>
                <a href="https://crm.akij.net/all-users" class="text-white"><i class="fa fa-chevron-right"></i> All User</a>
            </li>
        </ul>
        @endif
        
        
    </div>
</div>
<!-- Page Sidebar Ends-->