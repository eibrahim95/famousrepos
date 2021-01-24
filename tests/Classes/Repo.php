<?php
namespace Tests\Classes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repo
{
    use HasFactory;

    public $id;
    public $name;
    public $full_name;
    public $html_url;
    public $description;
    public $created_at;
    public $updated_at;
    public $stargazers_count;
    public $language;
    public $owner;

    /**
     * Repo constructor.
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }


    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

}
