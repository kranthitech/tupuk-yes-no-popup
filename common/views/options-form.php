<script type="text/javascript">
	var tupuk_widget_settings = "<?php echo get_option( 'tupuk_settings' ); ?>";
	var tupuk_widget_active = "<?php echo get_option( 'tupuk_active' ); ?>";
  console.log('tupuk_widget_active- '+tupuk_widget_active)
</script>
<form method="post" action="options.php">
<?php
  settings_fields( 'tupuk-'.($this->tupuk_tag).'-options' );
  do_settings_sections( 'tupuk-'.($this->tupuk_tag).'-options' );
?><table class="form-table">
    <tr valign="top">   
   	<td><input id="widget_active_field" type="checkbox" name="tupuk_active" ?></td>
    <td><input id="widget_settings_field" type="text" name="tupuk_settings" value="<?php echo get_option( 'tupuk_settings' ); ?>"/></td>
    <td><input id="widget_template_field" type="text" name="tupuk_template" value="<?php echo get_option( 'tupuk_template' ); ?>"/></td>
    </tr>
  </table>
<?php submit_button();?>
</form>