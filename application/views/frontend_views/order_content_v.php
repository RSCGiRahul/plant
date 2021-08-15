<form action="<?php echo base_url(); ?>order/verify" method="POST" name="form1" style="display:none;" >
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data_roz['key']?>"
    data-amount="<?php echo $data_roz['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data_roz['name']?>"
    data-image="<?php echo $data_roz['image']?>"
    data-description="<?php echo $data_roz['description']?>"
    data-prefill.name="<?php echo $data_roz['prefill']['name']?>"
    data-prefill.email="<?php echo $data_roz['prefill']['email']?>"
    data-prefill.contact="<?php echo $data_roz['prefill']['contact']?>"
    data-notes.shopping_order_id="<?php echo $shopping_order_id; ?>"
    data-order_id="<?php echo $data_roz['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data_roz['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data_roz['display_currency']?>" <?php } ?>
  >
  </script>
  <input type="hidden" name="shopping_order_id" value="<?php echo $shopping_order_id; ?>">
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
$(document).ready(function(){ 
  setTimeout(function(){ $(".razorpay-payment-button").trigger('click');; }, 200);
});
</script>

<style>
::-moz-selection {
    background-color: #282d3b;
    color: #fff;
}
::selection {
    background-color: #282d3b;
    color: #fff;
}
p {
    margin-bottom: 1.5rem;
}
ul, ol {
    margin: 0 0 2.25rem;
    padding: 0;
    list-style: none;
}
b, strong {
    font-weight: 700;
}
em, i {
    font-style: italic;
}
hr {
    max-width: 1730px;
    margin: 5.5rem auto 5.2rem;
    border: 0;
    border-top: 1px solid #dfdfdf;
}
sub, sup {
    position: relative;
    font-size: 70%;
    line-height: 0;
    vertical-align: baseline;
}
sup {
    top: -.5em;
}
sub {
    bottom: -.25em;
}
img {
    display: block;
    max-width: 100%;
    height: auto;
}
@-webkit-keyframes rotating {
    from {
    -webkit-transform: rotate(0deg);
}
to {
    -webkit-transform: rotate(360deg);
}
}@keyframes rotating {
    from {
    transform: rotate(0deg);
}
to {
    transform: rotate(360deg);
}
}@-webkit-keyframes spin {
    0% {
    -webkit-transform: rotate(0deg);
}
100% {
    -webkit-transform: rotate(359deg);
}
}@keyframes spin {
    0% {
    transform: rotate(0deg);
}
100% {
    transform: rotate(359deg);
}
}@-webkit-keyframes bouncedelay {
    0%, 
  80%, 
  100% {
    -webkit-transform: scale(0);
}
40% {
    -webkit-transform: scale(1);
}
}@keyframes bouncedelay {
    0%, 
  80%, 
  100% {
    transform: scale(0);
}
40% {
    transform: scale(1);
}
}.loading-overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    transition: all .5s ease-in-out;
    background: #fff;
    opacity: 1;
    visibility: visible;
    z-index: 999999;
}
.loaded>.loading-overlay {
    opacity: 0;
    visibility: hidden;
}
.bounce-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 70px;
    margin: -9px 0 0 -35px;
    transition: all .2s;
    text-align: center;
    z-index: 10000;
}
.bounce-loader .bounce1, .bounce-loader .bounce2, .bounce-loader .bounce3 {
    display: inline-block;
    width: 18px;
    height: 18px;
    border-radius: 100%;
    background-color: #CCC;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.15);
    -webkit-animation: 1.4s ease-in-out 0s normal both infinite bouncedelay;
    animation: 1.4s ease-in-out 0s normal both infinite bouncedelay;
}
.bounce-loader .bounce1 {
    -webkit-animation-delay: -.32s;
    animation-delay: -.32s;
}
.bounce-loader .bounce2 {
    -webkit-animation-delay: -.16s;
    animation-delay: -.16s;
}

a {
    transition: all .3s;
    color: #282d3b;
    text-decoration: none;
}
a:hover, a:focus {
    color: #282d3b;
    text-decoration: underline;
}
.heading {
    margin-bottom: 4rem;
    font-size: 1.4rem;
}
.heading .title {
    margin-bottom: 1.6rem;
}
.heading p {
    letter-spacing: -.015em;
}
.heading p:last-child {
    margin-bottom: 0;
}
.title {
    text-transform: uppercase;
}

.lead {
    margin-bottom: 2rem;
    color: #21293c;
    font-size: 1.8rem;
    font-weight: 400;
    line-height: 1.5;
}
</style>

<div class="loading-overlay" style="opacity: 1;visibility: visible;" ><div class="bounce-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>