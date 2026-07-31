<?php
require_once "config.php";
header("Content-Type: application/json; charset=utf-8");

/**
 * toggle.php
 * Receives an "id" from JavaScript (fetch).
 * Flips the status value from 0 -> 1 or 1 -> 0.
 * Returns the new value as JSON so JavaScript can update the table instantly.
 */

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
    exit();
}

// Get the current status first
$stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($current_status);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    $stmt->close();
    exit();
}
$stmt->close();

// Flip the value: 0 becomes 1, 1 becomes 0
$new_status = $current_status ? 0 : 1;

$update = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
$update->bind_param("ii", $new_status, $id);
$update->execute();
$update->close();

echo json_encode([
    "success" => true,
    "id" => $id,
    "new_status" => $new_status
]);