<?php
include_once('../../../wp-config.php');
  global $wpdb;
  if ( is_user_logged_in() ) {

    $userid = isset($_GET['userid']) ? absint($_GET['userid']) : 0;

    if ( $userid === 0 ) {
        wp_die('Invalid user ID');
    }

    $products = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM career_details_int WHERE id = %d",
            $userid
        ),
        OBJECT
    );

    // Safety check before accessing index 0
    $applied_post_id = !empty($products)
        ? absint($products[0]->applyed_post_id)
        : 0;

    $products3 = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM post_applied_details_int WHERE id = %d",
            $applied_post_id
        ),
        OBJECT
    );

    $products_details = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM career_document_int WHERE career_id = %d",
            $userid
        ),
        OBJECT
    );
  ?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<head id="Head1">
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
</head>
<body>
	<?php 
	if (isset($_POST['payment_update'])) {
    $user_id = intval($_GET['userid']);
    $ip = get_client_ip();
    $appdate = current_time('mysql');

    $wpdb->query(
        $wpdb->prepare(
            "UPDATE career_payment_int SET payment_status = 1, appip = %s, appdate = %s WHERE user_id = %d",
            $ip, $appdate, $user_id
        )
    );

    $url = $_SERVER['REQUEST_URI'];
    wp_redirect($url);
    exit;
}
?>
    
<div class="aspNetHidden">

