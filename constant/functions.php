<?php
session_start(); // Start the session

// Database connection 
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "dasmart_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle user login
function handleLogin($username, $password) {
    global $conn;

    // Prepare and execute the query to fetch the user
    $query = "SELECT password, email FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword, $email);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['isLoggedIn'] = true; // Set session variable
        $_SESSION['username'] = $username; // Store username
        $_SESSION['email'] = $email; // Store email
        return true; // Login successful
    } else {
        return false; // Invalid credentials
    }
}

// Function to handle admin registration
function regisAdmins($data) {
    global $conn;

    // Extracting data
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];
    $password2 = $data['password2'];

    // Check if passwords match
    if ($password !== $password2) {
        return false; // Passwords do not match
    }

    // Check if the username or email already exists
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return false; // Username or email already exists
    }
    
    mysqli_stmt_close($stmt); // Close the statement

    // Hash the password before storing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt); // Close the statement
        return true; // Registration successful
    } else {
        mysqli_stmt_close($stmt); // Close the statement
        return false; // Registration failed
    }
}

// Function to get user information
function getUserInfo() {
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        return [
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email']
        ];
    }
    return null;
}

// Function to handle logout
function logout() {
    session_destroy(); // Destroy the session
    header("Location: ../public/index.html"); // Redirect to homepage or login page
    exit();
}

// Check if logout is requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logout();
}

?>
