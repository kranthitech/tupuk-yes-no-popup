
<script type="text/javascript">
	var plugin_path = "<?php echo $this->tupuk_plugin_path;?>"
	var plugin_name = "<?php echo $this->tupuk_tag; ?>"
	var container_id = "tupuk-"+plugin_name+"-container"
	console.log('plugin path- '+plugin_path);
</script>

<div ng-app="tupukAdmin" class="container-fluid" ng-controller="tupukAdminController" ng-cloak>
	<hr>
	<h3>Tupuk <?php echo $this->tupuk_label ?></h3>
	<hr>
	
	<accordion close-others="'true'">
		<accordion-group heading="Display" is-open="'true'">
			<!-- Render Layouts in Radio Buttons -->
			{{widgetDetails}}<br>
			<div class="row">
				<div class="col-md-1 col-xs-12">
					Select Layout
				</div>
				<div class="col-md-11 col-xs-12">
					<label ng-repeat="L in widgetDetails.layouts">
						<input type="radio" ng-model="settings.layout" value="{{L}}">
						{{L}}
					</label>
				</div>
			</div>

			<!-- Render the template, either directly from the file, or from saved variable -->
			
			<div class="row" ng-repeat="L in widgetDetails.layouts" ng-if="settings.layout== L" ng-cloak>
				<link rel="stylesheet" type="text/css" ng-attr-href="{{plugin_path}}/widget/layouts/{{L}}/{{L}}-style.css">

				<div class="col-md-12"  ng-if="!encodedTemplates[L]" ng-include="layoutTemplateUrl(L)">

				</div>
				<div class="col-md-12" ng-if="encodedTemplates[L]" bind-html-compile="layoutTemplates[L]">
					{{layoutTemplates[L]}}
				</div>	
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
	<hr>
		<toggle-switch ng-model="widgetActive" on-label="Enabled" off-label="Disabled">
		</toggle-switch>
	<hr>
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
</div>
<?php include 'options-form.php';?>