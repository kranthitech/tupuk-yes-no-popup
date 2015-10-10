
<script type="text/javascript">
	var tupuk_trigger = "tupuk_page_exit";	
</script>

<link rel="stylesheet" type="text/css" href="<?php echo $this->get_container_css_path()?>">
<link rel="stylesheet" type="text/css" href="<?php echo $this->get_layout_css_path()?>">

<div class="tupuk-blog-page-container">
	<div class="tupuk-layout-<?php echo $this->get_current_layout()?>">
		<?php if(get_option( 'tupuk_widget_active' )){
				wp_enqueue_script('client-core');

				echo $this->get_current_template();
			}
		?>
	</div>
</div>