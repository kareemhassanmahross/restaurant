<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customers;

class CustomerController extends Controller
{
    public function register(Request $request)
    {
            $request->validate([
                'name'  => ['required','string'],
                'phone' => ['required', 'regex:/^01[0-2,5][0-9]{8}$/', 'size:11','unique:customers'],
            ]);   


            $customer = Customers::create([
              'name' =>$request->name,
              'phone' =>$request->phone
            ]);
            $token = $customer->createToken('Auth_token')->plainTextToken;

            return [
             "customer" => $customer,
             "token" => $token,
             "Status" => "Customer Created Successfully" 
            ];
    }
}
