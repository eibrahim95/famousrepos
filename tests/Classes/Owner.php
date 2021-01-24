<?php
namespace Tests\Classes;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Owner
{
    use HasFactory;

    public $id;
    public $login;
    public $html_url;

    /**
     * Owner constructor.
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
