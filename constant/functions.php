<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "dasmart_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start session for login status tracking
session_start();

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

// Function to handle user login
function handleLogin($username, $password) {
    global $conn;

    // Prepare and execute the query to fetch the user
    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['isLoggedIn'] = true; // Set session variable
        return true; // Login successful
    } else {
        return false; // Invalid credentials
    }
}

// Function to check login status
function checkLoginStatus() {
    return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    // Call the handleLogin function
    if (handleLogin($username, $password)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit; // Make sure to exit after returning the response
}

// Check login status for AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['check_login'])) {
    $response = ['isLoggedIn' => checkLoginStatus()];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Make sure to exit after returning the response
}
?>
