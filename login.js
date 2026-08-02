document.getElementById("loginForm").addEventListener("submit", function (e) {

  let email = document.getElementById("email").value.trim();
  let password = document.getElementById("password").value.trim();

  if (email == "" || password == "") {

    alert("Please fill in all fields to login your account!");

    e.preventDefault();

  }

});

