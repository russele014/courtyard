<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
	<link rel="stylesheet" href="LogResForm.css">
	<link rel="stylesheet" href="navbar.css">
</head>
<body>

<div class="bg-wrapper">
        <!-- Background layers -->
        <div id="bg1" class="bg-layer" style="background-image: url('daan.jpg'); opacity: 1;"></div>
        <div id="bg2" class="bg-layer" style="background-image: url('gate1.jpg'); opacity: 0;"></div>
    </div>
	<nav class="navbar">
  <div class="navbar-left">The Courtyard of Maia Alta</div>
  <ul class="navbar-right">
    <li><a href="index.php">Home</a></li>
    <li><a href="Officers.php">Officers</a></li>
    <li><a href="Gallery.php">Gallery </a></li>
    <li><a href="UserDash.php">SOA</a></li>
    <li><a href="Events.php">Events</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Login.php" class="logout-btn">Login</a></li>
  </ul>
</nav>

<div class="center-wrapper">
<h2>The Couryard of Maia Alta</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="#">
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your email for registration</span>
			<input type="text" placeholder="Name" />
			<input type="email" placeholder="Email" />
			<input type="password" placeholder="Password" />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="#">
			<h1>Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your account</span>
			<input type="email" placeholder="Email" />
			<input type="password" placeholder="Password" />
			<a href="#">Forgot your password?</a>
			<button>Sign In</button>
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


<script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        const bg1 = document.getElementById('bg1');
        const bg2 = document.getElementById('bg2');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
            // Fade out the current background and fade in the next one
            bg1.style.opacity = 0;
            bg2.style.opacity = 1;
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
            // Fade out the current background and fade in the next one
            bg1.style.opacity = 1;
            bg2.style.opacity = 0;
        });
</script>
</body>
</html>