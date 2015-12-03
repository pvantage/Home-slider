<?php 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$id=$_REQUEST['id'];
	$trip = servicedetail($id);
	$image=$trip[0]->image;
	if (file_exists("../wp-content/uploads/serviceimages/".$image) && trim($image)!=''){ unlink("../wp-content/uploads/serviceimages/".$image);}
	$result=$wpdb->query( "DELETE FROM `".$prefix."homeslides` where id='$id'" );
	if($result==1) { 
		$url=get_option('home').'/wp-admin/admin.php?page=HomeSlider&del=succ';
		echo"<script>window.location='".$url."'</script>";
	}

 ?>