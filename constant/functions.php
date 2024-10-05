<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "dasmart_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function regisAdmins($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $email= mysqli_real_escape_string($conn, $data["email"]);
    
    // Check if username already exists
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
            alert('Username already exists!');
        </script>";
        return false;
    }

    // Check password confirmation
    if ($password !== $password2) {
        echo "<script>
            alert('Password confirmation does not match!');
        </script>";
        return false;
    }

    // Hash password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into database
    if (mysqli_query($conn, "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', 'customer')")) {
        return true; // or return mysqli_affected_rows($conn);
    } else {
        echo "Error: " . mysqli_error($conn); // Output any error for debugging
        return false;
    }
}
