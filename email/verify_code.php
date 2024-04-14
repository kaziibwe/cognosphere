<?php
session_start();

include('config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['code'])) {
        $code = mysqli_real_escape_string($conx, $_POST['code']);
        $email = mysqli_real_escape_string($conx, $_POST['email']);


        if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM users where verification_code='{$code}'")) > 0) {
            // mysqli_commit($conx);


            $update_query = "UPDATE users SET verification_code = NULL WHERE verification_code = '{$code}'";
            if (mysqli_query($conx, $update_query)) {
                // mysqli_commit($conx);

                // echo "<div style='color: green;' class='alert alert-success'>Email verified continue with the verification.</div>";

                // printf("<script>alert('Email verified continue with the verification'); document.location.href = 'payments.php'; </script>");

                $_SESSION['success'] = 'Account created successfully';


                header("Location:http://localhost/cognosphere/payments.php?id=1");
                exit;
            } else {

                echo "<div style='color: red;' class='alert alert-danger'>Error: Something went wrong. Please Try again</div>";
            }
        } else {
            // mysqli_rollback($conx);


            $update_query = "UPDATE users SET verification_code = NULL WHERE verification_code = '{$code}'";
            if (mysqli_query($conx, $update_query)) {
                // mysqli_commit($conx);
                echo "<div style='color: red;' >Invalid verification code Re-enter the Valid Email to Try again!!!.</div>";
            }


?>

            <form action="" method="post">

                <input type="hidden" class="form-control" id="email" value="<?php echo $email; ?>" required>

                <button type="button" id="resendButton" style='color: red;'>Resend OTP</button>
            </form>

            <script>
                $(document).ready(function() {
                    $('#resendButton').on('click', function() {
                        var email = $('#email').val();
                        resendVerification(email);
                    });

                    function resendVerification(email) {
                        $.ajax({
                            type: 'POST',
                            url: 'email/verify_email-resend.php',
                            data: {
                                email: email
                            },
                            beforeSend: function() {
                                // Show the preloader before sending the email
                                $('.preloader').show();
                            },
                            success: function(response) {
                                $('#msg').html(response);
                                // Hide the preloader after the email is sent successfully
                                $('.preloader').hide();
                            },
                            error: function(xhr, status, error) {
                                // Hide the preloader if there's an error
                                $('.preloader').hide();
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            </script>
<?php
        }
    }
}



?>