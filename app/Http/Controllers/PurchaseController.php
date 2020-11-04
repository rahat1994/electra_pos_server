<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\ProductPurchase;
use App\Models\Product;
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


        $this->validate($request, [
            'supplier_id' => 'required',
            'paid_amount' => 'required',
            'purchased_products' => 'required|array|min:1'
        ]);

        $purchase = $request->all();

        // 1. create the purchase.
        // 2. create the related purchase products.
        // 3. Update Inventory.

        // note: Implement Transactions

        $purchase['product_variety_count'] = count($purchase['purchased_products']);
        $stored_purchase = Purchase::create($purchase);
        // dd($stored_purchase->id);
        if ( $stored_purchase) {

            foreach ($purchase['purchased_products'] as $key => $value) {

                $product = Product::find($value['product_id']);
                $total_cost = $value['total_cost'];

                $product_purchase['purchase_id'] = $stored_purchase->id;
                $product_purchase['product_id'] = $product->id;
                $product_purchase['quantity'] = $value['quantity'];
                $product_purchase['total_cost'] = $value['total_cost'];
                $product_purchase['net_unit_cost'] = round($value['total_cost'] / $value['quantity'], 2);

                ProductPurchase::create($product_purchase);
            }


        } else{

        }


        //  quantity will have to be calculated.
        //
        foreach ($purchase['purchased_products'] as $key => $value) {

            $product = Product::find($value['product_id']);
            dd($product);


        }

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
