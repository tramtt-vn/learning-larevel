<?php
namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
class CustomerFactory extends Factory {
    protected $model = Customer::class;
    public function definition():array {
        return [
            'name' => fake() -> name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '0' . fake()->numerify('#########'),
            'address' => fake()->address(),
            'password' => Hash::make('password123'),
        ];
    }
}
?>
