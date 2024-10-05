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
    header("Location: ./index.html"); // Redirect to homepage or login page
    exit();
}

// Check if logout is requested
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    logout();
}

// Check for user info if required
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_info'])) {
    $userInfo = getUserInfo();
    header('Content-Type: application/json');
    echo json_encode($userInfo);
    exit();
}
?>
