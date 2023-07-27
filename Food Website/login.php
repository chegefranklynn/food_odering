<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form action="login_process.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
    <?php
// Database connection and configuration (same as register_process.php)
// ...

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare and execute the SQL query to retrieve the user's information from the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Start the PHP session and store user information
        session_start();
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;

        // Redirect the user to a secured page (e.g., dashboard.php)
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid username or password. <a href='login.php'>Try again</a>.";
    }
}

$conn->close();
?>

</body>
</html>
