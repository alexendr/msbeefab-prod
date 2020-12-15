<form method="GET" class="form-horizontal noo-umbra-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="note-search"><?php echo esc_html__( 'Type and Press Enter to Search', 'noo-umbra' ); ?></label>
	<input type="search" name="s" class="form-control" value="<?php echo get_search_query(); ?>" placeholder="<?php echo esc_attr__( 'Enter keyword to search...', 'noo-umbra' ); ?>" />
	<button type="submit" class="noo-search-submit"><i class="icon_search"></i></button>
</form>