<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Auth;

class SupplierController extends Controller
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

        $suppliers = Supplier::all();
        return response()->json(['status' => 'success','result' => $suppliers]);
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
            'supplierName' => 'required',
        ]);

        if(Supplier::create($request->all())){
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
        $productgroup = Supplier::where('id', $id)->get();
        return response()->json($productgroup->first());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $todo = Supplier::where('id', $id)->get();
        return view('todo.edittodo',['todos' => $todo]);
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
            'supplierName' => 'filled',
        ]);


        if(Supplier::where('id',$id)->update($request->all())){
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
        if(Supplier::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }

    public function searches(Request $request){
        $suppliers = Supplier::where('supplierName', 'LIKE', '%'.$request->input('q').'%')
                                ->orWhere('phone','LIKE','%'.$request->input('q').'%')
                                ->get();

        if(count($suppliers)){
            return response()->json(['status' => 'success','result' => $suppliers]);
        } else{
            return response()->json(['status' => 'failed','result' => 'No data available.']);
        }

    }
}
