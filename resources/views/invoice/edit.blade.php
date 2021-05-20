@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Invoice <small>Update A Invoice</small></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="quickForm" action="{{ route('orders.update', $order->id) }}" method="POST" class="repeater">
                        @method('PUT')
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="card-body">
                            <div data-repeater-list="outer-list" id="invoice-div">
                                <div class="form-group ">
                                    <label for="item">Receiver Name</label>
                                    <input type="reciever" name="receiver" value="{{ $order->receiver_name }}"
                                        class="form-control" id="receiver">
                                </div>
                                @foreach ($order->order_item as $item)
                                    <div data-repeater-item class="form-row my-div" id="append1">
                                        <div class="form-group col-md-4">
                                            <label for="item">Item Name</label>
                                            <input type="item" name="item" value="{{ $item->item }}"
                                                class="form-control item">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" value="{{ $item->price }}"
                                                class="form-control price">
                                        </div>
                                        <input type="hidden" name="hidden_id" value="{{ $item->id }}">
                                        <div class="form-group col-md-2">
                                            <label for="Quant">Quantity</label>
                                            <input type="text" name="quantity" value="{{ $item->quantity }}"
                                                class="form-control quantity">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="total">Total</label>
                                            <input type="text" name="item_total" value="{{ $item->item_total }}"
                                                class="form-control amount">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label data-repeater-delete for="Quant">Delete Item</label>
                                            <input data-repeater-delete type="button" class="form-control btn btn-danger remove_row"
                                                value="Delete" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-2">
                                <input data-repeater-create type="button" name="add" class="btn btn-primary mr-2"
                                    value="Add" />
                            </div>
                            <div class="form-group">
                                <label for="Total">Total</label>
                                <input type="text" name="total" value="{{ $item->total }}" class="form-control total">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        @csrf
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Update Invoice</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>


    @push('script')
        <script src="{{ asset('js/jquery.repeater.js') }}"></script>
        <script src="{{ asset('js/validation.js') }}"></script>
    @endpush
@endsection
