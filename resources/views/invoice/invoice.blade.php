@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order with Pdf Format</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-between text-primary">
                            <h3> Receiver Name : {{ $order->receiver_name }}</h3>
                            <a href="{{ route('pdfinvoice', $order->id) }}" class="btn btn-warning">
                                <i class="fas fa-file-pdf"></i> &nbsp; PDF
                            </a>
                        </div>
                        <table id="example1" class="table table-bordered table-hover text-muted">
                            <thead>
                                <tr>
                                    <th>Item. No</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_item as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->item }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->item_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right" colspan="4">Grand Total</th>
                                    <td>{{ $order->grandtotal }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
@endsection
