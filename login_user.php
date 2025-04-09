<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="res/css/login_user.css">
</head>
<body>
<?php
//database connection
require_once 'database/db_connection.php';

//Process Registration Form
if (isset($_POST['register'])) {
    $name = $_POST['reg_name'];
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];

    // Check if email already exists
    $check_query = "SELECT * FROM home_owners_tbl WHERE email = '$email'";
    $result = $conn->query($check_query);
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // Insert new user into database
        $sql = "INSERT INTO home_owners_tbl (name, email, password) VALUES ('$name', '$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! Please login.');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Process login form
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    
    // Check user credentials
    $sql = "SELECT * FROM home_owners_tbl WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Login successful
        $user = $result->fetch_assoc();
        // Start session and store user information
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        
        // Redirect to dashboard or home page
        echo "<script>alert('Login successful! Welcome, " . $user['name'] . "!');</script>";
        // Uncomment the line below to redirect to another page after login
        // header("Location: dashboard.php");
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>

<div class="center-wrapper">
<h2>The Couryard of Maia Alta</h2>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="text" name="reg_name" placeholder="Name" required />
            <input type="email" name="reg_email" placeholder="Email" required />
            <input type="password" name="reg_password" placeholder="Password" required />
            <button type="submit" name="register">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your account</span>
            <input type="email" name="login_email" placeholder="Email" required />
            <input type="password" name="login_password" placeholder="Password" required />
            <a href="#">Forgot your password?</a>
            <button type="submit" name="login">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please <break>
                login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
</div>
<script src="res/javascript/login_user.js"></script> 
</body>
</html>