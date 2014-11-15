<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package Disueños
 * @subpackage Dreamy_Town
 * @since esArroyo.es 2014
 */
?>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand dt_category" href="<?php echo home_url();?>" data-dt_type_link="category" data-dt_category="all">
					<img alt="Logo" src="<?php bloginfo('template_url');?>/images/logo.png">
				</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php
					$categories = get_categories();

					foreach ($categories as $category):
						$slug = $category->slug;
						$cat_id = $category->cat_ID;
					?>
					<li class="dropdown">
						<div class="btn-group">
						<a class="btn dt_category" role="button" href="<?php echo get_category_link( $cat_id ); ?>" data-dt_type_link="category" data-dt_category="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a>
						<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						    <span class="caret"></span>
						    <span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php

							$lastposts = get_posts(array('category' => $cat_id));
							foreach ( $lastposts as $post ) :
								setup_postdata( $post );
								$the_category = get_the_category();
								// Set marker info
								echo '<li><a class="dt_link_'.$the_category[0]->slug.'" href="'.get_the_permalink().'" data-dt_type_link="link" data-dt_category="'.$the_category[0]->slug.'" data-dt_lat="'.get_post_meta(get_the_ID(), "dreamy_lat", true).'" data-dt_lng="'.get_post_meta(get_the_ID(), "dreamy_long", true).'" data-dt_icon="'.get_template_directory_uri().'/images/markers/'.get_post_meta(get_the_ID(), "dreamy_icon", true).'">'.get_the_title().'</a></li>';
							endforeach;
							wp_reset_postdata();
							?>
						</ul>
						</div>
					</li>
					<?php
					endforeach;
					?>
				</ul>
			</div>
		</div>
	</nav>


