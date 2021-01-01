<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Order_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('orders.index',compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // return $request->all();

        DB::transaction(function() use($request){

        // Order Model
        $order = new Order;
        $order->name = $request->customer_name;
        $order->phone = $request->customer_phone;

        $order->save();

        $order_id = $order->id;  // This id will be used in next section

        // Order Details Model
        for ($product_id=0; $product_id < count($request->product_id) ; $product_id++) { 

            $order_details = new Order_Detail;
            $order_details->order_id = $order_id;
            $order_details->product_id = $request->product_id[$product_id];
            $order_details->quantity = $request->quantity[$product_id];
            $order_details->unity_price = $request->price[$product_id];
            $order_details->discount = $request->discount[$product_id];
            $order_details->amount = $request->total_amount[$product_id];

            $order_details->save();
        }

        // Transaction Model
        $transaction = new Transaction;
        $transaction->user_id = auth()->user()->id;
        $transaction->order_id = $order_id;
        $transaction->balance = $request->balance;
        $transaction->paid_amount = $request->paid_amount;
        $transaction->payment_method = $request->payment_method;
        $transaction->transact_amount = $order_details->amount;
        $transaction->transact_date = date('Y-m-d');

        $transaction->save();
        
        // Last order history:
        $products = Product::all();
        $order_details = Order_Detail::where('order_id',$order_id)->get();
        $orderBy = Order::where('id',$order_id)->get();

        return view('orders.index',compact('products','order_details','orderBy'));
        });

        return back()->with("Echec lors de l'insertion de la commande !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
