<div id="wpbody" role="main">
<div id="wpbody" role="main">
<?php
include_once(ABSPATH . 'wp-config.php');
	global $wpdb;
	$products = $wpdb->get_results("SELECT * FROM career_details_int", OBJECT);
	$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
	$products2 = $wpdb->get_results(
		$wpdb->prepare("SELECT * FROM career_upload_admin_document_int WHERE user_id = %d", $user_id),
		OBJECT
	);
	$products3 = $wpdb->get_results("SELECT * FROM post_applied_details_int", OBJECT);
	$post_applied_id = isset($_GET['postapplied']) ? intval($_GET['postapplied']) : 0;
	$products4 = $wpdb->get_results(
		$wpdb->prepare("SELECT * FROM post_applied_details_int WHERE id = %d", $post_applied_id),
		OBJECT
	);
?>
<?php if (isset($_POST['createuser'])) {
    // Sanitize input
    $data = array(
        'post_name' => sanitize_text_field($_POST['post_name']),
        'gate_details' => sanitize_textarea_field($_POST['get_details']),
        'net_details' => sanitize_textarea_field($_POST['net_details']),
        'clat_details' => sanitize_textarea_field($_POST['clat_details']),
        'personal_details' => sanitize_textarea_field($_POST['personal_details']),
        'registration_emploment_exchange' => sanitize_textarea_field($_POST['registartionwithemployment_details']),
        'pwd_details' => sanitize_textarea_field($_POST['pwd_details']),
        'work_experinece' => sanitize_textarea_field($_POST['perior_work_powersystem']),
        'malling_address' => sanitize_textarea_field($_POST['malling_address']),
        'contact_details' => sanitize_textarea_field($_POST['contect_details']),
        'qualification_details' => sanitize_textarea_field($_POST['qualification_details']),
        'writen_exam_language' => sanitize_textarea_field($_POST['writen_exam_language']),
        'bank_details' => sanitize_textarea_field($_POST['bank_details']),
        'relationship_declaration' => sanitize_textarea_field($_POST['transparency_details']),
        'status' => sanitize_text_field($_POST['status']),
    );

    $wpdb->insert('post_applied_details_int', $data);

    $url = add_query_arg('success', 'Post inserted successfully', $_SERVER['REQUEST_URI']);
    wp_redirect($url);
    exit;
}

if (isset($_POST['updateuser'])) {
    $post_id = isset($_GET['postapplied']) ? intval($_GET['postapplied']) : 0;

    if ($post_id > 0) {
        $data = array(
            'post_name' => sanitize_text_field($_POST['post_name']),
            'gate_details' => sanitize_textarea_field($_POST['get_details']),
            'net_details' => sanitize_textarea_field($_POST['net_details']),
            'clat_details' => sanitize_textarea_field($_POST['clat_details']),
            'personal_details' => sanitize_textarea_field($_POST['personal_details']),
            'registration_emploment_exchange' => sanitize_textarea_field($_POST['registartionwithemployment_details']),
            'pwd_details' => sanitize_textarea_field($_POST['pwd_details']),
            'work_experinece' => sanitize_textarea_field($_POST['perior_work_powersystem']),
            'malling_address' => sanitize_textarea_field($_POST['malling_address']),
            'contact_details' => sanitize_textarea_field($_POST['contect_details']),
            'qualification_details' => sanitize_textarea_field($_POST['qualification_details']),
            'writen_exam_language' => sanitize_textarea_field($_POST['writen_exam_language']),
            'bank_details' => sanitize_textarea_field($_POST['bank_details']),
            'relationship_declaration' => sanitize_textarea_field($_POST['transparency_details']),
            'status' => sanitize_text_field($_POST['status']),
        );

        $wpdb->update(
            'post_applied_details_int',
            $data,
            array('id' => $post_id)
        );

        $url = add_query_arg('success', 'Post updated successfully', $_SERVER['REQUEST_URI']);
        wp_redirect($url);
        exit;
    }
}

