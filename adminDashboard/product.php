<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php
// include("connection.php"); ?>

<!-- Add property -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPropModal">Add property</button>

<!-- // Form handling -->
<?php
if (isset($_POST['addProp'])) {
    $p_title = mysqli_real_escape_string($db_conn, $_POST['p_title']);
    $p_price = mysqli_real_escape_string($db_conn, $_POST['p_price']);
    $p_description = mysqli_real_escape_string($db_conn, $_POST['p_description']);
    $p_region = mysqli_real_escape_string($db_conn, $_POST['p_region']);
    $p_city = mysqli_real_escape_string($db_conn, $_POST['p_city']);
    $p_floor = mysqli_real_escape_string($db_conn, $_POST['p_floor']);
    $p_image_url = mysqli_real_escape_string($db_conn, $_POST['p_image_url']);
    $p_type = mysqli_real_escape_string($db_conn, $_POST['p_type']);

    if (empty($p_title) || empty($p_price) || empty($p_description) || empty($p_city) || empty($p_region) || empty($p_type)) {
        header('Location: add_property.php?message=All fields are required. Please fill all fields.');
        exit();
    } else {
        $insert_Q = "INSERT INTO properties (p_title, p_price, p_description, p_city, p_region, p_floor, p_image_url , p_type) VALUES
            ('$p_title', '$p_price', '$p_description', '$p_city', '$p_region', '$p_floor', '$p_image_url', '$p_type')";
        if (mysqli_query($db_conn, $insert_Q)) {
            header('Location: add_property.php?insrt_msg=property added successfully!');
        } else {
            die("Query Failed: " . mysqli_error($db_conn));
        }
        exit();
    }
}
?> 

<!-- Add proprty Modal -->
<form action="add_property.php" method="POST">
    <div class="modal fade" id="addPropModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel"><b>Add Property</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="p_title">Property Title</label>
                        <input type="text" name="p_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="p_price">property Price</label>
                        <input type="text" name="p_price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="p_description">Description</label>
                        <input type="text" name="p_description" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="p_city">City</label>
                        <input type="text" name="p_city" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="p_region">Region</label>
                        <input type="text" name="p_region" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="p_floor">Floor</label>
                        <input type="text" name="p_floor" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="p_type">Type of Property</label>
                        <input type="text" name="p_type" class="form-control" placeholder="house, villa, building...">
                    </div>
                    <div class="form-group">
                        <label for="p_image_url">Add image</label>
                        <input type="file" name="p_image_url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success" name="addProp" value="ADD">
                </div>
            </div>
        </div>
    </div>
</form>

<?php

$servername = "localhost";
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>

