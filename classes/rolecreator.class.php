<?php

class RoleCreator {

	public function __construct(){

	}

	public function create_role($role, $display_name, $capabilities, $clone_role = false){

		if(!is_array($capabilities) or empty($capabilities))
			return new WP_Error('no_capabilities',__('No capabilities passed'));

		if(empty($display_name))
			return new WP_Error('no_display_name',__('Display name not passed'));

		$role = add_role( $role, $display_name, $capabilities );

		if(null === $role)
			return new WP_Error('role_exists',__('Role already exists'));

		return $role;
	}
}
