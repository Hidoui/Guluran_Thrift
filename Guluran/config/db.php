<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$db = 'guluran_thrift';

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
