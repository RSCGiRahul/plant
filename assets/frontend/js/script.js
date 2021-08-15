$(document).ready(function () {
	
	$(document).on('click', '.btn-add-shipping', function () { 
			var LoginFrm = $("#shippingForm").serialize();
			var url = "/user/Shipping/ajax_shipping_address";
			$('.btn-add-shipping').html('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response); 
					if(data['success']=='true'){  
						  location.reload(); 
					}else{ 
						$('.btn-add-shipping').html('Next');
						$(".shippingMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".shippingMsg").html("");  }, 8000); 
					} 					
					  
					  
					
				}
			});
			
		});
		
	
	 /*btn-new-place*/
		$(document).on('click', '.btn-new-place', function () { 
			
			$("#newaddress").show();
			
		});
	  /*btn-new-place*/
	
	
	/*checkout*/
		$(document).on('click', '.btn-deliver-here', function () { 
			
			var shipping_id = $(this).attr('data-shipping_id');
			var url = "/checkout/ajax_checkout_select_shipping";
			$(this).val('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					shipping_id: shipping_id,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response); 
					if(data['success']=='true'){  
						 $('#checkoutForm').html(data['content']); 
						 $(".loginMsg").html("");
						 
						 $("#checkoutForm").attr('action','/order');
						 
					}else{ 
						$('.btn-deliver-here').val('Deliver here');
						
						if(data['outlet_error']=='true'){  
						
							$(".loginMsg_"+data['shipping_id']+"").html('<div class="error">'+data['message']+'</div>'); 
							setTimeout(function(){ $(".loginMsg_"+data['shipping_id']+"").html("");  }, 8000); 
							
						}else{
							$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
							setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
						}
						
						
					} 					
					  
					   
					
				}
			});
			
		});
		
		
		
		$(document).on('click', '.btn-checkout-step-3', function () { 
			var LoginFrm = $("#checkoutForm").serialize();
			var url = "/checkout/ajax_checkout_shipping_address";
			$('.btn-checkout-step-3').html('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response); 
					if(data['success']=='true'){  
						 $('#checkoutForm').html(data['content']); 
						 $(".loginMsg").html("");
						 
						 $("#checkoutForm").attr('action','/order');
					}else{ 
						$('.btn-checkout-step-3').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					} 					
					  
					  
					
				}
			});
			
		});
	
	
		$(document).on('click', '.btn-checkout-login', function () { 
			var LoginFrm = $("#checkoutForm").serialize();
			var url = "/user/Login/ajax_checkout_login";
			$('.btn-checkout-login').html('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){  
						 $('.loginStep').html(data['content']); 
						 $(".loginMsg").html("");
						 
						  timerStart();
						 
					}else{ 
						$('.btn-checkout-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
				}
			});
	});
	
	
	
	
	
	$(document).on('click', '.btn-checkout-login-2', function () { 
			var LoginFrm = $("#checkoutForm").serialize();
			var url = "/user/Login/ajax_checkout_login_verify";
			 
			$('.btn-login').html('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){  
						 
						 $("#checkoutForm").html(data['content']); 
						 
					}else{ 
						$("#otp-checkout-1,#otp-checkout-2,#otp-checkout-3,#otp-checkout-4").val("");
					    $(".otp-checkout-resend").show();
						$('.btn-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
				}
			});
	});	
		
	$(document).on('keyup', '#otp-checkout-1', function () { 
		var otp = $("#otp-checkout-1").val();
		if(otp!=""){ $("#otp-checkout-2").focus();  }
	});
	$(document).on('keyup', '#otp-checkout-2', function () { 
		var otp = $("#otp-checkout-2").val();
		if(otp!=""){ $("#otp-checkout-3").focus();  }
	});
	$(document).on('keyup', '#otp-checkout-3', function () { 
		var otp = $("#otp-checkout-3").val();
		if(otp!=""){ $("#otp-checkout-4").focus();  }
	});	
		
		
	$(document).on('click', '.otp-checkout-resend', function () { 
				
			var LoginFrm = $("#checkoutForm").serialize();
			var url = "/user/Login/ajax_checkout_resend_otp"; 
			
			$('.otp-checkout-resend').html('Sending..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){  
						 $('.loginStep').html(data['content']); 
						 $(".loginMsg").html(""); 
						 
						 timerStart();
						 
					}else{ 
						$('.btn-checkout-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					$('.otp-checkout-resend').html('Resend Code');
					
					
				}
					
		});
	});	
		
	/*checkout*/
	
	
	/*login popup*/
	
	
	$(document).on('keyup', '#otp-1', function () { 
		var otp = $("#otp-1").val();
		if(otp!=""){ $("#otp-2").focus();  }
	});
	$(document).on('keyup', '#otp-2', function () { 
		var otp = $("#otp-2").val();
		if(otp!=""){ $("#otp-3").focus();  }
	});
	$(document).on('keyup', '#otp-3', function () { 
		var otp = $("#otp-3").val();
		if(otp!=""){ $("#otp-4").focus();  }
	});
	
	
	
	$(document).on('click', '.btn-login', function () { 
			var LoginFrm = $("#loginForm").serialize();
			var url = "/user/Login/ajax_popup_login";
			 
			$('.btn-login').html('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){  
						 $('#loginForm').html(data['content']); 
						 $(".loginMsg").html("");
						 
						 timerStart();
						 
					}else{ 
						$('.btn-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
				}
			});
	});
		
	function otpResetTime(){  
		$('#timeLeftInSeconds').html("");
		$("#otp-1,#otp-2,#otp-3,#otp-4").val("");

		$("#otp-checkout-1,#otp-checkout-2,#otp-checkout-3,#otp-checkout-4").val("");
		$(".otp-checkout-resend").show();
		
		$(".otp-resend").show();
		$('.btn-login').html('Next');
		$(".loginMsg").html('<div class="error">Error: Session Timeout</div>'); 
		setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
		
	}	
		
		
	function timerStart(){  
		/**/
		var timer2 = "5:49";
		 $('#timeLeftInSeconds').html(timer2);
		 
		var interval = setInterval(function() { 

		  var timer = timer2.split(':'); 
		  var minutes = parseInt(timer[0], 10);
		  var seconds = parseInt(timer[1], 10);
		  
		  
		  
		  --seconds;
		  minutes = (seconds < 0) ? --minutes : minutes;
		  if (minutes < 0) clearInterval(interval);
		  seconds = (seconds < 0) ? 59 : seconds;
		  seconds = (seconds < 10) ? '0' + seconds : seconds;
		  
		  if(minutes<0){
		  $('#timeLeftInSeconds').html("");		
		  }else{ 
		  $('#timeLeftInSeconds').html(minutes + ':' + seconds);
		  }
		  
		  timer2 = minutes + ':' + seconds;
		  
		  
		  if(minutes==0 && seconds==0){
			otpResetTime();	
		  }
		  
		  
		}, 1000);
		/**/
		
		
	}
	
		
	$(document).on('click', '.btn-login-2', function () { 
			var LoginFrm = $("#loginForm").serialize();
			var url = "/user/Login/ajax_login_verify";
			 
			$('.btn-login').html('Wait..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){  
						 location.reload(); 
					}else{ 
						
						
						$("#otp-1,#otp-2,#otp-3,#otp-4").val("");
					    $(".otp-resend").show();
						$('.btn-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
				}
			});
	});	
	
	
	$(document).on('click', '.otp-resend', function () { 
				
			var LoginFrm = $("#loginForm").serialize();
			var url = "/user/Login/ajax_resend_otp"; 
			$('.otp-resend').html('Sending..');
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					LoginFrm: LoginFrm,
				},
				dataType: "text",
				success: function (script_response)
				{   
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){  
						 $('#loginForm').html(data['content']); 
						 $(".loginMsg").html("");
						 timerStart();
						 
					}else{ 
						$('.btn-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}
					$('.otp-resend').html('Resend Code');					
					
				}
					
		});
	});
	/*login popup*/
	
	
	
	$(document).on('click', '.btn-add-cart', function () { 
			var productFrm = $(this).closest("form").serialize();
			var url = "/products/add_to_cart";
			
			var hasClass = 0;
			if($(this).hasClass('add-cart') ){
				$(this).html('<span>Wait..</span>');
				hasClass=1;
			}else{
				$(this).html('<i class="icon-bag"></i>Wait..');
			}				
			
			
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					productFrm: productFrm,
				},
				dataType: "text",
				success: function (script_response)
				{  
					var data = $.parseJSON(script_response);  
					if(hasClass=='1'){
						$(".add-cart.btn-add-cart").html('<span>Add to Basket</span>');
					}else{
						$(".btn-add-cart").html('<i class="icon-bag"></i>ADD');
						$(".add-cart.btn-add-cart").html('<span>Add to Basket</span>');
					}
					
					if(data['success']=='true'){ 
						
						/* $("#addCartModal .modal-body").html(""+data['message']+""); 
						$("#addCartModal").modal();  */
						$('#response_popup_msg').remove(); 
						$('header').after(""+data['message']+"");
						$("#car-dropdown").html(data['cart_popup']);
						
						$('html, body').animate({
						scrollTop: $("body").offset().top
						}, 2000);
					 
						
					}else{
						
						$("#modelMessage .modal-msg").html(data['message']); 
						$("#modelMessage").modal(); 
					}  
					
				}
			});
	});
	
	$(document).on('click', '.btn-remove-cart', function () {
			
			var cart_id = $(this).attr('cart_id');
			var url = "/products/remove_to_cart";
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					cart_id: cart_id,
				},
				dataType: "text",
				success: function (script_response)
				{  
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){ 
						$("#car-dropdown").html(data['cart_popup']);
					}  
				}
			});
	});
	
	
	$(document).on('click', '.btn-refresh-cart-2', function () {
			
			var cart_id = $(this).attr('cart_id');
			var quantity = $("#input-quantity-"+cart_id+"").val(); 
			var url = "/products/refresh_to_cart";
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					cart_id: cart_id,
					quantity: quantity,
				},
				dataType: "text",
				success: function (script_response)
				{  
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){ 
						location.reload(); 
					}  
				}
			});
	});
	
	$(document).on('click', '.btn-remove-cart-2', function () {
			
			var cart_id = $(this).attr('cart_id');
			var url = "/products/remove_to_cart";
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					cart_id: cart_id,
				},
				dataType: "text",
				success: function (script_response)
				{  
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){ 
						location.reload(); 
					}  
				}
			});
	});
	
	
	$(document).on('click', '.btn-quantity-minus', function () {
			
			var cart_id = $(this).attr('cart_id');
			var url = "/products/minus_to_cart";
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					cart_id: cart_id,
				},
				dataType: "text",
				success: function (script_response)
				{  
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){ 
						$("#car-dropdown").html(data['cart_popup']);
					}  
				}
			});
	});
	
	$(document).on('click', '.btn-quantity-add', function () {
			
			var cart_id = $(this).attr('cart_id');
			var url = "/products/adding_to_cart";
			
			$.ajax({
				url: url,
				method: "POST",
				data: {
					cart_id: cart_id,
				},
				dataType: "text",
				success: function (script_response)
				{  
					var data = $.parseJSON(script_response);  
					if(data['success']=='true'){ 
						$("#car-dropdown").html(data['cart_popup']);
					}  
				}
			});
	});
	
	
	$(document).on('click', '.btn-select-size', function () {
		  
		 var json_data = $(this).attr('json_data');
		  myJSON = $.parseJSON(json_data);  
		  
		  var price_id = myJSON.price_id;
		  
		   console.log(myJSON);
		   
		   
			var price_box = '';
			var discount = parseFloat(myJSON.discount);
			var discount_price = parseFloat(myJSON.discount_price);
			var price = parseFloat(myJSON.price);
			 
			
			if((discount)>0){
			
			 price_box += '<span class="old-price">MRP: <i class="fas fa-rupee-sign"></i>&nbsp;'+price+'</span>';
			 
			 price_box += ' <span class="product-price">Price: <i class="fas fa-rupee-sign"></i>&nbsp;'+discount_price+'</span>';
										
			 price_box += ' <span class="discount-price">You Save: '+discount+'% </span>';
			
			}else{
				
				price_box += '<span class="product-price">Price: <i class="fas fa-rupee-sign"></i>&nbsp;'+price+'</span>'; 
			}
		
			$(".price-box").html(price_box);
		 
		 $("input[name='price_option']").val(price_id);	 
		 $(".btn-select-size").removeClass("active");
		 $(this).addClass("active");
		 
		 
		 
	});
	
	
	/*************************** filter ***********************************/
	$(document).on('change',"#orderby", function () { 
			
		 $('#btn-show-more').attr('currentpage',2);
		 filter_product();
	});
	 
	$(document).on('click', '#filter-search input', function () { 	
		 
		 
		  filter_product();
		
	
	}); 
	
	
	
	function filter_product(){
		
		var category_id = $("input[name='category_id']").val();
		var orderby = $("#orderby").val();	
		
		var brand_search = [];
		$("input:checkbox[name='brand_search']:checked").each(function() {
		  var vals = $(this).val();
		  brand_search.push(vals);
		});
		
		var price_search = [];
		$("input:checkbox[name='price_search']:checked").each(function() {
		  var vals = $(this).val();
		  price_search.push(vals);
		});
		
		var discount_search = [];
		$("input:checkbox[name='discount_search']:checked").each(function() {
		  var vals = $(this).val();
		  discount_search.push(vals);
		});
		
		
		var url = "/products/filter_product";
		
		
		var t = $("#t").val();	
		var s = $("#s").val();	
		
		 
		$.ajax({
			url: url,
			method: "POST",
			data: {
				category_id: category_id,
				brand_search: brand_search,
				price_search: price_search,
				discount_search: discount_search,
				orderby: orderby, 
				t: t,
				s: s,
				currentpage: 1,
			},
			dataType: "text",
			success: function (script_response)
			{ 
				 var data = $.parseJSON(script_response); 
				 if(data['success']=='true'){  
				    $("#btn-show-more").attr('currentpage',2);
					$("#product_list").html( data['main_content'] ); 
					if(data['currentpage']==0){
						$("#btn-show-more").hide();
					}else{
						$("#btn-show-more").show();
					}
				 }   
				
			}
		});
		
	}
	
	
	$(document).on('click', '#btn-show-more', function () { 
		
		var currentpage = $(this).attr('currentpage');
		if (currentpage === undefined || currentpage === null) {
		   return false;
		 }  
		
		var category_id = $("input[name='category_id']").val();
		var orderby = $("#orderby").val();	
		
		var t = $("#t").val();	
		var s = $("#s").val();	
		
		var brand_search = [];
		$("input:checkbox[name='brand_search']:checked").each(function() {
		  var vals = $(this).val();
		  brand_search.push(vals);
		});
		
		var price_search = [];
		$("input:checkbox[name='price_search']:checked").each(function() {
		  var vals = $(this).val();
		  price_search.push(vals);
		});
		
		var discount_search = [];
		$("input:checkbox[name='discount_search']:checked").each(function() {
		  var vals = $(this).val();
		  discount_search.push(vals);
		});
		
		var url = "/products/filter_product"; 
		
		$.ajax({
			url: url,
			method: "POST",
			data: {
				category_id: category_id,
				brand_search: brand_search,
				price_search: price_search,
				discount_search: discount_search,
				orderby: orderby,
				t: t,
				s: s,
				currentpage: currentpage,
			},
			dataType: "text",
			success: function (script_response)
			{ 
				 var data = $.parseJSON(script_response); 
				 if(data['success']=='true'){  
				    
					$("#product_list").append( data['main_content'] ); 
					$("#btn-show-more").attr('currentpage',data['currentpage'])
					if(data['currentpage']==0){
						$("#btn-show-more").hide();
					}
				 }   
				
			}
		});
	
	}); 
	
	/*************************** filter ***********************************/
	
	
	$(document).on('click', '.showlogin', function () { 
		$(".form-login").toggle('slide');
	});
	
});
 
 
 
 
 /***************** map ***************/
 
  
 /***************** map ***************/
 
 
 /************* newslatter ****************/
 
 $(document).on('click', '.btn-newslatter_email', function () { 
			var newslatter_email = $("#newslatter_email").val();  
			var url = "/Ajax/add_subscriber";
			if(newslatter_email!=""){
				
				$('.btn-newslatter_email').val('Wait..');
				
				$.ajax({
					url: url,
					method: "POST",
					data: {
						email_address: newslatter_email,
					},
					dataType: "text",
					success: function (php_script_response)
					{  
						$('.btn-newslatter_email').val('Subscribe');
						var data = $.parseJSON(php_script_response); 
						if(data[1]==1){
						$(".sms-newslatter_email").html("<div class='msg alert  alert-success'>"+data['msg']+"</div>");  
						}else{
						$(".sms-newslatter_email").html("<div class='msg alert  alert-danger'>"+data['msg']+"</div>");
						} 
					}
				});
			
			}else{
				$(".sms-newslatter_email").html("<div class='msg alert  alert-danger'>Enter email address.</div>");
			}
			
			
			
		});
		
 /************* newslatter ****************/		
 
 
 /*********** filter *****************/
 
  $(document).on('keyup', '#filter_Brand', function () { 
  
  var input, filter, ul, li, a, i;
  input = document.getElementById("filter_Brand");
  filter = input.value.toUpperCase();
  ul = document.getElementById("filter_Brand_ul");
  li = ul.getElementsByTagName("li");
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("label")[0];
	
    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
  
});

 /*********** filter *****************/ 