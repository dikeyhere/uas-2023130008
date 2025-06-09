<?php

namespace App\Database;

use App\Models\Flight;

class FlightDAO extends Connection
{
    public function all(): array
    {
        $sql =
            "SELECT flt.*, arl.name AS airline_name, org.name AS origin_name, dst.name AS destination_name
            FROM flights flt
            JOIN airlines arl ON flt.airline_id = arl.id
            JOIN airports org ON flt.origin_id = org.id
            JOIN airports dst ON flt.destination_id = dst.id
            ORDER BY flt.id ASC";

        $flight = self::query($sql);
        return array_map(fn($data) => new Flight($data), $flight);
    }

    public function get(int $id): ?Flight
    {
        $sql =
            "SELECT flt.*, arl.name AS airline_name, org.name AS origin_name, dst.name AS destination_name
            FROM flights flt
            JOIN airlines arl ON flt.airline_id = arl.id
            JOIN airports org ON flt.origin_id = org.id
            JOIN airports dst ON flt.destination_id = dst.id
            WHERE flt.id = :id";

        $data = self::query($sql, ['id' => $id]);
        return $data ? new Flight($data[0]) : null;
    }


    public function create(Flight $flight)
    {
        $sql =
            "INSERT INTO flights (origin_id, destination_id, departure_time, arrival_time, status, airline_id)
            VALUES (:origin_id, :destination_id, :departure_time, :arrival_time, :status, :airline_id)";

        $db = self::getDB();
        $data = $db->prepare($sql);
        return $data->execute([
            'origin_id' => $flight->origin_id,
            'destination_id' => $flight->destination_id,
            'departure_time' => $flight->departure_time,
            'arrival_time' => $flight->arrival_time,
            'status' => $flight->status,
            'airline_id' => $flight->airline_id,
        ]);
    }

    public function update(int $id, string $status)
    {
        $sql = "UPDATE flights SET status = :status WHERE id = :id";
        $db = self::getDB();
        $data = $db->prepare($sql);
        return $data->execute(['status' => $status, 'id' => $id]);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM flights WHERE id = :id";
        $db = self::getDB();
        $data = $db->prepare($sql);
        return $data->execute(['id' => $id]);
    }
}
