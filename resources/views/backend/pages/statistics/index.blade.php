@extends('backend.layouts.app')

@section('title')
All Application Login Attempt Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>
                    Application Login Attempt Lists
                    @if(!isset(request()->groupBy))
                        <a href="https://crm.akij.net/application-statistics?groupBy=user_name">Get Unique User</a>
                    @else
                        <a href="https://crm.akij.net/application-statistics">Get All Login Data</a>
                    @endif
                    
                </h3>
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
                        <th>Type</th>
                        <th>Name</th>
                        <th>Version</th>
                        <th>User Name & ID</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($login_attempts as $attempt)

                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        
                        <td>
                            {{ $attempt->type }}
                        </td>
                        <td>
                            <strong class="text-primary">
                                {{ $attempt->name }}
                            </strong>
                            <br>
                        </td>
                        <td>
                            {{ $attempt->version }}
                        </td>
                        <td>
                            {{ $attempt->user_name }}
                        </td>
                        <td>
                            {{ $attempt->user_email }}
                        </td>
                        <td>
                            {{ $attempt->user_phone_number }}
                        </td>
                        <td>
                            {{ $attempt->created_at }}
                        </td>
                        <td>
                            <!--<div class="dropdown">-->
                            <!--    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"-->
                            <!--        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                            <!--        Action-->
                            <!--    </button>-->
                            <!--    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
                                    
                            <!--    </div>-->
                            <!--</div>-->
                            --
                        </td>

                    </tr>
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