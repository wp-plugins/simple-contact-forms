<?php

/**
 * Provide a dashboard view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    simple_contact_forms
 * @subpackage simple_contact_forms/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<style type="text/css">
	.wp-list-table .column-col_link_id { width: 8%; }
	.wp-list-table .column-col_link_label { width: 25%; }
	.wp-list-table .column-col_link_type { width: 15%; }
	.wp-list-table .column-col_link_options { width: 25%; }
	.wp-list-table .column-col_link_required { width: 10%; }
	.wp-list-table .column-col_link_exclude { width: 10%; }
	.wp-list-table .column-col_link_delete { width: 7%; }
</style>

<?php 

include ('SCFOptions.php');
$options = new SCFOptions();
if( !empty($_POST) ) $options->set();
$vals = $options->get();

include ('Form_List_Table.php');
$wp_list_table = new scf_Form_List_Table();
$wp_list_table->setPassedOptions($vals);
$wp_list_table->prepare_items();

?>

<div class="settings-holder">

	<div class="credits-box">
		<h3 class="hndle">Simple Contact Forms v1.0.1</h3>
		<div class="inside">

			<h4 class="inner">How to use Simple Contact Forms</h4>
			<p class="inner">The contact form can be displayed on your site in three ways:</p>
			<p class="inner">
				1. Shortcode<br />
				2. Function<br />
				3. Widget
			</p>
			<p class="inner">All methods accept options to change some of the default settings.</p>

			<h4 class="inner">Using the shortcode</h4>
			<p class="inner"><em>[simple_contact_form]</em></p>

			<h4 class="inner">Using the PHP Function</h4>
			<p class="inner"><em>simple_contact_form($options = array());</em></p>

			<h4 class="inner">Options</h4>
			<ul class="inner">
				<li><strong>width: </strong><em>String</em> (full-width|narrow)</li>
				<li><strong>button: </strong><em>Boolean</em></li>
				<li><strong>btn_text: </strong><em>String</em></li>
				<li><strong>form_title: </strong><em>String</em></li>
				<li><strong>form_collapse: </strong><em>Boolean</em></li>
				<li><strong>email_subject: </strong><em>String</em></li>
				<li><strong>form_title: </strong><em>String</em></li>
				<li><strong>return: </strong><em>Boolean</em> (echoes if false)</li>
			</ul>

			<p class="inner"><a href="https://github.com/owenr88/Simple-Contact-Forms" target="_blank">View the GitHub page for more uses and options.</a></p>
			<hr>

			<h4 class="inner">Need support?</h4>
			<p class="inner">If you are having problems with this plugin, please talk about them in the <a href="#" target="_blank" title="Support forum">Support forum</a></p>
			
			<hr>
			<h4 class="inner">Do you like this plugin?</h4>
				<p class="inner"><a href="http://wordpress.org/support/view/plugin-reviews/simple-contact-forms" target="_blank" title="Rate it 5">Rate it 5</a> on WordPress.org <br>
			</p>    
			<hr>

			<p class="df-link inner">Created by <a href="http://www.biglemoncreative.co.uk" target="_blank" title="Big Lemon Creative">Big Lemon Creative</a></p>

		</div>
	</div>

	<form method="post" class="scf-form" action="">
		<h2>Simple Contact Forms</h2>
		
		<p class="inner">This plugin is designed to strip all the faff so you can drop in contact forms where you want and how you want.</p>

		<h3>Form Generation Options</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="form_title">Form Title</label></th>
					<td>
						<input name="form_title" id="form_title" type="text" value="<?=$vals['form_title']?>" class="regular-text" />
						<p class="description">Title to be displayed at the top of each form. Use something enticing!</p>
					</td>
				</tr>
				<tr>
					<th><label for="form_styling">Form Styling</label></th>
					<td>
						<select disabled name="form_styling" id="form_styling" class="postform do_hide" value="<?=$vals['form_styling']?>">
							<option value='bootstrap'>Bootstrap
						</select>
						<p class="description">Select the styling required. More to come soon!</p>
					</td>
				</tr>
				<div class="show_form_styling_bootstrap hide_form_styling_" <?=($vals['form_styling']!='bootstrap'?' style="display:none;"':'')?>>
					<tr>
						<th></th>
						<td>
							<label for="include_bootstrap">
								<input type="hidden"   name="include_bootstrap" value="false" />
								<input type="checkbox" name="include_bootstrap" value="true" id="include_bootstrap" <?=($vals['include_bootstrap']=='true'?'checked':'')?>> Include Bootstrap
							</label>
						</td>
					</tr>
					<tr>
						<th></th>
						<td>
							<label for="include_fontawesome">
								<input type="hidden"   name="include_fontawesome" value="false" />
								<input type="checkbox" name="include_fontawesome" value="true" id="include_fontawesome" <?=($vals['include_fontawesome']=='true'?'checked':'')?>> Include FontAwesome
							</label>
						</td>
					</tr>
				</div>
				<tr>
					<th></th>
					<td>
						<label for="submit_class">
							Submit Button Additional Classes
							<input type="text" name="submit_class" id="submit_class" value="<?=$vals['submit_class']?>" class="regular-text">
							<p class="description">i.e. btn-primary</p>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">Form Validation Settings</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Form Validation Settings</span></legend>
							<label for="validation_enable">
								<input type="hidden"   name="validation_enable" value="false" />
								<input type="checkbox" name="validation_enable" value="true" id="validation_enable" <?=($vals['validation_enable']=='true'?'checked':'')?> class="do_hide"> Enable Form Validation (Recommended)
							</label>
							<br>
							<div class="show_validation_enable_true hide_validation_enable_false">
								<label for="validation" >Vaidation Format
									<select name="validation" id="validation" class="postform do_hide">
										<option value="recaptcha" disabled <?=($vals['validation']=='recaptcha'?'selected':'')?>>reCAPTCHA
										<option value="maths" <?=($vals['validation']!='recpatcha'?'selected':'')?>>Mathamatical test
									</select>
									<p class="description">reCAPTCHA soming soon!</p>
								</label>
								<br>
								<div class="hide_validation_maths show_validation_recaptcha">
									<label for="recaptcha_public">reCAPTCHA Site Key</label>
									<input name="recaptcha_public" id="recaptcha_public" type="text" value="<?=$vals['recaptcha_public']?>" class="regular-text" />
									<br>
									<label for="recaptcha_private">reCAPTCHA Secret Key</label>
									<input name="recaptcha_private" id="recaptcha_private" type="text" value="<?=$vals['recaptcha_private']?>" class="regular-text" />
									<p class="description">Your site and secret reCAPTCHA keys are required to use this. <a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">Get them here.</a> The form will default to a mathamatical test if there are no keys provided</p>
								</div>
							</div>
						</fieldset>
					</td>
				</tr>
				<tr>
					<th scope="row">Button Display Settings</th>
					<td>
						<fieldset>
							<legend class="screen-reader-text"><span>Button Display Settings</span></legend>
							<label for="display_button">
								<input type="hidden"   name="display_button" value="false" />
								<input type="checkbox" name="display_button" value="true" id="display_button" <?=($vals['display_button']=='true'?'checked':'')?> class="do_hide"> Display a button to collapse/uncollapse the form
							</label>
							<br>
							<div class="show_display_button_true hide_display_button_false">
								<label for="default_collapse">
									<input type="hidden"   name="default_collapse" value="false" />
									<input type="checkbox" name="default_collapse" value="true" id="default_collapse" <?=($vals['default_collapse']=='true'?'checked':'')?>> Collapse the form by default
								</label>
								<br>
								<label for="button_text">
									Button Text 
									<input type="text" name="button_text" id="button_text" value="<?=$vals['button_text']?>" class="regular-text">
								</label>
								<br>
								<label for="button_class">
									Additional Button Classes
									<input type="text" name="button_class" id="button_class" value="<?=$vals['button_class']?>" class="regular-text">
									<p class="description">i.e. btn-primary</p>
								</label>
								<br>
								<label for="button_icon_side">Show an icon in the button 
									<select name="button_icon_side" id="button_icon_side" class="postform do_hide">
										<option value="" <?=($vals['button_icon_side']==''?'selected':'')?>>-- No Icon --
										<option value="right" <?=($vals['button_icon_side']=='right'?'selected':'')?>>On the Right
										<option value="left" <?=($vals['button_icon_side']=='left'?'selected':'')?>>On the Left
									</select>
								</label>
								<br>
								<label for="button_icon" class="show_button_icon_side_left show_button_icon_side_right hide_button_icon_side_">Button icon to show (FontAwesome)
									<input name="button_icon" id="button_icon" class="all-options" value="<?=$vals['button_icon']?>" placeholder="fa-comments" />
								</label>
								<br>
							</div>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table> 


		<h3>Form Completion Options</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="send_to">Destination Page</label></th>
					<td>
						<select name="send_to" id="send_to" class="postform" value="<?=$vals['send_to']?>">
							<option value="" <?=($vals['send_to']==''?'selected':'')?>>Same Page as form (default)
							<?php 

							$cpt = get_post_types(
								array(
									'_builtin'	=> false,
									'public'	=> true
								),
								'objects',
								'and'
							);

							array_unshift(
								$cpt, 
								(object) array( 
									'name'	=> 'post',
									'label' => 'Posts'
								),
								(object) array(
									'name'	=> 'page',
									'label' => 'Pages'
								)
							);

							foreach ( $cpt as $pt ) {

								$posts = get_posts( array(
									'post_type' 		=> $pt->name,
									'posts_per_page' 	=> -1,
									'orderby'			=> 'title',
									'order'				=> 'ASC'
								) ); 

								if(count($posts) > 0) echo '<option disabled>---<option disabled><strong>' . $pt->label . '</strong>';

								foreach ( $posts as $page ) {
								  	$option = '<option value="' . get_page_link( $page->ID ) . '" '. ($vals['send_to']==get_page_link( $page->ID )?'selected':'') . '>';
									$option .= $page->post_title;
									$option .= '</option>';
									echo $option;
							 	}

							}

							?>
						</select>
						<p class="description">Select what page the user should be sent to after completing. If the form shortcode or function is present then the success message will be shown.</p>
					</td>
				</tr>
				<tr>
					<th><label for="email_recipients">Email Address</label></th>
					<td>
						<input name="email_recipients" id="email_recipients" type="text" value="<?=$vals['email_recipients']?>" class="regular-text" />
						<p class="description">Where should the enquiries be sent to? To add multiple addresses, separate them with a comma. <br /> e.g.  cool@example.com,awesome@example.com</p>
					</td>
				</tr>
				<tr>
					<th><label for="email_subject">Email Subject</label></th>
					<td>
						<input name="email_subject" id="email_subject" type="text" value="<?=$vals['email_subject']?>" class="regular-text" />
						<p class="description">This can also be changed for each form instance.</p>
					</td>
				</tr>
				<tr>
					<th><label for="success_msg">Success Message</label></th>
					<td> 
						<?php wp_editor($vals['success_msg'],'successmsg', array(
							'textarea_rows' => 10,
							'textarea_name' => 'success_msg'
						)); ?>
						<p class="description">This is displayed when the form has been submitted and all data is correct.</p>
					</td>
				</tr>
			</tbody>
		</table>

		<input class="button-primary" type="submit" value="<?php _e('Save Settings'); ?>" />

	</form>

</div>

<div class="clear"></div>
<br />
<br />

<hr />


<form method="post" action="" style="padding-right: 20px;">

	<h3>Fields</h3>

		<?php $wp_list_table->display();?>
		<input class="button-secondary add-field" type="button" value="<?php _e('Add a new Field'); ?>" style="float:right;" />
		<p>PLEASE NOTE: It's strongly adviced that you select at least one field as a Name or Email Address field type so you know who the enquiry is coming from!</p>

	<br />
	<br />
	<input class="button-primary" type="submit" value="<?php _e('Save Fields'); ?>" />

</form>