<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "register");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $date = $_POST['date'];
    $no_of_eggs = $_POST['no_of_eggs'];
    $conn->query("INSERT INTO egg_production (date, no_of_eggs) VALUES ('$date', '$no_of_eggs')");
}

// Delete record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM egg_production WHERE id = $id");
}

// Fetch records for egg production
$records = $conn->query("SELECT * FROM egg_production");

// Determine which section to display
$section = isset($_GET['section']) ? $_GET['section'] : 'overview'; // Default to overview if no section is selected
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .sidebar {
            width: 250px;
            background-color: #007BFF;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #0056b3;
        }

        .sidebar a:hover {
            background-color: #003f7f;
        }

        .content {
            margin-left: 270px;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container {
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container input[type="date"],
        .form-container input[type="number"],
        .form-container button {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .overview-card {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 18%;
            text-align: center;
            margin: 10px 1%;
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 22px;
            color: #007BFF;
        }

        .card p {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .card p.negative {
            color: #dc3545; /* Red color for critical levels */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <a href="?section=overview">Overview</a>
        <a href="?section=egg_production">Egg Production</a>
        <a href="#">Bird Management</a>
        <a href="#">Feed Management</a>
        <a href="#">Customer Management</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="content">
        <?php if ($section === 'overview'): ?>
            <h1>Overview</h1>
            <div class="overview-card">
                <div class="card">
                    <h3>Total Birds</h3>
                    <p>150</p>
                </div>
                <div class="card">
                    <h3>Egg Stock</h3>
                    <p>3000 eggs</p>
                </div>
                <div class="card">
                    <h3>Sales Generated</h3>
                    <p>$5000</p>
                </div>
                <div class="card">
                    <h3>Remaining Feed</h3>
                    <p>500 kg</p>
                </div>
                <div class="card">
                    <h3>Eggs Left</h3>
                    <p class="negative">2000 eggs</p>
                </div>
            </div>
        <?php elseif ($section === 'egg_production'): ?>
            <h1>Egg Production Management</h1>
            <div class="form-container">
                <h2>Add New Egg Production Record</h2>
                <form method="POST">
                    <input type="date" name="date" required>
                    <input type="number" name="no_of_eggs" placeholder="Enter No. of Eggs" required>
                    <button type="submit" name="add">Add Record</button>
                </form>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>No. of Eggs</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $records->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_of_eggs']); ?></td>
                        <td class="action-buttons">
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                            <a href="?section=egg_production&delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <h1>Welcome to the Dashboard</h1>
            <p>Select a section from the sidebar to manage your poultry farm system.</p>
        <?php endif; ?>
    </div>
</body>
</html>
