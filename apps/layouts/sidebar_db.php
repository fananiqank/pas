	<?php
	// session_start();
	// include "../../webclass.php";
	// $db=new kelas();
	// echo "<pre>";
	// print_r($_SESSION['MENU']);
	// print_r($cc);
	// echo "</pre>";
	?>
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
	<div class="main-menu-content">		
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
			 
            <li class=" nav-item"><a href="index.php" target="_self"><i class="la la-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a></li>
			<?php
			$act="";
			foreach($_SESSION['MENU'] as $key => $vmenu)
			{
				if($vmenu[SLUG]==$_GET[x] AND !empty($_GET[x])){
					$act="active";
				} else {
					$act="";
				}
				if($vmenu[SLUG]==''){
					// $menu[]=
					echo "
							

							<li class=\"nav-parent $act\">
                            <a>
								<i class=\"la $vmenu[ICON]\" aria-hidden=\"true\"></i>
								<span>$vmenu[NAMA]</span>
							</a>";
					
				} else {
					echo "<li class=\"$act\">
								<a href=\"index.php?x=$vmenu[SLUG]\">
									<i class=\"la la-sign-out\" aria-hidden=\"true\"></i>
									<span>$vmenu[NAMA]</span>
								</a>
                            </li> ";

				}
					
					if(count($vmenu[CHILD1])>0){
						echo "<ul class=\"menu-content\">";
					}
					foreach($vmenu[CHILD1] as $key2 => $vchild){
						if($vchild[SLUG]==$_GET[x] AND !empty($_GET[x])){
							$act="active";
						} else {
							$act="";
						}											
						if(count($vchild[CHILD2])>0){
						
						echo "

								<li class=\"nav-parent $act\">
                                    <a>
                                        
                                        <span>$vchild[NAMA]</span>
                                    </a>
                                ";
                        } else {

      					// $content=$vchild[FCONTENT];
						// $contenttitle=$vchild[NAMA];
						// $js=$vchild[FJS];
                        echo "<li class=\"$act\">
                                    <a href=\"index.php?x=$vchild[SLUG]\">
                                        
                                        <span>$vchild[NAMA]</span>
                                    </a>
                                </li>";
                        }
								if(count($vchild[CHILD2])>0){
									echo "<ul class=\"nav nav-children\">";
								foreach($vchild[CHILD2] as $key3 => $vchild2){
									if($vchild2[SLUG]==$_GET[x] AND !empty($_GET[x])){
										$act="active";
									} else {
										$act="";
									}
									
									echo "<li class=\"$act\">
                                                <a href=\"index.php?x=$vchild2[SLUG]\">
                                                    <span>$vchild2[NAMA]</span>
                                                </a>
                                            </li>";
         //                            $content=$vchild[FCONTENT];
									// $contenttitle=$vchild[NAMA];
									// $js=$vchild[FJS];
								}
									
									echo "</li></ul>";
								}
					}
					if(count($vmenu[CHILD1])>0){
						echo "</ul>";
					}

			}
			?>   
				</ul>
			
		</div>

	</div>