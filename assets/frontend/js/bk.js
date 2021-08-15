$(document).ready(function () {
	
	/*checkout*/
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
					}else{ 
						$('.btn-checkout-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
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
					}else{ 
						$('.btn-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
				}
			});
	});
		
		
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
					}else{ 
						$('.btn-login').html('Next');
						$(".loginMsg").html('<div class="error">'+data['message']+'</div>'); 
						setTimeout(function(){ $(".loginMsg").html("");  }, 8000); 
					}  
					
				}
					
		});
	});
	/*login popup*/
	
	
	
	$(document).on('click', '.btn-add-cart', function () { 
			var productFrm = $(this).closest("form").serialize();
			var url = "/products/add_to_cart";
			
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
	 
	$(document).on('click', '#filter-search input', function () { 	
		 
		
		var category_id = $("input[name='category_id']").val();
		var orderby = $("input[name='orderby']").val();	
		
		var brand_search = [];
		$("input:checkbox[name='brand_search']:checked").each(function() {
		  var vals = $(this).val();
		  brand_search.push(vals);
		});
		
		var url = "/products/filter_product";
		
		
		$.ajax({
			url: url,
			method: "POST",
			data: {
				category_id: category_id,
				brand_search: brand_search,
				orderby: orderby, 
				currentpage: 1,
			},
			dataType: "text",
			success: function (script_response)
			{ 
				 var data = $.parseJSON(script_response); 
				 if(data['success']=='true'){  
				    $("#btn-show-more").attr('currentpage',1);
					$("#product_list").html( data['main_content'] ); 
					if(data['currentpage']==0){
						$("#btn-show-more").hide();
					}else{
						$("#btn-show-more").show();
					}
				 }   
				
			}
		});
	
	}); 
	
	
	$(document).on('click', '#btn-show-more', function () { 
		
		var currentpage = $(this).attr('currentpage');
		if (currentpage === undefined || currentpage === null) {
		   return false;
		 }  
		
		var category_id = $("input[name='category_id']").val();
		var orderby = $("input[name='orderby']").val();	
		
		var brand_search = [];
		$("input:checkbox[name='brand_search']:checked").each(function() {
		  var vals = $(this).val();
		  brand_search.push(vals);
		});
		
		var url = "/products/filter_product";
		
		
		$.ajax({
			url: url,
			method: "POST",
			data: {
				category_id: category_id,
				brand_search: brand_search,
				orderby: orderby,
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
 