// Display success message if passed in URL
$success = isset($_GET['success']) ? sanitize_text_field($_GET['success']) : '';
?>
<div id="wpbody-content" aria-label="Main content" tabindex="0">
	
		<div class="wrap">
			<?php if(!empty($_GET['postapplied'])){?>
				<h1 class="wp-heading-inline">EDIT POST</h1>
				<h3><?php echo $success;?></h3>
				<?php }else{?>
			<?php if(empty($_GET['post'])){?>	
<h1 class="wp-heading-inline">Post List</h1>
<?php  }else{?>
	<h1 class="wp-heading-inline">Post Add</h1>
	<h3><?php echo $success;?></h3>
	<?php }}?>








	<div class="tablenav top">
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

		<?php if(empty($_GET['postapplied']) && empty($_GET['post'])){?>		
<div class="tablenav-pages one-page button action"><a href="<?php echo  esc_url($_SERVER['REQUEST_URI']);?>&post=post_name">Add Post</a></div>
		<br class="clear">
	</div>
	<?php }?>
	<?php
		if(!empty($_GET['postapplied'])){?>
			<form method="post" action="<?php echo  esc_url($_SERVER['REQUEST_URI']);?>">
		<table class="form-table">
	<tbody><tr class="form-field form-required">
		<th scope="row"><label for="user_login">Post Name</label></th>
		<td><input name="post_name" type="text" value="<?php echo $products4[0]->post_name;?>"></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="email">Status</label></th>
		<td>
			<select name="status">
				<option value="1" <?php if($products4[0]->status==1){?>selected<?php }?>>Enabled</option>
				<option value="0" <?php if($products4[0]->status==0){?>selected<?php }?>>Disabled</option>
			</select>
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row"><label for="first_name">Candidate`s GATE Details</label></th>
		<td><input name="get_details" type="radio" value="1" <?php if($products4[0]->gate_details==1){?>checked<?php }?>> Yes <input name="get_details" type="radio" value="0" <?php if($products4[0]->gate_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Candidate`s NET Details</label></th>
		<td><input name="net_details" type="radio" value="1" <?php if($products4[0]->net_details==1){?>checked<?php }?>> Yes <input name="net_details" type="radio" value="0" <?php if($products4[0]->net_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Candidate`s CLAT Details</label></th>
		<td><input name="clat_details" type="radio" value="1" <?php if($products4[0]->clat_details==1){?>checked<?php }?>> Yes <input name="clat_details" type="radio" value="0" <?php if($products4[0]->clat_details==0){?>checked<?php }?>> No</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row"><label for="first_name">Personal Details</label></th>
		<td><input name="personal_details" type="radio" value="1" <?php if($products4[0]->personal_details==1){?>checked<?php }?>> Yes <input name="personal_details" type="radio" value="0" <?php if($products4[0]->personal_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Registration with Employment Exchange</label></th>
		<td><input name="registartionwithemployment_details" type="radio" value="1" <?php if($products4[0]->registration_emploment_exchange==1){?>checked<?php }?>> Yes <input name="registartionwithemployment_details" type="radio" value="0" <?php if($products4[0]->registration_emploment_exchange==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">PwD Details</label></th>
		<td><input name="pwd_details" type="radio" value="1" <?php if($products4[0]->pwd_details==1){?>checked<?php }?>> Yes <input name="pwd_details" type="radio" value="0" <?php if($products4[0]->pwd_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Prior work experience with Power System Operation Corporation</label></th>
		<td><input name="perior_work_powersystem" type="radio" value="1" <?php if($products4[0]->work_experinece==1){?>checked<?php }?>> Yes <input name="perior_work_powersystem" type="radio" value="0" <?php if($products4[0]->work_experinece==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Mailing Address</label></th>
		<td><input name="malling_address" type="radio" value="1" <?php if($products4[0]->malling_address==1){?>checked<?php }?>> Yes <input name="malling_address" type="radio" value="0" <?php if($products4[0]->malling_address==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Contact Details</label></th>
		<td><input name="contect_details" type="radio" value="1" <?php if($products4[0]->contact_details==1){?>checked<?php }?>> Yes <input name="contect_details" type="radio" value="0" <?php if($products4[0]->contact_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Qualification Details</label></th>
		<td><input name="qualification_details" type="radio" value="1" <?php if($products4[0]->qualification_details==1){?>checked<?php }?>> Yes <input name="qualification_details" type="radio" value="0" <?php if($products4[0]->qualification_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Writen Exam Language</label></th>
		<td><input name="writen_exam_language" type="radio" value="1" <?php if($products4[0]->writen_exam_language==1){?>checked<?php }?>> Yes <input name="writen_exam_language" type="radio" value="0" <?php if($products4[0]->writen_exam_language==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Bank Details</label></th>
		<td><input name="bank_details" type="radio" value="1" <?php if($products4[0]->bank_details==1){?>checked<?php }?>> Yes <input name="bank_details" type="radio" value="0" <?php if($products4[0]->bank_details==0){?>checked<?php }?>> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Transparency / Relationship Declaration</label></th>
		<td><input name="transparency_details" type="radio" value="1" <?php if($products4[0]->relationship_declaration==1){?>checked<?php }?>> Yes <input name="transparency_details" type="radio" value="0" <?php if($products4[0]->relationship_declaration==0){?>checked<?php }?>> No</td>
	</tr>
	</tbody></table>
		
		<p class="submit"><input type="submit" name="updateuser" id="createusersub" class="button button-primary" value="Submit"></p>
		
		
		</form>
		<?php }else{
		if(!empty($_GET['post'])){?>
			
		<form method="post" action="<?php echo  esc_url($_SERVER['REQUEST_URI']);?>">
		<table class="form-table">
	<tbody><tr class="form-field form-required">
		<th scope="row"><label for="user_login">Post Name</label></th>
		<td><input name="post_name" type="text" value=""></td>
	</tr>
	<tr class="form-field form-required">
		<th scope="row"><label for="email">Status</label></th>
		<td>
			<select name="status">
				<option value="1">Enabled</option>
				<option value="0">Disabled</option>
			</select>
		</td>
	</tr>
	
	<tr class="form-field">
		<th scope="row"><label for="first_name">Candidate`s GATE Details</label></th>
		<td><input name="get_details" type="radio" value="1"> Yes <input name="get_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Candidate`s NET Details</label></th>
		<td><input name="net_details" type="radio" value="1"> Yes <input name="net_details" type="radio" value="0" checked> No</td>
	</tr>
		<tr class="form-field">
			<th scope="row"><label for="first_name">Candidate`s CLAT Details</label></th>
			<td><input name="clat_details" type="radio" value="1"> Yes <input name="clat_details" type="radio" value="0" checked> No</td>
		</tr>
	
	<tr class="form-field">
		<th scope="row"><label for="first_name">Personal Details</label></th>
		<td><input name="personal_details" type="radio" value="1"> Yes <input name="personal_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Registration with Employment Exchange</label></th>
		<td><input name="registartionwithemployment_details" type="radio" value="1"> Yes <input name="registartionwithemployment_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">PwD Details</label></th>
		<td><input name="pwd_details" type="radio" value="1"> Yes <input name="pwd_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Prior work experience with Power System Operation Corporation</label></th>
		<td><input name="perior_work_powersystem" type="radio" value="1"> Yes <input name="perior_work_powersystem" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Mailing Address</label></th>
		<td><input name="malling_address" type="radio" value="1"> Yes <input name="malling_address" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Contact Details</label></th>
		<td><input name="contect_details" type="radio" value="1"> Yes <input name="contect_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Qualification Details</label></th>
		<td><input name="qualification_details" type="radio" value="1"> Yes <input name="qualification_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Writen Exam Language</label></th>
		<td><input name="writen_exam_language" type="radio" value="1"> Yes <input name="writen_exam_language" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Bank Details</label></th>
		<td><input name="bank_details" type="radio" value="1"> Yes <input name="bank_details" type="radio" value="0" checked> No</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name">Transparency / Relationship Declaration</label></th>
		<td><input name="transparency_details" type="radio" value="1"> Yes <input name="transparency_details" type="radio" value="0" checked> No</td>
	</tr>
	</tbody></table>
		
		<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary" value="Submit"></p>
		
		
		</form>
		<?php }else{?>
		<h2 class="screen-reader-text">Pages list</h2>
		<table class="table table-hover table-striped" cellspacing="0" cellpadding="4" rules="all" border="1" id="g12">
			<thead>
			<tr>
				<th scope="col">Post Name</th>
				<th scope="col">Status</th>
				<th scope="col">Action</th>
												
			  </tr>
			</thead>
			<tbody>
				<?php foreach($products3 as $value){?>
					<tr>
						<td><?php echo $value->post_name;?></td>
						<td><?php if($value->status==1){ echo "Enabled"; }else{ echo "Disabled"; }?></td>
						<td><a href="<?php echo  esc_url($_SERVER['REQUEST_URI']);?>&postapplied=<?php echo $value->id;?>">Edit</a></td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	
<?php }}?>
</div>

