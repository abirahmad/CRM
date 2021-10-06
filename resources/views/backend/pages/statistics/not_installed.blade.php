@extends('backend.layouts.app')

@section('title')
All Users
@endsection

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>
                    @if(isset(request()->installed) && request()->installed == 'yes')
                        Installed 
                    @elseif(isset(request()->installed) && request()->installed == 'no')
                        Not Installed 
                    @endif
                    
                    Users List
                </h3>
                <div class="ml-2">
                    @if(isset(request()->installed) && request()->installed == 'yes')
                        <a href="https://crm.akij.net/all-users?installed=no" class="btn btn-danger">See Not Installed List - {{ App\Models\Admin::getLatesVersionApp("team") }} </a>
                    @elseif(isset(request()->installed) && request()->installed == 'no')
                        <a href="https://crm.akij.net/all-users?installed=yes" class="btn btn-success"> See Installed List - {{ App\Models\Admin::getLatesVersionApp("team") }}</a>
                    @endif
                    
                    <!--<a href="https://crm.akij.net/all-users" class="btn btn-info ml-2">All List</a>-->
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="table-responsive product-table">
            <table class="display" id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Enroll</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Office</th>
                        <th>Contact Personal</th>
                        <th>Line</th>
                        <th>Region</th>
                        <th>Area</th>
                        <th>Territory</th>
                        <th>Point</th>
                        <th>Section</th>
                        <th>Latest App Installed</th>
                        <th>Installed App Version</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    
                    @if(isset(request()->installed) && request()->installed == 'yes')
                        @if(App\Models\Admin::isInstallVersion($employee->email))
                        
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            
                            <td>{{ $employee->enroll }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_no_office }}</td>
                            <td>{{ $employee->contact_no_personal }}</td>
                            <td>{{ $employee->line }}</td>
                            <td>{{ $employee->region }}</td>
                            <td>{{ $employee->area }}</td>
                            <td>{{ $employee->territory }}</td>
                            <td>{{ $employee->point }}</td>
                            <td>{{ $employee->section }}</td>
                            
                            <td>
                                {{ App\Models\Admin::isInstallVersion($employee->email) ? 'Yes' : 'No' }}
                            </td>
                            
                            <td>
                                {{ App\Models\Admin::getLatesVersionApp("team") }}
                            </td>
                            
                        </tr>
                        
                        @endif
                    @elseif(isset(request()->installed) && request()->installed == 'no')
                        @if(App\Models\Admin::isInstallVersion($employee->email) != true)
                        
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            
                            <td>{{ $employee->enroll }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_no_office }}</td>
                            <td>{{ $employee->contact_no_personal }}</td>
                            <td>{{ $employee->line }}</td>
                            <td>{{ $employee->region }}</td>
                            <td>{{ $employee->area }}</td>
                            <td>{{ $employee->territory }}</td>
                            <td>{{ $employee->point }}</td>
                            <td>{{ $employee->section }}</td>
                            
                            <td>
                                {{ App\Models\Admin::isInstallVersion($employee->email) ? 'Yes' : 'No' }}
                            </td>
                            
                            <td>
                                @if(App\Models\Admin::isInstallVersion($employee->email) == false)
                                    {{ App\Models\Admin::getInstalledVersion($employee->email, "team") }}
                                @else
                                    {{ App\Models\Admin::isInstallVersion($employee->email) }}
                                @endif
                                
                            </td>
                        </tr>
                        
                        @endif
                    @else
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            
                            <td>{{ $employee->enroll }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_no_office }}</td>
                            <td>{{ $employee->contact_no_personal }}</td>
                            <td>{{ $employee->line }}</td>
                            <td>{{ $employee->region }}</td>
                            <td>{{ $employee->area }}</td>
                            <td>{{ $employee->territory }}</td>
                            <td>{{ $employee->point }}</td>
                            <td>{{ $employee->section }}</td>
                            
                            <td>
                                {{ App\Models\Admin::isInstallVersion($employee->email) ? 'Yes' : 'No' }}
                            </td>
                            
                            <td>
                                @if(App\Models\Admin::isInstallVersion($employee->email) == false)
                                    {{ App\Models\Admin::getInstalledVersion($employee->email, "team") }}
                                @elseif(App\Models\Admin::isInstallVersion($employee->email) == true)
                                    {{ App\Models\Admin::getLatesVersionApp("team") }}
                                @endif
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#usersTable').DataTable({
        dom: 'Blfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ],
        aLengthMenu: [
            [25, 50, 100, 1000, -1],
            [25, 50, 100, 1000, "All"]
        ],
    });
</script>
@endsection