<?php

namespace App\Models;

class Airport
{
    public int $id;
    public string $iata;
    public string $name;
    public string $country;

    public function __construct(array $data = [])
    {
        if ($data) {
            $this->id = $data['id'];
            $this->iata = $data['iata'];
            $this->name = $data['name'];
            $this->country = $data['country'];
        }
    }
}
