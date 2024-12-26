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
            padding: 2rem;
            background-color: #303134;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #8ab4f8;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #e8eaed;
            font-size: 0.95rem;
        }

        input[type=text], 
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

        input[type=text]:focus, 
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

        .login-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #8ab4f8;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #aecbfa;
            text-decoration: underline;
        }

        /* Password strength indicator */
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #9aa0a6;
        }

        .strength-meter {
            height: 4px;
            background-color: #5f6368;
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
        }

        .strength-meter div {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }
        





        .weak { width: 33.33%; background-color: #f44336; }
        .medium { width: 66.66%; background-color: #ffa726; }
        .strong { width: 100%; background-color: #66bb6a; }

        /* Form icons */
        .form-group {
            position: relative;
        }

        .form-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa0a6;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container {
            animation: fadeIn 0.3s ease-out;
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
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
          
        }
        .logo {
            width: 75px;
            height: auto;
            margin-bottom: 1rem;
            justify-content:center;
        }
        .logo-text {
            font-size: 1.5rem;
            color: #e8eaed;
            margin-bottom: 0.5rem;
            
        }
    </style>
</head>
<body>
    
    <div class="container">
    <img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_light_color_92x30dp.png" 
     alt="Google" 
     style="display: block; margin: 0 auto;">


        <h2>Create Account</h2>
      
        
        <?php if ($signup_error != ""): ?>
            <div class="error">
                <?php echo $signup_error; ?>
            </div>
        <?php endif; ?>

        <form name="signupForm" action="signup.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       placeholder="Enter your username"
                       autocomplete="username">
            </div>

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
                       placeholder="Create a strong password"
                       autocomplete="new-password">
                <div class="password-strength">
                    <div class="strength-meter">
                        <div></div>
                    </div>
                </div>
            </div>

            <button type="submit">Create Account</button>
        </form>

        <a href="login.php" class="login-link">Already have an account? Log in</a>
    </div>

    <script>
        function validateForm() {
            var username = document.forms["signupForm"]["username"].value.trim();
            var email = document.forms["signupForm"]["email"].value.trim();
            var password = document.forms["signupForm"]["password"].value.trim();
            
            if (username === "" || email === "" || password === "") {
                alert("All fields must be filled out");
                return false;
            }

            // Email validation
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address");
                return false;
            }

            // Password strength validation
            if (password.length < 3) {
                alert("Password must be at least 3 characters long");
                return false;
            }

            return true;
        }

        // Password strength meter
        document.getElementById('password').addEventListener('input', function(e) {
            var password = e.target.value;
            var strength = 0;
            var strengthMeter = document.querySelector('.strength-meter div');

            if (password.length >= 8) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^A-Za-z0-9]/)) strength++;

            strengthMeter.className = '';
            if (strength >= 4) strengthMeter.classList.add('strong');
            else if (strength >= 2) strengthMeter.classList.add('medium');
            else if (strength >= 1) strengthMeter.classList.add('weak');
        });
    </script>
</body>
</html>
