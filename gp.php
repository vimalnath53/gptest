<!DOCTYPE html>

<?php
// echo 'dsa';exit;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("vendor/braintree/braintree_php/lib/Braintree.php");
require("vendor/braintree/braintree_php/lib/autoload.php");

$gateway = new Braintree\Gateway([
  'environment' => 'sandbox',
  'merchantId' => 'zynjg7c9rd5c95z2',
  'publicKey' => 'rqm8g5vrk2hs8zr8',
  'privateKey' => '266278dcd1e87f27558a3d266df0b727'
]);

$clientToken = $gateway->clientToken()->generate();
?>


<!DOCTYPE html>


<div id="container"></div>
<button id="google-pay-button"/>Pay with Google
 <script src="https://pay.google.com/gp/p/js/pay.js"></script>
<script src="https://js.braintreegateway.com/web/3.84.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.84.0/js/google-payment.min.js"></script>
<script>

var clientToken = "<?php echo $clientToken; ?>";

var paymentButton = document.querySelector('#google-pay-button');
var paymentsClient = new google.payments.api.PaymentsClient({
  environment: 'TEST' // or 'PRODUCTION'
});

braintree.client.create({
  authorization: clientToken
}).then(function (clientInstance) {
  return braintree.googlePayment.create({
    client: clientInstance,
     googlePayVersion: 2,
     //googleMerchantId: 'your-merchant-id-from-google'
  });
}).then(function (googlePaymentInstance) {
  paymentButton.addEventListener('click', function (event) {
    var paymentDataRequest;

    event.preventDefault();

    paymentDataRequest = googlePaymentInstance.createPaymentDataRequest({
      transactionInfo: {
        currencyCode: 'USD',
        totalPriceStatus: 'FINAL',
        totalPrice: '100.00'
      }
    });

    paymentsClient.loadPaymentData(paymentDataRequest).then(function (paymentData) {
      return googlePaymentInstance.parseResponse(paymentData);
    }).then(function (result) {
      // send result.nonce to your server
      console.log(result);
     // window.location.href = 'checkout_discount.php?nounce='+result.nonce;
    }).catch(function (err) {
      // handle err
    });
  });
});

      
</script>
  </body>
</html>