<?php
/**
 * The template for displaying the Search Form
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */
 ?>
 <form role="search" method="get" id="searchform" class="navbar-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
            <input type="text" class="form-control" placeholder="Search" name="s">
            <div class="input-group-btn">
                <button class="btn btn-warning" style="background-color : #f8c300" type="submit"><i class="glyphicon glyphicon-search" style="color: #000"></i></button>
            </div>
        </div>	
</form>

