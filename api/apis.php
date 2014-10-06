<?php

function register_apis($server) {
	global $aj_system_roles;
	$aj_system_roles = new AjSystemRoles($server);
	add_filter( 'json_endpoints', array( $aj_system_roles, 'register_routes' ) );
}
add_action( 'wp_json_server_before_serve', 'register_apis', 20, 1 );
