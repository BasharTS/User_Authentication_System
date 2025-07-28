<?php
require_once 'password_system/includes/db.php';

// Check for required parameters
if (!isset($_GET['type']) || !isset($_GET['tab'])) {
    die("Invalid request.");
}

$type = $_GET['type'];
$tab = $_GET['tab'];

// Validate export type
if (!in_array($type, ['csv', 'excel'])) {
    die("Invalid data type specified.");
}

// Initialize file name
$file_name = "export_" . $tab . "." . ($type === 'csv' ? 'csv' : 'xls');

// Fetch data based on the tab parameter
switch ($tab) {
    case 'tab1':
        $query = "SELECT user_email AS `Email`, registration_time AS `Registration Time`, avg_login_time AS `Average Login Time` FROM (
            SELECT 
                rl.user_id AS user_email, 
                MIN(rl.registration_time) AS registration_time, 
                AVG(ll.login_time) AS avg_login_time
            FROM registration_logs rl
            LEFT JOIN login_logs ll ON rl.user_id = ll.user_id
            GROUP BY rl.user_id
        ) AS summary";
        break;

    case 'tab2':
        $query = "SELECT user_email AS `Email`, total_failed_attempts AS `Failed Attempts`, total_successful_attempts AS `Successful Attempts`, total_attempts AS `Total Attempts` FROM (
            SELECT 
                ll.user_id AS user_email, 
                SUM(ll.failed_attempt) AS total_failed_attempts, 
                SUM(ll.successful_attempt) AS total_successful_attempts, 
                (SUM(ll.failed_attempt) + SUM(ll.successful_attempt)) AS total_attempts
            FROM login_logs ll
            LEFT JOIN users u ON ll.user_id = u.email
            WHERE u.password IS NOT NULL
            GROUP BY ll.user_id
        ) AS summary";
        break;

    case 'tab3':
        $query = "SELECT user_email AS `Email`, total_failed_attempts AS `Failed Attempts`, total_typo_errors AS `Typo Errors`, total_successful_attempts AS `Successful Attempts`, total_attempts AS `Total Attempts` FROM (
            SELECT 
                ll.user_id AS user_email, 
                SUM(ll.failed_attempt) AS total_failed_attempts, 
                SUM(ll.typo_error) AS total_typo_errors, 
                SUM(ll.successful_attempt) AS total_successful_attempts, 
                (SUM(ll.failed_attempt) + SUM(ll.typo_error) + SUM(ll.successful_attempt)) AS total_attempts
            FROM passphrase_system.login_logs ll
            LEFT JOIN passphrase_system.users u ON ll.user_id = u.email
            GROUP BY ll.user_id
        ) AS summary";

        break;

    default:
        die("Invalid tab specified.");
}

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Export data
if ($type === 'csv') {
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=$file_name");
    
    $output = fopen('php://output', 'w');
    $columns = array_keys(mysqli_fetch_assoc($result));
    mysqli_data_seek($result, 0); // Reset the result pointer
    
    fputcsv($output, $columns); // Add headers
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
} elseif ($type === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");
    
    echo "<table border='1'>";
    // Add headers
    $columns = array_keys(mysqli_fetch_assoc($result));
    mysqli_data_seek($result, 0); // Reset the result pointer

    echo "<tr>";
    foreach ($columns as $col) {
        echo "<th>" . htmlspecialchars($col) . "</th>";
    }
    echo "</tr>";

    // Add rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    exit();
}
?>
