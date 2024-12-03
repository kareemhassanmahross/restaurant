<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Http\Resources\TableResource;
use App\Http\Requests\table\StoreTableRequest;
use App\Http\Requests\table\UpdateTableRequest;




class TableController extends Controller
{
    public function index(){
         
        $tables = TableResource::collection(Table::all());
        return $tables;
    }
    public function show(Table $table){
        return TableResource::make($table);
    }
    public function store(StoreTableRequest $req){

        $table = Table::create($req->validated());
        return TableResource::make($table);

    } 
    public function update(UpdateTableRequest $req , Table $table){

        $table -> update($req->validated());
        return TableResource::make($table);

    }
    public function destroy(Table $table){
        $table->delete();
        return response()->noContent();
    }

}
