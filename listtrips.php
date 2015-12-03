<?php if(!isset($_REQUEST['usr']) )
{ 
	global $wpdb,$signature;
	$prefix=$wpdb->base_prefix;
	$blog_id = $wpdb->blogid;
	
	$totalrec=20;
	if(isset($_REQUEST['pagedid']) && $_REQUEST['pagedid']>1)
	{
		$pageid=$_REQUEST['pagedid'];
		$limitstart=$totalrec*($pageid-1);
	}
	else
	{
		$pageid=1;
		$limitstart=0;
		$limitsend=$totalrec;
	}
	
	
	$where=" order by id desc";
	$querystr = "SELECT * FROM ".$prefix."homeslides $where limit $limitstart, $totalrec";
	$trips = $wpdb->get_results($querystr, OBJECT);
	
	$querystr = "SELECT * FROM ".$prefix."homeslides $where";
	$totalphotos = $wpdb->get_results($querystr, OBJECT);
?>
<style type="text/css">
table td,table th{padding:5px;}
.pagination{ float:left; line-height:30px; font-size:14px; font-weight:bold;}
.pagination span{background:#f6f6f6; color:#000; padding:0px 10px; text-decoration:underline;}
.pagination a{background:#FFFFFF color:#0000FF; padding:0px 10px; text-decoration:none;}
.pagination a:hover{text-decoration:underline;}
ul.config{	padding:10px;	margin:0px;}
ul.config li{	display:inline;	float:left;	padding:0px 10px;}
ul.config li a{	text-decoration:none;	color:#000066;}
ul.config li a:hover, ul.config li a.active{	text-decoration:underline;	color:#990000;}
.clr{clear:both;}
.fl{float:left;}
.fr{float:right;}
</style>
<?php $url=get_option('home').'/wp-admin/admin.php?page=HomeSlider'; ?>
<div class="wrap">
<?php    echo "<h2>" . __( 'Manage Home Slider', 'webserve_trdom' ) . "</h2>"; ?>

<div class="clr"></div>
<?php if(isset($_REQUEST['del'])){if($_REQUEST['del']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Deleted successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['add'])){if($_REQUEST['add']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Added successfully.' ); ?></strong></p></div>
<?php }} ?>
<?php if(isset($_REQUEST['update'])){if($_REQUEST['update']=='succ'){ ?>
	<div class="updated"><p><strong><?php _e('Update successfully.' ); ?></strong></p></div>
<?php }} ?>
<div class="clr"></div>
<div class="fl">To show images in page please use this shortcode [Homeslides]</div>

<form name="conatct_form" method="post" onSubmit="return check_blank();" action="<?php echo $url; ?>">
<input type="hidden" name="usr" value="filter" />
<div style="clear:both; height:20px;"></div>
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ccc;">
		<tr>
			<th valign="top" align="left" width="60">&nbsp;<?php _e("Sr. No." ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Title" ); ?></th>
            <th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Image" ); ?></th>
			<th valign="top" align="left" style="border-left:1px solid #ccc;"><?php _e("Actions" ); ?></th>
		</tr>
	<?php $cnt=$limitstart+1; foreach($trips as $trip){ ?>
	  <tr>
		<td valign="top" align="left" style="border-top:1px solid #ccc;">&nbsp;<?php _e($cnt); ?></td>
        <td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;"><?php _e($trip->title); ?></td>
		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
		<?php if (file_exists("../wp-content/uploads/serviceimages/".$trip->beforeimage) && trim($trip->beforeimage)!=''){ ?>
          <img style="border:1px solid #ccc;" width="100" src="<?php echo get_option('home'); ?>/wp-content/uploads/serviceimages/<?php _e($trip->beforeimage); ?>" alt="" />
          <?php } ?>
        </td>
        		<td valign="top" align="left" style="border-top:1px solid #ccc; border-left:1px solid #ccc;">
			<a href="<?php _e($url); ?>&usr=tripedit&id=<?php _e($trip->id); ?>">View and Edit</a>&nbsp;&nbsp;
			<a href="javascript:if(confirm('Please confirm that you would like to delete this case?')) {window.location='<?php _e($url); ?>&usr=tripdelete&id=<?php _e($trip->id); ?>';}">Delete</a>
		</td>
	  </tr>
	  <?php $cnt++; } ?>
	</table>
</form>
<?php if(count($totalphotos)>$totalrec){ ?>
<div style="float:left; margin-top:10px;" class="pagination">

<?php if($pageid>1){ ?><a href="<?php _e($url); ?>" title="First" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/home-slider/images/first.png" alt="First" title="First" /></a><?php } ?>
    <?php $totalpages=ceil(count($totalphotos)/$totalrec);
			
			$previous = $pageid-1;
			if($previous>0)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$previous);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/home-slider/images/previous.png" alt="previous" title="previous" /></a>
				<?php
			}
			?>
            <div class="fl ml5 mr10">Page Number:</div>
            <div class="fl mr5">
            	<script type="text/javascript">
				//<![CDATA[
					jQuery(document).ready( function(){
						jQuery('#paginate').live('change', function(){
							var pagedid=jQuery(this).val();
							window.location='<?php _e($url); ?>&pagedid='+pagedid;
						});
					})
					//]]>
				</script>
                <select style="float:left;" id="paginate" name="pagedid">
                <?php for($k=1;$k<=$totalpages;$k++){ ?>
                    <option value="<?php _e($k); ?>" <?php if($k==$pageid){ _e('selected="selected"');}?>><?php _e($k); ?></option>
                <?php } ?>
                </select>
           	</div>
			<?php
				
			
			$next = $pageid+1;
			if($totalpages>=$next)
			{
				?>
				<a class="fl" href="<?php _e($url.'&amp;pagedid='.$next);?>"><img src="<?php echo get_option('home');?>/wp-content/plugins/home-slider/images/next.png" alt="next" title="next" /></a>
				<?php
			}
     ?>
     <?php if($totalpages>$pageid){ ?><a href="<?php _e($url.'&amp;pagedid='.$totalpages); ?>" title="Last" class="fl"><img src="<?php echo get_option('home');?>/wp-content/plugins/home-slider/images/last.png" alt="Last" title="Last" /></a><?php } ?>

</div>
<?php } ?>
</div>

<?php } ?>