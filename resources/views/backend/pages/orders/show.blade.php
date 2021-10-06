@extends('backend.layouts.app')

@section('top-content')
<div class="page-header">
    <div class="row">
        <div class="col">
            <div class="page-header-left">
                <h3>Order Information - #{{ $order->id }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-content')

<div class="row">
    <div class="col-xl-12 xl-100">
        @include('backend.layouts.partials.messages')
        <div class="order-details">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-body">
                        <h4>Order Informations</h4>
                        <hr>
                        <div>
                            <table class="table table-info">
                                <tr>
                                    <th>Product:</th>
                                    <td>{{ $order->product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity:</th>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Delivery Location: </th>
                                    <td>
                                        <strong>Upazilla: </strong>
                                        {{ isset($order->upazila) ? $order->upazila->name : '' }}
                                        <br>

                                        <strong>District: </strong>
                                        {{ isset($order->district) ? $order->district->name : '' }}
                                        <br>
                                        <strong>Address: </strong> {{ $order->location }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Delivery Date: </th>
                                    <td>
                                        {{ $order->date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Order By: </th>
                                    <td>
                                        <a href="{{ route('admin.contacts.show', $order->createdBy->id) }}"
                                            target="_blank">
                                            {{ $order->createdBy->name }}
                                        </a>
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-body">
                        <h4>Processing Status</h4>
                        <hr>
                        <div>
                            <strong>Status: </strong>
                            {!! $order->statusPrint() !!}
                            <form class="mt-4" action="{{ route('admin.orders.activate', $order->id) }}"
                                onsubmit="return confirm('Do you want to change the order status ?')" method="post">
                                @csrf
                                <p>
                                    <strong>Change Status: </strong>
                                    <input type="radio" name="status" value="1"
                                        {{ $order->status == 1 ? 'checked' : '' }} id="check1">&nbsp;
                                    <label for="check1"> Completed</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="status" value="0"
                                        {{ $order->status == 0 ? 'checked' : '' }} id="check0">&nbsp;
                                    <label for="check0"> Processing</label>
                                </p>
                                <label for="">Order Details (optional)</label>
                                <textarea name="details" id="details" rows="3" class="form-control"
                                    placeholder="Enter Order completing details">{!! $order->details !!}</textarea>
                                <button type="submit"
                                    class="mt-2 btn btn-sm btn-{{ $order->status ? 'danger' : 'success' }}">
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