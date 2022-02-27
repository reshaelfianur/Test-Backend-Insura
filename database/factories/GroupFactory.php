<?php

namespace Database\Factories;

use App\Models\Group;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_code'    => 'GRP' . $this->faker->randomNumber(3),
            'group_name'    => $this->faker->name,
        ];
    }
}
