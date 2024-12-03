<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;
use App\Models\Table;
use App\Models\Reservations;
use App\Models\WaitingList;
use Carbon\Carbon;

class ChechAvailableTableController extends Controller
{   
    public function CheckTableAvailble(Request $req){

        $req->validate([
            'from_time' => ['required',
            function ($attribute, $value, $fail) {
                $from_time = Carbon::createFromFormat('d-m-Y H:i', $value);
                $day = $from_time->format('d-m-Y');
                $start = Carbon::parse("$day 13:00");
                $end = Carbon::parse("$day 00:00")->addDay();
                $inputTime = Carbon::parse($value);
                if (!$inputTime->between($start, $end)) {
                    $fail("The $attribute must be between $start and $end.");
                }
            }
        ],
        'to_time' => ['required',
        function ($attribute, $value, $fail) {
            $to_time = Carbon::createFromFormat('d-m-Y H:i', $value);
            $dayToTime = $to_time->format('d-m-Y');
            $startToTime = Carbon::parse("$dayToTime 13:00");
            $endToTime = Carbon::parse("$dayToTime 23:59")->addDay();
            $inputTime = Carbon::parse($value);
            if (!$inputTime->between($startToTime, $endToTime)) {
                $fail("The $attribute must be between $startToTime and $endToTime.");
            }
                    }
                ],
                'capacity' => 'required',
            ]);

            // $this->day($req->fromtime);
            $tables = Table::where('capacity',$req->capacity)->get();

        
        $from_time = Carbon::createFromFormat('d-m-Y H:i', $req->from_time)->format('Y-m-d H:i');
        $to_time = Carbon::createFromFormat('d-m-Y H:i', $req->to_time)->format('Y-m-d H:i');

        $availableTables = [];

         foreach ($tables as $table){
            // $reservations = Reservations::where('table_id', $table->id)
            // ->whereBetween('from_time',[$from_time,$to_time])
            // ->whereBetween('to_time',[$from_time,$to_time])
            // ->get();
            $reservations = Reservations::where('table_id', $table->id)
                ->where(function ($query) use ($from_time, $to_time) {
                    $query->where(function ($q) use ($from_time, $to_time) {
                        $q->where('from_time', '<', $to_time)
                        ->where('to_time', '>', $from_time);
                    });
                })
                ->get();

            if ($reservations->isEmpty()) {
                $availableTables[] = $table;
            }
         }
         if (count($availableTables) != 0) {
            return[
            'message' => 'there are table at this time '.$from_time ,
            'available_tables' => $availableTables,
            'status' => 1
            ];
        } else {
            return [
                'message' => 'There is no table at this time '.$from_time,
                'status' => 0
            ];
        }
    }
    public function reserveTable(Request $req){
        $req->validate([
            'table_id'=>'required',
        ]);

        $capacity = Table::find($req->table_id);

        $data = [
            'from_time' => $req-> from_time,
             'to_time' => $req-> to_time,
             'capacity' => $capacity->capacity,
         ];

         $request = new Request($data);

         $ChechAvailableTableController = new ChechAvailableTableController();
         $CheckAvalibleTable = $ChechAvailableTableController->CheckTableAvailble($request);

         $from_time = Carbon::createFromFormat('d-m-Y H:i', $req->from_time)->format('Y-m-d H:i:s');
         $to_time = Carbon::createFromFormat('d-m-Y H:i', $req->to_time)->format('Y-m-d H:i:s');
         if($CheckAvalibleTable['status'] == 1){
            $tablesIdreserve  = []; 
            foreach($CheckAvalibleTable['available_tables'] as $tableID){
                      array_push($tablesIdreserve,$tableID->id);
            } 
            if(in_array($req->table_id, $tablesIdreserve)){
               $Reservation = Reservations::create([
                           'table_id'=>$req->table_id,
                           'from_time'=>$from_time,
                           'to_time'=>$to_time,
                           'customer_id'=>$req->customer_id,
                       ]);
                       return [
                           'message' => 'Your reservation has been made at time '.$from_time." to ".$to_time." number of Table is ".$req->table_id,
                           'Reservation' => $Reservation,
                           'status' => true
                       ];
            }   
   
         }else{
            $Cst = Customers::find($req->customer_id);
            $waitingList =  WaitingList::create([
                'name'=>$Cst->name,
                'phone'=>$Cst->phone,
                'from_time'=>$from_time,
                'to_time'=>$to_time,
            ]);
            return [
               'message' => 'There is no table at this time '.$from_time,
               'this Data added in waiting list'=> $waitingList,
               'status' => false
           ];
        } 
    }
}
