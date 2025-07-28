<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Systems</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('images/authentication-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
            text-align: center;
        }
        .container {
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
            max-width: 800px;
            width: 90%;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .q_links{
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            background: #007BFF;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .links {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
        .links a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            background: #007BFF;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .links a:hover {
            background: #0056b3;
        }
        .note {
            margin-top: 20px;
            font-size: 1.1rem;
            color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Authentication Systems</h1>
        <p>Choose an authentication method to proceed.</p>
        
        <!-- Links for systems -->
        <div class="links">
            <a href="password_system/index.php">Password Authentication</a>
            <a href="passphrase_system/index.php">Passphrase Authentication</a>
        </div>

        <!-- Purpose and request for feedback -->
        <div class="note">
            <p>
                This study aims to compare <strong>Password-based</strong> and <strong>Passphrase-based</strong> authentication methods.
                We encourage you to try both methods and provide your feedback in the questionnaire afterward.
            </p>
            <p>
                Your opinion will help us understand which system is more user-friendly and effective. 
                Please tell us which one you prefer and why.
            </p>
            <p>To fill the questionnaire click the link --> 
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSdMGuWPy6e0qEmF8NbocR5BTTCMPaC6jpngUWFIVbPiEVv31A/viewform?usp=sharing" class="q_links"> Questionnaire</a>
            </p>
        </div>
    </div>
</body>
</html>
