<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Auth;

class ProductController extends Controller
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
        $products = Product::all();
        return response()->json(['status' => 'success','result' => $products]);
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
            'productName' => 'required',
            'productGroup' => 'required',
            'warranty' => 'required',
            'stockAlertCount' => 'required',
            'code' => 'required',
            'salePrice' => 'required',
        ]);

        if(Product::create($request->all())){
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
        $product = Product::where('id', $id)->get();
        return response()->json($product);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Product = Product::where('id', $id)->get();
        return view('todo.edittodo',['todos' => $Product]);
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
            'productName' => 'filled',
            'productGroup' => 'filled',
            'warranty' => 'filled',
            'stockAlertCount' => 'filled',
            'code' => 'filled',
            'salePrice' => 'filled'
         ]);

        $Product = Product::find($id);
        if($Product->fill($request->all())->save()){
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
        if(Product::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }

    public function searches(Request $request){
        $Product = Product::where('productName', 'LIKE', '%'.$request->input('q').'%')->get();

        if(count($Product)){
            return response()->json(['status' => 'success','result' => $Product]);
        } else{
            return response()->json(['status' => 'failed','result' => 'No data available.']);
        }

    }
}
