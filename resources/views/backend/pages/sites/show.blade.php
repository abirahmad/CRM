@extends('backend.layouts.app')

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left">
                <h3>Contact Information - {{ $contact->name }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="contact-details">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-body">
                        <h4>Primary Informations</h4>
                        <hr>
                        <div>
                            <strong>Name:</strong> {{ $contact->name }}
                            <br>
                            <strong>Designation:</strong> {{ $contact->designation }}
                            <br>
                            <strong>Email:</strong> {{ $contact->email }}
                            <br>
                            <strong>Phone:</strong> {{ $contact->phone_no }}
                            <br>
                            <strong>Registration Time: </strong>
                            {{ $contact->created_at }} 
                            <!--<span class="text-info">({{ $contact->created_at->diffForHumans() }})</span>-->
                        </div>

                        <div>
                            <strong>
                                Status:
                            </strong>
                            {!! $contact->statusPrint() !!}
                            <form class="mt-4" action="{{ route('admin.contacts.activate', $contact->id) }}"
                                onsubmit="return confirm('Do you want to change the contacts status ?')" method="post">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm btn-{{ $contact->status ? 'danger' : 'success' }}">
                                    <i class="fa fa-check"></i> {{ $contact->status ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card card-body">
                        <h4>More Informations</h4>
                        <hr>
                        <div class="mt-3">

                            <strong>Upazilla: </strong> {{ isset($contact->upazilla) ? $contact->upazilla->name : '' }}
                            <br>

                            <strong>District: </strong> {{ isset($contact->district) ? $contact->district->name : '' }}
                            <br>

                            <strong>Office Address: </strong> {{ $contact->office_address }}
                            <br>
                            <strong>Facebook:</strong> <a href="{{ $contact->fb_address }}"
                                target="_blank">{{ $contact->fb_address }}</a>
                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-body">
                        <h4>Reference Informations</h4>
                        <hr>
                        <div>
                            <table class="table table-info table-responsive">
                                <tr>
                                    <th>Name</th>
                                    <th>Relation</th>
                                    <th>Birthdate / Marriage Date</th>
                                </tr>

                                @foreach ($contact->references as $reference)
                                @if($reference->relation->name == 'Wife')
                                <tr>
                                    <td>{{ $reference->name }}</td>
                                    <td>{{ $reference->relation->name }}</td>
                                    <td>
                                        {{ $reference->marriage_date }}
                                    </td>
                                </tr>
                                @endif
                                @endforeach

                                @foreach ($contact->references as $reference)
                                @if($reference->relation->name != 'Wife')
                                <tr>
                                    <td>{{ $reference->name }}</td>
                                    <td>{{ $reference->relation->name }}</td>
                                    <td>
                                        {{ $reference->birthdate }}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
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