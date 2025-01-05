<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>To-Do List</h1>

    <?php
    // Load environment variables
    $env = parse_ini_file('.env');
    $hostname = $env["HOSTNAME"];
    $username = $env["USERNAME"];
    $password = $env["PASSWORD"];
    $database = $env["DATABASE"];
    $port = $env["PORT"];

    // Create connection
    $conn = new mysqli($hostname, $username, $password, $database, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['add'])) {
            $task = $conn->real_escape_string($_POST['task']);
            $conn->query("INSERT INTO todo_list (task) VALUES ('$task')");
        } elseif (isset($_POST['delete'])) {
            $id = (int)$_POST['id'];
            $conn->query("DELETE FROM todo_list WHERE id = $id");
        } elseif (isset($_POST['update'])) {
            $id = (int)$_POST['id'];
            $status = $conn->real_escape_string($_POST['status']);
            $conn->query("UPDATE todo_list SET status = '$status' WHERE id = $id");
        }
    }

    // Fetch tasks
    $result = $conn->query("SELECT * FROM todo_list ORDER BY created_at DESC");
    ?>

    <!-- Add Task Form -->
    <form method="POST">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="add">Add Task</button>
    </form>

    <!-- Task List -->
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['task']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <!-- Update Status Form -->
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="status" required>
                                <option value="pending" <?php echo $row['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?php echo $row['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                            <button type="submit" name="update">Update</button>
                        </form>

                        <!-- Delete Task Form -->
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>