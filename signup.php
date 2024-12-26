<?php
// signup.php
include 'db.php';

$signup_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $signup_error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Invalid email format.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO google_user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            if ($conn->errno == 1062) { // Duplicate entry
                $signup_error = "Username or Email already exists.";
            } else {
                $signup_error = "Error: " . $conn->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        /* Inline CSS for styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            width: 300px;
            padding: 16px;
            background-color: white;
            margin: 100px auto;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 12px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
    <script>
        // JavaScript for client-side validation
        function validateForm() {
            var username = document.forms["signupForm"]["username"].value.trim();
            var email = document.forms["signupForm"]["email"].value.trim();
            var password = document.forms["signupForm"]["password"].value.trim();
            if (username == "" || email == "" || password == "") {
                alert("All fields must be filled out");
                return false;
            }
            // Additional validations can be added here
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <?php if ($signup_error != ""): ?>
            <div class="error"><?php echo $signup_error; ?></div>
        <?php endif; ?>
        <form name="signupForm" action="signup.php" method="POST" onsubmit="return validateForm()">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter Username">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password">

            <button type="submit">Signup</button>
        </form>
        <a href="login.php">Already have an account? Login here</a>
    </div>
</body>
</html>
