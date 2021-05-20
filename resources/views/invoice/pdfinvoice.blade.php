<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
                #example{
                    width: 100%;    
                    background-color: #f1f1c1;
                    border: 1px solid black;
                    border-collapse: collapse;
                    text-align:center;
                }
              </style>
</head>
<body>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Invoice</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example" border="1">
                  <thead>
                  <tr>
                    <th>Invoice. No</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                  </tr>
                  </thead>
                  <tbody> 
                      @foreach ($order->order_item as $item )
                          <tr>
                          <td>{{$item->id}}</td>
                          <td>{{$item->item}}</td>
                          <td>{{$item->price}}</td>
                          <td>{{$item->quantity}}</td>
                          <td>{{$item->item_total}}</td>
                          </tr>
                      @endforeach
                  </tbody>
                  <tfoot>
                      <tr>
                        <th class="text-right" colspan="4">Grand Total</th>
                        <td>{{$order->grandtotal}}</td>
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
</body>
</html>