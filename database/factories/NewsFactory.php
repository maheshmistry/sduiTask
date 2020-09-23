<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Making dummy data with the use of Faker library
        return [
            'title'=> $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'content'=> $this->faker->text($maxNbChars = 200),
            // this will create new user every time a news via factory is made.
            'user_id' => User::factory()->create()->id,
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
