<?php

class RolesAPITest extends WP_UnitTestCase{

	public function setUp(){
		parent::setUp();
		$this->author_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		wp_set_current_user( $this->author_id );
		$this->fake_server = $this->getMock( 'WP_JSON_Server', null );
		$this->endpoint = new AjSystemRoles( $this->fake_server );
	}

	public static function tearDownAfterClass(){
		parent::tearDownAfterClass();
		wp_set_current_user( 99999 );
		remove_role('new_role');
		remove_role('new_test_role');
		remove_role('new_r');
	}

	protected function check_create_new_role_response($role, $response){
		$this->assertNotInstanceOf( 'WP_Error', $response );

		$response = json_ensure_response( $response );
		$headers = $response->get_headers();
		$this->assertEquals( 201, $response->get_status() );

		$response_data = $response->get_data();
		$this->assertEquals( $role, $response_data->name );

	}

	public function test_new_role_api(){

		$response = $this->endpoint->new_role( 'new_role', 'New Role',array('edit_plugin' => true));
		$response = json_ensure_response( $response );
		$this->check_create_new_role_response('new_role', $response );
	}

	public function test_new_role_api_existing_role(){

		$response = $this->endpoint->new_role( 'administrator', 'Administrator', array('edit_plugin' => true));
		$response = json_ensure_error_response( $response );
		$this->assertInstanceOf( 'WP_JSON_Error_Response', $response );
		$data = $response->get_data();
		$this->assertEquals( 'role_exists', $data['code']);
		$this->assertEquals( 'Role already exists', $data['error'] );
		$this->assertEquals(422, $response->get_status() );
	}

	public function test_new_role_api_without_caps(){

		$response = $this->endpoint->new_role( 'new_role', 'New Role', array());
		$response = json_ensure_error_response( $response );
		$data = $response->get_data();
		$this->assertInstanceOf( 'WP_JSON_Error_Response', $response );
		$this->assertEquals( 'no_capabilities', $data['code'] );
		$this->assertEquals( 'No capabilities passed', $data['error'] );
		$this->assertEquals(422, $response->get_status() );
	}

	public function test_new_role_api_without_display_name(){

		$response = $this->endpoint->new_role( 'new_role', '', array('edit_plugin' => true));
		$response = json_ensure_error_response( $response );
		$data = $response->get_data();
		$this->assertInstanceOf( 'WP_JSON_Error_Response', $response );
		$this->assertEquals( 'no_display_name', $data['code'] );
		$this->assertEquals( 'Display name not passed', $data['error']);
	}

	public function test_new_role_api_with_role_to_inherit(){

		$response = $this->endpoint->new_role( 'new_r', 'display name', array('edit_plugin' => true), 'editor');
		$response = json_ensure_response( $response );
		$this->check_create_new_role_response('new_r', $response );
	}

	public function test_get_roles(){
		$response = $this->endpoint->get_roles();
		$response = json_ensure_response( $response );
		$data = $response->get_data();
		$this->assertEquals(200, $response->get_status() );
		$this->assertEquals(7, count($data['roles']) );
	}

	public function test_edit_role_api(){
		$response = $this->endpoint->edit_role('editor', array('cap_name' => true) );
		$response = json_ensure_response( $response );
		$data = $response->get_data();
		$this->assertEquals(200, $response->get_status() );
		$this->assertInstanceOf('WP_Role', $data['role'] );
	}

	public function test_delete_role_api(){
		$response = $this->endpoint->delete_role('editor');
		$response = json_ensure_response( $response );
		$data = $response->get_data();
		$this->assertEquals(200, $response->get_status() );
	}

}
