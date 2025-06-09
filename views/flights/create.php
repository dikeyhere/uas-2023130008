<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\Flight;
use App\Database\FlightDAO;
use App\Database\AirlineDAO;
use App\Database\AirportDAO;

$AirportDAO = new AirportDAO();
$airports = $AirportDAO->all();
$AirlineDAO = new AirlineDAO();
$airlines = $AirlineDAO->all();
$FlightDAO = new FlightDAO();

$errors = [];

$airline_id = '';
$origin_id = '';
$destination_id = '';
$departure_time = '';
$arrival_time = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $airline_id = $_POST['airline_id'];
    $origin_id = $_POST['origin_id'];
    $destination_id = $_POST['destination_id'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];

    if ($origin_id === $destination_id) {
        $errors[] = "WARNING : Departure and arrival airports cannot be the same.";
    }
    if (new DateTime($arrival_time) <= new DateTime($departure_time)) {
        $errors[] = "WARNING : Arrival time cannot be earlier than departure time.";
    }
    if (!$errors) {
        $flight = new Flight([
            'origin_id' => $origin_id,
            'destination_id' => $destination_id,
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
            'status' => 'SCHEDULED',
            'airline_id' => $airline_id,
        ]);

        $FlightDAO->create($flight);
        header('Location: /flights');
        exit;
    }
}
?>

<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4 mb-4 pb-4 pt-2">
    <h2 class="text-center pb-2">New Flight Schedule</h2>

    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?= implode('<br>', $errors); ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label pb-1">Airline</label>
            <select name="airline_id" class="form-control" required>
                <option value="" disabled selected>-- Select Airline --</option>
                <?php foreach ($airlines as $airline): ?>
                    <option value="<?= $airline->id ?>" <?= $airline->id == $airline_id ? 'selected' : '' ?>>
                        <?= $airline->name ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label pb-1">Departure Airport</label>
            <select name="origin_id" class="form-control" required>
                <option value="" disabled selected>-- Select Airport --</option>
                <?php foreach ($airports as $airport): ?>
                    <option value="<?= $airport->id ?>" <?= $airport->id == $origin_id ? 'selected' : '' ?>>
                        <?= $airport->name ?> (<?= $airport->iata ?>)
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label pb-1">Arrival Airport</label>
            <select name="destination_id" class="form-control" required>
                <option value="" disabled selected>-- Select Airport --</option>
                <?php foreach ($airports as $airport): ?>
                    <option value="<?= $airport->id ?>" <?= $airport->id == $destination_id ? 'selected' : '' ?>>
                        <?= $airport->name ?> (<?= $airport->iata ?>)
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label pb-1">Departure Time</label>
            <input type="datetime-local" name="departure_time" class="form-control" required
                value="<?= $departure_time ?>">
        </div>
        <div class="mb-3">
            <label class="form-label pb-1">Arrival Time</label>
            <input type="datetime-local" name="arrival_time" class="form-control" required
                value="<?= $arrival_time ?>">
        </div>
        <div class="text-center pt-2 pe-5">
            <button class="btn btn-success">Save Flight</button>
            <a href="/flights" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>