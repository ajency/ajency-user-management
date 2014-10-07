<?php

class RolesAPITest extends WP_UnitTestCase{

	public function setUp(){
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'editor' ) );
		wp_set_current_user( $this->author_id );
		$this->fake_server = $this->getMock( 'WP_JSON_Server', null );
		$this->endpoint = new AjSystemRoles( $this->fake_server );
	}

	public static function tearDownAfterClass(){
		parent::tearDownAfterClass();
		remove_role('new_role');
		remove_role('new_test_role');
	}

	protected function check_create_new_role_response($response){
		$this->assertNotInstanceOf( 'WP_Error', $response );

		$response = json_ensure_response( $response );
		$headers = $response->get_headers();
		$this->assertEquals( 201, $response->get_status() );
		$this->assertArrayHasKey( 'Location', $headers );

		$response_data = $response->get_data();
		$this->assertEquals( 'new_role', $response_data->name );
		$this->assertTrue( $response_data->has_cap('edit_plugin') );
	}

	public function test_new_role_api(){

		$response = $this->endpoint->new_role( 'new_role', 'New Role',
											array(
													'edit_plugin' => true
											)
										);
		$response = json_ensure_response( $response );
		$this->check_create_new_role_response( $response );
	}



	public function test_new_role_api_existing_role(){

		$response = $this->endpoint->new_role( 'administrator', 'Administrator',
											array(
													'edit_plugin' => true
											)
										);
		$response = json_ensure_response( $response );
		$this->assertInstanceOf( 'WP_Error', $response );
		$this->assertEquals( 'role_exists', $response->get_error_code() );
		$this->assertEquals( 'Role already exists', $response->get_error_message() );
	}

	public function test_new_role_api_without_caps(){

		$response = $this->endpoint->new_role( 'new_role', 'New Role', array());
		$response = json_ensure_response( $response );
		$this->assertInstanceOf( 'WP_Error', $response );
		$this->assertEquals( 'no_capabilities', $response->get_error_code() );
		$this->assertEquals( 'No capabilities passed', $response->get_error_message() );
	}

	public function test_new_role_api_without_display_name(){

		$response = $this->endpoint->new_role( 'new_role', '', array('edit_plugin' => true));
		$response = json_ensure_response( $response );
		$this->assertInstanceOf( 'WP_Error', $response );
		$this->assertEquals( 'no_display_name', $response->get_error_code() );
		$this->assertEquals( 'Display name not passed', $response->get_error_message() );
	}

	public function test_new_role_api_with_role_to_inherit(){

		$response = $this->endpoint->new_role( 'new_test_role', 'display name', array('edit_plugin' => true), 'administrator');
		$response = json_ensure_response( $response );
		$response_data = $response->get_data();
		$this->assertEquals( 'new_test_role', $response_data->name );
	}

	public function test_get_roles(){
		$response = $this->endpoint->get_roles();
		$response = json_ensure_response( $response );
		$data = $response->get_data();
		$this->assertEquals(7, count($data['roles']) );
	}

}
