<?php
namespace Tests\factories;

use Tests\Classes\Owner;
use Tests\Classes\Repo;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Repo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(0, 1000),
            'name' => $this->faker->name,
            'full_name' => $this->faker->name,
            'html_url' => $this->faker->url,
            'description' => $this->faker->text,
            'created_at' => $this->faker->dateTime->format("Y-dd-mm"),
            'updated_at' => $this->faker->dateTime->format("Y-dd-mm"),
            'stargazers_count' => $this->faker->numberBetween(0, 1000),
            'language' => $this->faker->text,
            'owner' => Owner::factory()->make()
        ];
    }
}
