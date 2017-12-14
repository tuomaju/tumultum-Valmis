const registerBtn = document.getElementById('registerBtn');
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('register');

registerBtn.addEventListener('click', () => {
    loginForm.style.display = "none";
    registerForm.style.display = "flex";
});