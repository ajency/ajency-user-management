<?php

/**
 * Get roles
 * @param  boolean $archived All roles?
 * @return [array]            array of role objects
 */
function get_roles( $archived = false ){
	global $wp_roles;

	$archived_roles = array();
	$roles = array();

	//get archived roles
	if($archived === false)
		$archived_roles = get_option('archived_roles', array());

	foreach ($wp_roles->roles as $role_name => $role) {

		if(!in_array($role_name, $archived_roles))
			$roles[] = $role;
	}

	return $roles;
}