</div>





        <div id="wrapper">
            <div id="header" style="background-color:#2c58a4">

                <img src="<?php echo site_url();?>/wp-content/plugins/xcareers/images/Rectt-Banner.jpg" style="margin-bottom: -5px;margin-top: 5px;" alt="GRID-INDIA Recruitment System" class="img-responsive" />
                <hr />
            </div>

            <div id="container">
                <div id="center">
                    <div id="main">
                       
                        <!--<a href="<?php echo site_url();?>/index.php/logout" class="btn btn-danger btn-xs" style="padding:3px 10px;float:right; margin-top:7px;margin-right:10px;">Log Out</a>-->
                       
                        <br/>
                        <br/>

                        <div id="ctl26">
  
                                <div>
                                    <div class="table-responsive">
                                        <div>
    <table class="table table-hover table-striped" cellspacing="0" cellpadding="4" rules="all" border="1" id="g12">
      <caption align="Top">
        Application for the post of <?php
                            echo $products3[0]->post_name;
                         ?>
      </caption><tr>
        <th scope="col">
                                                        View Resume
                                                    </th><th scope="col">Reg. Id</th><th scope="col">Name</th><th scope="col">Category</th><th scope="col">APAAR ID</th><th scope="col">Is PwD</th>
													<th scope="col">Date of Birth</th>
      </tr><tr>
        <td>
                                                        <a id="g12_hDetails_0" href="<?php echo get_site_url();?>/wp-content/plugins/internship/preview.php?userid=<?php echo $products[0]->id;?>" target="blank">Resume</a>
                                                    </td><td><?php echo $products[0]->career_uniqe_id;?></td>
                                                    <td><?php echo $products[0]->name_of_condidate;?></td>
                                                    <td><?php echo $products[0]->ddlCategory;?></td>
                                                    <td><?php echo $products[0]->apaarid;?></td>
                                                    <td><?php echo $products[0]->ddlIsPwd;?></td>
                                                   
                                                    <td><?php echo $products[0]->Dob;?></td>
                                                   
      </tr>
    </table>
  </div>
                                        <br/>
										<!-- <table class="table table-hover table-striped" cellspacing="0" cellpadding="4" rules="all" border="1" >
      <caption align="Top">
        Contact Details
      </caption><tr>
        <th scope="col">DB Id</th><th scope="col">Name</th><th scope="col">Reg. Id</th><th scope="col">Mobile</th><th scope="col">E-mail</th><th scope="col">Pass</th>
      </tr><tr>
													<td><?php echo $products[0]->id;?></td>
													 <td><?php echo $products[0]->name_of_condidate;?></td>
													<td><?php echo $products[0]->career_uniqe_id;?></td>
                                                   
                                                    <td><?php echo $products[0]->MobileNumber;?></td>
                                                    <td><?php echo strtolower($products[0]->Email);?></td>
													<td><?php echo $products[0]->password;?></td>
                                                    
                                                   
      </tr>
	  <tr ><td colspan="6" style="text-align:left">
			Ma’am <br>

			Following credential for POSOCO Career
			<br>
			<b>Name:</b> <?php echo $products[0]->name_of_condidate;?> 
			<br>
			<b>Registration Id: </b> <?php echo $products[0]->career_uniqe_id;?>
			<br>
			<b>User-Id:</b> <?php echo strtolower($products[0]->Email);?>
			<br>
			
			<br>
			<b>Registered Mobile No. for OTP:</b> <?php echo $products[0]->MobileNumber;?>
			<br>
			Login page for Experience Candidate is https://recruitment.grid-india.in/loginint/
			<br>
			<br>
			Regards 
			
		</td>
	</tr>
    </table> -->
                                        
                                        <br>
                                        
                                        <br>
                                        <div>
                                            <div class="pullCenter">
                                            <div style='background-color:#21409a;color:white;text-align: left;padding: 10px;
    font-size: 18px; font-weight:bold'> Attachments </div><ul class="doumentList">
										<table class="table table-hover table-striped" >
                        <tbody>
						
						<ul class="doc-list">
						<?php if(!empty($products_details[0]->image)){?>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                        <li>  <a href="<?php echo get_site_url()."/wp-content/plugins/internship/upload/"?><?php echo $products_details[0]->image;?>" target='_blank' class="doc-view">Photo</a></li>
							</td>
						</tr>
						<?php } ?>
						
						
						<?php if(!empty($products_details[0]->signature)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                      <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/"?><?php echo $products_details[0]->signature;?>' target='_blank'>Signature</a></li>
							</td>
						</tr>
						<?php } ?>
						
						
						<?php if(!empty($products_details[0]->birth_certificate)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                      <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->birth_certificate;?>' target='_blank'>Date of Birth Certificate / Class-X passing Certificate</a></li>
										 
							</td>
						</tr>
						<?php } ?>
						
						
						<?php if(!empty($products_details[0]->degree_certificate)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->degree_certificate;?>' target='_blank'>Degree Certificate</a></li>
										 
							</td>
						</tr>
						<?php } ?>
						
						<?php if(!empty($products_details[0]->pwd_certificate)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->pwd_certificate;?>' target='_blank'>PWD Certificate</a></li>
										 
							</td>
						</tr>
						<?php } ?>
                        <?php if(!empty($products_details[0]->desirable_certificate)){?>
                        <tr><td colspan="3"><hr /></td></tr>
                        <tr>
                        <td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->desirable_certificate;?>' target='_blank'>Desirable Certificate</a></li>
                                         
                            </td>
                        </tr>
                        <?php } ?>
                        <?php if(!empty($products_details[0]->project_paper_document)){?>
                        <tr><td colspan="3"><hr /></td></tr>
                        <tr>
                        <td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->project_paper_document;?>' target='_blank'>Project Document</a></li>
                                         
                            </td>
                        </tr>
                        <?php } ?>
						<?php if(!empty($products_details[0]->sc_st_certificate)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->sc_st_certificate;?>' target='_blank'><?php echo $products[0]->ddlCategory;?> Certificate</a></li>
										 
							</td>
						</tr>
						<?php } ?>
						<?php if(!empty($products_details[0]->payslip)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->payslip;?>' target='_blank'>Adhaar</a></li>
										 
							</td>
						</tr>
						<?php } ?>
						
						<?php if(!empty($products_details[0]->dbtacc)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->dbtacc;?>' target='_blank'>Bank Cancelled Cheque / First Page of Passbook (DBT enabled Acc. Details)</a></li>
										 
							</td>
						</tr>
						<?php } ?>
						<?php if(!empty($products_details[0]->pan)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->payslip;?>' target='_blank'>PAN</a></li>
										 
							</td>
						</tr>
						<?php } ?>
						<?php if(!empty($products_details[0]->exchange_certificate)){?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr>
						<td class="textbox" style="width: 30%" align="left">
                                    <li><a href='<?php echo get_site_url()."/wp-content/plugins/internship/upload/".$products_details[0]->exchange_certificate;?>' target='_blank'>NATS Certificate </a></li>
										 
							</td>
						</tr>
						<?php } ?>
						</ul>
						</tbody>
						 </table>
						 </div>
                                            </div>
                                    </div>




                                    <?php 
                         $products2 = $wpdb->get_results("SELECT * FROM career_upload_admin_document_int WHERE user_id=".$_GET['userid']." ",OBJECT);
                         ?>
								<?php if(!empty($products2[0]->status)==1){ ?>
								
								<?php if(!empty($products2[0]->Offer_Letter)){?>
								<div id="d1" class="alert alert-success pullCenter" >
								<p style="font-size:14px; color:#444; margin-top:0;font-weight:bold">Congratulations. You have been provisionally selected for the post of <?php
                            echo $products3[0]->post_name; 
                         ?>.<img class="alignnone" title="posoco" src="https://posoco.in/IA/new.gif" alt="posoco" width="45" height="25" /></p> 
										<ul class="doumentList">
											<li><a href='<?php echo site_url();?>/wp-content/plugins/internship/upload/<?php echo $products2[0]->Offer_Letter;?>' target='_blank'>Offer Letter </a> </li>
											<li><a href='<?php echo site_url();?>/wp-content/plugins/internship/upload/<?php echo $products2[0]->enclosure;?>' target='_blank'>Manager HR Enclosures </a> </li>
											</ul>
											</div>
											<br/>
											<?php }?>
									
								 
								<?php if(!empty($products2[0]->region_posting)){?>
								<div id="d1" class="alert alert-success pullCenter" >
										<ul class="doumentList">
											<li><a href='<?php echo site_url();?>/wp-content/plugins/internship/upload/<?php echo $products2[0]->region_posting;?>' target='_blank'>Candidature cancellation for personal interview for the post of <?php echo $products3[0]->post_name;?></a> <img class="alignnone" title="posoco" src="https://posoco.in/IA/new.gif" alt="posoco" width="45" height="25" /></li>
											</ul>
											</div>
											<br/>
											<?php }?>
									
                                    <div id="d1" class="alert alert-success pullCenter"  >
                                        <p style="font-size:14px; color:#444; margin-top:0;font-weight:bold">Congratulations. You have been provisionally shortlisted for Interviews to be held for the post of <?php
                            echo $products3[0]->post_name;
                         ?>.</p>
                         
                                        <ul class="doumentList">
											
											
											<li><a href='<?php echo site_url();?>/wp-content/plugins/internship/upload/<?php echo $products2[0]->call_letter;?>' target='_blank'>Click here to Download Call Letter for Interview.</a></li>
											<li>
											<a href='https://posoco.in/IA/rectdoc/Candidate_resume-MGR.pdf'>Download Resume PDF Format for Interview.</a></li>
											
										</ul>
									</div>
									<?php }?>
                                   

                                    <div id="dPhase2">
                                    </div>

                                    <div id="dcut"><br/><a href='../docs/Cutoff marks-CS.docx' target='_blank' style="    font-size: 14px;padding: 15px; text-decoration:none;display: none;" > <i class="fa fa-check"></i>&nbsp; Cut off marks for candidates called for GD and Interview.</a><br/></div>

                                    
                                </div>
                            
