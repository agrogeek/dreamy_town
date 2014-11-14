/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */
 var body,
 _window,
 my_domain_selector,
 position,
 zoom,
 latLng,
 map, markers;
 jQuery( document ).ready(function() {
	// Init vars
	body    = jQuery( 'body' );
	_window = jQuery( window );
	my_domain_selector = "a[href*='http://esarroyo.es']:not(a[href$='.jpg'])";
	position = [body.data('lat'), body.data('lng')];
	zoom = body.data('zoom');
	latLng = new google.maps.LatLng(position[0], position[1]);
	markers = {};

	/* History with AJAX: check for support before we move ahead */
	if (typeof history.pushState !== "undefined") {
		var historyCount = 0;

		jQuery(my_domain_selector).live('click',function(event){
			event.preventDefault();
			var link = jQuery(this);
			dreamyHistory(link.attr('href'), link.text(), link.data('type_link'), link.data('category'));
		});

		window.onpopstate = function(event){
			hideMain();
			var href = jQuery(window.location).attr('href');
			var history_data = event.state;
			dreamyGoTo(href, history_data.title, history_data.type_link, history_data.category);
			
			historyCount = historyCount+1;
		};
	}



	/* Google Maps: listener load */
	google.maps.event.addDomListener(window, 'load', showGoogleMaps);


	// Hide main
	jQuery('#main-hide').live('click', function(event){
		event.preventDefault();
		// Goto parent category or home
		//TODO menu in mobile resolution: dreamyGoToCategoryPost(jQuery(body).data("dreamy_category"));
		dreamyHistory('/', '', 'category', 'all')
		// Hide content
		hideMain();
	});
});




/* Functions */

	// History with AJAX
	function dreamyHistory(href, title, type_link, category){
		hideMain();
		// Set history data
		var history_data = {
			title: title,
			type_link: type_link,
			category: category
		};
		jQuery(body).data("dreamy_category", history_data.category);

		dreamyGoTo(href, title, type_link, category);

		history.pushState(history_data, null, href);
		return false;
	}

	function dreamyGoTo(href, title, type_link, category) {
		// Set title
		dreamyPageTitle(title, category);
    	// Send GA data
    	ga('send', 'pageview', href); 

    	if (type_link == 'category') {
			// Show category post
			dreamyShowMarkers(category); 
		}else{
			jQuery.ajax({
				url: href,
				method: 'POST',
				data: {ajax: true},
				success: function(main) {
		        	// Load content
		        	jQuery('#content').html(main);
		        	showMain();
		        	easy_fancybox_handler();
		        }
		    });
		}
	}

	function dreamyGoToCategoryPost(category){
		var link = jQuery( 'a[data-category="'+category+'"]');
		dreamyHistory(link.attr('href'), link.text(), 'category', category);
	}

	function dreamyLoadMarkers(map){
		var data = jQuery(body).data("markers");
		var cluster = [];
		jQuery.each(data, function(cat_name, category_markers){
			markers[cat_name] = [];
			jQuery.each(category_markers, function(index, marker_data){
				var latLong = new google.maps.LatLng(marker_data.lat, marker_data.lng);
				var marker =  new MarkerWithLabel({
					position: latLong,
					map: map,
					title: marker_data.title,
					icon: marker_data.icon,
					animation: google.maps.Animation.DROP,
					labelContent: marker_data.title,
					labelAnchor: new google.maps.Point(22, 0),
			        labelClass: "marker_labels"
			    });



				markers[cat_name].push(marker);
				cluster.push(marker);

    			// Show post
    			google.maps.event.addListener(marker, 'click', function() {
    				if (typeof history.pushState !== "undefined") {
    					dreamyHistory(marker_data.url, marker_data.title, 'post', marker_data.category);
    				}else{
    					window.location = marker_data.url;
    				}
    			});
    		});

        	//var markerCluster = new MarkerClusterer(map, cluster); disabled for zoom problems
		});
	}

	function dreamyShowMarkers(category){
		if(category == 'all'){
			jQuery.each(markers, function(index, value){
				dreamyShowMarkersOfCategory(markers[index]);				
			});
		}else{
			dreamyClearMarkers();
			dreamyShowMarkersOfCategory(markers[category]);
		}
	}

	function dreamyShowMarkersOfCategory(category_markers){
		jQuery.each(category_markers, function(index, marker){
			marker.setVisible(true);
			marker.setAnimation(google.maps.Animation.DROP);
		});
	}

	function dreamyClearMarkers(){
		jQuery.each(markers, function(index, category_markers){
			jQuery.each(category_markers, function(index, marker){
				marker.setVisible(false);
			});
		});

	}


	function showGoogleMaps() {
		var mapOptions = {
	        zoom: zoom, // initialize zoom level - the max value is 21
	        streetViewControl: false, // hide the yellow Street View pegman
	        scaleControl: false, // allow users to zoom the Google Map
	        mapTypeId: google.maps.MapTypeId.HYBRID,
	        disableDefaultUI: true,
	        scrollwheel: false,
	        disableDoubleClickZoom: true,
	        center: latLng
	    };

	    map = new google.maps.Map(document.getElementById('googlemaps'),
	    	mapOptions);

	    /* Load markers */
	    dreamyLoadMarkers(map);

	    var category = jQuery(body).data("dreamy_category");
	    dreamyShowMarkers(category);

	}

	function showMain(){
		jQuery('#content').css({display: 'block'});
		jQuery('#main').css({width: '0%'});
		jQuery('#main').animate({
			width: '100%', 
			opacity: 1
		});
	}

	function hideMain(){
		jQuery('#main').fadeOut('slow', function(){
			jQuery('#content').css({display: 'none'});
		});
	}

	function dreamyPageTitle(title, category){
		title = category=='all'?'es Arroyo':'es Arroyo, es ' +title;
		jQuery('head').find('title').text(title);
	}

	function sleep(seconds) {
		var milliseconds = seconds*1000;
		var start = new Date().getTime();
		for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
				break;
			}
		}
	}


