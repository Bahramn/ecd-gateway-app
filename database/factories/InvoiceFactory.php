<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(Invoice::STATUSES),
            'total_amount' => $this->faker->randomNumber(4, true),
            'uuid' => $this->faker->uuid
        ];
    }

    public function statusNew(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Invoice::STATUS_PENDING,
            ];
        });
    }
}
