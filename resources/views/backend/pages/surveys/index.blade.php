@extends('backend.layouts.app')

@section('title')
All Survey Lists |
{{ isset(Auth::guard('admin')->user()->unit) ? Auth::guard('admin')->user()->unit->name : '' }}
@endsection

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left float-left">
                <h3>Survey Lists</h3>
            </div>
            <div class="clearfix"></div>
            <div class="text-right">
                <a  href="{{route('admin.surveys.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>Add New Survey</a>  
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="table-responsive product-table">
            <table class="display" id="surveysTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surveys as $survey)

                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            <strong class="text-primary">
                                {{ $survey->title }}
                            </strong>
                            <br>
                        </td>
                        <td>
                            {!! $survey->link !!}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('admin.surveys.edit', $survey->id) }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item" href="#deleteModal{{ $survey->id }}"
                                        data-toggle="modal"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </div>
                        </td>

                    </tr>

                    <!-- Delete Modal -->
                    <div class="modal fade delete-modal" id="deleteModal{{ $survey->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to delete ?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        Survey all informations will be deleted. Please
                                        be sure
                                        first to delete.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.surveys.destroy', $survey->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success"><i
                                                class="fa fa-check"></i> Confirm Delete</button>
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                                class="fa fa-times"></i> Close</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#surveysTable').DataTable({
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