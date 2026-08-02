// Wait until the page is fully loaded
document.addEventListener("DOMContentLoaded", function () {

  const form = document.getElementById("registerForm");

  const name = document.getElementById("name");
  const email = document.getElementById("email");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm_password");

  form.addEventListener("submit", function (event) {

    // Remove leading/trailing spaces
    const fullName = name.value.trim();
    const userEmail = email.value.trim();
    const userPassword = password.value;
    const confirmPwd = confirmPassword.value;

    // Name validation
    const nameRegex = /^[A-Za-z ]+$/;

    if (!nameRegex.test(fullName)) {
      alert("Name can only contain letters and spaces.");
      name.focus();
      event.preventDefault();
      return;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(userEmail)) {
      alert("Please enter a valid email address.");
      email.focus();
      event.preventDefault();
      return;
    }

    // Password length
    if (userPassword.length < 6) {
      alert("Password must contain at least 6 characters.");
      password.focus();
      event.preventDefault();
      return;
    }

    // Password strength
    const passwordRegex =
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&^#()_\-+=])[A-Za-z\d@$!%*?&^#()_\-+=]{6,}$/;

    if (!passwordRegex.test(userPassword)) {
      alert(
        "Password must contain:\n\n" +
        "• One uppercase letter\n" +
        "• One lowercase letter\n" +
        "• One number\n" +
        "• One special character\n" +
        "• Minimum 6 characters"
      );
      password.focus();
      event.preventDefault();
      return;
    }

    // Confirm password
    if (userPassword !== confirmPwd) {
      alert("Passwords do not match.");
      confirmPassword.focus();
      event.preventDefault();
      return;
    }

    // Allow the form to submit to registerValidate.php
  });

});
