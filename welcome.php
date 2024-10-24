<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ensure 'posts' is initialized
if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}

// Handle logout
if (isset($_POST['logout'])) {
    $userDataFile = 'user_data_' . $_SESSION['username'] . '.json';
    file_put_contents($userDataFile, json_encode($_SESSION));

    session_destroy();
    header('Location: login.php');
    exit();
}

// Handle profile picture upload
$profile_picture_button_text = "Upload Profile Picture"; // Default button text

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $profileDir = 'uploads/profiles/';
    if (!is_dir($profileDir)) {
        mkdir($profileDir, 0777, true);
    }

    $profileFile = $profileDir . basename($_FILES['profile_picture']['name']);
    if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profileFile)) {
        $_SESSION['profile_picture'] = $profileFile;
        $profile_picture_button_text = "Change Profile Picture"; // Change button text after upload
    } else {
        $error_message = "Failed to upload profile picture.";
    }
}

// Handle post submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['caption']) || isset($_FILES['post_image']))) {
    $postDir = 'uploads/posts/';
    if (!is_dir($postDir)) {
        mkdir($postDir, 0777, true);
    }

    $newPost = [
        'caption' => isset($_POST['caption']) ? htmlspecialchars($_POST['caption']) : '',
        'image' => null,
        'likes' => 0,
        'liked' => false,
        'comments' => []
    ];

    // Handle image upload
    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] == UPLOAD_ERR_OK) {
        $postFile = $postDir . basename($_FILES['post_image']['name']);
        if (move_uploaded_file($_FILES['post_image']['tmp_name'], $postFile)) {
            $newPost['image'] = $postFile;
        } else {
            $post_error_message = "Failed to upload post image.";
        }
    }

    if (!empty($newPost['caption']) || !empty($newPost['image'])) {
        $_SESSION['posts'][] = $newPost;
    } else {
        $post_error_message = "You must provide either a caption or an image.";
    }
}

// Handle post deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post_index'])) {
    $index = intval($_POST['delete_post_index']);
    if (isset($_SESSION['posts'][$index])) {
        unset($_SESSION['posts'][$index]);
        $_SESSION['posts'] = array_values($_SESSION['posts']);
        $delete_success_message = "Post deleted successfully!";
    }
}

// Handle editing post captions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_post_index'])) {
    $index = intval($_POST['edit_post_index']);
    if (isset($_SESSION['posts'][$index])) {
        $_SESSION['posts'][$index]['caption'] = htmlspecialchars($_POST['new_caption']);
    }
}

// Handle liking posts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post_index'])) {
    $index = intval($_POST['like_post_index']);
    if (isset($_SESSION['posts'][$index])) {
        $_SESSION['posts'][$index]['liked'] = !$_SESSION['posts'][$index]['liked'];
        $_SESSION['posts'][$index]['likes'] += $_SESSION['posts'][$index]['liked'] ? 1 : -1;
    }
}

// Handle commenting on posts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_post_index']) && !empty($_POST['comment'])) {
    $index = intval($_POST['comment_post_index']);
    if (isset($_SESSION['posts'][$index])) {
        $_SESSION['posts'][$index]['comments'][] = htmlspecialchars($_POST['comment']);
    }
}

// Get profile picture from session
$profile_picture = isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'uploads/profiles/default_profile.jpg';

// Check if the session variable 'username' is set
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #ffffff; /* White background */
            color: #333; /* Dark text */
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #000; /* Black for navbar */
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #444;
        }
        .container {
            margin-top: 20px;
            background-color: #f9f9f9; /* Light gray for container */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .profile-picture-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-picture {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            border: 2px solid #000; /* Black border */
        }
        .post {
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 0;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
        .logout-button {
            margin-top: 20px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-button:hover {
            background-color: #ff1a1a;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #000; /* Black button */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #444; /* Dark gray on hover */
        }
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="navbar">
        <h3><?php echo htmlspecialchars($username); ?></h3>
        <div>
            <a href="home.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="settings.php">Settings</a>
            <a href="notifications.php">Notifications</a>
            <a href="messages.php">Messages</a>
            <a href="help.php">Help</a>
            <form method="POST" style="display:inline;">
                <input type="submit" name="logout" value="Logout" class="logout-button" />
            </form>
        </div>
    </div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

        <div class="profile-picture-container">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-picture">
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_picture" accept="image/*" required>
                <input type="submit" value="<?php echo $profile_picture_button_text; ?>">
            </form>
        </div>

        <h3>Create a Post</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="caption" placeholder="Write a caption..." required>
            <input type="file" name="post_image" accept="image/*">
            <input type="submit" value="Post">
        </form>

        <h3>Your Posts</h3>
        <?php if (!empty($_SESSION['posts'])): ?>
            <?php foreach ($_SESSION['posts'] as $index => $post): ?>
                <div class="post">
                    <p><?php echo htmlspecialchars($post['caption']); ?></p>
                    <?php if (!empty($post['image'])): ?>
                        <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image" style="max-width: 100%; height: auto;">
                    <?php endif; ?>
                    <p>Likes: <?php echo $post['likes']; ?></p>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="like_post_index" value="<?php echo $index; ?>">
                        <input type="submit" value="<?php echo $post['liked'] ? 'Unlike' : 'Like'; ?>">
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="comment_post_index" value="<?php echo $index; ?>">
                        <input type="text" name="comment" placeholder="Add a comment..." required>
                        <input type="submit" value="Comment">
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="edit_post_index" value="<?php echo $index; ?>">
                        <input type="text" name="new_caption" placeholder="Edit caption...">
                        <input type="submit" value="Edit" class="edit-button">
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_post_index" value="<?php echo $index; ?>">
                        <input type="submit" value="Delete" class="btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">
                    </form>
                    <h4>Comments:</h4>
                    <?php if (!empty($post['comments'])): ?>
                        <ul>
                            <?php foreach ($post['comments'] as $comment): ?>
                                <li><?php echo htmlspecialchars($comment); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No posts yet.</p>
        <?php endif; ?>

        <div class="error-message">
            <?php if (isset($error_message)) echo $error_message; ?>
            <?php if (isset($post_error_message)) echo $post_error_message; ?>
            <?php if (isset($delete_success_message)) echo $delete_success_message; ?>
        </div>

        <!-- Print Button -->
        <div class="text-center">
            <button onclick="printPage()">Print Page</button>
        </div>

    </div>
</body>
</html>
