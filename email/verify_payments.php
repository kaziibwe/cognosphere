<?php
include('config.php');

if (isset($_GET['status'])) {
    //* check payment status
    if ($_GET['status'] == 'cancelled') {
        // echo 'YOu cancel the payment';

    } elseif ($_GET['status'] == 'successful') {
        $txid = $_GET['transaction_id'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer FLWSECK_TEST-723f1df37c2341965123d79b4ee5015e-X"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;


        echo '<pre>';
        echo $response;

        echo '</pre>';

        $res = json_decode($response);


        $amountPaid = $res->data->charged_amount;
        $amountToPay = $res->data->meta->price;
        $status = $res->data->status;
        $message = $res->message;
        $trans_id = $res->data->id;
        $device_fingerprint =  $res->data->device_fingerprint;
        $flw_ref =  $res->data->flw_ref;
        $tx_ref =  $res->data->tx_ref;

        $amount =  $res->data->amount;
        $app_fee =  $res->data->app_fee;
        $currency =  $res->data->currency;
        $auth_model =  $res->data->auth_model;
        $ip =  $res->data->ip;
        $created_at =  $res->data->created_at;
        $account_id =  $res->data->account_id;

        $payment_type =  $res->data->payment_type;
        $firstname = $res->data->meta->firstname;
        $lastname = $res->data->meta->lastname;
        $username = $res->data->meta->username;
        $email = $res->data->meta->email;
        $phone = $res->data->meta->phone;
        $price = $res->data->meta->price;
        $amount = $res->data->meta->amount;
        $org_name = $res->data->meta->org_name;
        $org_website = $res->data->meta->org_website;
        $admin_mobile_app = $res->data->meta->admin_mobile_app;
        $add_social_profile = $res->data->add_social_profile;

        $external_advert = $res->data->meta->external_advert;
        $amount_settled = $res->data->amount_settled;


        if ($res->status) {

            if ($amountPaid >= $amountToPay) {

                $date = date("Y-m-d"); // Format date as YYYY-MM-DD


                // $sqlCler = $mysqli->prepare("INSERT INTO organisations (org_name, org_website, registration_date) VALUES (?, ?, ?)");
                // $sqlCler->bind_param("sss", $org_name, $org_website, $date);
                // $sqlCler->execute();
                // if ($sqlCler->errno) {
                //     // Handle errort 
                //     echo 'Error not stored ';

                // } else {
                //     $sqlCler->close();
                //         echo 'data inserted';
                // }
                // echo $org_name;

                try {


                    $query = "INSERT INTO organisations(`org_name`, `org_website`, `charged_amount`) values('$org_name','$org_website','$charged_amount')";
                    $result = mysqli_query($conx, $query);

                    if (!$result) {
                        // mysqli_rollback($conx);

                        echo '<p style="font-size: 24px; font-weight: bold; color: blue;">Something went wrong. Try again!!!</p>';
                    } else {

                        $org_id = mysqli_insert_id($conx); // Retrieve the ID of the newly inserted row
                        // users
                        $query =  "UPDATE users SET firstname = '{$firstname}', lastname = '{$lastname}', phone = '{$phone}' , username = '{$username}' , organisation_id  = '{$org_id}' WHERE email = '{$email}'";
                        $result = mysqli_query($conx, $query);

                        if (!$result) {
                            // mysqli_rollback($conx);

                            echo '<p style="font-size: 24px; font-weight: bold; color: red;">Something went wrong. Try again!!!</p>';
                        } else {




                            $query = "INSERT INTO payments(`reference`, `amount`, `created_at`) 
                            values('$tx_ref','$amount','$date')";
                            $result = mysqli_query($conx, $query);

                            if (!$result) {
                                // mysqli_rollback($conx);

                                echo '<p style="font-size: 24px; font-weight: bold; color: blue;">Something went wrong. Try again!!!</p>';
                            }
                            echo '<p style="font-size: 24px; font-weight: bold; color: blue;">data inserted successfully</p>';
                        }
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();

                    echo '<p style="font-size: 24px; color: red;">' . $error . '</p>';
                }
            } else {
                echo 'Fraud transaction detected';
            }
        } else {
            echo 'Can not process payment';
        }
    }
}




// $sqlCler = $mysqli->prepare("INSERT INTO organisations (org_name, org_website, total_loan_amount, amount_received, balance_remaining, dateNormal, date_format, random_code, adminid, status, message, payment_id, reference, fullnames, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// $sqlCler->bind_param("iiiiisssisssssss", $uid3, $lid2, $totalloan, $amount, $balance, $date, $dateF, $ranCode, $adminidcl, $status, $message, $id, $reference, $fullName, $email, $phone);
// $sqlCler->execute();