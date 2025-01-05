<?php
// Load environment variables
$env = parse_ini_file('.env');
$hostname = $env["HOSTNAME"];
$username = $env["USERNAME"];
$password = $env["PASSWORD"];
$port = $env["PORT"];

// Create connection
$conn = new mysqli($hostname, $username, $password, '', $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$conn->query("DROP DATABASE php_project;");