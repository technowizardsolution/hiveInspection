<?php
require_once('vendor/autoload.php');
require_once('stripe-php/init.php');
try {
    $orderNumber = $orderNumber;
    $orderamount = $orderamount;

    // \Stripe\Stripe::setApiKey("sk_test_wu8DykZ8nIjvHo10ZSMvzcIY");//krunal
    \Stripe\Stripe::setApiKey("sk_test_51GrkVyF1BsfDL5BrRL5I9SHDBVIhiwrWxO09E2ZNWFAqgeeiRaCcRdjmTiRRK3wFaTtbKYZ7cQi2ELkialqpEzEz00RP5q5HJn");//text
    // \Stripe\Stripe::setApiKey('sk_live_sSCQeUPEgZEJZq1FWssPd5Nx');//live
    $refund = \Stripe\Refund::create(array(
          "charge" => $orderNumber,
          'amount' => $orderamount // Amount in cents!
      ));

    /*$status = $refund['status'];
    $paymentID = $refund['id'];
    $amount = $refund['amount']/100;

    $response['status']='1';
    $response['message'] = "Thank you - your payment was refund successfully.";
    $response['data']['paymentID'] = $paymentID;
    $response['data']['status'] = "refund";
    $response['data']['amount'] = $amount;
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();*/
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
    $response['status']='0';
    $response['message'] = $e->getMessage();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
}
