<?php

class RolesTest extends WP_UnitTestCase{

	public function setUp(){
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $this->author_id );
	}

	public static function tearDownAfterClass(){
		parent::tearDownAfterClass();
		wp_set_current_user( 99999 );
	}

	public function test_get_roles(){
		global $wp_roles;
		$this->assertEquals(5, count(get_roles()));
	}

	public function test_get_roles_without_archived_roles(){
		global $wp_roles;
		update_option('archived_roles', array('editor','author'));
		$this->assertEquals(3, count(get_roles()));
		update_option('archived_roles', array());
	}

	public function test_get_roles_with_archived_roles(){
		global $wp_roles;
		update_option('archived_roles', array('editor','author'));
		$this->assertEquals(5, count(get_roles(true)));
		update_option('archived_roles', array());
	}
}
