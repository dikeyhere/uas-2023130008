<?php
session_start();

use App\Database\FlightDAO;

$id = $_GET['id'];
$FlightDAO = new FlightDAO();
$FlightDAO->delete($id);
$_SESSION['sucmsg'] = "Flight schedule successfully deleted.";

header('Location: /');
exit;
