<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meals;
use App\Http\Resources\MealResource;
use App\Http\Requests\meal\StoreMealRequest;
use App\Http\Requests\meal\UpdateMealRequest;

class MealController extends Controller
{
    public function index(){
        return MealResource::collection(Meals::all());
    }
    public function show(Meals $meal){
        return MealResource::make($meal);
    }
    public function store(StoreMealRequest $req){

        $meal = Meals::create($req->validated());
        return MealResource::make($meal);

    } 
    public function update(UpdateMealRequest $req ,Meals $meal ){

        $meal->update($req->validated());
        return MealResource::make($meal);

    } 
    public function destroy(Meals $meal){
        $meal->delete();
        return response()->noContent();
    }
}
