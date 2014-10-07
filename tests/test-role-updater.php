<?php

class RolesUpdaterTest extends WP_UnitTestCase{

	public function setUp(){
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $this->author_id );
		$this->updater = new RoleUpdater;
	}

	public static function tearDownAfterClass(){
		parent::tearDownAfterClass();
		wp_set_current_user( 99999 );
	}

	public function test_update_role_without_permission(){
		$uid = $this->factory->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $uid );
		$args = array('editor', array('cap' => true));
		$return = call_user_func_array(array($this->updater, 'update_role'), $args);
		$this->assertInstanceOf('WP_Error', $return);
		$this->assertEquals( 'not_enough_permission', $return->get_error_code() );
		$this->assertEquals( 'You do not have enough permission to perform this action', $return->get_error_message() );
		wp_set_current_user( $this->author_id );
	}

	public function test_update_role_non_existing_role(){
		$args = array('dummyrole', array('cap' => true));
		$return = call_user_func_array(array($this->updater, 'update_role'), $args);
		$this->assertInstanceOf('WP_Error', $return);
		$this->assertEquals( 'role_not_found', $return->get_error_code() );
		$this->assertEquals( 'Role does not exists', $return->get_error_message() );
	}

	public function test_update_role_add_capabilities(){
		$args = array('editor', array('new_cap' => true, 'cap_two' => false));
		call_user_func_array(array($this->updater, 'update_role'), $args);
		$role = get_role('editor');
		$this->assertTrue($role->has_cap('new_cap'));
		$this->assertFalse($role->has_cap('cap_two'));
	}

	public function test_update_role_update_capabilities(){
		$args = array('editor', array('read_private_pages' => false, 'upload_files' => false));
		call_user_func_array(array($this->updater, 'update_role'), $args);
		$role = get_role('editor');
		$this->assertFalse($role->has_cap('read_private_pages'));
		$this->assertFalse($role->has_cap('upload_files'));
	}
}
