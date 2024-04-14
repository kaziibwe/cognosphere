<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
    <style>
        /* Your CSS styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .preloader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            z-index: 9999;
        }

        .spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 4px solid #333;
            border-top: 4px solid #777;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <div class="preloader">
                    <div class="spinner"></div>
                </div>
                <form action="" method="POST" class="sign-up-form" id="signupForm">
                    <h2 class="title">Sign up</h2>


                    <div id="msg"></div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="Email" id="email" placeholder="Email" required/>

                    </div>
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.</p>
                    <a href="index.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">Sign in</a>
                </div>
                <img src="img/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('#email').on('blur', function() {
        //         var email = $(this).val();
        //         // Your code to handle the user leaving the input field here
        //         $.ajax({
        //             type: 'POST',
        //             // url: window.location.href, // Use the current page URL

        //             url: 'verify_email.php',
        //             data: {
        //                 email: email
        //             },
        //             success: function(response) {
        //                 $('#msg').html(response);
        //             }
        //         });
        //     });
        // });

        $(document).ready(function() {
            $('#email').on('blur', function() {
                var email = $(this).val();
                // Your code to handle the user leaving the input field here
                $.ajax({
                    type: 'POST',
                    url: 'verify_email.php',
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
            });
        });
    </script>
</body>

</html>


// $(document).ready(function() {
// $('#verifyBtn').click(function() {
// var email = $('#email').val();
// // console.log(email);
// $.ajax({
// type: 'POST',
// // url: window.location.href, // Use the current page URL

// url: 'verify_email.php',
// data: {
// email: email
// },
// success: function(response) {
// $('#msg').html(response);
// }
// });
// });
// });