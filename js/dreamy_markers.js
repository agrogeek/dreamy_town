var map, marker;
function init(){
	var position = [38.0243962, -6.422818];
	var latLng = new google.maps.LatLng(position[0], position[1]);



	var mapOptions = {
	        zoom: 16, // initialize zoom level - the max value is 21
	        streetViewControl: false, // hide the yellow Street View pegman
	        scaleControl: false, // allow users to zoom the Google Map
	        mapTypeId: google.maps.MapTypeId.HYBRID,
	        center: latLng
	    };

	    map = new google.maps.Map(document.getElementById('dreamy_googlemaps'), mapOptions);


		// Check values loads
		iconMarker = iconMarker==''?'marker.png':iconMarker;
		latMarker = latMarker==''?position[0]:latMarker;
		lngMarker = lngMarker==''?position[1]:lngMarker;

	    marker = new google.maps.Marker({
	    	position: new google.maps.LatLng(latMarker, lngMarker),
	    	map: map,
	    	draggable: true,
	    	icon: urlMarkers + iconMarker
	    });


	    google.maps.event.addDomListener(marker, "dragend", function (e) {
		    //lat and lng is available in e object
		    var latLng = e.latLng;

		    jQuery('#dreamy_lat').val(latLng.lat());
		    jQuery('#dreamy_long').val(latLng.lng());
		});



	}

	jQuery( document ).ready(function() {
		jQuery('#dreamy_markers img').on('click', function(){
			var img = jQuery(this).data('file');
			jQuery('#dreamy_icon').val(img);
			marker.setIcon(urlMarkers + img)
		});
	});


	google.maps.event.addDomListener(window, 'load', init);
