<?php
include_once("connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "php_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="index.php" method="get">
        <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search properties...">
        <select name="city" id="citySelect">
            <option value="">Select City</option>
            <option value="Amman" <?php if ($p_city == 'Amman') echo 'selected'; ?>>Amman</option>
            <option value="Irbid" <?php if ($p_city == 'Irbid') echo 'selected'; ?>>Irbid</option>
            <option value="Aqaba" <?php if ($p_city == 'Aqaba') echo 'selected'; ?>>Aqaba</option>
            <option value="Jerash" <?php if ($p_city == 'Jerash') echo 'selected'; ?>>Jerash</option>
            <option value="Madaba" <?php if ($p_city == 'Madaba') echo 'selected'; ?>>Madaba</option>
            <option value="Zarqa" <?php if ($p_city == 'Zarqa') echo 'selected'; ?>>Zarqa</option>
            <option value="Mafraq" <?php if ($p_city == 'Mafraq') echo 'selected'; ?>>Mafraq</option>
            <option value="Karak" <?php if ($p_city == 'Karak') echo 'selected'; ?>>Karak</option>
            <option value="Tafila" <?php if ($p_city == 'Tafila') echo 'selected'; ?>>Tafila</option>
            <option value="Ayla" <?php if ($p_city == 'Ayla') echo 'selected'; ?>>Ayla</option>
            <option value="Ain Al-Basha" <?php if ($p_city == 'Ain Al-Basha') echo 'selected'; ?>>Ain Al-Basha</option>
            <option value="Rusaifa" <?php if ($p_city == 'Rusaifa') echo 'selected'; ?>>Rusaifa</option>
        </select>
        <select name="region" id="regionSelect">
            <option value="">Select Region</option>
        </select>
        <input type="number" name="min_price" placeholder="Min Price" min="0" value="<?php echo htmlspecialchars($min_price); ?>">
        <input type="number" name="max_price" placeholder="Max Price" min="0" value="<?php echo htmlspecialchars($max_price); ?>">
        <input type="submit" value="Search">
    </form>

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
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No results found</p>
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
    "Amman": [
        "Downtown", "Jubeiha", "Abdoun", "Ruwais", "Shmeisani", "Jabal Al-Weibdeh", "Bayader Wadi Al-Seer", "Al-Madina Al-Munawara"
    ],
    "Irbid": [
        "University District", "City Center", "Al-Madina", "Al-Hassan Industrial City", "Al-Sarouj", "Khalidiya", "Al-Nuzha"
    ],
    "Aqaba": [
        "South Beach", "North Beach", "Faisali", "Al-Hafayer", "Al-Manara", "Al-Qidra", "Al-Shat"
    ],
    "Jerash": [
        "Downtown", "Al-Kharrub", "Mshairfeh", "Al-Methar", "Al-Joumhour", "Al-Husseini", "Al-Yarmouk"
    ],
    "Madaba": [
        "Downtown", "Al-Muhajireen", "Al-Junaid", "Mukhayyat", "Al-Hari", "Al-Luweibdeh", "Al-Madaba"
    ],
    "Zarqa": [
        "Downtown", "Russeifa", "Al-Hashmi", "Al-Qadisiyah", "Al-Husn", "Jebel Al-Hussein", "Al-Muwaqqar"
    ],
    "Mafraq": [
        "Downtown", "Al-Husn", "Badiya", "Al-Zaatari", "Al-Mafraq", "Al-Kharabish", "Al-Mukhayyam"
    ],
    "Karak": [
        "Downtown", "Al-Mashareqa", "Al-Husseini", "Al-Hisn", "Al-Shobak", "Al-Ma’an", "Al-Karak"
    ],
    "Tafila": [
        "Downtown", "Risha", "Qasr", "Al-Baraem", "Al-Karak", "Al-Mazra'a", "Al-Madina"
    ],
    "Ayla": [
        "Downtown", "Ayla Resort", "Ayla Oasis", "Ayla Golf", "Ayla Heights"
    ],
    "Ain Al-Basha": [
        "Downtown", "Jama'a", "Al-Misra", "Al-Salam", "Al-Safawi", "Al-Khalidiyah"
    ],
    "Rusaifa": [
        "Downtown", "Mufeed", "Al-Jalil", "Al-Haql", "Al-Balad", "Al-Khobar"
    ]
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

        // Trigger change event to populate regions if a city is already selected
        if (citySelect.value) {
            citySelect.dispatchEvent(new Event('change'));
        }
    });
    </script>
</body>
</html>
