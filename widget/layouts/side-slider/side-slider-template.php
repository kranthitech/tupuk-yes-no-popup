<div id="tupuk-yes-no-popup-container" class="">
	<div class="yeloni-popup-block-container">
		<!-- the actual popup box -pageSider-->

		<!-- popup content -->
		<div class="yeloni-popup-content yeloni-popup-content-yesno">

			<div class="yeloni-ynlayout">

				<!-- close button-->
				<div class="yeloni-actual-content">

					<div class="yeloni-close-button">
						<img ng-src="{{plugin_path}}/common/images/close.png"></img>
					</div>

					<div class="yeloni-yn-content-topdata">
						
						<div class="yline1">
							<span editable>It's time you upgrade your skills</span></div>
						<br/><br/>
						<div class="yline2" editable>Want to learn how to get</div>
						<div class="yline3" editable>50000 subscribers</div>
						<div class="yline4" editable>for free?</div>							

						<hr/>
						<div class="yeloni-light-text" editable>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</div>
						
					</div>					

					<div class="yeloni-yn-content-buttons">
						<table width="100%" border="0">
							<tr>
								<td valign="top" width="50%">
									<a ng-href="{{settings.widget.url}}" ng-attr-target="{{(settings.widget.tab == 'newtab')?'_blank':''}}">
										<button class="yeloni-yn-yesbutton"><span class="yeloni-superlarge" editable>Yes</span><br/><span editable>I Love Customers</span></button>
									</a>
								</td>
								<td valign="top" width="50%">										
									<button class="yeloni-yn-nobutton"><span class="yeloni-superlarge" editable>No</span><br/><span editable>I don't like them</span></button>
								</td>
							</tr>
						</table>
						
					</div>

				</div>

			</div><!-- end yeloni-ynlayout -->

		</div>
		<div style="clear:both"></div>
	</div>
</div>