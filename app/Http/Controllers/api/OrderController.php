<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Order_Details;
// use App\Models\;
use App\Models\Customers;
use App\Models\Meals;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function setOrder(Request $req){
        $req->validate([
            'table_id'=>'required|exists:tables,id',
            'customer_id' => 'required|exists:customers,id',
            'reservation_id'=>'required|exists:reservations,id',
            'waiter_id'=>'required|exists:users,id',
            // 'meal_id'=>'required|exists:meals,id|array',
        ]);
        $loopMeal = json_decode($req->meal_id);
        $idMealS=[];
        foreach($loopMeal as $mealID){
             $idMeal = [
                'meal_id'=>$mealID
             ];
             array_push($idMealS,$idMeal);
        }

        $validator = Validator::make(
            ['items' => $idMealS],
            [
                'items' => 'required',
                'items.*.meal_id' => 'required|exists:meals,id', 
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $mealCounts = array_count_values(array_column($idMealS, 'meal_id'));
        $result = [];
            foreach ($mealCounts as $meal_id => $count) {
                $result []= [
                    'meal_id' => $meal_id,
                    'repeated_meal_id' => $count
                ];
            }
        $order = Orders::create([
            'table_id'=>$req->table_id,
            'customer_id'=>$req->customer_id,
            'reservation_id'=>$req->reservation_id,
            'waiter_id'=>$req->waiter_id,
            'total'=>0,
            'data' =>carbon::now()
        ]);
        $nidMealS = [];
        foreach($result as $ids){
            array_push($nidMealS,[
                'meal'=>Meals::find($ids['meal_id']),
                'repeated_meal_id'=>$ids['repeated_meal_id']
            ]);
        }
        $total = 0;
        foreach($nidMealS as $MealOnOrder){
            $meal = $MealOnOrder['meal'];
            $repeatedMealId = $MealOnOrder['repeated_meal_id'];

             if($meal['discount'] <= 20.00  || $meal['discount'] <= 70.00){
                $amountToPay = ($meal['price'] * $repeatedMealId * $meal['discount'])/100 ;
                DB::table('order__details')->insert([
                    'order_id' => $order['id'], 
                    'meal_id' => $meal['id'],
                    'amount_to_pay' => $amountToPay,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $quantity_available = $meal['quantity_available'] - $repeatedMealId;
                $total += $amountToPay;
                DB::table('meals')
                    ->where('id', $meal['id'])
                    ->update(['quantity_available' => $quantity_available]);
                DB::table('orders')
                    ->where('id', $order['id'])
                    ->update(['total' => $total]);
             }
            
        }
        $lastUpdateOnOrder = Order_Details::where('order_id',$order['id'])->get();
        $order = [
             'number Of Table ' => $req->table_id,
             'Customer' => Customers::find($req->customer_id),
             'Reservation Number ' => $req->reservation_id,
             'Meals' => $lastUpdateOnOrder
           ];
        return [
            "Massage" => 'Order Create Successfully',
            'Order_id' =>$order
        ];
    }
}
