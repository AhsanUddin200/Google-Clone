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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #202124;
            color: #e8eaed;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            background-color: #303134;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #8ab4f8;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #e8eaed;
            font-size: 0.95rem;
        }

        input[type=email], 
        input[type=password] {
            width: 100%;
            padding: 12px 16px;
            background-color: #202124;
            border: 2px solid #5f6368;
            border-radius: 8px;
            color: #e8eaed;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type=email]:focus, 
        input[type=password]:focus {
            border-color: #8ab4f8;
            outline: none;
            box-shadow: 0 0 0 2px rgba(138, 180, 248, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #8ab4f8;
            color: #202124;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #aecbfa;
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background-color: rgba(244, 67, 54, 0.1);
            border-left: 4px solid #f44336;
            color: #f44336;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .signup-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #8ab4f8;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .signup-link:hover {
            color: #aecbfa;
            text-decoration: underline;
        }

        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .forgot-password {
            color: #9aa0a6;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #8ab4f8;
        }

        .divider {
            margin: 1.5rem 0;
            border-top: 1px solid #5f6368;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }

            h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_light_color_92x30dp.png" 
     alt="Google" 
     style="display: block; margin: 0 auto;">
        <h2>Welcome Back</h2>
        
        <?php if ($login_error != ""): ?>
            <div class="error">
                <?php echo $login_error; ?>
            </div>
        <?php endif; ?>

        <form name="loginForm" action="login.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       placeholder="Enter your email"
                       autocomplete="email">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter your password"
                       autocomplete="current-password">
            </div>

            <button type="submit">Log In</button>

            <div class="form-footer">
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>

            <div class="divider"></div>

            <a href="signup.php" class="signup-link">Don't have an account? Sign up</a>
        </form>
    </div>

    <script>
        function validateForm() {
            var email = document.forms["loginForm"]["email"].value.trim();
            var password = document.forms["loginForm"]["password"].value.trim();
            
            if (email === "" || password === "") {
                alert("All fields must be filled out");
                return false;
            }

            // Email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
