<?php

class RoleCreator {

	public function __construct(){

	}

	public function create_role($role, $display_name, $capabilities, $inherit_from = false){

		if(!current_user_can('activate_plugins' ) && !current_user_can('edit_roles')){
			return new WP_Error('not_enough_permission', __('You do not have enough permission to perform this action'));
		}

		if(!is_array($capabilities) or empty($capabilities))
			return new WP_Error('no_capabilities',__('No capabilities passed'));

		if(empty($display_name))
			return new WP_Error('no_display_name',__('Display name not passed'));

		if($inherit_from !== false)
			$capabilities = wp_parse_args($capabilities, $this->get_capabilities($inherit_from));

		$role = add_role( $role, $display_name, $capabilities );

		if(null === $role)
			return new WP_Error('role_exists',__('Role already exists'));

		return $role;
	}

	private function get_capabilities($inherit_from){

		$role = get_role($inherit_from);

		$capabilities = array();

		if($role instanceof WP_Role)
			$capabilities = $role->capabilities;

		return $capabilities;
	}
}
