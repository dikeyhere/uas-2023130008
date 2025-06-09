<?php

namespace App\Database;

use App\Models\Airport;

class AirportDAO extends Connection
{
    public static function all(): array
    {
        $sql = "SELECT * FROM airports";
        $airport = self::query($sql);
        return array_map(fn($data) => new Airport($data), $airport);
    }

    public static function get(int $id): ?Airport
    {
        $sql = "SELECT * FROM airports WHERE id = :id";
        $data = self::query($sql, ['id' => $id]);
        return $data ? new Airport($data[0]) : null;
    }
}
