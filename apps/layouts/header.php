<header class="header">
				
                <div class="logo-container">
					<a href="../" class="logo">
				
                <img src="assets/images/logo.png" height="40" alt="SIMRS" /></a>
                <a href="../" class="logo">
					<img src="assets/images/logo.png"" width="75" height="35" alt="Porto Admin" />
				</a>
				<button class="btn header-btn-collapse-nav d-lg-none" data-toggle="collapse" data-target=".header-nav">
					<i class="fas fa-bars"></i>
				</button>

                <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
                </div>
				<div class="header-right">
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								 <img src="assets/images/!logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
								
                              </figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name"><?php echo $_SESSION[NAMA_PEG]?></span>
                                
								<span class="role"><?php echo $_SESSION[NAMA_DIV]?></span>
							</div>
							<i class="fa custom-caret"></i>
						</a>
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<!--<li>
									<a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>-->
								<li>
									<a role="menuitem" tabindex="-1" href="index.php?x=cpassword"><i class="fa fa-user"></i> Ubah password</a>
								</li>
                                <li>
									<a role="menuitem" tabindex="-1" href="apps/layouts/logout.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>