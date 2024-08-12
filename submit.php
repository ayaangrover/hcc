<?php
require 'vendor/autoload.php';
require 'config.php';
use Mailgun\Mailgun;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'] ?? 'Not provided';

    $email_content = "New Club Member Submission:\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";

    $mgClient = Mailgun::create(MAILGUN_API_KEY);
    
    $result = $mgClient->messages()->send(MAILGUN_DOMAIN, [
        'from'    => 'Harker Coding Club <mailgun@MAILGUN_DOMAIN>',
        'to'      => 'Ayaan Grover <ayaangrover@gmail.com>',
        'subject' => 'New Coding Club Member Submission',
        'text'    => $email_content
    ]);

    if ($result->getId()) {
        echo "<script>alert('Thank you for your submission!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('There was an error processing your submission. Please try again later.'); window.location.href='join.html';</script>";
    }
}
?>