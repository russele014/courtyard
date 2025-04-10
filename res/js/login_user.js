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