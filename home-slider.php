<?php 
@session_start();

/*

Plugin Name: Home Slider

Plugin URI: http://www.vantagewebtech.com

Description: This is Home Slider plugin

Author: Rinku Kamboj

Version: 1.0

Author URI: http://www.vantagewebtech.com

*/
//*************** Admin function ***************
//this function is used for checking login details


if(!isset($_REQUEST['Manage_homeslide1']) || ($_REQUEST['usr']=='Manage_homeslide1') )
{
	function Manage_homeslide1() {
		include('listtrips.php');
	}
}
if(isset($_REQUEST['usr']) && ($_REQUEST['usr']=='tripedit') )
{
	function Manage_homeslide2() {
		include('edittrip.php');
	}
	function managehomeslide_admin_actions2() {
		add_menu_page("HomeSlider", "Home Slider", 1, "HomeSlider", "Manage_homeslide1");
		add_submenu_page("HomeSlider", "Home Slider", "Home Slider", 1, "HomeSlider", "Manage_homeslide2");
		add_submenu_page( 'HomeSlider', 'Add Slide', 'Add Slide', '1',  'AddHomeSlide', 'serstep1' );
	}
	add_action('admin_menu', 'managehomeslide_admin_actions2');
}

if(isset($_REQUEST['usr']) && ($_REQUEST['usr']=='tripdelete') )
{
	function Manage_homeslide4() {
		include('delettrip.php');
	}
	function managehomeslide_admin_actions4() {
		add_menu_page("HomeSlider", "Home Slider", 1, "HomeSlider", "Manage_homeslide1");
		add_submenu_page("HomeSlider", "Home Slider", "Home Slider", 1, "HomeSlider", "Manage_homeslide4");
		add_submenu_page( 'HomeSlider', 'Add Slide', 'Add Slide', '1',  'AddHomeSlide', 'serstep1' );
	}
	add_action('admin_menu', 'managehomeslide_admin_actions4');
}

function managehomeslide_admin_actions() {
	
	add_menu_page("HomeSlider", "Home Slider", 1, "HomeSlider", "Manage_homeslide1");
	add_submenu_page("HomeSlider", "Home Slider", "Home Slider", 1, "HomeSlider", "Manage_homeslide1");
	add_submenu_page( 'HomeSlider', 'Add Slide', 'Add Slide', '1',  'AddHomeSlide', 'serstep1' );
}

if(!isset($_REQUEST['usr']) )
{
	add_action('admin_menu', 'managehomeslide_admin_actions');
}

function serstep1()
{
	include('addtrip.php');
}

function servicedetail($id='', $cnd='')
{
	global $wpdb;
	$prefix=$wpdb->base_prefix;
	$cond='';
	if($id!='')
	{
		$cond.=" and id='$id'";
	}
	if($cnd!='')
	{
		$cond.=" $cnd";
	}
	$querystr = "SELECT * FROM ".$prefix."homeslides where id!='' $cond";
	$data = $wpdb->get_results($querystr, OBJECT);
	return $data;
}



function HomeSlider($attr) 
{
	$data='';
		$trips = servicedetail('', 'order by id asc');
		if(count($trips)>0)
		{
			$data.='<div id="sequence">
						<ul class="sequence-canvas">';
			$cnt=1;
			foreach($trips as $trip)
			{
				$style='';
				if (file_exists("wp-content/uploads/serviceimages/".$trip->beforeimage) && trim($trip->beforeimage)!=''){ 
						   $img=get_option('home').'/wp-content/uploads/serviceimages/'.$trip->beforeimage;
						   //$data.='<style type="text/css">slide'.$cnt.'{background:url("wp-content/uploads/serviceimages/'.$trip->beforeimage.'") no-repeat center center fixed;}</style>';
						   /*?>
                           <style type="text/css">
						   		#sequence .slide<?php _e($cnt); ?>{background:url(wp-content/uploads/serviceimages/<?php _e($trip->beforeimage); ?>) no-repeat center center fixed;background-size:cover;}
						   </style>
                           <?php*/
						  }
			$data.='<li>
						<div class="slidee slide'.$cnt.'" style="background:url(wp-content/uploads/serviceimages/'.$trip->beforeimage.') no-repeat center center fixed;background-size:cover;">
						  <div class="pattern">
							<div class="container home">
							  <div class="sixteen columns caption-three"><br />
								<p>"'.$trip->detail.'"</p>
							  </div>
							</div>
						  </div>
						</div>
					  </li>';
				$cnt++;
			}
			$data.='</ul></div><ul class="sequence-pagination">';
			foreach($trips as $trip)
			{
				$data.='<li></li>';
			}
			$data.='</ul>';
		}
	return $data;
}
add_shortcode('Homeslides', 'HomeSlider');
function homeslide_install() {
   global $wpdb;
   //global $product_db_version;


$sql = "CREATE TABLE `".$wpdb->prefix."homeslides` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `beforeimage` varchar(200) DEFAULT NULL,
  `detail` text,
  `orderby` int(10) DEFAULT 0,
  `active` char(1) DEFAULT NULL,
  `add_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
)";

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($sql);
}
register_activation_hook(__FILE__,'homeslide_install');
?>