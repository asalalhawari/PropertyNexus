<?php
include './include/top.php';
include './include/nav.php';
echo '<br><br><br><br><br>';
?>

<?php
@session_start();

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

// Handle property addition
if (isset($_POST['add_property'])) {
    if (!isset($_SESSION['userID'])) {
        die("You need to be logged in to add a property.");
    }

    $title = $_POST['p_title'];
    $price = $_POST['p_price'];
    $description = $_POST['p_description'];
    $city = $_POST['p_city'];
    $region = $_POST['p_region'];
    $floor = $_POST['p_floor'];
    $image_url = $_POST['p_image_url'];
    $type = $_POST['p_type'];

    $stmt = $conn->prepare("INSERT INTO properties (p_title, p_price, p_description, user_id, p_city, p_region, p_floor, p_image_url, p_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sdsssisss', $title, $price, $description, $_SESSION['userID'], $city, $region, $floor, $image_url, $type);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: product.php?status=success");
        exit();
    } else {
        echo "Error adding property.";
    }
}

// Search and filter properties
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$p_city = isset($_GET['city']) ? $_GET['city'] : '';
$p_region = isset($_GET['region']) ? $_GET['region'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : PHP_INT_MAX;

$sql = "SELECT * FROM properties WHERE (p_title LIKE ? OR p_description LIKE ?)";
$params = ['ss', "%{$searchTerm}%", "%{$searchTerm}%"];

if ($p_city) {
    $sql .= " AND p_city = ?";
    $params[0] .= 's';
    $params[] = $p_city;
}

if ($p_region) {
    $sql .= " AND p_region = ?";
    $params[0] .= 's';
    $params[] = $p_region;
}

if ($min_price) {
    $sql .= " AND p_price >= ?";
    $params[0] .= 'd';
    $params[] = $min_price;
}

if ($max_price) {
    $sql .= " AND p_price <= ?";
    $params[0] .= 'd';
    $params[] = $max_price;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param(...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real Estate Listings</title>
    <link rel="stylesheet" href="style/product.css">
</head>
<body>
    <div class="filter">
    <form action="product.php" method="get">
        <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search properties...">
        <select name="city" id="citySelect">
            <option value="">Select City</option>
            <option value="Amman" <?php if ($p_city == 'Amman') echo 'selected'; ?>>Amman</option>
            <!-- Other cities -->
        </select>
        <select name="region" id="regionSelect">
            <option value="">Select Region</option>
        </select>
        <input type="number" name="min_price" placeholder="Min Price" min="0" value="<?php echo htmlspecialchars($min_price); ?>">
        <input type="number" name="max_price" placeholder="Max Price" min="0" value="<?php echo htmlspecialchars($max_price); ?>">
        <input type="submit" value="Search">
    </form>

    <!-- <button id="addPropertyBtn"> -->
        <?
        // php if (!isset($_SESSION['userID'])): 
        ?>
            <!-- <a href="login.php" style="text-decoration: none; color: #000;">Add Property</a> -->
        <?php 
    // else: 
    ?>
            <!-- Add Property -->
        <?php 
    // endif; 
    ?>
    </button>
    </div>
    <div id="addPropertyModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Property</h2>
            <form action="product.php" method="post">
                <input type="hidden" name="add_property" value="1">
                <label for="p_title">Title:</label>
                <input type="text" id="p_title" name="p_title" required><br><br>
                <label for="p_price">Price:</label>
                <input type="number" id="p_price" name="p_price" step="0.01" required><br><br>
                <label for="p_description">Description:</label>
                <textarea id="p_description" name="p_description" required></textarea><br><br>
                <label for="p_city">City:</label>
                <input type="text" id="p_city" name="p_city" required><br><br>
                <label for="p_region">Region:</label>
                <input type="text" id="p_region" name="p_region" required><br><br>
                <label for="p_floor">Floor:</label>
                <input type="text" id="p_floor" name="p_floor"><br><br>
                <label for="p_image_url">Image URL:</label>
                <input type="text" id="p_image_url" name="p_image_url"><br><br>
                <label for="p_type">Type:</label>
                <input type="text" id="p_type" name="p_type"><br><br>
                <input type="submit" value="Add Property">
            </form>
        </div>
    </div>

    <div class="container_m">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($row['p_image_url']); ?>" alt="<?php echo htmlspecialchars($row['p_title']); ?>" onerror="this.src='images/placeholder.jpg';">
                <h2><?php echo htmlspecialchars($row['p_title']); ?></h2>
                <!-- <p class="city"><?php echo htmlspecialchars($row['p_city']); ?></p>
                <p class="region"><?php echo htmlspecialchars($row['p_region']); ?></p>
                <p class="floor"><?php echo htmlspecialchars($row['p_floor']); ?></p>
                <p><?php echo htmlspecialchars($row['p_description']); ?></p>
                <p class="price">$<?php echo htmlspecialchars(number_format($row['p_price'], 2)); ?></p> -->
                <p>Almost there! Now run the installer that just downloaded.
</p>
<button class="see_moer_btn"><a style="color:white" href="index4.php?p_ID=<?php echo htmlspecialchars($row['p_ID']); ?>" class="see_more_btn">See More</a></button>
                <?php if (isset($_SESSION['userID']) && $_SESSION['userID'] === $row['user_id']): ?>
                    <form action="product.php" method="post" onsubmit="return confirm('Are you sure you want to delete this property?');">
                        <input type="hidden" name="delete_property_id" value="<?php echo htmlspecialchars($row['p_ID']); ?>">
                        <input type="submit" value="Delete">
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No results found</p>
    </div>

    <?php endif; ?>
    </div>

    <?php
    $stmt->close();
    $conn->close();
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const citySelect = document.getElementById('citySelect');
        const regionSelect = document.getElementById('regionSelect');

        const cityRegions = {
            "Amman": ["Downtown", "Jubeiha", ...],
            "Irbid": ["University District", "City Center", ...],
            // Add other cities
        };

        citySelect.addEventListener('change', function () {
            const city = this.value;
            const regions = cityRegions[city] || [];
            
            regionSelect.innerHTML = '<option value="">Select Region</option>';
            
            regions.forEach(function(region) {
                const option = document.createElement('option');
                option.value = region;
                option.textContent = region;
                regionSelect.appendChild(option);
            });
        });

        // Modal
        const modal = document.getElementById("addPropertyModal");
        const btn = document.getElementById("addPropertyBtn");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            if (btn.querySelector('a')) {
                window.location.href = 'login.php';
            } else {
                modal.style.display = "block";
            }
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
    
    </script>
</body>
</html>
