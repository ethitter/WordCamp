<?php
function action_pre_get_posts( $query ) {
	if ( $query->is_main_query() )
		$query->set( 'cache_results', true );
}
add_action( 'pre_get_posts', 'action_pre_get_posts' );
?>