@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DataTable With Order Invoice</h3>
                        <a href="{{ route('orders.create') }}" class="btn btn-success float-right">Create Invoice</a>
                        <a href="javascript:void(0)" id="index" data-url="{{ route('allinvoice') }}"></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Invoice. No</th>
                                    <th>Receiver Name</th>
                                    <th>Grand Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Invoice. No</th>
                                    <th>Receiver Name</th>
                                    <th>Grand Total</th>
                                    <th>Action</th>
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


    @push('script')
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var dburl = $('#index').data('url');
                var table = $('#example2').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: dburl,
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'receiver_name'
                        },
                        {
                            data: 'grandtotal'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]

                });

                $('body').on('click', '.delete', function() {
                    if (confirm("Delete Record?") == true) {
                        var el = $(this);
                        var url = el.data('url');
                        // ajax
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                // alert("success");
                                table.draw();
                            },
                            error: function(response) {
                                console.log('Error:', response);
                            }
                        });
                    }
                });
            });

        </script>

    @endpush
@endsection
