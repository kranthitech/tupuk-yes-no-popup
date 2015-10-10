<script type="text/javascript">
	var tupuk_widget_settings = "<?php echo get_option( 'tupuk_widget_settings' ); ?>";
	var tupuk_widget_active = "<?php echo get_option( 'tupuk_widget_active' ); ?>";
  console.log('tupuk_widget_active- '+tupuk_widget_active)
</script>
<form method="post" action="options.php">
<?php
  settings_fields( 'tupuk-sample-widget-options' );
  do_settings_sections( 'tupuk-sample-widget-options' );
?><table class="form-table">
    <tr valign="top">   
   	<td><input id="widget_active_field" type="checkbox" name="tupuk_widget_active" ?></td>
    <td><input id="widget_settings_field" type="text" name="tupuk_widget_settings" value="<?php echo get_option( 'tupuk_widget_settings' ); ?>"/></td>
    <td><input id="widget_template_field" type="text" name="tupuk_widget_template" value="<?php echo get_option( 'tupuk_widget_template' ); ?>"/></td>
    </tr>
  </table>
<?php submit_button();?>
</form>