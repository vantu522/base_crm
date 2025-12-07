<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Webkul\Contact\Models\Person;
use Webkul\User\Models\User;
use Webkul\Contact\Models\Organization;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        $userId = class_exists(User::class) ? User::inRandomOrder()->value('id') : null;
        $orgId  = class_exists(Organization::class) ? Organization::inRandomOrder()->value('id') : null;

        return [
            'name' => $this->faker->name(),
            'emails' => [
                $this->faker->unique()->safeEmail(),
                ...($this->faker->boolean(30) ? [$this->faker->safeEmail()] : []),
            ],

            'contact_numbers' => [
                $this->faker->numerify('0#########'),  // ví dụ 0xxxxxxxxx
                ...($this->faker->boolean(25) ? [$this->faker->numerify('0#########')] : []),
            ],

            'job_title' => $this->faker->jobTitle(),
            'user_id' => $userId,
            'organization_id' => $orgId,
            'unique_id' => strtoupper(Str::random(10)),
        ];
    }

    public function withUser(): static
    {
        return $this->state(function () {
            return [
                'user_id' => User::factory()->create()->id,
            ];
        });
    }

    public function withOrganization(): static
    {
        return $this->state(function () {
            return [
                'organization_id' => Organization::factory()->create()->id,
            ];
        });
    }
}
