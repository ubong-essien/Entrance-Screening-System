<div onmouseover="putme.allAnimations.sideBarLeftOver('gethidden')" onmouseout="putme.allAnimations.sideBarLeftOut('gethidden')" style="position: absolute;left:0;top:0;width:49px;height:100%;cursor:pointer;">
			<!-- just icons -->
			 <div id="gethidden" style="width:49px;height:inherit;background-color:black;z-index: 3;box-shadow: 1px 1px 3px lightgrey;overflow-x: hidden;transition: 0.5s;">
				<div class=" w3-text-white" style="width: 150px;">
					<div style="width:100%;margin-top:0px;border-bottom:solid thin #aaaaaa33;">
						<div class="putme-displ-inl-sidbr">
							<img class="w3-circle" src="Images/duke.jpg" alt="" width="40" height="40" style="margin-left:-8px;">
						</div>
						<div class="putme-displ-inl-sidbr">Duke</div>
					</div>
					<div onclick="putme.allAnimations.shHome('exitHomePage');" class="putme-hover-sidBtn" style="width:100%;padding: 1px;margin-top:30px;">
						<div class="putme-displ-inl-sidbr">
							<i class="fa fa-home w3-large"></i>
						</div>
						<div class="putme-displ-inl-sidbr">HOME</div>
					</div>
					<div onclick="putme.allAnimations.putmeLoading.mainInitLoading()" title="RELOAD CANDIDATE" class="putme-hover-sidBtn" style="width:100%;padding: 1px;margin-top:1px;">
						<div class="putme-displ-inl-sidbr">
							<i class="fa fa-refresh w3-large"></i>
						</div>
						<div class="putme-displ-inl-sidbr">RELOAD</div>
					</div>
					<div onclick="putme.allAnimations.shLgin();//window.location = 'index.php'" class="putme-hover-sidBtn" style="width:100%;padding: 1px;margin-top:1px;">
						<div class="putme-displ-inl-sidbr">
							<i class="fa fa-power-off w3-large"></i>
						</div>
						<div class="putme-displ-inl-sidbr">LOGOUT</div>
					</div>
					<div onclick="//window.location = 'index.php'" class="putme-hover-sidBtn" style="width:100%;padding: 1px;margin-top:1px;">
						<div class="putme-displ-inl-sidbr">
							<i class="fa fa-cog w3-large"></i>
						</div>
						<div class="putme-displ-inl-sidbr">SETTINGS</div>
					</div>
					<div title="LOCK SCREEN" onclick="putme.allAnimations.Pin.shPin()" class="putme-hover-sidBtn" style="width:100%;padding: 1px;margin-top:1px;">
						<div class="putme-displ-inl-sidbr">
							<i class="fa fa-key w3-large"></i>
						</div>
						<div class="putme-displ-inl-sidbr">LOCK</div>
					</div>
				</div>
			</div>
</div>