<?php
// Establishing Connections
$conn_password = mysqli_connect("localhost", "root", "", "password_system");
if (!$conn_password) {
    die("Password DB Connection failed: " . mysqli_connect_error());
}

$conn_passphrase = mysqli_connect("localhost", "root", "", "passphrase_system");
if (!$conn_passphrase) {
    die("Passphrase DB Connection failed: " . mysqli_connect_error());
}

// Password Summary Query
$password_summary_query = "
    SELECT 
        COUNT(DISTINCT u.email) AS total_users,
        COALESCE(SUM(l.failed_attempt), 0) AS total_failed_attempts,
        COALESCE(SUM(l.successful_attempt), 0) AS total_successful_attempts
    FROM users u
    LEFT JOIN login_logs l ON u.email = l.user_id
";
$password_summary_result = mysqli_query($conn_password, $password_summary_query);
if (!$password_summary_result) {
    die("Error in Password Summary Query: " . mysqli_error($conn_password));
}
$password_summary_data = mysqli_fetch_assoc($password_summary_result);

// Passphrase Summary Query
$passphrase_summary_query = "
    SELECT 
        COUNT(DISTINCT u.email) AS total_users,
        COALESCE(SUM(l.failed_attempt), 0) AS total_failed_attempts,
        COALESCE(SUM(l.typo_error), 0) AS total_typo_errors,
        COALESCE(SUM(l.successful_attempt), 0) AS total_successful_attempts
    FROM users u
    LEFT JOIN login_logs l ON u.email = l.user_id
";
$passphrase_summary_result = mysqli_query($conn_passphrase, $passphrase_summary_query);
if (!$passphrase_summary_result) {
    die("Error in Passphrase Summary Query: " . mysqli_error($conn_passphrase));
}
$passphrase_summary_data = mysqli_fetch_assoc($passphrase_summary_result);

/*-------------------------------------*/

// Tab 1: Email, Registration Time, and Average Login Time
$password_tab1_query = "
    SELECT 
        u.email AS user_email,
        MAX(r.registration_time) AS registration_time,
        ROUND(AVG(l.login_time), 2) AS avg_login_time
    FROM users u
    LEFT JOIN registration_logs r ON u.email = r.user_id
    LEFT JOIN login_logs l ON u.email = l.user_id
    GROUP BY u.email
";
$password_tab1_result = mysqli_query($conn_password, $password_tab1_query);
if (!$password_tab1_result) {
    die("Error in Password Tab 1 Query: " . mysqli_error($conn_password));
}

$passphrase_tab1_query = "
    SELECT 
        u.email AS user_email,
        MAX(r.registration_time) AS registration_time,
        ROUND(AVG(l.login_time), 2) AS avg_login_time
    FROM users u
    LEFT JOIN registration_logs r ON u.email = r.user_id
    LEFT JOIN login_logs l ON u.email = l.user_id
    GROUP BY u.email
";
$passphrase_tab1_result = mysqli_query($conn_passphrase, $passphrase_tab1_query);
if (!$passphrase_tab1_result) {
    die("Error in Passphrase Tab 1 Query: " . mysqli_error($conn_passphrase));
}

// Tab 2: Failed Attempts, Successful Attempts, and Total Attempts for Password
$password_tab2_query = "
    SELECT 
        u.email AS user_email,
        COALESCE(SUM(l.failed_attempt), 0) AS total_failed_attempts,
        COALESCE(SUM(l.successful_attempt), 0) AS total_successful_attempts,
        COALESCE(SUM(l.failed_attempt) + SUM(l.successful_attempt), 0) AS total_attempts
    FROM users u
    LEFT JOIN login_logs l ON u.email = l.user_id
    GROUP BY u.email
";
$password_tab2_result = mysqli_query($conn_password, $password_tab2_query);
if (!$password_tab2_result) {
    die("Error in Password Tab 2 Query: " . mysqli_error($conn_password));
}

// Tab 3: Failed Attempts, Typo Errors, Successful Attempts, and Total Attempts for Passphrase
$passphrase_tab3_query = "
    SELECT 
        u.email AS user_email,
        COALESCE(SUM(l.failed_attempt), 0) AS total_failed_attempts,
        COALESCE(SUM(l.typo_error), 0) AS total_typo_errors,
        COALESCE(SUM(l.successful_attempt), 0) AS total_successful_attempts,
        COALESCE(SUM(l.failed_attempt) + SUM(l.typo_error) + SUM(l.successful_attempt), 0) AS total_attempts
    FROM users u
    LEFT JOIN login_logs l ON u.email = l.user_id
    GROUP BY u.email
