<?php echo "<pre>";
print_r($_REQUEST);
?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

  //Stripe.setPublishableKey('pk_test_rE7U1XjIXIsrElwnRU81IK5S');//krunal
  // Stripe.setPublishableKey('pk_test_51HMyBZBONzVh7yXtd0CwZpdpr3SQmMKuMMy5A3FmXrEm9Lfjh6Y3tjCLSGBPhVwdNVqdOnTxntGFiqmCSqDGjqCE00jqDjRjoK');// ln account

  Stripe.setPublishableKey('pk_test_UosvxkUnkyj6HM84jYIevy8U');// smartfuture


</script>

<script type="text/javascript">
jQuery(function($) {
	  $('#payment-form').submit(function(event) {
	    var $form = $(this);

	    // Disable the submit button to prevent repeated clicks
	    $form.find('button').prop('disabled', true);

	    Stripe.card.createToken($form, stripeResponseHandler);

	    // Prevent the form from submitting with the default action
	    return false;
	  });
	});

function stripeResponseHandler(status, response) {
	  var $form = $('#payment-form');

	  if (response.error) {
	    // Show the errors on the form
	    $form.find('.payment-errors').text(response.error.message);
	    $form.find('button').prop('disabled', false);
	  } else {
	    // response contains id and card, which contains additional card details
	    var token = response.id;
	    // Insert the token into the form so it gets submitted to the server
	    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
	    // and submit
	    $form.get(0).submit();
	  }
	};
</script>
<form action="" method="POST" id="payment-form">
  <span class="payment-errors"></span>

  <div class="form-row">
    <label>
      <span>Card Number</span>
      <input type="text" size="20" data-stripe="number" value="4242424242424242"/>
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>CVC</span>
      <input type="text" size="4" data-stripe="cvc"  value="123"/>
    </label>
  </div>

  <div class="form-row">
    <label>
      <span>Expiration (MM/YYYY)</span>
      <input type="text" size="2" data-stripe="exp-month"  value="07"/>
    </label>
    <span> / </span>
    <input type="text" size="4" data-stripe="exp-year"  value="2022"/>
  </div>

  <button type="submit">Submit Payment</button>
</form>
