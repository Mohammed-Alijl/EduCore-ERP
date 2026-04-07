<?php

namespace Database\Factories;

use App\Models\Nationality;
use App\Models\Religion;
use App\Models\TypeBlood;
use App\Models\Users\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guardian>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password', // mutator handles hashing
            'name_father' => [
                'en' => $this->faker->firstNameMale().' '.$this->faker->lastName(),
                'ar' => 'والد '.$this->faker->firstNameMale(),
            ],
            'national_id_father' => $this->faker->unique()->numerify('10########'),
            'passport_id_father' => $this->faker->unique()->numerify('A########'),
            'phone_father' => $this->faker->phoneNumber(),
            'job_father' => [
                'en' => $this->faker->jobTitle(),
                'ar' => 'مهنة '.$this->faker->word(),
            ],
            'nationality_father_id' => Nationality::inRandomOrder()->value('id') ?? 1,
            'blood_type_father_id' => TypeBlood::inRandomOrder()->value('id') ?? 1,
            'religion_father_id' => Religion::inRandomOrder()->value('id') ?? 1,
            'address_father' => $this->faker->address(),

            'name_mother' => [
                'en' => $this->faker->firstNameFemale().' '.$this->faker->lastName(),
                'ar' => 'والدة '.$this->faker->firstNameFemale(),
            ],
            'national_id_mother' => $this->faker->unique()->numerify('10########'),
            'passport_id_mother' => $this->faker->unique()->numerify('A########'),
            'phone_mother' => $this->faker->phoneNumber(),
            'job_mother' => [
                'en' => $this->faker->jobTitle(),
                'ar' => 'مهنة '.$this->faker->word(),
            ],
            'nationality_mother_id' => Nationality::inRandomOrder()->value('id') ?? 1,
            'blood_type_mother_id' => TypeBlood::inRandomOrder()->value('id') ?? 1,
            'religion_mother_id' => Religion::inRandomOrder()->value('id') ?? 1,
            'address_mother' => $this->faker->address(),
        ];
    }
}
