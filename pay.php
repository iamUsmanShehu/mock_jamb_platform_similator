<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Now</title>
</head>
<body>
    <h2>Paystack Payment</h2>
    <form id="paymentForm">
        <input type="hidden" id="email" value="<?php echo $_SESSION['email']; ?>">
        <input type="hidden" id="amount" value="5000"> <!-- Amount in kobo (5000 = 50 naira) -->
        <button type="button" onclick="payWithPaystack()"> Pay Now </button>
    </form>

    <script src="https://js.paystack.co/v1/inline.js"></script> 
    <script>
    function payWithPaystack(){
      var handler = PaystackPop.setup({
        key: 'pk_test_6890595463b6cd16c8b4320f1ed906db9864215d', 
        email: document.getElementById("email").value,
        amount: document.getElementById("amount").value * 100, // Amount in kobo
        currency: "NGN",
        onClose: function(){
          alert('Window closed.');
        },
        callback: function(response){
          // Payment was successful
          window.location = "payment_success.php?reference=" + response.reference;
        }
      });
      handler.openIframe();
    }
    </script>
</body>
</html>
