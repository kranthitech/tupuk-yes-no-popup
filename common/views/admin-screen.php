<script type="text/javascript">
	var tupuk_plugin_path = "<?php echo plugins_url( 'tupuk-test');?>";
	console.log('plugin path- '+tupuk_plugin_path);
</script><?php 
wp_enqueue_style('tupuk-bootstrap');
wp_enqueue_style('tupuk-angular-toggle-switch');
wp_enqueue_script('tupuk-bootstrap');
wp_enqueue_script('tupuk-angular');
wp_enqueue_script('tupuk-angular-base64');
wp_enqueue_script('tupuk-angular-animate');
wp_enqueue_script('tupuk-api-check');
wp_enqueue_script('tupuk-angular-formly');
wp_enqueue_script('tupuk-formly-bootstrap');
wp_enqueue_script('tupuk-angular-ui-bootstrap');
wp_enqueue_script('tupuk-angular-toggle-switch');
wp_enqueue_script('tupuk-admin-core');
?><div ng-app="tupukAdmin" class="container-fluid" ng-controller="tupukAdminController">
	<hr>
	<h3>Setup your Tupuk Sample Widget</h3>
	<hr>
		<toggle-switch ng-model="widgetActive" on-label="Enabled" off-label="Disabled">
		</toggle-switch>
	<hr>
	<accordion close-others="'true'">
		<accordion-group heading="Display" is-open="'true'">
			<!-- Render Layouts in Radio Buttons -->
			Select Layout: 
			<label ng-repeat="layout in widgetDetails.layouts">
				<input type="radio" ng-model="layout.current" value="red">
				{{layout}}
			</label><br/>
			selected - {{layout.current}}
			
			<!-- Render the template, either directly from the file, or from saved variable -->
			<div ng-repeat="layout in widgetDetails.layouts" ng-include="layout">

			</div>	  
		</accordion-group>

		<accordion-group heading="Settings">
		  <div class="row">
		  	<div class="col-md-6 col-xs-12">
		  		<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">Sample</h3>
				  </div>
				  <div class="panel-body">
				    <formly-form ng-if="widgetFields" model="settings.widget" fields="widgetFields">
					</formly-form>
				  </div>
				</div>
		  	</div>

		  	<div class="col-md-6 col-xs-12">
		  		<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">General</h3>
				  </div>
				  <div class="panel-body">
				    <formly-form ng-if="widgetFields" model="settings.general" fields="general">
					</formly-form>
				  </div>
				</div>
		  	</div>
		  	
		  </div>
		</accordion-group>

	</accordion>

	<script type="text/ng-template" id="editableInput.html">
	    <div class="modal-header">
	        <h3 class="modal-title">Enter new text</h3>
	    </div>
	    <div class="modal-body">
	        <textarea class="form-control" ng-model="inner" ></textarea>
	    </div>
	    <div class="modal-footer">
	        <button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
	        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
	    </div>
	</script>

	<?php
		$num_layouts = count($tupuk_layouts);
		for($i =0; $i< $num_layouts;$i++){
			//echo each layout within a script tag
			echo "<script type='text/ng-template' id='".($tupuk_layouts[$i])."'>";
			include ($tupuk_plugin_path)."/widget/layouts/".($tupuk_layouts[$i]).".php";
			echo "</script>";
		}
	?>
</div><?php include 'options-form.php';?>