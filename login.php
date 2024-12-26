
<?php
// login.php
session_start();
include 'db.php';

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Basic validation
    if (empty($email) || empty($password)) {
        $login_error = "All fields are required.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT id, username, password FROM google_user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, start a session
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: search.php");
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "No account found with that email.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        input[type=email], input[type=password] {
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
            var email = document.forms["loginForm"]["email"].value.trim();
            var password = document.forms["loginForm"]["password"].value.trim();
            if (email == "" || password == "") {
                alert("All fields must be filled out");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($login_error != ""): ?>
            <div class="error"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form name="loginForm" action="login.php" method="POST" onsubmit="return validateForm()">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password">

            <button type="submit">Login</button>
        </form>
        <a href="signup.php">Don't have an account? Signup here</a>
    </div>
</body>
</html>
