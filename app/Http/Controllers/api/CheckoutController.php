<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Order_Details;
use Illuminate\Support\Facades\DB;
use App\Models\Customers;
use App\Models\Meals;


class CheckoutController extends Controller
{
    public function Checkout(Request $req){
        
        $req->validate([
            'order_id'=>'required|exists:orders,id',
        ]);
        $order = Orders::find($req->order_id);
       
        $Id_Meals = [];
        $meals = Order_Details::where('order_id' , $req->order_id)->get();
        foreach($meals as $meal){
            array_push($Id_Meals,$meal->meal_id);
        }
        $meal = Meals::whereIn('id', $Id_Meals)->get();
        $orderDetails = [
            'Order Number' => $req->order_id,
            'Table Number' => $order->table_id,
            'reservation Number' => $order->reservation_id,
            'Customer' => Customers::findOrFail($order->customer_id),
            'Meals' =>$meal,
            'Total Price' =>$order->total,
            'Date' => $order->data
        ];
        DB::table('orders')
        ->where('id',$req->order_id)
        ->update(['paid' => true]);
        return $orderDetails;
    }
}
