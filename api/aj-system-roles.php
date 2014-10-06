<?php

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

class AjSystemRoles{

	/**
	 * Server object
	 *
	 * @var WP_JSON_ResponseHandler
	 */
	protected $server;

	/**
	 * Constructor
	 *
	 * @param WP_JSON_ResponseHandler $server Server object
	 */
	public function __construct( WP_JSON_ResponseHandler $server ) {
		$this->server = $server;
	}

	/**
	 * Register the user-related routes
	 *
	 * @param array $routes Existing routes
	 * @return array Modified routes
	 */
	public function register_routes( $routes ) {
		$role_routes = array(
			// User endpoints
			'/roles' => array(
				array( array( $this, 'get_roles' ),        WP_JSON_Server::READABLE ),
				array( array( $this, 'new_role' ),         WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
			),
			'/roles/(?P<id>\d+)' => array(
				array( array( $this, 'get_role' ),         WP_JSON_Server::READABLE ),
				array( array( $this, 'edit_role' ),        WP_JSON_Server::EDITABLE | WP_JSON_Server::ACCEPT_JSON ),
				array( array( $this, 'delete_role' ),      WP_JSON_Server::DELETABLE ),
			)
		);
		return array_merge( $routes, $role_routes );
	}

	/**
	 * @api {get} /roles Request system roles
	 * @apiName GetRoles
	 * @apiGroup Roles
	 * @apiVersion 0.1.0
	 *
	 * @apiSuccess {Int} code Response code
	 * @apiSuccess {Array} roles  All system roles
	 *
	 * @apiError {Int} code Response code
	 * @apiError {String} message(optional) Error message
	 */
	public function get_roles(){
		global $wp_roles;
		$response = json_ensure_response(array('roles' => $wp_roles->roles));
		return $response;
	}

	/**
	 * @api {post} /roles Create new role
	 * @apiName New Role
	 * @apiGroup Roles
	 * @apiVersion 0.1.0
	 *
	 * @apiSuccess {Int} code Response code
	 * @apiSuccess {String} role New Role
	 *
	 * @apiError {Int} code Response code
	 * @apiError {String} message(optional) Error message
	 */
	public function new_role($role_name, $display_name, $capabilities){
		$role_creator = new RoleCreator();
		$response = $role_creator->create_role($role_name,  $display_name, $capabilities);

		if(is_wp_error($response )){
			return $response;
		}

		$response = json_ensure_response($response);
		$response->set_status( 201 );
		$response->header( 'Location', json_url( '/roles/') );

		return $response;
	}

	/**
	 * @api {post} /role/:role-slug Return role
	 * @apiName Get Role
	 * @apiGroup Roles
	 * @apiVersion 0.1.0
	 *
	 * @apiSuccess {Int} code Response code
	 * @apiSuccess {Object} role Role object
	 *
	 * @apiError {Int} code Response code
	 * @apiError {String} message(optional) Error message
	 */
	public function get_role(){}

	/**
	 * @api {put} /role/:role-slug update role
	 * @apiName Update Role
	 * @apiGroup Roles
	 * @apiVersion 0.1.0
	 *
	 * @apiSuccess {Int} code Response code
	 * @apiSuccess {Object} role Updated Role object
	 *
	 * @apiError {Int} code Response code
	 * @apiError {String} message(optional) Error message
	 */
	public function edit_role(){}

	/**
	 * @api {delete} /role/:role-slug Delete role
	 * @apiName Remove Role
	 * @apiGroup Roles
	 * @apiVersion 0.1.0
	 *
	 * @apiSuccess {Int} code Response code
	 *
	 * @apiError {Int} code Response code
	 * @apiError {String} message(optional) Error message
	 */
	public function delete_role(){}
}
