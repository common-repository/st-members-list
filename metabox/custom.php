<?php 


add_action('cmb2_admin_init', 'extra_metabox_add_korbo');


function extra_metabox_add_korbo(){

	$boxes = new_cmb2_box(array(
		'title' => 'Additional fields',
		'id' => 'additional-fields',
		'object_types' => array('members_list')
	));


	$boxes->add_field(array(
		'id' => 'designation',
		'type' => 'text',
		'name' => 'Designation'
	));

	$boxes->add_field(array(
		'id' => 'facebook',
		'type' => 'text',
		'name' => 'Facebook Profile'
	));

	$boxes->add_field(array(
		'id' => 'twitter',
		'type' => 'text',
		'name' => 'Twitter Profile'
	));

	$boxes->add_field(array(
		'id' => 'short-description',
		'type' => 'wysiwyg',
		'name' => 'Short Description',
		'options' => array(
			'textarea_rows' => get_option('default_post_edit_rows', 4)
		)
	));




}