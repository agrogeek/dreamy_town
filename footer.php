<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */
global $category_slug, $is_single;
$markers = array();

$categories = get_categories();

foreach ($categories as $category):
	$slug = $category->slug;
	$cat_id = $category->cat_ID;
	$markers[$slug] = array();

	$lastposts = get_posts(array('category' => $cat_id));
	foreach ( $lastposts as $post ) :
  		setup_postdata( $post );
  		$the_category = get_the_category();
		// Set marker info
		$marker = array(
			"title" => get_the_title(),
			"url" => get_the_permalink(),
			"category" => $the_category[0]->slug,
			"lat" => get_post_meta(get_the_ID(), "dreamy_lat", true),
			"lng" =>get_post_meta(get_the_ID(), "dreamy_long", true),
			"icon" => get_template_directory_uri().'/images/markers/'.get_post_meta(get_the_ID(), "dreamy_icon", true)
			);

		$markers[$slug][] = $marker;
	endforeach;
	wp_reset_postdata();
endforeach;


?>
	</div><!-- Content -->
</div><!-- Container-fluid -->
<script>

 jQuery( document ).ready(function() {
 	jQuery(body).data("markers", <?php echo json_encode($markers); ?>);
	jQuery(body).data("dreamy_category", '<?php echo $category_slug; ?>');
	<?php if ($is_single) { ?>
	showMain();
	<?php } ?>

	//jQuery("#main").perfectScrollbar()
	jQuery(".fancybox").fancybox();
 });
 
/*
  * Normalized hide address bar for iOS & Android
  * (c) Scott Jehl, scottjehl.com
  * MIT License
*/
(function( win ){
	var doc = win.document;
	
	// If there's a hash, or addEventListener is undefined, stop here
	if( !location.hash && win.addEventListener ){
		
		//scroll to 1
		window.scrollTo( 0, 1 );
		var scrollTop = 1,
			getScrollTop = function(){
				return win.pageYOffset || doc.compatMode === "CSS1Compat" && doc.documentElement.scrollTop || doc.body.scrollTop || 0;
			},
		
			//reset to 0 on bodyready, if needed
			bodycheck = setInterval(function(){
				if( doc.body ){
					clearInterval( bodycheck );
					scrollTop = getScrollTop();
					win.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
				}	
			}, 15 );
		
		win.addEventListener( "load", function(){
			setTimeout(function(){
				//at load, if user hasn't scrolled more than 20 or so...
				if( getScrollTop() < 20 ){
					//reset to hide addr bar at onload
					win.scrollTo( 0, scrollTop === 1 ? 0 : 1 );
				}
			}, 0);
		} );
	}
})( this );

</script>
	<script>

	/*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-42243238-1', 'esarroyo.es');
	ga('require', 'displayfeatures');
	ga('require', 'linkid', 'linkid.js');
	ga('send', 'pageview');*/
	
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42243238-1', 'esarroyo.es');
  ga('send', 'pageview');


</script>

	<?php wp_footer(); ?>
</body>
</html>