<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('config.php');
try {
  // Check if the 'id' parameter is set in the URL
  if (isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conx, $_GET['id']);

    // Prepare and execute SQL query to fetch the item with the provided ID
    $sql = "SELECT amount, id, Business FROM companies WHERE id = '$id'";
    $result = $conx->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

        $amount = $row["amount"];
?>
        <!-- <div class="box featured">
                    <h4><sup>UGX</sup><?php
                                      // echo $row["amount"]; 
                                      ?><span> / month</span></h4>
                    <ul>
                       
                  
                </div> -->
<?php
      }
    } else {
      echo "<p>No results found</p>";
    }
  } else {
    echo "<p>ID parameter not provided</p>";
  }
} catch (Exception $e) {
  echo $e->getMessage();
}
?>




<!-- proloader -->
<div class="preloader">
  <div class="spinner"></div>
</div>

<form method="post" action='email/submit_payment_logic.php' class="needs-validation" novalidate>
  <div class="row g-3">
    <div class="col-sm-6">
      <label for="firstName" class="form-label">First name</label>
      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" value="<?php if (isset($_POST['firstname'])) {
                                                                                                      echo $firstname;
                                                                                                    } ?>" required>

      <div class="invalid-feedback">
        Valid first name is required.
      </div>
    </div>

    <div class="col-sm-6">
      <label for="lastName" class="form-label">Last name</label>
      <input type="text" name="lastname" class="form-control" id="lastname" placeholder="" value="<?php if (isset($_POST['lastname'])) {
                                                                                                    echo $lastname;
                                                                                                  } ?>" required>
      <div class="invalid-feedback">
        Valid last name is required.
      </div>
    </div>

    <div class="col-6">
      <label for="username" class="form-label">Username</label>
      <div class="input-group has-validation">
        <span class="input-group-text">@</span>
        <input type="text" name="username" class="form-control" id="username" placeholder="username" value="<?php if (isset($_POST['username'])) {
                                                                                                              echo $username;
                                                                                                            } ?>" required>
        <div class="invalid-feedback">
          Your username is required.
        </div>
      </div>
    </div>

    <div class="col-sm-6">
      <label for="lastName" class="form-label"> Phone number</label>
      <input type="text" name="phone" class="form-control" id="phone" placeholder="+256 785557587" value="<?php if (isset($_POST['phone'])) {
                                                                                                    echo $phone;
                                                                                                  } ?>"  required>
      <div class="invalid-feedback">
        Valid last name is required.
      </div>
    </div>

    <div class="col-sm-6">




      <div id="msg"></div>

      <label for="email" class="form-label">Email <span class="text-muted">(Strongly Needed)</span></label>
      <input type="email" class="form-control" id="email" placeholder="you@example.com" name="email" value="<?php if (isset($_POST['email'])) {
                                                                                                                echo $email;
                                                                                                              } ?>" required>
      <div class="invalid-feedback">
        Please enter a valid email address for account activation.
      </div>
    </div>


    <!-- <div class="col-sm-6">
                    <label for="lastName" class="form-label">Verify Email</label>
                    <input type="text" class="form-control" id="" placeholder="OTP" value="" required>
                    <div class="invalid-feedback">
                      Valid OTP required.
                    </div>
                  </div> -->

  </div>
  <hr class="my-4">
  <h4 class="mt-3 mb-3">Business Profile</h4>
  <div class="row g-3">
    <div class="col-12">
      <label for="address" class="form-label">Organization name</label>
      <input type="text" class="form-control" id="org_name" name="org_name" value="<?php if (isset($_POST['org_name'])) {
                                                                                      echo $org_name;
                                                                                    } ?>" placeholder="1234 Main St" required>
      <div class="invalid-feedback">
        Please enter your shipping address.
      </div>
    </div>

    <div class="col-12">
      <label for="address2" class="form-label">Organization website</label>
      <input type="text" class="form-control" id="org_website" name="org_website" value="<?php if (isset($_POST['org_website'])) {
                                                                                            echo $org_website;
                                                                                          } ?>" placeholder="Apartment or suite" required>

    </div>

    <!-- <div class="col-md-5">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" required>
                      <option value="">Choose...</option>
                      <option>United States</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select a valid country.
                    </div>
                  </div>
                
                  <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <select class="form-select" id="state" required>
                      <option value="">Choose...</option>
                      <option>California</option>
                    </select>
                    <div class="invalid-feedback">
                      Please provide a valid state.
                    </div>
                  </div>
                
                  <div class="col-md-3">
                    <label for="zip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="zip" placeholder="" required>
                    <div class="invalid-feedback">
                      Zip code required.
                    </div>
                  </div>
                </div> -->

    <hr class="my-4">
    <h4 class="mt-3 mb-3">Payment Frequency</h4>

    <div class="container">
      <div class="row">
        <div class="col-sm-3 mb-2">
          <div class="card p-3">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <p class="pe-3">1 Month</p>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="amount" name="amount" value="<?php echo $amount ?? 0; ?>" onchange="handleCheckboxChange(this)">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3 mb-2">
          <div class="card p-3">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <p class="pe-3">3 Months</p>

                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="amount" name="amount" value="<?php echo $amount * 3 ?? 0; ?>" onchange="handleCheckboxChange(this)">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3 mb-2">
          <div class="card p-3">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <p class="pe-3">6 Months</p>

                <div class="form-check form-switch">

                  <input class="form-check-input" type="checkbox" id="amount" name="amount" value="<?php echo $amount * 6 ?? 0; ?>" onchange="handleCheckboxChange(this)">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3 mb-2">
          <div class="card p-3">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <p class="pe-3">1 Year</p>

                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="amount" name="amount" value="<?php echo $amount * 12 ?? 0; ?>" onchange="handleCheckboxChange(this)">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      function handleCheckboxChange(checkbox) {
        if (checkbox.checked) {
          var checkboxes = document.getElementsByName("amount");
          checkboxes.forEach(function(item) {
            if (item !== checkbox) {
              item.checked = false;
            }
          });
        }
      }
    </script>

    <hr class="my-4">

    <h4 class="mt-3 mb-3">Addons</h4>
    <div class="card p-3 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <p class="fw-bold">Admin Mobile Application</p> <small class="text-muted">Manage and Monitor AI and other business activities.</small>
        </div>
        <div class="d-flex align-items-center">
          <p class="pe-3">10000 UGX</p>
          <div class="form-check form-switch"> <input class="form-check-input" type="checkbox" name="admin_mobile_app" value="10000" id="SwitchCheck"> </div>
        </div>
      </div>
    </div>
    <div class="card p-3 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <p class="fw-bold">External Advertising</p> <small class="text-muted">Run external advertising on your platforms.</small>
        </div>
        <div class="d-flex align-items-center">
          <p class="pe-3">10000 UGX</p>
          <div class="form-check form-switch"> <input class="form-check-input" type="checkbox" name="external_advert" value="10000" id="SwitchCheck"> </div>
        </div>
      </div>
    </div>
    <div class="card p-3 mb-2">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <p class="fw-bold">Add Social Profiles</p> <small class="text-muted">Link your account to external social medial profiles for adds and notifications.</small>
        </div>
        <div class="d-flex align-items-center">
          <p class="pe-3">10000 UGX</p>
          <div class="form-check form-switch"> <input class="form-check-input" type="checkbox" id='add_social_profile' name="add_social_profile" value="10000" id="SwitchCheck"> </div>
        </div>
      </div>
    </div>

    <hr class="my-4">

    <!-- <h4 class="mt-3 mb-3">Payment</h4>
      
                <div class="my-3">
                  <div class="form-check">
                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                    <label class="form-check-label" for="credit">Credit card</label>
                  </div>
                  <div class="form-check">
                    <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="debit">Debit card</label>
                  </div>
                  <div class="form-check">
                    <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                    <label class="form-check-label" for="paypal">PayPal</label>
                  </div>
                </div>
      
                <div class="row gy-3">
                  <div class="col-md-6">
                    <label for="cc-name" class="form-label">Name on card</label>
                    <input type="text" class="form-control" id="cc-name" placeholder="" required>
                    <small class="text-muted">Full name as displayed on card</small>
                    <div class="invalid-feedback">
                      Name on card is required
                    </div>
                  </div>
      
                  <div class="col-md-6">
                    <label for="cc-number" class="form-label">Credit card number</label>
                    <input type="text" class="form-control" id="cc-number" placeholder="" required>
                    <div class="invalid-feedback">
                      Credit card number is required
                    </div>
                  </div>
      
                  <div class="col-md-3">
                    <label for="cc-expiration" class="form-label">Expiration</label>
                    <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                    <div class="invalid-feedback">
                      Expiration date required
                    </div>
                  </div>
      
                  <div class="col-md-3">
                    <label for="cc-cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                    <div class="invalid-feedback">
                      Security code required
                    </div>
                  </div>
                </div>

                printf("<script>alert('Success')
                  document.location.href= 'index.php'
                </script>);
      
                <hr class="my-4"> -->

    <div id="msg"></div>

    <!-- <a class="w-100 btn btn-primary btn-lg" id="submit" type="submit">Proceed to Payement</a> -->
    <!-- <input type="submit" class="w-100 btn btn-primary btn-lg" id="submit" value='submit'  > -->
    <input type="submit" class="w-100 btn btn-primary btn-lg" id="lsubmit" name="submit" value='submit'>



