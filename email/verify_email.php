<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Cognosphere Dynamics Limited</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Favicons -->
    <link href="assets/img/cognosphere.png" rel="icon">
    <link href="assets/img/cognosphere.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>


    <?php
    // session_start();

    include('config.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $verify_much = '';
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email'])) {
            $email = mysqli_real_escape_string($conx, $_POST['email']);
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= mt_rand(0, 9);
            }
            mysqli_begin_transaction($conx);

            if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM users where email='{$email}'")) > 0) {
                echo "<div style='color: red;' class='alert alert-danger'>This Email: '{$email}' already exists.</div>";

                // $_SESSION['success'] = 'Account created successfully';


                // header("Location:/payments.php?id=1");
                exit;

            } else {

                // Generate verification code
                try {
                    $query = "INSERT INTO users(`email`, `verification_code`) values('$email','$code')";
                    $result = mysqli_query($conx, $query);

                    if (!$result) {
                        // mysqli_rollback($conx);

                        echo '<p style="font-size: 24px; font-weight: bold; color: blue;">Something went wrong. Try again!!!</p>';
                    }



                    try {

                        $mail = new PHPMailer(true);

                        //Server settings
                        $mail->SMTPDebug = 0;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host  = 's13.asurahosting.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'info@gictafrica.com';                     //SMTP username
                        $mail->Password   = 'Mammyggg1.';                               //SMTP password
                        $mail->SMTPSecure = 'Tls';            //Enable implicit TLS encryption
                        $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('info@gictafrica.com', 'cognos');
                        $mail->addAddress($email, 'alfred');
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Welecom To kazzimoto';
                        $mail->Body = '
                            <div style="font-family: Arial, sans-serif;">
                            <h2>Welcome to Our Website!</h2>
                            <p>Here is your verification code:</p>
                            <p style="font-size: 24px; font-weight: bold; color: blue;">' . $code . '</p>
                            <p>Please enter this code to complete the signup process.</p>
                            <p>Thank you!</p>
                        </div>
                            ';

                        $mail->send();


                        echo "<div style='color:green;' class='alert alert-info'>We've sent a verification code to your email address.</div>";
    ?>


                        <form action="" method="post">

                            <div class="col-sm-6">
                                <label for="lastName" class="form-label">Verify Email</label>
                                <input type="hidden" class="form-control" id="email" value="<?php echo $email; ?>" required>
                                <input type="text" class="form-control" id="code" placeholder="OTP" value="" required>
                                <div class="invalid-feedback">
                                    Valid OTP required.
                                </div>
                            </div>
                        </form>

                        <script>
                            $(document).ready(function() {
                                $('#code').on('blur', function() {
                                    var code = $(this).val();
                                    var email = $('#email').val();
                                    $.ajax({
                                        type: 'POST',
                                        url: 'email/verify_code.php',
                                        data: {
                                            code: code,
                                            email: email // Include email in the data sent to the server
                                        },
                                        success: function(response) {
                                            $('#msg').html(response);
                                        }
                                    });
                                });
                            });
                        
                        </script>


    <?php
                        mysqli_commit($conx);
                    } catch (Exception $e) {
                        mysqli_rollback($conx);

                        $error = $e->getMessage();
                        if ($error == 'SMTP Error: Could not connect to SMTP host. Failed to connect to server') {
                            echo '<p style=" color: red;">There is Network error</p>';
                        }

                        echo '<p style=" color: red;">' . $error . '</p>';
                    }
                } catch (Exception $e) {
                    mysqli_rollback($conx);

                    $error = $e->getMessage();
                    echo '<p style="  color: red;">' . $error . '</p>';
                }
            }
        }
    }
    ?>


</body>

</html>