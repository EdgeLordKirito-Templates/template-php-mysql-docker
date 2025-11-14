<?php
$servername = "db";
$username = "student";
$password = "studentpass";
$dbname = "schooldb";

header('Content-Type: text/html; charset=utf-8');
echo "<h2>PHP + MySQL Health Check</h2>";

// Array to store step messages
$log = [];

// Helper function for logging
function log_step(&$log, $message, $success = true) {
    $icon = $success ? "✅" : "❌";
    $log[] = "$icon $message";
}

// 1️⃣ Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    log_step($log, "Connected to MySQL: " . $conn->connect_error, false);
    echo implode("<br>", $log);
    exit;
} else {
    log_step($log, "Connected to MySQL successfully!");
}

// 2️⃣ Create a test table
$sql_create = "CREATE TABLE IF NOT EXISTS healthcheck_test (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL
)";
if ($conn->query($sql_create) === TRUE) {
    log_step($log, "Table 'healthcheck_test' exists or was created.");
} else {
    log_step($log, "Error creating table: " . $conn->error, false);
}

// 3️⃣ Insert a test row
$testMessage = "Health check at " . date("Y-m-d H:i:s");
$stmt = $conn->prepare("INSERT INTO healthcheck_test (message) VALUES (?)");
$stmt->bind_param("s", $testMessage);

if ($stmt->execute()) {
    $lastId = $stmt->insert_id;
    log_step($log, "Inserted test message (ID: $lastId): $testMessage");
} else {
    log_step($log, "Error inserting test message: " . $stmt->error, false);
}

// 4️⃣ Read back the row
$result = $conn->query("SELECT id, message FROM healthcheck_test WHERE id = $lastId");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    log_step($log, "Read back test row: ID {$row['id']} - Message: {$row['message']}");
} else {
    log_step($log, "Error reading back test message", false);
}

// 5️⃣ Delete the test row
if ($conn->query("DELETE FROM healthcheck_test WHERE id = $lastId") === TRUE) {
    log_step($log, "Deleted test row (ID: $lastId)");
} else {
    log_step($log, "Error deleting test row: " . $conn->error, false);
}

// Close connection
$conn->close();

// 6️⃣ Display summary
echo "<h3>Health Check Summary:</h3>";
echo "<ul>";
foreach ($log as $message) {
    echo "<li>$message</li>";
}
echo "</ul>";

echo "<p style='font-style:italic;'>This page demonstrates PHP can connect to MySQL, write, read, and delete data.</p>";
?>
