<?php
    # Message variables

    $msg = '';
    $msgClass = '';
    if(filter_has_var(INPUT_POST, 'submit')) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
    }
    if(!empty($name) && !empty($email) && !empty($message)) {
        # Check email

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            # Fail 
            $msg = 'Please use a valid email';
            $msgClass = 'alert-danger';
        } else {
            // Passed
            // Recipient email
           $toEmail = 'benediceduard@outlook.com';
           $subject = 'Contact Request from '.$name;
           $body = '<h2> Contact Request </h2>
                    <h4> Name </h4>
                     <p>'. $name. '</p>   
                     <h4> Email </h4>
                     <p>'. $email. '</p>  
                     <h4> Message </h4>
                     <p>'. $message. '</p>  
                    ';

                    // Email headers
            $headers = "MIME-Version: 1.0". "\r\n";
            $headers .= "Content-Type: text/html;charset=UTF-8"."\r\n";
            // Additional headers
            $headers = "From: ".$name. "<". $email. ">". "\r\n";

            if(mail($toEmail, $subject, $body, $headers)) {
                // Email sent
                $message = "Your email has been sent";
                $msgClass = "success";
            } else {
                $msg = "your email didnt go through";
                $msgClass = "alert-danger";
            }
        }
    } else {
        $msg = 'Please fill in all fields';
        $msgClass = 'alert-danger';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact us</title>
</head>
<style>
.alert-danger {
    background-color: red;
    color: white;
}
</style>
<body>
<?php if($msg != ''): ?>
    <div class="<?php echo $msgClass; ?>"><?php echo $msg; ?></div>
<?php endif; ?>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" >
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
        <br>
        <label>Message</label>
        <textarea name="message">
            <?php echo isset($_POST['message']) ? $message : ''; ?>
        </textarea>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>