<?php
require_once('vendor/autoload.php');
require_once('stripe-php/init.php');
try {
    // \Stripe\Stripe::setApiKey("sk_test_wu8DykZ8nIjvHo10ZSMvzcIY");//krunal
    \Stripe\Stripe::setApiKey("sk_test_llv59BvYDUhk1nRaK8Qxrmnm");//test
    // \Stripe\Stripe::setApiKey('sk_live_sSCQeUPEgZEJZq1FWssPd5Nx');//live

    $charge = \Stripe\Charge::retrieve($orderNumber);
    //$charge = \Stripe\Charge::retrieve("ch_17aNszBPGoZhAJFqiO0luZbT");
    $charge->capture();

    /*$status = $charge['status'];
    $paymentID = $charge['id'];
    $amount = $charge['amount']/100;

    $response['status']='1';
    $response['message'] = "Thank you - your payment was received successfully.";
    $response['data']['paymentID'] = $paymentID;
    $response['data']['status'] = "success";
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
