<?php 
global $wpdb,$signature;
$prefix=$wpdb->base_prefix;
$error=array();
$id=$_REQUEST['id'];
$trip = servicedetail($id);
$title=$trip[0]->title;
$beforeimage=$trip[0]->beforeimage;
$detail=$trip[0]->detail;
$active=$trip[0]->active;

if(isset($_POST['registration']))
{
	$title=$_POST['title'];
	$detail=$_POST['detail'];
	$aliasbeforeimagetitle='banner-'.$id;
	
	$file='beforeimage';
	if(isset($_FILES[$file]['name']))
	{
		if($_FILES[$file]['name']!='')
		{
			if ( (strtolower($_FILES[$file]["type"]) == "image/gif")
			|| (strtolower($_FILES[$file]["type"]) == "image/jpeg")
			|| (strtolower($_FILES[$file]["type"]) == "image/jpg")
			|| (strtolower($_FILES[$file]["type"]) == "image/png")
			|| (strtolower($_FILES[$file]["type"]) == "image/pjpeg"))
			  {
				if ($_FILES[$file]["error"] > 0)
				{
					 echo "Error: " . $_FILES[$file]["error"] . "<br />";
				}
				else
				{
					if (!is_dir('../wp-content/uploads/serviceimages')) {
						mkdir('../wp-content/uploads/serviceimages');
					}
					if (file_exists("../wp-content/uploads/serviceimages/".$beforeimage) && trim($beforeimage)!=''){ unlink("../wp-content/uploads/serviceimages/".$beforeimage);}
					$exts=explode('.',$_FILES[$file]["name"]);
					$exten='.'.$exts[count($exts)-1];
					$altername=$aliasbeforeimagetitle.$exten;
					move_uploaded_file($_FILES[$file]["tmp_name"], "../wp-content/uploads/serviceimages/" . $_FILES[$file]["name"]);
					rename("../wp-content/uploads/serviceimages/".$_FILES[$file]["name"], "../wp-content/uploads/serviceimages/$altername");
					$sql="UPDATE `".$prefix."homeslides` set beforeimage='$altername' where id='$id'";
					$result = $wpdb->query( $sql );
				}
			}
		}
	}
	
	if(count($error)<=0)
	{
		$sql="UPDATE `".$prefix."homeslides` set title='$title',detail='$detail' where id='$id'";
		$result = $wpdb->query( $sql );
		
		$url=get_option('home').'/wp-admin/admin.php?page=HomeSlider&add=succ';
		echo"<script>window.location='".$url."'</script>";
	}
}

?>
<style type="text/css">
.error
{
	color:#CC0000;
}
.donotshowerror label.error
{
	display: none !important;
}
label.error
{
	margin-left:10px;
}
input.error, select.error,textarea.error, checkbox.error
{
	color:#000000;
	border:1px solid #CC0000 !important;
}
input[type='checkbox'].error
{
	border: solid #CC0000;
	outline:1px solid #CC0000 !important;
}
.personal_info{float:left; width:160px;}
.e-mail{ clear:both;}
.adress{ width:168px; float:left; text-align:left; font-size:13px; color:#454546;}
.field{ float:left; width:600px;}
.field input, .field select{ width:324px; height:30px; padding:0 !important; border:1px solid #c7cecf;  border:1px solid #c7cecf; margin:0px 0px 10px 0; background:#f0f0f0; }
.field textarea{ width:500px; padding:0 !important; border:1px solid #c7cecf;  border:1px solid #c7cecf; margin:0px 0px 10px 0; background:#f0f0f0; }
.profile .green-submit-btn input[type="submit"], .profile .green-submit-btn input[type="button"]{ width:152px; border:1px solid #b4babb; height: 45px; line-height:45px; text-align:center; color:#000; font-size:17px; font-weight:bold; border-radius:5px; display:block; font-family:Arial, Helvetica, sans-serif; cursor:pointer; }
.profile .green-submit-btn input[type="button"]{ margin-left:20px;}
.field .wp-core-ui input, .field .wp-core-ui select{ width:auto; height:auto;}
input, select, textarea{float:left;}
.clr{clear:both; margin-top:10px;}.mr5{margin-right:5px;}
.fl{float:left;}.removeday, .addday{float:left; color:#FF0000; font-size:18px; text-decoration:none; margin-left:10px;}.addday{color:#0000FF;}
.tt{float:left; width:70px;}
.removedayimage{margin-left:5px; color:#FF0000;}
.sparator{width:600px; margin:5px 0px; height:1px; border-bottom:1px solid #000000;} 
.ml10{margin-left:10px;}
</style>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/home-slider/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo get_option('home');?>/wp-content/plugins/home-sliderHome Slider/js/validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	
	jQuery("#register_spcialist").validate();
	
});
</script>
<h2>Edit Service </h2>

	<div class="profile donotshowerror">
    	<?php if(count($error)>0)
		  { ?>
		<div class="tabletitle"><span class="error">Error</span></div>
		<table width="700" class="from_main" border="0" cellpadding="0" cellspacing="0">
		  <?php 
		   
			for($i=0;$i<count($error);$i++)
			{
				?>
			  <tr>
				<td align="left" valign="top" class="name"><span class="error"><?php echo $error[$i]; ?></span></td>
			</tr>
	<?php	} ?>
		</table>
		<div class="clr mt20"></div>
	 <?php } ?>
        <div class="right donotshowerror">
        	<form action="" method="post" name="register_spcialist" id="register_spcialist" enctype="multipart/form-data">
            	<input type="hidden" name="id" value="<?php _e($id); ?>" />
                <div class="e-mail">
                    <div class="adress">Title : </div>
                    <div class="field"><input type="text" name="title" value="<?php _e($title); ?>" /></div>
                </div>
                <div class="e-mail">
                    <div class="adress">Image :  </div>
                    <div class="field"><input type="file" name="beforeimage" />
                    	<?php if (file_exists("../wp-content/uploads/serviceimages/".$beforeimage) && trim($beforeimage)!=''){ ?>
                          <img style="border:1px solid #ccc;" src="<?php echo get_option('home'); ?>/wp-content/uploads/serviceimages/<?php _e($beforeimage); ?>" alt="" />
                    <?php } ?>
                    </div>
                </div>
                <div class="e-mail">
                    <div class="adress">Detail :  </div>
                    <div class="field" style="width:700px;"><textarea name="detail" rows="5" cols="50"><?php _e($detail); ?></textarea></div>
                </div>
                <div class="clr"></div>
                <div class="e-mail">
                    <div class="adress">&nbsp;&nbsp;</div>
                    <div class="field" style="margin-top:10px;">
                        <div class="green-submit-btn">
                        	<input type="submit" name="registration" value="SUBMIT" /> <input onclick="return backtolist()" type="button" name="back" value="Back" title="Back" />
                       
                         </div>
                    </div>
                </div>
                
            </form>
            </div>
        </div>
<div class="clr"></div>

<script type="text/javascript">
function backtolist()
{
	window.location='<?php echo get_option('home').'/wp-admin/admin.php?page=HomeSlider'; ?>';
}
</script>