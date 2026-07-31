<?php
require_once "config.php";
header("Content-Type: application/json; charset=utf-8");

/**
 * delete.php
 * Receives an "id" from JavaScript (fetch).
 * Deletes that row from the "users" table.
 * Returns JSON so JavaScript can remove the row from the page instantly.
 */

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
    exit();
}

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$deleted = $stmt->affected_rows > 0;
$stmt->close();

echo json_encode([
    "success" => $deleted,
    "id" => $id,
    "message" => $deleted ? "Deleted successfully" : "User not found"
]);