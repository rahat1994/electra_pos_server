<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Auth;

class PurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchases = Purchase::all();
        return response()->json(['status' => 'success','result' => $purchases]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $this->validate($request, [
            'supplier_id' => 'required',
            'quantity' => 'required',
            'total_cost' => 'required',
            'paid_amount' => 'required'
        ]);

        //  quantity will have to be calculated.

        $purchase = $request->all();
        $purchase['status'] = 'Recived';
        $purchase['net_unit_cost'] = $purchase['total_cost'] / $purchase['quantity'];

        if($purchase['total_cost'] ==  $purchase['paid_amount']){
            $purchase['payment_status'] = 'Paid';
        } else if($purchase['paid_amount'] == 0){
            $purchase['payment_status'] = 'Unpaid';
        } else{
            $purchase['payment_status'] = 'Partially Paid';
        }

        if(Purchase::create($purchase)){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::where('id', $id)->get();
        return response()->json($purchase->first());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Purchase = Purchase::where('id', $id)->get();
        return view('todo.edittodo',['todos' => $Purchase]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'purchaseName' => 'filled',
            'purchaseGroup' => 'filled',
            'warranty' => 'filled',
            'stockAlertCount' => 'filled',
            'code' => 'filled',
            'salePrice' => 'filled'
         ]);

        $Purchase = Purchase::find($id);
        if($Purchase->fill($request->all())->save()){
           return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Purchase::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }

    public function searches(Request $request){
        $Purchase = Purchase::where('purchaseName', 'LIKE', '%'.$request->input('q').'%')->get();

        if(count($Purchase)){
            return response()->json(['status' => 'success','result' => $Purchase]);
        } else{
            return response()->json(['status' => 'failed','result' => 'No data available.']);
        }

    }
}
