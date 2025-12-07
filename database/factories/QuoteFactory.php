<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webkul\Quote\Models\Quote;
use Webkul\User\Models\User;
use Webkul\Contact\Models\Person;

class QuoteFactory extends Factory
{
    protected $model = Quote::class;

    public function definition(): array
    {
        $subTotal = $this->faker->randomFloat(4, 100, 50000);

        $discountPercent = $this->faker->boolean(40)
            ? $this->faker->randomFloat(2, 1, 30)
            : 0;

        $discountAmount = $discountPercent > 0
            ? round($subTotal * $discountPercent / 100, 4)
            : $this->faker->randomFloat(4, 0, 2000);

        $taxAmount = round(($subTotal - $discountAmount) * $this->faker->randomFloat(2, 0, 0.1), 4);

        $adjustmentAmount = $this->faker->boolean(20)
            ? $this->faker->randomFloat(4, -500, 500)
            : 0;

        $grandTotal = max(
            0,
            round($subTotal - $discountAmount + $taxAmount + $adjustmentAmount, 4)
        );

        $userId = class_exists(User::class)
            ? User::inRandomOrder()->value('id')
            : null;

        $personId = class_exists(Person::class)
            ? Person::inRandomOrder()->value('id')
            : null;

        return [
            'subject' => $this->faker->sentence(4),
            'description' => $this->faker->sentence(12),

            'billing_address' => [
                'address1' => $this->faker->streetAddress(),
                'city'     => $this->faker->city(),
                'state'    => $this->faker->state(),
                'postcode' => $this->faker->postcode(),
                'country'  => $this->faker->country(),
            ],

            'shipping_address' => [
                'address1' => $this->faker->streetAddress(),
                'city'     => $this->faker->city(),
                'state'    => $this->faker->state(),
                'postcode' => $this->faker->postcode(),
                'country'  => $this->faker->country(),
            ],

            'discount_percent'  => $discountPercent,
            'discount_amount'   => $discountAmount,
            'tax_amount'        => $taxAmount,
            'adjustment_amount' => $adjustmentAmount,
            'sub_total'         => $subTotal,
            'grand_total'       => $grandTotal,

            'expired_at' => $this->faker->dateTimeBetween('+7 days', '+90 days'),

            'user_id'   => $userId,
            'person_id' => $personId,
        ];
    }
}