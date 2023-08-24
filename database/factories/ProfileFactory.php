<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $year = rand(2000, 2016);  // Generate a random year between 2000 and 2016
        $month = rand(1, 12);       // Generate a random month between 1 and 12
        $day = rand(1, 28);         // Generate a random day between 1 and 28 (assuming all months have 28 days)

        $streetNames = ['Main', 'Park', 'Oak', 'Cedar', 'Maple', 'Pine', 'Elm', 'Spruce', 'Willow'];
        $streetTypes = ['Street', 'Avenue', 'Road', 'Lane', 'Boulevard', 'Drive', 'Court', 'Place'];
        $cityNames = ['Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Depok', 'Tangerang', 'Manado', 'Bogor', 'Malang', 'Batam', 'Padang', 'Denpasar', 'Bekasi'];

        $roleNames = ['student', 'teacher', 'staff', 'management'];
        $gradeLevelNames = ['elementary', 'junior', 'senior',];
        $role = $roleNames[array_rand($roleNames)];
        $gradeLevel = ($role == 'student') ? $gradeLevelNames[array_rand($gradeLevelNames)] : '';
        $yearJoin =  rand(date('Y', strtotime('three years ago')), date('Y', time()));

        $randomStreetName = $streetNames[array_rand($streetNames)];
        $randomStreetType = $streetTypes[array_rand($streetTypes)];

        return [
            'user_id' => User::factory(),
            'full_name' => $this->faker->name,
            'gender' => rand(0, 1) ? 'male' : 'female',
            'birth_date' => date('Y-m-d', mktime(0, 0, 0, $month, $day, $year)),
            'role' => $role,
            'grade_level' => $gradeLevel,
            'year_join' => $yearJoin,
            'address_street' => rand(1, 999) . ' ' . $randomStreetName . ' ' . $randomStreetType,
            'address_city' => $cityNames[array_rand($cityNames)],
            'address_zip' => rand(10000, 99999),
        ];
    }
}
