/*
Place this, or a subset of it, inside PayPal Payment description:

Cart Total: <span class="ppcc_cart_total"></span><br>
Shipping Total: <span class="ppcc_shipping_total"></span><br>
Handling <span class="ppcc_handling_percentage"></span>% plus <span class="ppcc_handling_amount"></span> fixed.<br>
Handling total: <span class="ppcc_handling_amount_total"></span><br>
Order Total Tax: <span class="ppcc_tax_total"></span><br>
Order Total inclusive Tax: <span class="ppcc_total_order_inc_tax"></span><br>
Conversion Rate: <span class="ppcc_cr"></span>
*/


jQuery(document).ready(function(){
	jQuery(document.body).on('change', 'input[name="payment_method"]', function() {
	   jQuery('body').trigger('update_checkout');
	});
});



jQuery(document).ajaxComplete(function(){  

	// This Values come initially by the session and are always renewed on http://.../?wc-ajax=update_order_review
	jQuery('.ppcc_cart_total').html(jQuery('.shadowppcc_cart_total').html());
	jQuery('.ppcc_tax_total').html(jQuery('.shadowppcc_tax_total').html());
	jQuery('.ppcc_shipping_total').html(jQuery('.shadowppcc_shipping_total').html());
	jQuery('.ppcc_total_order_inc_tax').html(jQuery('.shadowppcc_total_order_inc_tax').html());
	jQuery('.ppcc_cr').html(jQuery('.shadowppcc_cr').html());
	jQuery('.ppcc_handling_percentage').html(jQuery('.shadowppcc_handling_percentage').html());
	jQuery('.ppcc_handling_amount').html(jQuery('.shadowppcc_handling_amount').html());
	jQuery('.ppcc_handling_amount_total').html(jQuery('.shadowppcc_handling_amount_total').html());

	//remove the now obsolete shadowed div
	jQuery('#PPCC-checkout-payment').remove();


});