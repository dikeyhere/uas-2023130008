<?php
session_start();

use App\Database\FlightDAO;

$id = $_GET['id'];

$FlightDAO = new FlightDAO();
$flight = $FlightDAO->get($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newstatus = $_POST['status'];
    $FlightDAO->update($flight->id, $newstatus);
    $_SESSION['sucmsg'] = "Flight status successfully updated.";
    header('Location: /flights');
    exit;
}

require_once __DIR__ . '/../../views/templates/header.php';
?>

<div class="container mt-4">
    <h2 class="text-center pt-2 pb-2">Change Flight Status</h2>
    <form method="post" class="mt-3">

        <div class="row g-4 ps-4">
            <div class="col-md-5 pe-5 me-5">
                <div class="row mb-3">
                    <label class="form-label ps-1">Flight ID</label>
                    <input type="text" class="form-control" value="<?= $flight->id ?>" readonly disabled>
                </div>

                <div class="row">
                    <label class="form-label ps-1">Departure Airport</label>
                    <input type="text" class="form-control" value="<?= $flight->origin_name ?>" readonly disabled>
                </div>
            </div>

            <div class="col-md-6 ps-5 ms-3">
                <div class="row mb-3">
                    <label class="form-label ps-1">Airline</label>
                    <input type="text" class="form-control" value="<?= $flight->airline_name ?>" readonly disabled>
                </div>

                <div class="row">
                    <label class="form-label ps-1">Arrival Airport</label>
                    <input type="text" class="form-control" value="<?= $flight->destination_name ?>" readonly disabled>
                </div>
            </div>

            <div class="mb-0 ps-0 pe-4 mt-3">
                <label class="form-label ps-1">Current Status</label>
                <input type="text" class="form-control" value="<?= $flight->status ?>" readonly disabled>
            </div>

            <div class="mb-3 ps-0 pe-4 mt-3">
                <label class="form-label ps-1">Change Status To</label>
                <select name="status" class="form-select" required>
                    <?php
                    $statuslist = ['SCHEDULED', 'ACTIVE', 'CANCELLED', 'DELAYED', 'BOARDING', 'LANDED', 'REDIRECTED', 'DIVERTED'];
                    foreach ($statuslist as $status) {
                        $selected = ($flight->status === $status) ? 'selected' : '';
                        echo "<option value='" . $status . "' $selected>" . $status . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="text-center mt-1 mb-3 ps-0 pe-5 ms-0 me-0">
                <button type="submit" class="btn btn-primary">Save Change</button>
                <a href="/flights" class="btn btn-secondary">Back</a>
            </div>

        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../../views/templates/footer.php'; ?>