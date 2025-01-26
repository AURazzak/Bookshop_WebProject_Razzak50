// Example JavaScript validation for login and registration
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (!email || !password) {
        alert('Please fill in all fields.');
        e.preventDefault();
    }
});
