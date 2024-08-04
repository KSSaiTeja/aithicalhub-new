<?php

// Only process POST requests.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the form fields and remove extra spaces and newlines.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"), array(" ", " "), $name);

    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Check that data was sent to the mailer.
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // Set the recipient email address.
    $recipient = "saitej4865@gmail.com"; // Update this to your desired email address.

    // Set the email subject.
    $subject = "New Message from Contact Form";

    // Build the email content.
    $email_content = "<h2>Contact Form Submission</h2>
                      <p><strong>Name:</strong> $name</p>
                      <p><strong>Email:</strong> $email</p>
                      <p><strong>Message:</strong></p>
                      <p>$message</p>";

    // Set the email headers.
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $headers)) {
        // Set a 200 (OK) response code and return success message.
        http_response_code(200);
        echo "Thank you for your message. It has been sent.";
    } else {
        // Set a 500 (internal server error) response code and return error message.
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Not a POST request.
    http_response_code(405);
    echo "Method not allowed.";
}
?>
