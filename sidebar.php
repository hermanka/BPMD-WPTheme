
	<?php 
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
$category_name = get_cat_name($category_id);
// Get array of post info.
		$args = array(
			'showposts' => 7,
			'cat' => $category_id,
			'orderby' => 'date',
			'order' => 'desc'
		);
		
$cat_posts = new WP_Query( $args );
if ( $cat_posts->have_posts() ) {		
			
			// Widget title
				
			echo '<a href="' . $category_id . '"><div class="single-sidebar-default">';
			//echo $before_title;
			echo $category_name;
			//echo $after_title;
			echo '</div></a>';

			
			// Post list
			echo "<ul class='cat-post-sidebar'>\n";
			while ( $cat_posts->have_posts() )
			{
				$cat_posts->the_post(); ?>
				
				<li >
									
					
					<a class="post-title <?php if( !isset( $instance['disable_css'] ) ) { echo " cat-post-title"; } ?>" 
						href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?>
					</a>

					
				</li>
				<?php
			}

			echo "</ul>\n";
			
		} // END if
?>	  
