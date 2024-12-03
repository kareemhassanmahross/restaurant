<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Meals;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meals>
 */
class MealsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Meals::class;
    public function definition(): array
    {
        return [
            'name'=>$this->faker->name,
            'price'=>"100",
            'description'=>"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cupiditate",
            "quantity_available"=>20
        ];
    }
}
