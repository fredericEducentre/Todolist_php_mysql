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
$conn->query("CREATE DATABASE php_project;");
$conn->query("USE php_project;");
$conn->query("CREATE TABLE todo_list (id INT AUTO_INCREMENT PRIMARY KEY,task VARCHAR(255) NOT NULL,status ENUM('pending', 'completed') DEFAULT 'pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);");
