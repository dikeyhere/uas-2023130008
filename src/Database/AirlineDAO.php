<?php

namespace App\Database;

use App\Models\Airline;

class AirlineDAO extends Connection
{
    public static function all(): array
    {
        $sql = "SELECT * FROM airlines";
        $airline = self::query($sql);
        return array_map(fn($data) => new Airline($data), $airline);
    }

    public static function get(int $id): ?Airline
    {
        $sql = "SELECT * FROM airlines WHERE id = :id";
        $data = self::query($sql, ['id' => $id]);
        return $data ? new Airline($data[0]) : null;
    }
}
