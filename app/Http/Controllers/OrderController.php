<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrederItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Constraints\SeeInOrder;
use SebastianBergmann\Environment\Console;
use Dompdf\Adapter\CPDF;      
use Dompdf\Dompdf;
use Dompdf\Exception;
use Illuminate\Support\Facades\Validator;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        return view('invoice.create');
    }

  
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'receiver' =>'required',
            'outer-list.*.item' => 'required',
            'outer-list.*.price' => 'required|numeric',
            'outer-list.*.quantity' => 'required|numeric',
        ]);
  
            $data = $request->all();
            $orders = new Order();
            $orders->user_id =Auth::id();
            $orders->receiver_name =$request->input('receiver');
            $orders->grandtotal =$request->input('total');
            $orders->save();

            foreach($data['outer-list'] as $item)
            {   
                $orederItem = new OrederItem();
                $orederItem->item =$item['item'];
                $orederItem->price =$item['price'];
                $orederItem->quantity =$item['quantity'];
                $orederItem->item_total =$item['item_total'];
                $orederItem->order_id =$orders->id;
                $orederItem->total =$request->total;
                $orederItem->save();

            }
        
        return redirect()->route('orders.index');
    }


    public function allinvoice(Request $request)
    {
        $order = $request->all();
        $draw = $order['draw'];
        $start = $order['start'];
        $rowperpage =$order['length']; // Rows display per page

        $columnIndex =$order['order'][0]['column']; // Column index
        $columnName =$order['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder =$order['order'][0]['dir']; // asc or desc
        $searchValue = $order['search']['value']; // Search value
        
        
      
        // Total records
        $totalRecords = Order::select('count(*) as allcount')
            ->where('user_id', Auth::user()->id)
            ->when($searchValue !='',function($query) use($searchValue){
            return $query->where('user_id', 'like', '%' . $searchValue . '%')
            ->orwhere('receiver_name', 'like', '%' . $searchValue . '%')
            ->orwhere('grandtotal', 'like', '%' . $searchValue . '%');
            })->count();
                
           
        // Fetch records
        $records = Order::orderBy($columnName, $columnSortOrder)
        ->orderBy('id', 'desc')
        ->where('user_id', Auth::user()->id)
        ->when($searchValue !='',function($query) use($searchValue){
            return $query->where('user_id', 'like', '%' . $searchValue . '%')
            ->orwhere('receiver_name', 'like', '%' . $searchValue . '%')
            ->orwhere('grandtotal', 'like', '%' . $searchValue . '%');
            })
            ->select('orders.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        
        
        
        foreach ($records as $record) {
            $id = $record->id;
            $receiver_name = $record->receiver_name;
            $grandtotal = $record->grandtotal;
            $action = '<a href="' . route('orders.edit', $record->id) . '"  class="edit btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                      </a>
                      <a href="' . route('orders.show', $record->id) . '"  class="view btn btn-warning btn-sm">
                            <i class="fas fa-table"></i>
                      </a>
                      <a href="javascript:void(0);" data-url="' . route('orders.destroy', $record->id) . '" id="delete-book" 
                        data-id=' . $record->id . '  class="delete btn btn-danger btn-sm">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                      </a>';
           
          
            $data_arr[] = array(
                "id" => $id,
                "receiver_name" => $receiver_name,
                "grandtotal" =>$grandtotal,
                "action" => $action,
            );
        }
        
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data_arr
        );

        return response()->json($response, 200);
    
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('invoice.invoice',compact('order'));
    }

    // table to pdf
    
    public function pdfinvoice($id)
    {
        $output = '';
        $order = Order::findOrFail($id);
        $html = view('invoice.pdfinvoice',compact('order'))->render();
          
        $filename = $order->id .'-document';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream($filename);
        return view('invoice.invoice',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        
        $order = Order::findOrfail($id);
        return view('invoice.edit',compact('order'));
    }
    


    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'receiver' =>'required',
            'outer-list.*.item' => 'required',
            'outer-list.*.price' => 'required',
            'outer-list.*.quantity' => 'required',
        ]);

   
        $order = Order::findOrFail($id);
        $order->receiver_name  = $request->input('receiver');
        $order->grandtotal  = $request->input('total');
        $order->save();
      
        //order item
        $datalist = $request->all();
        $collect = collect($request->input('outer-list'))->whereNotNull('hidden_id')->pluck('hidden_id');
        $collect1 = collect($request->input('outer-list'))->whereNull('hidden_id')->pluck('hidden_id');
        if ($collect->count() > 0 || $collect1->count()>0)  {
            $delete = OrederItem::whereNotIn('id',$collect)->where('order_id',$id)->delete();
        }

       foreach($datalist['outer-list'] as $item)
        { 
            $data = [
                'item' =>$item['item'],
                'price' =>$item['price'],
                'quantity' =>$item['quantity'],
                'item_total' =>$item['item_total'],                 
                'total' =>$request->total,
            ];

            //update or create
            $orderItem =  Orederitem::updateOrCreate(['id'=>$item['hidden_id'],'order_id' => $id],$data);
        } 
        return redirect()->route('orders.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['success'=>'order Deleted successfully']);
    }
}
