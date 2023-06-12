<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $accommodation_type = $this->faker->randomElement(['منزل ملك', 'منزل أجار', 'مركز إيواء', 'خيمة', 'أخر']);
        return [
            'phone' => '09' . $this->faker->numerify('########'),
            'registration_summary_number' => $this->faker->numerify('###########'),
            'landline_phone_number' => '03342' . $this->faker->numerify('#####'),
            'current_place_of_residence' => $this->faker->randomElement(['حماه', 'حمص', 'كفربهم', 'حلب', 'دمشق']),
            'accommodation_type' => $accommodation_type,
            'monthly_rent_value' => ($accommodation_type == 'أجار') ? $this->faker->numberBetween(100000, 250000) : '',
            'district_number' => $this->faker->randomElement([
                "1", "5", "9", "13", "17",
                "2", "6", "10", "14", "18",
                "3", "7", "11", "15", "19",
                "4", "8", "12", "16", "20",
            ]),
            'block_number' => $this->faker->randomElement([
                '1', '2', '3', '4', '5',
                '6', '7', '8', '9', '10',
                '11', '12', '13', '14', '15'
            ]),
            'notes' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam corporis accusamus nam exercitationem quasi enim facilis officia veniam harum, mollitia consectetur magni esse ex alias, ducimus molestiae ea, aut magnam?'
        ];
    }
}