</div>
                    </div>
                </div>
                <div class="clearer">
                </div>
            </div>
            <script src="../Scripts/jquery-3.1.1.min.js"></script>
            <script src="../Scripts/jquery-ui-1.12.1.min.js"></script>
            <script src="../Scripts/jquery.blockUI.js"></script>
            <script type="text/javascript">
                Sys.WebForms.PageRequestManager.getInstance().add_beginRequest(BeginRequestHandler);
                Sys.WebForms.PageRequestManager.getInstance().add_endRequest(EndRequestHandler);
                Sys.WebForms.PageRequestManager.getInstance().add_endRequest(req);
                function BeginRequestHandler(sender, args) {
                    $.blockUI({
                        theme: true,
                        title: 'Power System Operation Corporation Limited',
                        message: '<table><tr><td><img src="../images/ajax-loader.gif" alt="Updating"/></td><td>Please wait. Processing your request....</td></tr></table>'
                    });
                }
                function EndRequestHandler(sender, args) {
                    $.unblockUI();
                    $(document).ready(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                }
                $(document).ready(function () {
                    $('input[type="radio"]').click(function () {
                        if ($(this).attr('id') == 'rbtnList2_0') {
                            $('#yes2').show();
                            $('#no2').hide();
                        }
                        else {
                            $('#yes2').hide();
                            $('#no2').show();
                        }
                    });
                });
                function req(sender, args) {
                    $('input[type="radio"]').click(function () {
                        if ($(this).attr('id') == 'rbtnList2_0') {
                            $('#yes2').show();
                            $('#no2').hide();
                        }
                        else {
                            $('#yes2').hide();
                            $('#no2').show();
                        }
                    });
                }
            </script>

            <div id="footer" style=" background:#0187d0; padding:10px; text-align:center;margin-top:20px;" class="ui-widget-header ui-corner-all">
                <a style="font-size:14px; text-align:center; text-decoration:none;color:#fff;" href="https://grid-india.in/en/" id="aFo" target="_blank">© Copyright 2026 Grid Controller of India Limited.
                    </a>
            </div>
        </div>
    
</body>
</html>
<?php } else {

 header("Location: https://recruitment.grid-india.in/");

  }?>
