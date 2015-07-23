<?php

/**
 * Show the forms tab
 *
 * @since      1.2.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/admin/views
 */


// Create the fields table
include( plugin_dir_path( __FILE__ ) . "../partials/scf_fields_table.php" );
$fields_table = new scf_Fields_Table();
$fields_table->setPassedOptions($vals);
$fields_table->prepare_items();

?>

<style type="text/css">
	.wp-list-table .column-col_fields_id { width: 8%; }
	.wp-list-table .column-col_fields_label { width: 25%; }
	.wp-list-table .column-col_fields_type { width: 15%; }
	.wp-list-table .column-col_fields_options { width: 25%; }
	.wp-list-table .column-col_fields_required { width: 10%; }
	.wp-list-table .column-col_fields_exclude { width: 10%; }
	.wp-list-table .column-col_fields_delete { width: 7%; }
</style>


<form method="post" action="" style="padding-right: 20px; float: left;">

	<h3>Fields</h3>

		<?php $fields_table->display();?>
		<input class="button-secondary add-field" type="button" value="<?php _e('Add a new Field'); ?>" style="float:right;" />
		<p>PLEASE NOTE: It's strongly adviced that you select at least one field as a Name or Email Address field type so you know who the enquiry is coming from!</p>

	<br />
	<br />
	<input class="button-primary" type="submit" value="<?php _e('Save Fields'); ?>" />

</form>