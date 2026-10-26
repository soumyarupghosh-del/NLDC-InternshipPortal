<div id="wpbody" role="main">
<?php
include_once(ABSPATH . 'wp-config.php');
	global $wpdb;
	if(!empty($_GET['post_id'])){
			
			$products = $wpdb->get_results($wpdb->prepare("SELECT cp.*,cd.* FROM career_details_int cd 
											LEFT JOIN career_payment_int cp ON(cd.id = cp.user_id) 
											LEFT JOIN xcareer_audit_int ca ON(cd.id = ca.career_id)
											WHERE cd.applyed_post_id=%d AND ca.status= 2 ORDER BY cd.id DESC",intval($_GET['post_id'])),object);
										
			
	}else{
		$products = $wpdb->get_results("SELECT cp.*,cd.* FROM career_details_int cd LEFT JOIN career_payment_exp cp ON(cd.id = cp.user_id)
				ORDER BY cd.id DESC",object);
	}
    if(!empty($_GET['user_id']))
    {
        $products2 = $wpdb->get_results($wpdb->prepare("SELECT * FROM career_upload_admin_document_int WHERE user_id=%d",intval($_GET['user_id'])),OBJECT);
    }
	$post_applied = $wpdb->get_results("SELECT * FROM post_applied_details_int",OBJECT);
?>

<div id="wpbody-content" aria-label="Main content" tabindex="0">
	<?php
		if(isset($_GET['user_id'])){?>
			<?php if(isset($error)){?>
			<div id="lost-connection-notice" class="error">
				<p><span class="spinner"></span> <?php echo $error;?>
				</p>
			</div>
			<?php }?>
			<div class="wrap">
				<h1 class="wp-heading-inline">Upload Document</h1>
				
				<style>
     @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
      body{font-family: 'Open Sans', sans-serif; font-size: 16px; line-height: 24px;}
  #wrapper {width: 90%;
    padding: 0;margin: 5px auto 0 auto;
    height: auto;text-align: left;
    border: 1px solid #ddd;
}
#header {
    margin: 0;
    padding: 0;
    height: auto;
    width: auto;
    background-color: #f1f1f1;
}
#container {
    padding: 0;
    margin: 0;
    background-attachment: scroll;
    background-repeat: repeat-y;
    background-position: 0 0;
    height: 1%;
    width: auto;
}
#center {
    height: 100%;
    width: 100%;
    padding: 0;
    float: left;
    margin: 0;
}
.clearer {
    font-size: 0;
    line-height: 0;
    display: block;
    margin: 0;
    padding: 0;
    clear: both;
    height: 0;
    width: auto;
}
code {
    padding: 2px 4px;
    font-size: 90%;
    color: #c7254e;
    background-color: #f9f2f4;
    border-radius: 4px;
}
code, kbd, pre, samp {
    font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
}
.table-responsive {
    min-height: .01%;
    overflow-x: auto;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
.table {
    background-color: transparent;
}
.table {
    border-spacing: 0;
    border-collapse: collapse;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.table-responsive {
    min-height: .01%;
    overflow-x: auto;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}
table {
    background-color: transparent;
}
table {
    border-spacing: 0;
    border-collapse: collapse;
}
caption {
    text-align: center;
    background-color: chocolate;
    color: white;
}
caption {
    padding-top: 8px;
    padding-bottom: 8px;
    color: #777;
    text-align: left;
}
caption {
    text-align: center;
    background-color: crimson;
    color: white;
}
ul, ol {
    margin-top: 0;
    margin-bottom: 10px;
}
li {
    text-align: justify;
    font-size: 13px;
}
.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
.table-bordered {
    border: 1px solid #ddd;
}
button, html input[type="button"], input[type="reset"], input[type="submit"] {
    -webkit-appearance: button;
    cursor: pointer;
}

.btn-sm, .btn-group-sm > .btn {
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}
.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
      caption {text-align: center;background-color: chocolate;color: white;}
      .table.table-hover.table-striped{ width: 98%; margin: 0 auto;    border-color: #21409a;}
      .table.table-hover.table-striped caption{  background: #21409a;text-align: left;padding-left: 15px;font-size: 18px; font-weight: bold;}
      .table.table-hover.table-striped tr th{ font-size: 14px; font-weight: 600; text-align: center; background: #f1f1f1}
      .table.table-hover.table-striped tr td{ font-size: 14px; text-transform: capitalize;text-align: center;}
      .pullCenter{ width: 98%; margin: 0 auto;}
      .doumentList{margin:0px  0 20px 0 ; padding:15px  10px; list-style: none; border: 1px solid #21409a; background: #fff}
      .doumentList li{ padding-left: 30px; position: relative;}
      .doumentList li:before{ content: "\f15c"; font-family: fontAwesome; position: absolute; left: 2px; top: 2px;}
</style>
				<?php 
				
				$customer_details = $wpdb->get_results($wpdb->prepare("SELECT * FROM career_details_int WHERE id = %d", intval($_GET['user_id'])), OBJECT);
					
				$products_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM post_applied_details_int WHERE id = %d", intval($customer_details[0]->applyed_post_id)), OBJECT);
				
				?>
				<div>
    <table class="table table-hover table-striped" cellspacing="0" cellpadding="4" rules="all" border="1" id="g12">
      <caption align="Top">
        Application for the post of <?php
                            echo $products_data[0]->post_name;
                         ?>      </caption><tbody><tr>
       <th scope="col">Reg. Id</th><th scope="col">Name</th><th scope="col">Category</th><th scope="col">NATS No.</th><th scope="col">Is PwD</th><th scope="col">Date of Birth</th>
      </tr><tr>
       <td><?php echo $customer_details[0]->career_uniqe_id;?></td>
         <td><?php echo $customer_details[0]->name_of_condidate;?></td>
                                                    <td><?php echo $customer_details[0]->ddlCategory;?></td>
                                                    <td><?php echo $customer_details[0]->RegistrationNo;?></td>
                                                    <td><?php echo $customer_details[0]->ddlIsPwd;?></td>
                                                    
                                                    <td><?php echo $customer_details[0]->Dob;?></td>
                                                   
      </tr>
    </tbody></table>
  </div>
				
				
		<br/>
		<br/>

				
			</div>
		<?php }else{
	?>
		<div class="wrap">
<h1 class="wp-heading-inline">Careers List</h1>
<div class="tablenav top">

				<div class="alignleft actions bulkactions">
			
			<select name="action" id="search_post_wise">
				<option value="0">Select Post for Filter</option>
				<?php foreach($post_applied as $value_data){?>
					<option value="<?php echo $value_data->id;?>" <?php if(!empty($_GET['post_id'])){ if($value_data->id==$_GET['post_id']){?>selected<?php } }?>><?php echo $value_data->post_name;?></option>
				<?php }?>
			</select>
			<?php 
				if(isset($_GET['post_id']) && $_GET['post_id']!=0){?>
					<a href="<?php echo get_site_url();?>/wp-content/plugins/internship/report.php?post_id=<?php echo esc_attr($_GET['post_id']);?>" target="_blank"><button class="button button-primary ">Report</button></a>
				
				<?php }else{
			?>
			
			<?php }?>
		</div>

		<br class="clear">
	</div>
<h2 class="screen-reader-text">Pages list</h2>
<table class="wp-list-table widefat fixed striped pages">
	<thead>
	<tr> <th width="30px" scope="col">Sr. No.</th>
        <th width="50px" scope="col">
                                                        View
                                                    </th>
													
                                                    <th width="90px" scope="col">Reg. Id</th>
                                                    <th width="100px" scope="col">Name</th>
													<th width="60px" scope="col">Payment Status</th>
													<th width="30px" scope="col">Gender</th>
                                                    <th width="80px" scope="col">Category</th>
													<th width="50px" scope="col">APAAR ID</th>
                                                    <th width="50px" scope="col">Is PwD</th>
                                                 
                                                    <th width="80px"scope="col">Date of Birth</th>
                                                    
													<th width="60px" scope="col">Applied On</th>
													
                                                    <th width="60px" scope="col">Email</th> 
													 
                                                    
      </tr>
	</thead>

	<tbody>
	
		<?php $count = 1;
			foreach($products as $key=>$value){
				
				?>
				<tr>
				<td width="30" ><?php echo $count;?></td>
        <td width="50">
   <a id="g12_hDetails_0" href="<?php echo get_site_url();?>/wp-content/plugins/internship/customer_details.php?userid=<?php echo $value->id;?>" target="blank">Resume</a>
                                                    </td>
													
													<td width="90px" ><?php echo $value->career_uniqe_id;?></td>
                                                    <td><?php echo $value->name_of_condidate;?></td>
													<td style="font-size: 10px; color:red;" ><?php 
														if(($value->payment_status == 1) && ($value->user_status == 1)){
															$date= date_create($value->payment_date);
															echo "Completed";
															echo "\n";
															echo date_format($date,"d-m-Y");
														}
														if(($value->payment_status == 0) && ($value->user_status == 1)){
															$date= date_create($value->payment_date);
															echo "Admin pend.";
															echo "\n";
															echo date_format($date,"d-m-Y");
															
														}
														if(($value->payment_status == '') && ($value->user_status == '')){
															if((($value->ddlCategory=='GENERAL')  || ($value->ddlCategory=='OBC(NCL)') || ($value->ddlCategory=='EWS')) && ($value->ddlIsPwd=='NO') && ($value->IsExServiceMan=='NO' )){
																	echo "Pending";
																}else{
															echo "Nil";}
														}
                                                    ?></td>
													<td style="font-size: 11px;"><?php if($value->Gender=='MALE'){ echo "M";} else {echo "F";}?></td>
                                                    <td><?php echo $value->ddlCategory;?></td>
                                                    <td><?php echo $value->apaarid;?></td>
                                                    <td><?php echo $value->ddlIsPwd;?></td>
                                                   
                                                    <td><?php $date= date_create($value->Dob);
															echo date_format($date,"d-M-Y");?></td>
                                                    
													<td style="font-size: 10px;"><?php 
													$date= date_create($value->created_date);
													echo date_format($date,"d-M-Y");
													echo "\n";
													echo date_format($date,"H:i:s");
													?></td>
													
                                                   <td><?php echo $value->Email;?></td> 
                                                  
      </tr>
			<?php $count++; }
		?>
		 
	</tbody>

	
</table>
	
<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js?ver=4.9.4"></script>
<script>
	$(document).ready(function(){
		$(document).on("change","#search_post_wise",function(){
			var search_value = $(this).val();
			var url_data = "<?php echo $_SERVER['REQUEST_URI'];?>";
			window.location.href=url_data+"&post_id="+search_value;
		});
	});
</script>