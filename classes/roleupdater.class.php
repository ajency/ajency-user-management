<?php

class RoleUpdater {

	public function update_role($role, $capabilities = array()){

		if(!current_user_can('activate_plugins' ) && !current_user_can('edit_roles')){
			return new WP_Error('not_enough_permission', __('You do not have enough permission to perform this action'));
		}

		if(!is_array($capabilities) or empty($capabilities))
			return new WP_Error('no_capabilities',__('No capabilities passed'));

		$role = get_role($role);

		if(($role instanceof WP_Role) === false)
			return new WP_Error('role_not_found',__('Role does not exists'));

		foreach($capabilities as $cap => $grant){
			$role->add_cap($cap, $grant);
		}

		return $role;
	}

}
