<form action="<?php echo $action; ?>" method="POST" id="nickpapoutsis-alphabank-form" accept-charset="UTF-8">
<input type="hidden" name="version"                value="<?php echo $version; ?>"/>
<input type="hidden" name="mid"                    value="<?php echo $mid; ?>" />
<input type="hidden" name="lang"                   value="<?php echo $lang; ?>" />
<input type="hidden" name="orderid"                value="<?php echo $orderid; ?>"     id="orderid" />
<input type="hidden" name="orderDesc"              value="<?php echo $orderDesc; ?>" />
<input type="hidden" name="orderAmount"            value="<?php echo $orderAmount; ?>" />
<input type="hidden" name="currency"               value="<?php echo $currency; ?>" />
<input type="hidden" name="payerEmail"             value="<?php echo $payerEmail; ?>" />
<input type="hidden" name="payerPhone"             value="<?php echo $payerPhone; ?>" />
<input type="hidden" name="billCountry"            value="<?php echo $billCountry; ?>" />
<input type="hidden" name="billState"              value="<?php echo $billState; ?>" />
<input type="hidden" name="billZip"                value="<?php echo $billZip; ?>" />
<input type="hidden" name="billCity"               value="<?php echo $billCity; ?>" />
<input type="hidden" name="billAddress"            value="<?php echo $billAddress; ?>" />
<input type="hidden" name="shipCountry"            value="<?php echo $shipCountry; ?>" />
<input type="hidden" name="shipState"              value="<?php echo $shipState; ?>" />
<input type="hidden" name="shipZip"                value="<?php echo $shipZip; ?>" />
<input type="hidden" name="shipCity"               value="<?php echo $shipCity; ?>" />
<input type="hidden" name="shipAddress"            value="<?php echo $shipAddress; ?>" />
<input type="hidden" name="payMethod"              value="<?php echo $payMethod; ?>"     id="payMethod" />
<input type="hidden" name="trType"                 value="<?php echo $trType; ?>" />
<input type="hidden" name="extInstallmentoffset"   value="<?php echo $extInstallmentoffset; ?>"     id="extInstallmentoffset" />
<input type="hidden" name="extInstallmentperiod"   value="<?php echo $extInstallmentperiod; ?>"     id="extInstallmentperiod" />
<input type="hidden" name="extRecurringfrequency"  value="<?php echo $extRecurringfrequency; ?>" />
<input type="hidden" name="extRecurringenddate"    value="<?php echo $extRecurringenddate; ?>" />
<input type="hidden" name="cssUrl"                 value="<?php echo $cssUrl; ?>" />
<input type="hidden" name="confirmUrl"             value="<?php echo $confirmUrl; ?>" />
<input type="hidden" name="cancelUrl"              value="<?php echo $cancelUrl; ?>" />
<input type="hidden" name="var1"                   value="<?php echo $var1; ?>" />
<input type="hidden" name="var2"                   value="<?php echo $var2; ?>" />
<input type="hidden" name="var3"                   value="<?php echo $var3; ?>" />
<input type="hidden" name="var4"                   value="<?php echo $var4; ?>" />
<input type="hidden" name="var5"                   value="<?php echo $var5; ?>" />
<input type="hidden" name="digest"                 value="<?php echo $digest; ?>"    id="digest" />


<div>
<?php if ($masterpass_status) { ?>
<p><?php echo $masterpass_header; ?>
<span class="form-group">

<select name="card_masterpass_selection" id="card_masterpass_selection" >
<option value=""><?php echo $card_chosen; ?></option>
<option value="auto:MasterPass"><?php echo $masterpass_chosen; ?></option>
</select>
</span></p>
<br>
<?php } ?>


<?php if (isset($valid_installments)) { ?>
<span class="form-group">
<label for="user_selected_installments" style="font-weight: bold;"><?php echo $num_of_installments; ?> &nbsp;</label>

<select name="no_of_installments" id="user_selected_installments" >
<option value="0"><?php echo $zero_installments; ?></option>

<?php foreach ($valid_installments as $valid_installment) { ?>
<option value="<?php echo $valid_installment; ?>"><?php echo $valid_installment; ?> <?php echo $installments; ?></option>
<?php } ?>

</select>
</span>
<?php } ?>
</div>


</form>






<script type="text/javascript">
$('body').on('change', '#user_selected_installments, #card_masterpass_selection', function() {
$.ajax({url: 'index.php?route=extension/payment/nickpapoutsis_alphabank/index',
type: 'post',
data: {'user_selected_installments': $('#user_selected_installments').val(), 'card_masterpass_selection' : $('#card_masterpass_selection').val()},
dataType: 'json',
success: function(json__updated_values) {
$('#orderid').val(json__updated_values['orderid']);
$('#payMethod').val(json__updated_values['payMethod']);
$('#extInstallmentoffset').val(json__updated_values['extInstallmentoffset']);
$('#extInstallmentperiod').val(json__updated_values['extInstallmentperiod']);
$('#digest').val(json__updated_values['digest']);
}
});

});


$('#button-confirm').on('click', function() {
$('#nickpapoutsis-alphabank-form').submit();
});

</script>


<div class="buttons">
<div class="pull-right">
<input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
</div>
</div>
