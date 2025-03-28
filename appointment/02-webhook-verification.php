<?php
include('config.php');
$con = dbconnect();

/*
 * Example 2 - How to verify Mollie API Payments in a webhook.
 *
 * See: https://docs.mollie.com/guides/webhooks
 */

try {
    /*
     * Initialize the Mollie API library with your API key.
     *
     * See: https://www.mollie.com/dashboard/settings/profiles
     */
    require "examples/initialize.php";

    /*
     * Retrieve the payment's current state.
     */
    $payment = $mollie->payments->get($_POST["id"]);
    $orderId = $payment->metadata->order_id;

    /*
     * Update the order in the database.
     */
    database_write($orderId, $payment->status);

    if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
        /*
         * The payment is paid and isn't refunded or charged back.
         * At this point you'd probably want to start the process of delivering the product to the customer.
         */
    } elseif ($payment->isOpen()) {
        /*
         * The payment is open.
         */
    } elseif ($payment->isPending()) {
        /*
         * The payment is pending.
         */
    } elseif ($payment->isFailed()) {
        /*
         * The payment has failed.
         */
    } elseif ($payment->isExpired()) {
        /*
         * The payment is expired.
         */
    } elseif ($payment->isCanceled()) {
        /*
         * The payment has been canceled.
         */
    } elseif ($payment->hasRefunds()) {
        /*
         * The payment has been (partially) refunded.
         * The status of the payment is still "paid"
         */
    } elseif ($payment->hasChargebacks()) {
        /*
         * The payment has been (partially) charged back.
         * The status of the payment is still "paid"
         */
    }
} catch (\Mollie\Api\Exceptions\ApiException $e) {
    echo "API call failed: " . htmlspecialchars($e->getMessage());
}

/*
 * NOTE: This example uses a text file as a database. Please use a real database like MySQL in production code.
 */
function database_write($orderId, $status){
    global $con;
    $orderId = intval($orderId);
    $sql_updt = "UPDATE appointment SET payment_status='".$status."' WHERE order_id='".$orderId."'";
    mysqli_query($con, $sql_updt);
}
