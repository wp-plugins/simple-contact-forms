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
include( plugin_dir_path( __FILE__ ) . "../partials/scf_completions_table.php" );
$completions_table = new scf_Completions_Table();
$completions_table->form_id = 0;
$completions_table->prepare_items();

?>

<style type="text/css">
	.wp-list-table .column-col_completion_time { width: 20%; }
	.wp-list-table .column-col_completion_data { width: 50%; }
	.wp-list-table .column-col_completion_location { width: 30%; }
</style>


<h3>Completions</h3>
<div style="float: left;">
	<?php $completions_table->display();?>
</div>