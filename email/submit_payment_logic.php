

<?php


include('config.php');



if (isset($_POST['submit'])) {
  $firstname = mysqli_real_escape_string($conx, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conx, $_POST['lastname']);
  $username = mysqli_real_escape_string($conx, $_POST['username']);
  $phone = mysqli_real_escape_string($conx, $_POST['phone']);

  $email = mysqli_real_escape_string($conx, $_POST['email']);
  $org_name = mysqli_real_escape_string($conx, $_POST['org_name']);
  $org_website = mysqli_real_escape_string($conx, $_POST['org_website']);
  $amount = mysqli_real_escape_string($conx, $_POST['amount']);
  $admin_mobile_app = mysqli_real_escape_string($conx, $_POST['admin_mobile_app']);
  $external_advert = mysqli_real_escape_string($conx, $_POST['external_advert']);
  $add_social_profile = mysqli_real_escape_string($conx, $_POST['add_social_profile']);


  // echo 'hello';
  // echo $firstname, $lastname, $username, $email, $org_name, $org_website, $admin_mobile_app, $external_advert, $amount, $add_social_profile ;

  // check whether the email exists
 // Check if the user exists based on email
$query = mysqli_query($conx, "SELECT * FROM users WHERE email='{$email}'");
if (mysqli_num_rows($query) > 0) {
    // echo 'User found';

    // Check if the user has a verification code associated with their email
    $row = mysqli_fetch_assoc($query);
    if (!empty($row['verification_code'])) {
        echo 'You tried to verify your email but the process is incomplete';
    } else {
        // Proceed with whatever action you want to take if the user is verified
        // For example, you could redirect them to a dashboard or display a message indicating they are verified.
        // echo 'User is verified';


        $total_amount = (float)$amount + (float)$admin_mobile_app + (float)$external_advert + (float)$add_social_profile;
      
        
          
         $request = [
        'tx_ref' => time(),
        'amount' => $total_amount,
        'currency' => 'UGX',
        "phone_number"=>$phone,
    //    "client_ip"=>"154.123.220.1",
        'payment_options' => 'card',
        'redirect_url' => 'http://localhost/cognosphere/email/verify_payments.php',
        'customer' => [
            'email' => $email,
            'name' => $firstname ,
            "phone_number"=>$phone,

        ],
        'meta' => [
              'firstname' =>  $firstname,
              'lastname' =>  $lastname,
              'phone' =>  $phone,
              'email' =>  $email,
              'username' =>  $username,
            // "sender_country"=> "UG",
            "phone_number"=>$phone,
             'amount' => $total_amount,
             'price'=>$total_amount,
              'org_name' =>  $org_name , 
            'org_website' =>  $org_website ,
            'ai_subscription' =>  $amount , 
            'admin_mobile_app' =>  $admin_mobile_app , 
            'external_advert' =>  $external_advert , 
            'add_social_profile' =>  $add_social_profile , 

            
        ], 
        'customizations' => [
            'title' => ' subscription To Cognoshere Dynamics ltd',
            'description' => 'This a subscription for AI services at Cognosphere'
        ]
    ];


    //* Ca;; f;iterwave emdpoint
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',   
    // CURLOPT_URL => 'https://api.flutterwave.com/v3/charges?type=mobile_money_uganda', 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_HTTPHEADER => array( 
        // 'Authorization: Bearer FLWSECK_TEST-723f1df37c2341965123d79b4ee5015e-X',
                'Authorization: Bearer FLWSECK_TEST-723f1df37c2341965123d79b4ee5015e-X',

        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);


    $res = json_decode($response);

    if($res->status == 'success')
    {
        $link = $res->data->link;
        header('Location: '.$link);
    }
    else
    {
        echo 'We can not process your payment';
    }

    }
} else {
    // If user doesn't exist, prompt them to verify their email
    echo 'Verify your email first to continue';
}



}
?>