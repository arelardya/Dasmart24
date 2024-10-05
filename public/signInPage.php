<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "dasmart_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize message variable
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch user details from the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Start session and store user info
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to dashboard or homepage after login
            header("Location: index.html");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="script.js" defer></script>
</head>
<body class="font-[Poppins]">
    <div class="min-h-screen" style="background-image: url(./assets/bg_signIn.jpg);">
        <nav class="flex flex-wrap justify-between items-center p-5 bg-white bg-opacity-80 shadow-md sticky top-0 z-10">
            <div>
                <a href="./index.html">
                    <img class="w-16 h-16 md:w-20 md:h-20" src="./assets/logo.png" alt="">
                </a>
            </div>
        </nav>
        <div class="flex justify-center items-center mt-3">
            <div class="bg-gray-300 bg-opacity-50 rounded-lg shadow-md p-10 w-9/12 mb-12">
                <h2 class="text-2xl font-bold mb-4 text-center text-white">Sign In</h2>
                <form id="signInForm" method="POST">
                    <div class="mb-4">
                        <label for="username" class="block font-bold mb-2 text-white">Username</label>
                        <input type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Username" required>
                    </div>  
                    <div class="mb-6">
                        <label for="password" class="block font-bold mb-2 text-white">Password</label>
                        <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Password" required>
                    </div>
                    <p class="text-red-500 text-center mt-4"><?php echo $message; ?></p>
                    <button type="submit" class="h-10 mt-5 float-right cursor-pointer">
                        <img src="./assets/nextButton.png" id="nextButton" onmouseover="changeImage(1)" onmouseout="changeImage(2)">
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
