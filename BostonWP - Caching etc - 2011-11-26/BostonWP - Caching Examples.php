function generate_cached_output() {
	if ( false === ( $output = wp_cache_get( $cache_key, $cache_group ) ) ) {
		$output = 'Something to be cached';
		
		wp_cache_set( $cache_key, $output, $cache_group, 86400 );
	}

	return $output;
}


function clear_cached_output( $new_status, $old_status ) {
	if ( 'publish' == $new_status || 'publish' == $old_status )
		wp_cache_delete( $cache_key, $cache_group );
}
add_action( 'transition_post_status', 'clear_cached_output', 10, 2 );


function clear_cached_output( $new_status, $old_status, $post ) {
	if ( ( 'publish' == $new_status || 'publish' == $old_status ) && 'post' == $post->post_type )
		wp_cache_delete( $cache_key, $cache_group );
}
add_action( 'transition_post_status', 'clear_cached_output', 10, 3 );


function recent_posts( $post_id = false, $qty = 3 ) {
	$post_id = (int) $post_id;
	if ( ! $post_id )
		return false;
	
	$qty = (int) $qty ? (int) $qty : 3;
	
	$cache_key = $post_id . '_' . $qty;
	
	if ( false === ( $output = wp_cache_get( $cache_key, 'recent_posts' ) ) ) {
		$output = 'Something to be cached';
		
		wp_cache_set( $cache_key, $output, 'recent_posts', 86400 );
	}

	return $output;
}


function recent_posts( $post_id = false, $qty = 3 ) {
	/* Sanitize function arguments */
	
	$cache_key = $post_id . '_' . $qty;
	
	$cache = wp_cache_get( 'single', 'recent_posts' );
	if( ! is_array( $cache ) )
		$cache = array();
	
	if ( ! array_key_exists( $cache_key, $cache ) ) {
		$output = 'Something to be cached';
		
		$cache[ $cache_key ] = $output;
		wp_cache_set( 'single', $cache, 'recent_posts', 86400 );
	}

	return $output;
}


function get_cache_incrementor() {
	$incrementor = wp_cache_get( 'incrementor', 'recent_posts' );
	if ( ! is_numeric( $incrementor ) ) {
		$incrementor = time();
		wp_cache_set( 'incrementor', $incrementor, 'recent_posts', 86400 );
	}
	
	return $incrementor;
}

function recent_posts( $post_id = false, $qty = 3 ) {
	/* Sanitize function arguments */
	
	$cache_key = get_cache_incrementor() . '_' . $post_id . '_' . $qty;
	
	if ( false === ( $output = wp_cache_get( $cache_key, 'recent_posts' ) ) ) {
		$output = 'Something to be cached';
		
		wp_cache_set( $cache_key, $output, 'recent_posts', 86400 );
	}

	return $output;
}


function cache_wp_nav_menu( $args = false, $skip_cache = false ) {
	/* Sanitize function arguments */
	
	$echo = (bool) $args[ 'echo' ];
	$args[ 'echo' ] = false;
	
	$cache_key = md5( implode( '|', $args ) );
	
	if( $skip_cache || false === ( $menu = wp_cache_get( $cache_key, $this->cache_group ) ) ) {
		$menu = wp_nav_menu( $args );
		
		wp_cache_set( $cache_key, $menu, 'ipm_menus', $this->cache_group, 86400 );
	}
	
	if( $echo )
		echo $menu;
	else
		return $menu;
}

