<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   ajency-user-management
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 10-1-2014 Ajency.in
 */
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<!-- TODO: Provide markup for your options page here. -->
	<button class="btn btn-primary add-role">Add Role</button>
	<button class="btn btn-primary all-roles">All Roles</button>
	<button class="btn btn-primary edit-role">Edit Role</button>
	<button class="btn btn-primary delete-role">Delete Role</button>

</div>
