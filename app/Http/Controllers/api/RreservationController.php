<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservations;
use Carbon\Carbon;

class RreservationController extends Controller
{
    public function store(Request $req){
        $req->validate([
            'table_id'=>'required',
            'from_time' => 'required|date',
            'to_time' => 'required|date',
            'customer_id' => 'required|exists:customers,id'
        ]);
        $from_time = Carbon::createFromFormat('d-m-Y H:i', $req->from_time)->format('Y-m-d H:i:s');
        $to_time = Carbon::createFromFormat('d-m-Y H:i', $req->to_time)->format('Y-m-d H:i:s');
        $Reservation = Reservations::create([
            'table_id'=>$req->table_id,
            'from_time'=>$from_time,
            'to_time'=>$to_time,
            'customer_id'=>$req->customer_id,
        ]);

        return  [
            "customer" => $Reservation,
            "Massage" => "Reservation Created Successfully" 
           ];;
    }
}
