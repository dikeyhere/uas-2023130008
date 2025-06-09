<?php

namespace App\Models;

class Airline
{
    public int $id;
    public string $icao;
    public string $name;
    public ?string $country;

    public function __construct(array $data = [])
    {
        if ($data) {
            $this->id = $data['id'];
            $this->icao = $data['icao'];
            $this->name = $data['name'];
            $this->country = $data['country'];
        }
    }
}
