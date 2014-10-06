<?php

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
		return array('administrator','editor','subscriber');
	}

	public function new_role(){

	}

	public function get_role(){

	}

	public function edit_role(){}
	public function delete_role(){}
}
