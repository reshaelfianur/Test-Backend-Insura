<?php

namespace Database\Factories;

use App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'employee_code'             => 'EMP' . $this->faker->randomNumber(3),
            'employee_first_name'       => $this->faker->firstName,
            'employee_last_name'        => $this->faker->lastName(),
            'employee_email_private'    => $this->faker->email(),
            'employee_birth_date'       => $this->faker->date(),
            'employee_basic_salary'     => $this->faker->randomNumber(8),
            'employee_description'      => $this->faker->realText(),
            'group_id'                  => $this->faker->numberBetween(1, 10),
        ];
    }
}