</form>


<!-- js for email verification -->
<script>
  $(document).ready(function() {
    $('#submit').on('click', function() {
      var email = $('#email').val();
      resendVerification(email);
    });

    function resendVerification(email) {
      $.ajax({
        type: 'POST',
        url: 'email/submit_payment_logic.php',
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

  $(document).ready(function() {
    // Event handler for email input blur
    $('#email').on('blur', function() {
      var email = $(this).val();
      $.ajax({
        type: 'POST',
        url: 'email/verify_email.php',
        data: {
          email: email
        },
        beforeSend: function() {
          $('.preloader').show();
        },
        success: function(response) {
          $('#msg').html(response);
          $('.preloader').hide();
        },
        error: function(xhr, status, error) {
          $('.preloader').hide();
          console.error(xhr.responseText);
        }
      });
    });



    // Event handler for form submission
    // $('#submit').on('click', function() {
    //   var email = $('#email').val();
    //   var fullname = $('#fullname').val();
    //   var lastname = $('#lastname').val();
    //   var username = $('#username').val();
    //   var org_name = $('#org_name').val();
    //   var org_website = $('#org_website').val();
    //   var amount = $('#amount').val();
    //   var admin_mobile_app = $('#admin_mobile_app').val();
    //   var external_advert = $('#external_advert').val();
    //   var add_social_profile = $('#add_social_profile').val();

    //   resendVerification(email, fullname, lastname, username, org_name, amount, admin_mobile_app, external_advert, add_social_profile);
    // });

    // // Function to handle form submission AJAX request
    // function resendVerification(email, fullname, lastname, username, org_name, amount, admin_mobile_app, external_advert, add_social_profile) {
    //   $.ajax({
    //     type: 'POST',
    //     url: 'email/submit_payment_logic.php',
    //     data: {
    //       email: email,
    //       fullname: fullname,
    //       lastname: lastname,
    //       username: username,
    //       org_name: org_name,
    //       org_website: org_website,
    //       amount: amount,
    //       admin_mobile_app: admin_mobile_app,
    //       external_advert: external_advert,
    //       add_social_profile: add_social_profile,
    //     },
    //     beforeSend: function() {
    //       $('.preloader').show();
    //     },
    //     success: function(response) {
    //       $('#msg').html(response);
    //       $('.preloader').hide();
    //     },
    //     error: function(xhr, status, error) {
    //       $('.preloader').hide();
    //       console.error(xhr.responseText);
    //     }
    //   });
    // }
  });


  //     $(document).ready(function() {
  //         $('#email').on('blur', function() {
  //             var email = $(this).val();
  //             // Your code to handle the user leaving the input field here
  //             // console.log(email);
  //             $.ajax({
  //                 type: 'POST',
  //                 url: 'email/submit_payment_logic.php',
  //                 data: {
  //                     email: email
  //                 },
  //                 beforeSend: function() {
  //                     // Show the preloader before sending the email
  //                     $('.preloader').show();
  //                 },
  //                 success: function(response) {
  //                     $('#msg').html(response);
  //                     // Hide the preloader after the email is sent successfully
  //                     $('.preloader').hide();
  //                 },
  //                 error: function(xhr, status, error) {
  //                     // Hide the preloader if there's an error
  //                     $('.preloader').hide();
  //                     console.error(xhr.responseText);
  //                 }
  //             });
  //         });
  //     });

  //     $(document).ready(function() {
  //     $('#submit').on('click', function() {
  //         var email = $('#email').val();
  //         var fullname = $('#fullname').val();
  //         var lastname = $('#lastname').val();
  //         var username = $('#username').val();
  //         var org_name = $('#org_name').val();
  //         var org_website = $('#org_website').val();
  //         var amount = $('#amount').val();
  //         var admin_mobile_app = $('#admin_mobile_app').val();
  //         var external_advert = $('#external_advert').val();
  //         var add_social_profile = $('#add_social_profile').val();
  //         // var username = $('#username').val();
  //         // var username = $('#username').val();

  //         resendVerification(email, fullname, lastname, username, org_name,amount,admin_mobile_app,external_advert ,add_social_profile);
  //     });

  //     function resendVerification(email, fullname, lastname, username, org_name, org_website, amount, admin_mobile_app, external_advert, add_social_profile ) {
  //         $.ajax({
  //             type: 'POST',
  //             url: 'email/submit_form.php',
  //             data: {
  //                 email: email,
  //                 fullname: fullname,
  //                 lastname: lastname,
  //                 username: username,
  //                 org_name: org_name,
  //                 org_website: org_website,
  //                 amount: amount,
  //                 admin_mobile_app: admin_mobile_app,
  //                 external_advert: external_advert,
  //                 add_social_profile: add_social_profile,

  //             },
  //             beforeSend: function() {
  //                 // Show the preloader before sending the email
  //                 $('.preloader').show();
  //             },
  //             success: function(response) {
  //                 $('#msg').html(response);
  //                 // Hide the preloader after the email is sent successfully
  //                 $('.preloader').hide();
  //             },
  //             error: function(xhr, status, error) {
  //                 // Hide the preloader if there's an error
  //                 $('.preloader').hide();
  //                 console.error(xhr.responseText);
  //             }
  //         });
  //     }
  // });
</script>




