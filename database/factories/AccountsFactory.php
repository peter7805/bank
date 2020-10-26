<?php

namespace Database\Factories;

use App\Models\Accounts;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Accounts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'error_number' => '1',
            'login_time' => now(),
            'create_time' => now(),
        ];
    }
}