";
$passphrase_tab3_result = mysqli_query($conn_passphrase, $passphrase_tab3_query);
if (!$passphrase_tab3_result) {
    die("Error in Passphrase Tab 3 Query: " . mysqli_error($conn_passphrase));
}
/*-------------------------------------*/
/*print_r($password_tab1_result);
print_r($password_tab2_result);
print_r($passphrase_tab3_result);*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metrics Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        header {
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
        }
        .summary-section {
            margin-bottom: 30px;
        }
        .summary-section h2 {
            background-color: #2196f3;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .summary div {
            text-align: center;
        }
        .summary div p {
            margin: 5px 0;
            font-size: 18px;
        }
        .tabs {
            margin-top: 20px;
        }
        .tab-button {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            background-color: #2196f3;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
        .tab-button.active {
            background-color: #4caf50;
        }
        .tab-content {
            display: none;
            margin-top: 10px;
        }
        .tab-content.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #4caf50;
            color: white;
        }
        .export-links {
            margin-top: 10px;
            text-align: right;
        }
        .export-links a {
            margin-right: 10px;
            color: #2196f3;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
    <script>
        function showTab(tabId) {
            const contents = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-button');
            contents.forEach(content => content.classList.remove('active'));
            buttons.forEach(button => button.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`[data-target="${tabId}"]`).classList.add('active');
        }
    </script>
</head>
<body>
    <header>
        <h1>Metrics Dashboard</h1>
    </header>
    <div class="container">
        <div class="summary-section">
            <h2>Password Summary</h2>
            <div class="summary">
                <div>
                    <p>Total Users</p>
                    <p><strong><?php echo $password_summary_data['total_users']; ?></strong></p>
                </div>
                <div>
                    <p>Total Failed Attempts</p>
                    <p><strong><?php echo $password_summary_data['total_failed_attempts']; ?></strong></p>
                </div>
                <div>
                    <p>Total Successful Attempts</p>
                    <p><strong><?php echo $password_summary_data['total_successful_attempts']; ?></strong></p>
                </div>
            </div>
        </div>

        <div class="summary-section">
            <h2>Passphrase Summary</h2>
            <div class="summary">
                <div>
                    <p>Total Users</p>
                    <p><strong><?php echo $passphrase_summary_data['total_users']; ?></strong></p>
                </div>
                <div>
                    <p>Total Failed Attempts</p>
                    <p><strong><?php echo $passphrase_summary_data['total_failed_attempts']; ?></strong></p>
                </div>
                <div>
                    <p>Total Typo Errors</p>
                    <p><strong><?php echo $passphrase_summary_data['total_typo_errors']; ?></strong></p>
                </div>
                <div>
                    <p>Total Successful Attempts</p>
                    <p><strong><?php echo $passphrase_summary_data['total_successful_attempts']; ?></strong></p>
                </div>
            </div>
        </div>

        <div class="tabs">
            <div class="tab-button active" data-target="tab1" onclick="showTab('tab1')">Registration & Login Time</div>
            <div class="tab-button" data-target="tab2" onclick="showTab('tab2')">Password Metrics</div>
            <div class="tab-button" data-target="tab3" onclick="showTab('tab3')">Passphrase Metrics</div>
        </div>

        <div class="tab-content active" id="tab1">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Registration Time</th>
                        <th>Average Login Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Generate Registration & Login Times Table
                while ($row = mysqli_fetch_assoc($passphrase_tab1_result)) {
                    echo "<tr>
                        <td>{$row['user_email']}</td>
                        <td>{$row['registration_time']}</td>
                        <td>{$row['avg_login_time']}</td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
            <div class="export-links">
                <a href="export.php?type=csv&tab=tab1">Export as CSV</a>
                <a href="export.php?type=excel&tab=tab1">Export as Excel</a>
            </div>
        </div>

        <div class="tab-content" id="tab2">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Failed Attempts Before Success</th>
                            <th>Successful Attempts</th>
                            <th>Total Attempts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Generate Password Metrics Table
                    while ($row = mysqli_fetch_assoc($password_tab2_result)) {
                        echo "<tr>
                            <td>{$row['user_email']}</td>
                            <td>{$row['total_failed_attempts']}</td>
                            <td>{$row['total_successful_attempts']}</td>
                            <td>{$row['total_attempts']}</td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <div class="export-links">
                    <a href="export.php?type=csv&tab=tab2">Export as CSV</a>
                    <a href="export.php?type=excel&tab=tab2">Export as Excel</a>
                </div>
        </div>

        <div class="tab-content" id="tab3">
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Failed Attempts Before Success</th>
                            <th>Typo Errors</th>
                            <th>Successful Attempts</th>
                            <th>Total Attempts</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Generate Passphrase Metrics Table
                    while ($row = mysqli_fetch_assoc($passphrase_tab3_result)) {
                        echo "<tr>
                            <td>{$row['user_email']}</td>
                            <td>{$row['total_failed_attempts']}</td>
                            <td>{$row['total_typo_errors']}</td>
                            <td>{$row['total_successful_attempts']}</td>
                            <td>{$row['total_attempts']}</td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <div class="export-links">
                    <a href="export.php?type=csv&tab=tab3">Export as CSV</a>
                    <a href="export.php?type=excel&tab=tab3">Export as Excel</a>
                </div>
        </div>
    </div>
    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
            });
        });
    </script>
</body>
</html>