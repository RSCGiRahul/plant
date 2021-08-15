$(document).ready(function(){ 
		$("#input-payment-address").one("keyup", function() { 
		  $("#googleidsearch").val(this.id);
		  initMap();
		});
	  });
	  
	 var map, places, infoWindow;
     var markers = [];
     var autocomplete;
     var countryRestrict = {'country': 'in'};
     var MARKER_PATH = 'https://developers.google.com/maps/documentation/javascript/images/marker_green';
     var hostnameRegexp = new RegExp('^https?://.+?/');
     var countries = {
        'us': {
          center: {lat: 37.1, lng: -95.7},
          zoom: 3
      },
  }; 

  function initMap() {
	  
 
	  

   var idsearch=document.getElementById('googleidsearch').value; 
   autocomplete = new google.maps.places.Autocomplete(
       (
          document.getElementById(''+idsearch+'')), {
           /* types: ['(cities)'],  */
          componentRestrictions: countryRestrict
      });  
	autocomplete.addListener('place_changed', fillInAddress); 	    
}

var componentForm = {  
	  administrative_area_level_1: 'long_name',   
	  postal_code: 'long_name' ,
	  locality: 'long_name'
	 /*  locality: 'long_name' */	  
	};

function fillInAddress() {
	
	
	var place = autocomplete.getPlace();
	var idsearch=document.getElementById('googleidsearch').value;
	
	/* console.log( JSON.stringify(place.address_components)+"\n");  */
	
	if(place.address_components !== undefined && place.address_components.length > 0 ) {
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0]; 
			var val = place.address_components[i][componentForm[addressType]];
			
			/* console.log(addressType+"--"+val+"\n");  */
			if(addressType=='administrative_area_level_1' && typeof val !== "undefined"){	
				
			}
			if(addressType=='postal_code' && typeof val !== "undefined"){	
				$("#input-payment-postcode").val(val);
			}
			if(addressType=='locality' && typeof val !== "undefined"){	
				$("#input-payment-city").val(val);
			}
			
			
		}
		
	}
	
}

