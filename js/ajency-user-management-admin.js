/**
 * This is the main javascript file for the Ajency User Management plugin's main administration view.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end administrator.
 *
 * @package   ajency-user-management
 * @author    Team Ajency <team@ajency.in>
 * @license   GPL-2.0+
 * @link      http://ajency.in
 * @copyright 10-1-2014 Ajency.in
 */

(function ($) {
	"use strict";
	$(function () {
		var baseURl = 'http://localhost/wordpress/';
		$('button.all-roles').click(function(){
			$.get(baseURl + 'wp-json/roles', {}, function(){
				console.info(arguments);
			},'json')
		});

		$('button.add-role').click(function(){

			$.ajax({
				url : WP_API_Settings.root + '/roles',
				type : 'POST',
				beforeSend : function(xhr){
					xhr.setRequestHeader('X-WP-Nonce', WP_API_Settings.nonce);
				},
				data : {
					role_name : 'test_role',
					display_name : 'New Role',
					capabilities : {'cap_name' : true},
					inherit_from : 'author'
				},
				success : function(){
						console.info(arguments[0]);
				}
			})
		});

		$('button.delete-role').click(function(){
			$.ajax({
				url : baseURl + 'wp-json/roles/administrator',
				type : 'DELETE',
				data : {},
				beforeSend : function(xhr){
					xhr.setRequestHeader('X-WP-Nonce', WP_API_Settings.nonce);
				},
				dataType: 'json',
				success : function(){
					console.info(arguments[0]);
				}
			});
		});

		$('button.edit-role').click(function(){
			$.ajax({
				url : baseURl + 'wp-json/roles/administrator',
				type : 'PUT',
				data : {
					capabilities : [{activate_plugins : false}]
				},
				success : function(){
					console.info(arguments);
				}
			});

		});
	});
}(jQuery));