function cache_wp_nav_menu( $args = false, $skip_cache = false ) {
	/* Sanitize function arguments */
	
	$echo = (bool) $args[ 'echo' ];
	$args[ 'echo' ] = false;
	
	$queried_object = (int) get_queried_object_id();
	if ( ! $queried_object )
		$queried_object = 0;
	
	$cache_key = get_cache_incrementor();
	$cache_key .= $queried_object . '|';
	$cache_key .= implode( '|', $args );
	$cache_key = md5( $cache_key );
	
	...


//In home.php
query_posts( array(
	'posts_per_page' => 5
) );


function action_pre_get_posts( $query ) {
	if ( $query->is_home() )
		$query->set( 'posts_per_page', 5 );
}
add_action( 'pre_get_posts', 'action_pre_get_posts' );


new WP_Query( array(
	'category__not_in' => 167
) );


function cached_get_objects_in_term( $term_ids, $taxonomies, $args ) {
	/* Sanitize function arguments */
	
	$cache_key = md5( implode( ',', $term_ids ) . $taxonomies . serialize( $args ) );
	
	if ( false === ( $ids = wp_cache_get( $cache_key, 'get_objects_in_term' ) ) ) {
		$ids = get_objects_in_term( $term_ids, $taxonomies, $args );
		/* Error check $ids */
		wp_cache_set( $cache_key, $ids, 'get_objects_in_term', 86400 );
	}
	
	return $ids;
}


new WP_Query( array(
	'post__not_in' => cached_get_objects_in_term( 167, 'category' )
) );


SELECT   wp_posts.* FROM wp_posts  WHERE 1=1  AND wp_posts.ID
NOT IN ( SELECT tr.object_id FROM wp_term_relationships AS tr INNER JOIN
wp_term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
WHERE tt.taxonomy = 'category' AND tt.term_id IN ('3') ) AND
wp_posts.post_type = 'post' AND (wp_posts.post_status = 'publish')
ORDER BY wp_posts.ID ASC LIMIT 0, 1

SELECT   wp_posts.* FROM wp_posts  WHERE 1=1  AND wp_posts.ID
NOT IN ( '153', '682', '1132', '1133', '1134', '1135', '1136', '1137', '1139', '1140', '1141', '1144', '1147', '1149', '1152', '1153', '1155', '1157', '1349', '1434', '1446', '1447', '1453', '1460', '1462', '1466', '1468', '1471', '1475', '1476', '1479', '1482', '1485', '1486', '1497', '1505', '1525', '1526', '1539', '1541', '1543', '1545', '1546', '1547', '1551', '1552', '1564', '1566', '1570', '1580', '1583', '1588', '1596', '1615', '1623', '1635', '1640', '1655', '1676', '1685', '1767', '1823', '1863', '1908', '1931', '2002', '2025', '2093', '2094', '2095', '2096', '2097', '2099', '2100', '2101', '2102', '2103', '2104', '2105', '2106', '2107', '2111', '2112', '2116', '2118', '2119', '2124', '2128', '2131', '2141', '2144', '2148', '2150', '2151', '2158', '2162', '2164', '2169', '2171', '2174', '2175', '2176', '2177', '2179', '2183', '2184', '2185', '2186', '2189', '2191', '2194', '2197', '2198', '2201', '2203', '2206', '2207', '2209', '2210', '2214', '2215', '2216', '2692', '4515', '4529', '4534', '4541', '4542', '4543', '4580', '4581', '4590', '4594', '4602', '4606', '4611', '4612', '4617', '4622', '4626', '4636', '4643', '4648', '4668', '4684', '4698', '4700', '4702', '4710', '4717', '4723', '4725', '4727', '4739', '4742', '4757', '4785', '4786', '4789', '4791', '4803', '4818', '4822', '4844', '4845', '4848', '4849', '4851', '4857', '4859', '4869', '4880', '4886', '4891', '4909', '4910', '4912', '4926', '4931', '4941', '4958', '4966', '4979', '4982', '4983', '4989', '4990', '4999', '5013', '5017', '5021', '5030', '5038', '5053', '5054', '5055', '5067', '5068', '5069', '5075', '5080', '5095', '5100', '5103', '5105', '5113', '5116', '5124', '5136', '5137', '5157', '5186', '5188', '5198', '5204', '5214', '5225', '5228', '5236', '5244', '5250', '5252', '5259', '5280', '5289', '5291', '5292', '5411', '5413', '5415', '5416', '5417', '5418', '5419', '5420', '5421', '5422', '5424', '5426', '5427', '5428', '5429', '5430', '5452', '5453', '5459', '5460', '5463', '5464', '5465', '5466', '5468', '5469', '5470', '5472', '5473', '5476', '5479', '5480', '5481', '5482', '5483', '5484', '5721', '5858', '5859', '5860', '5861', '5862', '5863', '5864', '5916', '5920', '5922', '6083', '7674', '7678', '7700', '7729', '7734', '7807', '7821', '7863', '7879', '7890', '7892', '7895', '7896', '7906', '7911', '7922', '7938', '7951', '7953', '7964', '7968', '7973', '7974', '7978', '7980', '8585', '8635', '8655', '8708', '9148', '10638', '10994', '11010', '11022', '11264', '11338', '11348', '11420', '11460', '11487', '11627', '11641', '11687', '11697', '11798', '11804', '11919', '11970', '12237', '12247', '12324', '12535', '12576', '12645', '12665', '12764', '12785', '12871', '12918', '12928', '13153', '13166', '13179', '13389', '13455', '13468', '13723', '13732', '13974', '14899', '14905', '14928', '15000', '15057', '15140', '15146', '15183', '15460', '15469', '15481', '15829', '15991', '16021', '16039', '16131', '16221', '16257', '16300', '16322', '16326', '16335', '16404', '16548', '16554', '16596', '16647', '16734', '16776', '16791', '16852', '16915', '16977', '17043', '17048', '17183', '17405', '17418', '17429', '17514', '17579', '17662', '17689', '17787', '17963', '18002', '18027', '18043', '18063', '18198', '18376', '18432', '18575', '18646', '18657', '18673', '18678', '18839', '18883', '18938', '19093', '19114', '19149', '19293', '19295', '19388', '19550', '19679', '19687', '19727', '19731', '19792', '19793', '19836', '19990', '20060', '20284', '20380', '20420', '20822', '21134', '21244', '21370', '21403', '21554', '21742', '21822', '21850', '22115', '22162', '22500', '22514', '22561', '22586', '22712', '22874', '23773', '23790', '24120', '24236', '24281', '24394', '24613', '24731', '24889', '25036', '25063', '25090', '25250', '25335', '25342', '25359', '25508', '25634', '25677', '25693', '25806', '25831', '25866', '25972', '25991', '26012', '26037', '26129', '26170', '26296', '26420', '26494', '26595', '26820', '27139', '27206', '27279', '27510', '27557', '27692', '27756', '27960', '28014', '28490', '28494', '28608', '28988', '29106', '29265', '29390', '29393', '29408', '29516', '29647', '29734', '29755', '29766', '29778', '29789', '29958', '29970', '30024', '30199', '30208', '30238', '30241', '30249', '30263', '30325', '30343', '30344', '30394', '30400', '30453', '30459', '30526', '30673', '30830', '30923', '30965', '31015', '31018', '31032', '31092', '31109', '31120', '31123', '31124', '31141', '31147', '31216', '31249', '31381', '31432', '31492', '31646', '31659', '31927', '31969', '32043', '32129', '32236', '32319', '32375', '32395', '32424', '32535', '32554', '32568', '32728', '32730', '32742', '32788', '32889', '32982', '33047', '33065', '33097', '33137', '33146', '33256', '33295', '33325', '33413', '33491', '33543', '33588', '33620', '33629', '33674', '33702', '34040', '34104', '34229', '34258', '34391', '34434', '34508', '34547', '34602', '34649', '34698', '34766', '34789', '34808', '34857', '34942', '34963', '34979', '35145', '35155', '35205', '35243', '35254', '35362', '35373', '35375', '35403', '35532', '35679', '35746', '35796', '35816', '35885', '35946', '35952', '36036', '36075', '36143', '36174', '36179', '36205', '36262', '36292', '36426', '36479', '36492', '36512', '36517', '36625', '36630', '38381', '39623', '40794', '43477', '44269', '44299', '46341', '46690', '46974', '50166', '54054', '56509', '69203' ) AND
wp_posts.post_type = 'post' AND (wp_posts.post_status = 'publish')
ORDER BY wp_posts.ID ASC LIMIT 0, 1