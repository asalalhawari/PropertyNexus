<?php
include("connection.php"); ?>


<?php

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "php_project";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle property deletion
if (isset($_POST['delete_property_id'])) {
    if (!isset($_SESSION['userID'])) {
        die("You need to be logged in to delete a property.");
    }

    $property_id = intval($_POST['delete_property_id']);

    if ($property_id <= 0) {
        die("Invalid property ID.");
    }

    $stmt = $conn->prepare("SELECT user_id FROM properties WHERE p_ID = ?");
    $stmt->bind_param('i', $property_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Property not found.");
    }

    $row = $result->fetch_assoc();

    if ($_SESSION['userID'] !== $row['user_id']) {
        die("You are not authorized to delete this property.");
    }

    $stmt = $conn->prepare("DELETE FROM properties WHERE p_ID = ?");
    $stmt->bind_param('i', $property_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: product.php?status=success");
        exit();
    } else {
        echo "Error deleting property.";
    }
}

// Fetch all properties
$sql = "SELECT * FROM properties";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Property Listings</title>
    <link rel="stylesheet" href="style/product.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card h2 {
            margin: 10px;
            font-size: 1.5em;
        }
        .card p {
            margin: 10px;
            color: #555;
        }
        .card .price {
            font-weight: bold;
            color: #e74c3c;
        }
        .card .delete-btn {
            display: block;
            width: calc(100% - 20px);
            margin: 10px;
            padding: 10px;
            background: #e74c3c;
            color: white;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .card .delete-btn:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($row['p_image_url']); ?>" alt="<?php echo htmlspecialchars($row['p_title']); ?>" onerror="this.src='images/placeholder.jpg';">
                    <h2><?php echo htmlspecialchars($row['p_title']); ?></h2>
                    <p class="city"><?php echo htmlspecialchars($row['p_city']); ?></p>
                    <p class="region"><?php echo htmlspecialchars($row['p_region']); ?></p>
                    <p class="floor"><?php echo htmlspecialchars($row['p_floor']); ?></p>
                    <p><?php echo htmlspecialchars($row['p_description']); ?></p>
                    <p class="price">$<?php echo htmlspecialchars(number_format($row['p_price'], 2)); ?></p>
                    <?php if (isset($_SESSION['userID']) && $_SESSION['userID'] === $row['user_id']): ?>
                        <form action="product.php" method="post" onsubmit="return confirm('Are you sure you want to delete this property?');">
                            <input type="hidden" name="delete_property_id" value="<?php echo htmlspecialchars($row['p_ID']); ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No properties found</p>
        <?php endif; ?>
    </div>
    
    <?php
    $conn->close();
    ?>
</body>
</html>

