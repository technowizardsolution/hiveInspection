<?php
require_once('vendor/autoload.php');
require_once('stripe-php/init.php');

header('Content-Type: application/json; charset=utf-8');
$userData = json_decode(file_get_contents('php://input'),TRUE);
if(empty($userData['data']['token']) && !isset($userData['data']['token'])){
  $response['status'] = "0";
  $response['message'] = "Please pass the token";
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($response);
  exit();
}if(empty($userData['data']['amount']) && !isset($userData['data']['amount'])){
  $response['status'] = "0";
  $response['message'] = "Please pass the amount";
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($response);
  exit();
}if(empty($userData['data']['email']) && !isset($userData['data']['email'])){
  $response['status'] = "0";
  $response['message'] = "Please pass the email";
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($response);
  exit();
}else{
try {

    //\Stripe\Stripe::setApiKey("sk_test_wu8DykZ8nIjvHo10ZSMvzcIY");//krunal
    // \Stripe\Stripe::setApiKey('sk_test_51GrkVyF1BsfDL5BrRL5I9SHDBVIhiwrWxO09E2ZNWFAqgeeiRaCcRdjmTiRRK3wFaTtbKYZ7cQi2ELkialqpEzEz00RP5q5HJn');// ln account

   \Stripe\Stripe::setApiKey('sk_test_llv59BvYDUhk1nRaK8Qxrmnm');// smartfuture 

    $token  = $userData['data']['token'];
    if ($userData['data']['amount']) {
      $amount = $userData['data']['amount'] * 100;
    }else {
      $amount = 0;
    }
    $email  = $userData['data']['email'];

    $customerData=\Stripe\Customer::all();
    //check if customer exist
    $customer_id = '';
    foreach ($customerData['data'] as $customer) {
        if($customer['email'] == $email){
            $customer_id =  $customer['id'];
        }
    }
    //check if customer exist if not then create new one
    if($customer_id == ''){
        $customer = \Stripe\Customer::create(array(
                        // 'name' => 'Krunal',
                        // 'description' => 'Krunal description',
                         "email" => $email,
                         "description" => "SLC Payment",
                         "source" => $token, // obtained with Stripe.js
                         //"address" => ["city" => "Ahmedabad", "country" => "india", "line1" => "103", "line2" => "", "postal_code" => "386162", "state" => "Gujarat"]
                       ));
         $customer_id  = $customer['id'];
    }
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer_id,
        'amount' => $amount, // Amount in cents!
        'currency' => 'USD',
        //"capture" => false // for hold payment
    ));
    $response['message'] = "Thank you - your payment was received successfully.";

    $status = $charge['status'];
    $paymentID = $charge['id'];
    if ($charge['amount'] == 0) {
      $amount = 0;
    }else {
      $amount = $charge['amount']/100;
    }
    $response['status']='1';
    $response['data']['customer_id'] = $customer_id;
    $response['data']['paymentID'] = $paymentID;
    $response['data']['status'] = $status;
    $response['data']['amount'] = $amount;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
}catch(Stripe_CardError $e) {
    $response['status']='0';
    $response['message'] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
} catch (Stripe_InvalidRequestError $e) {
    // Invalid parameters were supplied to Stripe's API
    $response['status']='0';
    $response['message'] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
} catch (Stripe_AuthenticationError $e) {
    // Authentication with Stripe's API failed
    $response['status']='0';
    $response['message'] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
} catch (Stripe_ApiConnectionError $e) {
    // Network communication with Stripe failed
    $response['status']='0';
    $response['message'] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
} catch (Stripe_Error $e) {
    // Display a very generic error to the user, and maybe send
    // yourself an email
    $response['status']='0';
    $response['message'] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
} catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe
    $response['status']='2';
    $response['message'] = $e->getMessage();//Your card was declined.
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
}
}
