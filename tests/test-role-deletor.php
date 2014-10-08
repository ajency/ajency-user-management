<?php

class RolesDeletorTest extends WP_UnitTestCase{

	public function setUp(){
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $this->author_id );
		$this->remover = new RoleDeletor;
	}

	public static function tearDownAfterClass(){
		parent::tearDownAfterClass();
		wp_set_current_user( 99999 );
	}

	public function test_delete_role(){
		$this->remover->delete_role('author');
		$this->remover->delete_role('editor');
		$this->assertTrue(in_array('author', get_option('archived_roles', array() )));
		$this->assertTrue(in_array('editor', get_option('archived_roles', array() )));
	}

	public function test_delete_role_administrator_role(){
		$return = $this->remover->delete_role('administrator');
		$this->assertInstanceOf('WP_Error', $return);
		$this->assertEquals( 'invalid_action', $return->get_error_code() );
		$this->assertEquals( '"administrator" role cannot be removed', $return->get_error_message() );
	}

	public function test_delete_role_default_new_user_role(){
		$return = $this->remover->delete_role('subscriber');
		$this->assertInstanceOf('WP_Error', $return);
		$this->assertEquals( 'invalid_action', $return->get_error_code() );
		$this->assertEquals( 'default role cannot be removed', $return->get_error_message() );
	}

	public function test_delete_role_without_permission(){
		$uid = $this->factory->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $uid );
		$args = array('editor', array('cap' => true));
		$return = $this->remover->delete_role('author');
		$this->assertInstanceOf('WP_Error', $return);
		$this->assertEquals( 'not_enough_permission', $return->get_error_code() );
		$this->assertEquals( 'You do not have enough permission to perform this action', $return->get_error_message() );
		wp_set_current_user( $this->author_id );
	}

	public function test_delete_role_with_user_having_delete_role_cap(){
		$editor_id = $this->factory->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $editor_id );
		$user = wp_get_current_user();
		$user->add_cap('delete_roles');
		$user->_init_caps();
		$this->remover->delete_role('author');
		$this->assertTrue(in_array('author', get_option('archived_roles', array() )));
		wp_set_current_user( $this->author_id );
	}
}
