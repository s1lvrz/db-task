<?php
require_once "config.php";

// Handle form submission (insert a new name + age)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"], $_POST["age"])) {
    $name = trim($_POST["name"]);
    $age  = intval($_POST["age"]);

    if ($name !== "" && $age > 0) {
        // Use a prepared statement to protect against SQL injection
        $stmt = $conn->prepare("INSERT INTO users (name, age, status) VALUES (?, ?, 0)");
        $stmt->bind_param("si", $name, $age);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to this same page to prevent duplicate submissions on refresh
    header("Location: index.php");
    exit();
}

// Fetch all rows from the database to display in the table
$result = $conn->query("SELECT id, name, age, status FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Database App</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Name & Age Registration System</h1>

    <!-- ============= Form ============= -->
    <form method="POST" action="index.php" class="user-form">
        <input type="text" name="name" placeholder="Name" required>
        <input type="number" name="age" placeholder="Age" min="1" required>
        <button type="submit">Submit</button>
    </form>

    <!-- ============= Table ============= -->
    <table id="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Toggle</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr id="row-<?php echo $row['id']; ?>">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['age']; ?></td>
                <td class="status-cell">
                    <span class="badge <?php echo $row['status'] ? 'active' : 'inactive'; ?>">
                        <?php echo $row['status'] ? "1 (Active)" : "0 (Inactive)"; ?>
                    </span>
                </td>
                <td>
                    <button class="toggle-btn" data-id="<?php echo $row['id']; ?>">Toggle</button>
                </td>
                <td>
                    <button class="delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="script.js"></script>
</body>
</html>