<?php
include("../../sessionchecker.php");
include("../../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"], $_POST["user_id"])) {
        // Sanitize and validate input data
        $username = htmlspecialchars(trim($_POST['username']));
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        $user_id = intval($_POST['user_id']);

        // Initialize SQL and parameters
        $query = "UPDATE user_table SET username=?";
        $params = [$username];
        $types = "s"; // "s" for string (username)

        // If password fields are not empty and match, update password
        if (!empty($password) && !empty($confirm_password)) {
            if ($password === $confirm_password) {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password=?";
                $params[] = $hashed_password;
                $types .= "s"; // "s" for string (hashed password)
            } else {
                echo "<script>
                    alert('Passwords do not match.');
                    window.location='user_setting.php';
                    </script>";
                exit;
            }
        }

        // Add the user_id to the query
        $query .= " WHERE user_id=?";
        $params[] = $user_id;
        $types .= "i"; // "i" for integer (user_id)

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare($query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo "<script>
                alert('Record Successfully modified');
                window.location='user_setting.php';
                </script>";
        } else {
            echo "<script>
                alert('Error updating record: " . $stmt->error . "');
                window.location='user_setting.php';
                </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>
            alert('All fields are required.');
            window.location='user_setting.php';
            </script>";
    }
}

// Close the database connection
$conn->close();
?>