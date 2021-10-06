@extends('backend.layouts.app')

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left">
                <h3>Complain Information - #{{ $complain->id }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="complain-details">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-body">
                        <h4>Complain Informations</h4>
                        <hr>
                        <div>
                            <table class="table table-info">
                                <tr>
                                    <th>Site:</th>
                                    <td>{{ isset($complain->site) ? $complain->site->name : '' }}</td>
                                </tr>

                                <tr>
                                    <th>Message:</th>
                                    <td>{!! $complain->message !!}</td>
                                </tr>

                                <tr>
                                    <th>Complain By: </th>
                                    <td>
                                        <a href="{{ route('admin.contacts.show', $complain->createdBy->id) }}"
                                            target="_blank">
                                            {{ $complain->createdBy->name }}
                                        </a>
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-body">
                        <h4>Resolved Status</h4>
                        <hr>
                        <div>
                            <strong>Status: </strong>
                            {!! $complain->statusPrint() !!}
                            <form class="mt-4" action="{{ route('admin.complains.activate', $complain->id) }}"
                                onsubmit="return confirm('Do you want to change the complain status ?')" method="post">
                                @csrf
                                <p>
                                    <strong>Change Status: </strong>
                                    <input type="radio" name="status" value="1"
                                        {{ $complain->status == 1 ? 'checked' : '' }} id="check1">&nbsp;
                                    <label for="check1"> Resolved</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="status" value="0"
                                        {{ $complain->status == 0 ? 'checked' : '' }} id="check0">&nbsp;
                                    <label for="check0"> Pending</label>
                                </p>
                                <label for="">Complain Resolved Message (optional)</label>
                                <textarea name="reply_message" id="reply_message" rows="3" class="form-control"
                                    placeholder="Enter Complain Delivery details">{!! $complain->reply_message !!}</textarea>
                                <button type="submit"
                                    class="mt-2 btn btn-sm btn-{{ $complain->status ? 'danger' : 'success' }}">
                                    <i class="fa fa-check"></i>
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // 
</script>
@endsection