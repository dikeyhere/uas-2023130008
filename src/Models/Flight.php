<?php

namespace App\Models;

class Flight
{
    public ?int $id;
    public int $origin_id;
    public int $destination_id;
    public string $departure_time;
    public string $arrival_time;
    public string $status;
    public int $airline_id;
    public ?string $airline_name;
    public ?string $origin_name;
    public ?string $destination_name;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->origin_id = $data['origin_id'];
        $this->destination_id = $data['destination_id'];
        $this->departure_time = $data['departure_time'];
        $this->arrival_time = $data['arrival_time'];
        $this->status = $data['status'];
        $this->airline_id = $data['airline_id'];

        $this->airline_name = $data['airline_name'] ?? null;
        $this->origin_name = $data['origin_name'] ?? null;
        $this->destination_name = $data['destination_name'] ?? null;
    }
}
