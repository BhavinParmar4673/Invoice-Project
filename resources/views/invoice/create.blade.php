@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Invoice <small>Create A Invoice</small></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="quickForm" action="{{ route('orders.store') }}" method="POST" class="repeater">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="card-body">
                            <div data-repeater-list="outer-list" id="invoice-div">
                                <div class="form-group">
                                    <label for="item">Receiver Name</label>
                                    <input type="text" name="receiver" class="form-control" value="{{ old('receiver') }}">
                                </div>
                                <div data-repeater-item class="form-row my-div" id="append1">
                                    <div class="form-group col-md-4">
                                        <label for="item">Item Name</label>
                                        <input type="text" name="item" value="{{ old('item') }}"
                                            class="form-control item">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="price">Price</label>
                                        <input type="text" name="price" value="{{ old('price') }}"
                                            class="form-control price">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="Quant">Quantity</label>
                                        <input type="text" name="quantity" value="{{ old('quantity') }}"
                                            class="form-control quantity">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="total">Total</label>
                                        <input type="text" name="item_total" value="{{ old('item_total') }}"
                                            class="form-control amount">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label data-repeater-delete for="Quant">Delete Item</label>
                                        <input data-repeater-delete type="button" class="form-control btn btn-danger remove_row"
                                            value="Delete" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <input data-repeater-create type="button" class="btn btn-primary mr-2" value="Add" />
                            </div>
                            <div class="form-group">
                                <label for="Total">Total</label>
                                <input type="text" name="total" value="{{ old('total') }}" class="form-control total">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        @csrf
                        <div class="card-footer">
                            <button type="submit" id="invoice" class="btn btn-primary">Save Invoice</button>
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
