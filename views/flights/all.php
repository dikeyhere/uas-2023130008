<?php
session_start();

use App\Database\FlightDAO;

require_once __DIR__ . '/../../vendor/autoload.php';

$FlightDAO = new FlightDAO();
$flights = $FlightDAO->all();

function duration($start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $duration = $start->diff($end);
    return $duration->h . ' hours <br>' . $duration->i . ' minutes';
}

function datetime($datetimeString)
{
    $dateTime = new DateTime($datetimeString, new DateTimeZone('Asia/Jakarta'));
    $formatday = new \IntlDateFormatter(
        'en_US',
        \IntlDateFormatter::FULL,
        \IntlDateFormatter::NONE,
        'Asia/Jakarta',
        \IntlDateFormatter::GREGORIAN,
        'EEEE'
    );
    $formatdate = new \IntlDateFormatter(
        'en_US',
        \IntlDateFormatter::FULL,
        \IntlDateFormatter::NONE,
        'Asia/Jakarta',
        \IntlDateFormatter::GREGORIAN,
        'd MMMM yyyy'
    );
    $formattime = new \IntlDateFormatter(
        'en_US',
        \IntlDateFormatter::NONE,
        \IntlDateFormatter::SHORT,
        'Asia/Jakarta',
        \IntlDateFormatter::GREGORIAN,
        'HH:mm'
    );

    $day = $formatday->format($dateTime);
    $date = $formatdate->format($dateTime);
    $time = $formattime->format($dateTime);

    return "$day,<br>$date<br>$time";
}

require_once __DIR__ . '/../templates/header.php';
?>

<div class="container mt-0 mb-4 pb-3">
    <h2 class="text-center mb-3 pt-2">World Flight Data</h2>

    <?php if (isset($_SESSION['sucmsg'])): ?>
        <div id="success-message" class="alert alert-success">
            <?= $_SESSION['sucmsg'] ?>
        </div>
        <?php unset($_SESSION['sucmsg']); ?>
    <?php endif; ?>

    <div class="text-center">
        <a href="/flights/create" class="btn btn-primary mb-3">Add Flight Schedule</a>
    </div>

    <table class="table table-bordered border border-1 border-secondary shadow-sm">
        <thead class="table-dark">
            <tr class="text-center">
                <th style="width: 3%">ID</th>
                <th style="width: 8%">Airline</th>
                <th style="width: 15%">Departure Airport</th>
                <th style="width: 15%">Arrival Airport</th>
                <th style="width: 12%">Departure Time</th>
                <th style="width: 12%">Arrival Time</th>
                <th style="width: 11%">Duration</th>
                <th style="width: 6%">Status</th>
                <th style="width: 11%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($flights as $flight): ?>
                <tr class="align-middle">
                    <td class="text-center"><?= $flight->id ?></td>
                    <td><?= $flight->airline_name ?></td>
                    <td><?= $flight->origin_name ?></td>
                    <td><?= $flight->destination_name ?></td>
                    <td class="text-center"><?= datetime($flight->departure_time) ?></td>
                    <td class="text-center"><?= datetime($flight->arrival_time) ?></td>
                    <td class="text-center"><?= duration($flight->departure_time, $flight->arrival_time) ?></td>
                    <td class="text-center"><?= $flight->status ?></td>
                    <td class="text-center">
                        <a href="/flights/edit?id=<?= $flight->id ?>" class="btn btn-sm btn-warning mb-1">Change Status</a>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $flight->id ?>">Delete</button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this flight schedule?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" class="btn btn-danger" id="deleteBtn">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.transition = "opacity 0.5s ease";
                successMessage.style.opacity = 0;
                setTimeout(() => successMessage.remove(), 500);
            }
        }, 3000);

        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const flightid = button.getAttribute('data-id');
            const deletebtn = document.getElementById('deleteBtn');
            deletebtn.href = `/flights/delete?id=${encodeURIComponent(flightid)}`;
        });
    });
</script>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>