<label for="phone">Enter 4 digit code sent to your phone <br> <?php echo $phone; ?>  </label>
<div class="row col-opt-box">
<input type="hidden" name="phone" value="<?php echo $phone; ?>">
<input type="tel" id="otp-checkout-1" name="otp-checkout-1" class="form-control required col-sm-2" maxlength="1"  autocomplete="off" >
<input type="tel" id="otp-checkout-2" name="otp-checkout-2" class="form-control required col-sm-2" maxlength="1" autocomplete="off" >
<input type="tel" id="otp-checkout-3" name="otp-checkout-3" class="form-control required col-sm-2" maxlength="1" autocomplete="off" >
<input type="tel" id="otp-checkout-4" name="otp-checkout-4" class="form-control required col-sm-2" maxlength="1" autocomplete="off" >
</div> 
<button class="btn btn-lg btn-default btn-checkout-login-2 pull-right" type="submit">Next</button>	

<a class="otp-checkout-resend otp-resend--enabled btn btn-small" style="display:none;" >Resend Code </a>

<div class="row text-center" ><p id="timeLeftInSeconds" class="col-sm-12 text-center">5:00</p></div>