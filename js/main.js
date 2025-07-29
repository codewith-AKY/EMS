function togglePassword() {
    var pwd = document.getElementById('password');
    var eyeOpen = document.getElementById('eyeOpen');
    var eyeClosed = document.getElementById('eyeClosed');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'inline';
    } else {
        pwd.type = 'password';
        eyeOpen.style.display = 'inline';
        eyeClosed.style.display = 'none';
    }
}
