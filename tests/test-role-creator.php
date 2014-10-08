<?php

class RolesCreatorTest extends WP_UnitTestCase{

	public function setUp(){
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $this->author_id );
		$this->creator = new RoleCreator;
	}

	public static function tearDownAfterClass(){
		parent::tearDownAfterClass();
		wp_set_current_user( 99999 );
		remove_role('new_role');
		remove_role('new_clone_role');
		remove_role('new_test_role');
		remove_role('new_dummy_role');
		remove_role('new_extra_cap_role');
	}

	public function test_create_role(){
		$args = array('new_role', 'role display name', array('edit_files' => true));
		call_user_func_array(array($this->creator, 'create_role'), $args);
		$this->assertInstanceOf('WP_Role',get_role('new_role'));
	}

	public function test_create_role_with_role_to_inherit(){
		$args = array('new_clone_role', 'clone role display name', array('edit_files' => true), 'administrator');
		call_user_func_array(array($this->creator, 'create_role'), $args);
		$role = get_role('new_clone_role');
		$this->assertInstanceOf('WP_Role',$role);
		$this->assertTrue($role->has_cap('activate_plugins')); //administrator capability
		$this->assertTrue($role->has_cap('edit_files'));
	}

	public function test_create_role_with_role_to_inherit_with_non_existing_role(){
		$args = array('new_test_role', 'clone role display name', array('edit_files' => true), 'dummyrole');
		call_user_func_array(array($this->creator, 'create_role'), $args);
		$role = get_role('new_test_role');
		$this->assertInstanceOf('WP_Role',$role);
		$this->assertEquals(1, count($role->capabilities));

	}

	public function test_create_role_with_role_to_inherit_and_override_default_caps(){
		//overwrite existing caps
		$args = array('new_dummy_role', 'clone role display name', array('activate_plugins' => false), 'administrator');
		call_user_func_array(array($this->creator, 'create_role'), $args);
		$role = get_role('new_dummy_role');
		$this->assertInstanceOf('WP_Role',$role);
		$this->assertFalse($role->capabilities['activate_plugins']);
		$this->assertTrue($role->capabilities['manage_options']); // still have administrator cap
	}

	public function test_create_role_without_user_having_caps(){

		$editor_id = $this->factory->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $editor_id );

		$args = array('new_dummy_role', 'clone role display name', array('demo_cap' => false), 'subscriber');
		$return = call_user_func_array(array($this->creator, 'create_role'), $args);
		$this->assertInstanceOf('WP_Error', $return);
		$this->assertEquals( 'not_enough_permission', $return->get_error_code() );
		$this->assertEquals( 'You do not have enough permission to perform this action', $return->get_error_message() );

		wp_set_current_user( $this->author_id );
	}

	public function test_create_role_with_user_having_edit_role_cap(){
		$editor_id = $this->factory->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $editor_id );
		$user = wp_get_current_user();
		$user->add_cap('edit_roles');
		$user->_init_caps();
		$args = array('new_extra_cap_role', 'clone role display name', array('new_cap' => true));
		$return = call_user_func_array(array($this->creator, 'create_role'), $args);
		$role = get_role('new_extra_cap_role');
		$this->assertInstanceOf('WP_Role',$role);

		wp_set_current_user( $this->author_id );
	}
}
