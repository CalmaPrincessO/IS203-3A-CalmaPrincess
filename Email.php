    <?php
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    // Include PHPMailer classes
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    function sendMail($email, $subject, $message) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'princessocampocalma@gmail.com';  // Your email
            $mail->Password = 'u d y q v v p c v c y y a u q p'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient settings
            $mail->setFrom('princessocampocalma@gmail.com', 'Calma Princess O.');
            $mail->addAddress($email);  // Recipient email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);

            $mail->send();
            return "success";
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        if (empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
            $response = "All fields are required";
        } else {
            $response = sendMail($_POST['email'], $_POST['subject'], $_POST['message']);
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Notification</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
    body {
        background-color: #1a1a1a; /* Dark background */
        color: #e0e0e0; /* Light gray text */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        height: 100vh;
        margin: 0;
    }

    /* Navigation Bar */
    .navbar {
        background-color: #333; /* Dark gray for navbar */
        width: 220px; /* Width of the sidebar */
        height: 100%; /* Full height of the viewport */
        padding: 15px 0; /* Padding for top and bottom */
        position: fixed; /* Fixed positioning */
        display: flex;
        flex-direction: column; /* Stack links vertically */
    }

    .navbar a {
        color: #e0e0e0; /* Light gray for links */
        text-decoration: none;
        padding: 12px 20px;
        font-weight: 500;
        text-transform: uppercase;
        transition: background 0.3s ease;
        display: block; /* Block-level for full width */
    }

    .navbar a:hover {
        background-color: #444; /* Lighter gray on hover */
        border-radius: 5px;
    }

    .container {
        margin-left: 240px; /* Margin to avoid overlap with navbar */
        padding: 20px;
        background-color: #444; /* Darker gray for container */
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        flex-grow: 1; /* Take remaining space */
    }

    h1 {
        color: white; /* White color for headers */
        font-weight: bold;
        text-align: center; /* Centered title */
    }

    label {
        font-weight: bold; /* Bold labels */
    }

    input[type="text"],
    input[type="email"],
    textarea {
        width: 100%; /* Full width */
        padding: 10px;
        margin: 10px 0; /* Space between elements */
        border: 1px solid #e0e0e0; /* Light gray border for inputs */
        border-radius: 5px; /* Rounded corners */
        background-color: #555; /* Dark gray for input fields */
        color: white; /* White text */
        box-sizing: border-box; /* Include padding and border in element's total width */
    }

    input[type="submit"] {
    background-color: royalblue; /* Blue for the submit button */
    color: white; /* White text */
    border: none; /* No border */
    padding: 5px 15px; /* Smaller padding for a smaller button */
    cursor: pointer; /* Pointer cursor */
    transition: background-color 0.3s; /* Transition for hover effect */
    border-radius: 5px; /* Consistent border radius */
    display: inline-block; /* Align button to the left */
    margin-top: 10px; /* Space above the button */
}

    input[type="submit"]:hover {
        background-color: darkblue; /* Darker blue on hover */
    }

    /* Responsive textarea */
    textarea {
        resize: none; /* Disable resize to maintain size */
        height: 120px; /* Fixed height for consistency */
    }
</style>

    </head>
    <body>

   <!-- Navigation Bar -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="sms.php">SMS</a>
    <a href="Email.php">Email</a>
    <a href="registration.php">Register</a>
    <a href="Welcome.php">Welcome</a>
</div>
    </div>
    <div class="container">
        <h1><b>Send Email Notification</b></h1>
        <form action="" method="post">  
            <h2>Create Email</h2>
            <input type="email" name="email" placeholder="Enter recipient email" required />
            <input type="text" name="subject" placeholder="Enter email subject" required />
            <textarea name="message" rows="5" placeholder="Enter your message" required></textarea>
            <input type="submit" name="submit" value="Send Email" class="btn btn-primary">
        </form>

        <?php if (isset($response)) : ?>
            <p class="response <?= $response == 'success' ? 'text-success' : 'text-danger'; ?>">
                <?= $response == 'success' ? 'Email sent successfully.' : $response; ?>
            </p>
        <?php endif; ?>
    </div>

    </body>
    </html>
