<?php
session_start();
$servername = "sql111.infinityfree.com";
$username = "if0_38173944";
$password = "FB8x4t55Kgsg6K";
$dbname = "if0_38173944_quillverse";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_COOKIE['user_id'])) {
    header('Location: ../html/login_page.html');
    exit();
}
$user_id = $_COOKIE['user_id'];

// Handle blog deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_blog_id"])) {
    $blog_id = $_POST["delete_blog_id"];

    // Verify if the blog belongs to the user before deleting
    $verify_query = "SELECT blog_id FROM blogs WHERE blog_id = ? AND author = ?";
    $stmt_verify = $conn->prepare($verify_query);
    $stmt_verify->bind_param("ss", $blog_id, $user_id);
    $stmt_verify->execute();
    $result_verify = $stmt_verify->get_result();

    if ($result_verify->num_rows > 0) {
        // Proceed with deletion only if the blog exists and belongs to the user
        $delete_query = "DELETE FROM blogs WHERE blog_id = ? AND author = ?";
        $stmt_delete = $conn->prepare($delete_query);
        $stmt_delete->bind_param("ss", $blog_id, $user_id);
        $stmt_delete->execute();
        $stmt_delete->close();

        // Update num_blogs count
        $update_count_query = "UPDATE users SET num_blogs = num_blogs - 1 WHERE user_id = ?";
        $stmt_update = $conn->prepare($update_count_query);
        $stmt_update->bind_param("s", $user_id);
        $stmt_update->execute();
        $stmt_update->close();
    }

    $stmt_verify->close();
    
    // Refresh the page to reflect changes
    header("Location: profile.php");
    exit();
}

// Fetch user details
$query = "SELECT name, username, email, bio FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch user blogs
$query_blogs = "SELECT blog_id, title, date_created FROM blogs WHERE author = ? ORDER BY date_created DESC";
$stmt_blogs = $conn->prepare($query_blogs);
$stmt_blogs->bind_param("s", $user_id);
$stmt_blogs->execute();
$result_blogs = $stmt_blogs->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo htmlspecialchars($user['username']); ?></title>
    <link rel="stylesheet" type="text/css" href="../css/profile_page.css">
</head>
<body>
    <div class="profile-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
        
        <h2>Your Blogs</h2>
        <ul>
            <?php while ($blog = $result_blogs->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($blog['title']) . " - " . date("F j, Y", strtotime($blog['date_created'])); ?>
                    
                    <form method="post" style="display:inline;" onsubmit="return confirmDelete(<?php echo htmlspecialchars($blog['blog_id']); ?>)">
                        <input type="hidden" name="delete_blog_id" value="<?php echo $blog['blog_id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <script>
    function confirmDelete(blogId) {
        console.log("Deleting blog ID:", blogId);
        return confirm("Are you sure you want to delete this blog?");
    }
    </script>
</body>
</html>

<?php
$conn->close();
?>
