<?php

class RoleDeletor {

	public function delete_role($role){

		if(!current_user_can('activate_plugins' ) && !current_user_can('delete_roles')){
			return new WP_Error('not_enough_permission', __('You do not have enough permission to perform this action'));
		}

		if($role === 'administrator'){
			return new WP_Error('invalid_action', __('"administrator" role cannot be removed'));
		}

		if($role === get_option('default_role','')){
			return new WP_Error('invalid_action', __('default role cannot be removed'));
		}

		$archived_roles = get_option('archived_roles', array());

		$archived_roles = array_merge($archived_roles, array($role));
		update_option('archived_roles', $archived_roles);

	}
}
