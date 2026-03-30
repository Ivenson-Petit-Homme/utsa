<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Tanpri ranpli tout fòm nan kòrèkteman.";
        exit;
    }

    $recipient = "ivensonpetithomme9@gmail.com";
    $email_subject = "Nouvo mesaj kontak UTSA: $subject";
    
    $email_content = "Non: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Mesaj:\n$message\n";

    $email_headers = "From: $name <$email>";

    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        echo "<script>
                alert('Mèsi! Mesaj ou a voye byen.');
                window.location.href = 'contact.html';
              </script>";
    } else {
        // Si fonksyon mail() pa konfigire sou sèvè lokal la
        echo "<script>
                alert('Gen yon pwoblèm. Si w sou yon sèvè lokal (WAMP/XAMPP), fonksyon voye imèl la bezwen konfigirasyon espesyal. Men mesaj la t ap voye bay: $recipient');
                window.location.href = 'contact.html';
              </script>";
    }
} else {
    header("Location: contact.html");
    exit;
}
?>
