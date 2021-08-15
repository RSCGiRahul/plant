<label for="phone">Enter 4 digit code sent to your phone <br> <?php echo $phone; ?>  </label>
<div class="row col-opt-box">
<input type="hidden" name="phone" value="<?php echo $phone; ?>">
<input type="tel" id="otp-1" name="otp-1" class="form-control required col-sm-2" maxlength="1"  autocomplete="off" >
<input type="tel" id="otp-2" name="otp-2" class="form-control required col-sm-2" maxlength="1" autocomplete="off" >
<input type="tel" id="otp-3" name="otp-3" class="form-control required col-sm-2" maxlength="1" autocomplete="off" >
<input type="tel" id="otp-4" name="otp-4" class="form-control required col-sm-2" maxlength="1" autocomplete="off" >
</div> 
<button class="btn btn-lg btn-default btn-login-2 btn-block" type="submit">Next</button>	

<div class="row text-center" ><p id="timeLeftInSeconds" class="col-sm-12 text-center">5:00</p></div>

<a class="otp-resend otp-resend--enabled btn btn-small" style="display:none;" >Resend Code </a>