<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
#session_destroy();
include("../../../wp-config.php");
 global $wpdb;
 ?>
  <?php 
require_once get_template_directory() . '/functions.php';

// Start WAF Protection
custom_waf_protection();
 ?>
<style>
body{font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 24px;}
.bodyback{    border: 1px solid #ddd;padding: 2px;background: #f1f1f1;}
table{}
table tr{}
table tr td{ font-size: 14px; }
legend{ background: #fff;background: #fff;padding: 5px 10px;border-top: 1px solid #ddd;position: relative; }
legend:before{content: ""; position: absolute; left: 0; top: 0; background: #ddd; width: 1px; height: 14px;}
legend:after{content: ""; position: absolute; right: 0; top: 0; background: #ddd; width: 1px; height: 14px;}
fieldset{ background: #fff; border: 1px solid #ddd; margin-bottom: 15px; font-size: 14px; }
fieldset strong{ font-size: 13px; }
table{width: 100%;}
.textBold{ font-weight: 600; }

/* GRID-INDIA internship resume: presentation-only styling.
   Existing IDs, names, PHP, data and JavaScript are unchanged. */
#wrappers { background:#f5f8fc; border:1px solid #d8e2ee; padding:16px; color:#243449; }
#wrappers .shipment-outer-table { width:100%; border-collapse:collapse; background:#fff; }
#wrappers .shipment-outer-table img { max-width:100%; }
#wrappers fieldset { min-width:0; margin:15px 0; padding:16px; background:#fff; border:1px solid #d8e2ee; border-radius:8px; }
#wrappers fieldset legend { width:auto; max-width:95%; margin:0 0 8px; padding:4px 12px; color:#174578; background:#fff; border:0; font-size:16px; font-weight:600; line-height:1.4; }
#wrappers fieldset legend:before, #wrappers fieldset legend:after { display:none; }
#wrappers fieldset legend .fieldHeader { color:inherit; background:transparent; border:0; padding:0; font:inherit; }
#wrappers .shipment-table { width:100%; border-collapse:collapse; margin-bottom:0; }
#wrappers .shipment-table td, #wrappers .shipment-table th { border:1px solid #e2e8f0; padding:10px 12px; vertical-align:middle; font-size:13px; line-height:1.5; overflow-wrap:anywhere; }
#wrappers .shipment-table tr:nth-child(even) { background:#f7fafd; }
#wrappers .shipment-table td strong, #wrappers .shipment-table .textBold { color:#174578; font-weight:600; }
#wrappers .shipment-table > tbody > tr:first-child > td > b { color:#174578; }
#wrappers .shipment-table .table { margin-bottom:0; }
#wrappers .btn { border-radius:5px; }
@media(max-width:767px) { #wrappers { padding:8px; } #wrappers fieldset { padding:10px; } #wrappers .shipment-table td, #wrappers .shipment-table th { padding:7px; font-size:12px; } }
@media print { #wrappers { padding:0; background:#fff; border:0; } #wrappers fieldset { break-inside:avoid; margin:9px 0; padding:9px; } #wrappers .shipment-table td { padding:5px 7px; } .noprint { display:none !important; } }
/* Present and Permanent Address display styling */
#wrappers .resume-address-table td:first-child { width:32%; background:#f0f6fd; color:#174578; font-weight:600; }
#wrappers .resume-address-table td:last-child { width:68%; }
#wrappers .address-same-note { margin:0 0 10px; padding:7px 10px; border-radius:4px; background:#eef7f2; color:#226443; font-size:12px; }
@media(max-width:600px) { #wrappers .resume-address-table td:first-child { width:42%; } #wrappers .resume-address-table td:last-child { width:58%; } }

/* Side-by-side present and permanent address display */
#wrappers .resume-address-comparison { width:100%; border-collapse:collapse; table-layout:fixed; }
#wrappers .resume-address-comparison th { width:50%; background:#164b80; color:#fff; padding:11px 14px; text-align:left; border:1px solid #cbdbea; font-size:14px; }
#wrappers .resume-address-comparison td { width:50%; padding:9px 14px; border:1px solid #d8e3ef; vertical-align:top; overflow-wrap:anywhere; }
#wrappers .resume-address-comparison tbody tr:nth-child(even) td { background:#f6f9fd; }
#wrappers .resume-address-comparison .address-field-label { display:block; color:#385d80; font-size:12px; font-weight:600; }
#wrappers .resume-address-comparison .address-field-value { display:block; color:#253746; font-size:14px; min-height:20px; }
#wrappers .resume-address-section .address-same-note { margin:9px 0 0; }
@media print { #wrappers .resume-address-comparison th { background:#e5eef8 !important; color:#173e68 !important; -webkit-print-color-adjust:exact; print-color-adjust:exact; } }

/* Desirable Qualification: display only when saved records exist */
.resume-desirable-section { margin-bottom: 16px; }
.resume-desirable-scroll { width: 100%; overflow-x: auto; }
.resume-desirable-table { width: 100%; border-collapse: collapse; }
.resume-desirable-table th { background: #174a83; color: #fff; font-weight: 600; padding: 10px 12px; text-align: left; border: 1px solid #d4e2ef; }
.resume-desirable-table td { padding: 9px 12px; border: 1px solid #d4e2ef; vertical-align: top; }
.resume-desirable-table tbody tr:nth-child(even) { background: #f3f8fc; }
@media (max-width: 640px) { .resume-desirable-table { min-width: 650px; } }

/* A4 multi-page resume printing: allow long sections to flow onto subsequent pages. */
@page { size: A4 portrait; margin: 12mm 11mm 13mm; }
#wrappers .resume-empty-row td { text-align:center; color:#6b7280; font-style:italic; padding:12px; }
@media print {
  html, body { width:auto !important; margin:0 !important; padding:0 !important; background:#fff !important; font-size:10pt; }
  #wrappers { width:100% !important; max-width:none !important; margin:0 !important; padding:0 !important; border:0 !important; background:#fff !important; }
  #wrappers .shipment-outer-table, #wrappers .shipment-table, #wrappers .resume-desirable-table,
  #wrappers .resume-address-comparison { width:100% !important; border-collapse:collapse !important; }
  #wrappers fieldset { break-inside:auto !important; page-break-inside:auto !important; padding:6px 7px !important; margin:8px 0 !important; border:1px solid #cbd5e1; }
  #wrappers fieldset legend { break-after:avoid; page-break-after:avoid; font-size:11pt; padding:2px 5px; }
  #wrappers thead { display:table-header-group; }
  #wrappers tfoot { display:table-footer-group; }
  #wrappers tr { break-inside:avoid; page-break-inside:avoid; }
  #wrappers td, #wrappers th { padding:4px 5px !important; font-size:9pt !important; line-height:1.3 !important; }
  #wrappers .resume-desirable-scroll { overflow:visible !important; width:100% !important; }
  #wrappers .resume-desirable-table { min-width:0 !important; table-layout:auto; }
  #wrappers .resume-desirable-table th { background:#e5eef8 !important; color:#173e68 !important; }
  #wrappers img { max-width:100% !important; }
  .noprint, #printpagebutton { display:none !important; }
  * { -webkit-print-color-adjust:exact; print-color-adjust:exact; }
}

/* Print pagination fix: content fieldsets are no longer nested in a single giant table cell. */
#wrappers .resume-content-flow { display:block; width:100%; }
@page { size:A4 portrait; margin:10mm; }
@media print {
  html, body { margin:0 !important; padding:0 !important; }
  #wrappers, #wrappers .resume-content-flow { width:100% !important; max-width:none !important; margin:0 !important; padding:0 !important; }
  #wrappers .resume-content-flow { display:block !important; }
  #wrappers .resume-content-flow fieldset { display:block !important; break-inside:auto !important; page-break-inside:auto !important; margin:5px 0 !important; padding:6px 7px !important; }
  #wrappers .resume-content-flow legend { break-after:avoid !important; page-break-after:avoid !important; }
  #wrappers .resume-content-flow table { break-inside:auto !important; page-break-inside:auto !important; }
  #wrappers .resume-content-flow thead { display:table-header-group !important; }
  #wrappers .resume-content-flow tr { break-inside:avoid !important; page-break-inside:avoid !important; }
  #wrappers .shipment-table td, #wrappers .shipment-table th { padding:4px 5px !important; font-size:9pt !important; line-height:1.25 !important; }
  #wrappers .resume-desirable-scroll { overflow:visible !important; }
  #wrappers .resume-desirable-table { min-width:0 !important; }
  #wrappers .shipment-outer-wrapper { break-inside:auto !important; page-break-inside:auto !important; }
  #wrappers .shipment-outer-wrapper .shipment-table { margin:4px auto !important; }
  .noprint, #printpagebutton { display:none !important; }
}
</style>
<?php
    if(empty($_SESSION['user_id'])){
        header("location:/index.php/loginap");
    }
    $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

            /* Career details */
            $products = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM career_details_int WHERE id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Degree / work experience */
            $products_digree_exp = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM career_work_int WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Professional experience */
            $products_professional_exp = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM career_professional_int WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Project / Papers Published / Article Details */
            $products_project = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM career_project_details_int WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Statement of Interest / Objectives */
            $product_intrest = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM statement_of_intrest_int WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Internship Contribution */
            $internship_countiribution = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM internship_countiribution WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Institute Recommendation / NOC */
            $institute_noc = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM institute_noc WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Applied post details (check array index first) */
            $applied_post_id = !empty($products) ? intval($products[0]->applyed_post_id) : 0;

            $products3 = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM post_applied_details_int WHERE id = %d",
                    $applied_post_id
                ),
                OBJECT
            );

            /* Uploaded documents */
            $document = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM career_document_int WHERE career_id = %d",
                    $user_id
                ),
                OBJECT
            );

            /* Payment details */
            $payment = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM career_payment_int WHERE user_id = %d",
                    $user_id
                ),
                OBJECT
            );                  
?>
<form method="post" id="f">

 <div class="bodyback" id="wrappers">
            <table class="shipment-outer-table" bgcolor="#fff" style="border-bottom: 1px solid #ddd;">
                <tbody><tr>
                    <td style="width: 50%">
                       <img src="<?php echo site_url();?>/wp-content/plugins/careers/images/Rectt-Banner.jpg" alt="GRID-INDIA Recruitment">
                       
                    </td>
                    
                    <td style="font-size: 12pt;" align="center">
                        <span style="font-size: 20px;">
                            <?php echo $products[0]->career_uniqe_id;?>
                        </span><strong>
                            <br>
                            <span style="font-size: 8pt">Registration Number</span></strong><br>
                       <img
    src="barcode.php?text=<?php echo urlencode($products[0]->career_uniqe_id); ?>&size=50&print=true"
    alt="Barcode"
/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center" >
                         <p style="font-size: 14pt; color: #000080;padding: 5px 0; width:100%;border-top:1px solid #ddd">Resume for
                         <?php
                         $title = $products3[0]->post_name;
                            //$title = str_replace('Apprentices for', 'Apprenticeship at', $title);
                           echo $title;
                         ?>
                        </p>
                    </td>
                </tr>
            </tbody></table>
            

            <div class="shipment-outer-wrapper">
                <table class="shipment-outer-table">
                    <tbody>
                        <tr>
                            <td>
                                <table class="shipment-table" style="margin:10px auto -2px;width: 50%;">
                                    <tbody>

                                        <tr class="tr-bg-dark">
                                            <td>
                                                <strong>Post Applied For </strong>
                                            </td>
                                            <td>
                                               <?php
                           echo $products3[0]->post_name;
                         ?>
                                            </td>
                                            <td>
                                                <strong>Registration Number</strong>
                                            </td>
                                            <td>
                                                <?php echo $products[0]->career_uniqe_id;?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                    </td></tr></tbody>
                </table>
            </div>

            <div class="resume-content-flow">
                                <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">Candidate's Particulars</span> </legend>
                                    <table class="shipment-table">

                                        <tbody>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Name </strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->name_of_condidate;?>
                                                </td>
                                                <td>
                                                    <strong><?php echo $products[0]->guardianType;?>'s Name </strong>
                                                </td>
                                                <td>
                                                  <?php echo 'Sh. '.$products[0]->guardianName;?>  
                                                </td>
                                                <td rowspan="5">
                                                    
                                                     <?php if(!empty($document[0]->image)){?>
                                    <img id="b_iSignature" src="<?php echo site_url()."/wp-content/plugins/internship/upload/".$document[0]->image;?>" style="height:175px;width:150px;">
                                    <?php }?>

                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Mother's Name </strong>
                                                </td>
                                                <td>
                                                    <?php echo 'Mrs. '.$products[0]->motherName;?>    
                                                </td>
                                                <td>
                                                    <strong>Date of Birth </strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->Dob;?> 
                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Gender </strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->Gender;?> 
                                                </td>
                                                <td>
                                                    <strong>Marital Status </strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->MaritalStatus;?> 
                                                </td>
                                            </tr>
                                            
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Category </strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->ddlCategory;?>
                                                </td>
                                                <td>
                                                    <strong>Minority Community </strong>
                                                    
                                                </td>
                                                <td>
                                                <?php echo $products[0]->MinorityCommunity;?>
                                                </td>

                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Domicile State</strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->DomicileState;?>
                                                </td>
                                                <td>
                                                    <strong>Nationality</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->Nationality;?>
                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>APAAR ID</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->apaarid;?>
                                                </td>
                                                <td>
                                                    <strong>ADHAAR</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->aadhar_card;?>
                                                </td>




                                            </tr>
                                            


                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Application Fee (Including Bank Charges)  </strong>
                                                </td>
                                                <td colspan="3">
                                
                                                <?php if( false && (($products[0]->ddlCategory=='GENERAL' || $products[0]->ddlCategory=='OBC(NCL)' || $products[0]->ddlCategory=='EWS'  ) && ($products[0]->IsExServiceMan=='NO') && ($products[0]->ddlIsPwd=='NO'))){?>
                                                
                                                <?php if($payment[0]->payment_status==0){?>
                                                <?php if ($products3[0]->id == 4 || $products3[0]->id == 5 || $products3[0]->id == 6 || $products3[0]->id == 7 || $products3[0]->id == 8){?>
                                                <p style="padding: 20px;">₹ 500.00 Your Application fee amount is pending </P>
                                                <?php } else {?>
                                                    <p style="padding: 20px;">₹ 500.00 Your Application fee amount is pending kindly <a href="https://www.onlinesbi.com/sbicollect/icollecthome.htm?corpID=893411"  target="_blank">Pay</a><?php } ?></p> <?php }else{?><?php echo '₹'. $payment[0]->payment_amount;?><?php }?>
                                                    
                                                <?php } else {?> ₹ 0.00
                                                <?php }?>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                                <?php if($products3[0]->gate_details==1){?>
                                 <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">Gate Details</span> </legend>
                                    <table class="shipment-table">
                                        <tbody>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>GATE Enrolment Id:</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->gateenrolment_id;?>
                                                </td>
                                                <td>
                                                    <strong>GATE Registration No:</strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->gateregistration_no;?>
                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>GATE Appearing Year:</strong>
                                                </td>
                                                <td>
                                                   <?php echo $products[0]->gate_appearing_year;?>
                                                </td>
                                                <td>
                                                    <strong>GATE Score:</strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->gatescore_no;?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                                <?php }?>
                                <?php if($products3[0]->clat_details==1){?>
                                 <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">CLAT Details</span> </legend>
                                    <table class="shipment-table">
                                        <tbody>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>CLAT Enrolment Id:</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->clatenrolment_id;?>
                                                </td>
                                                <td>
                                                    <strong>CLAT Registration No:</strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->clatregistration_no;?>
                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>CLAT Appearing Year:</strong>
                                                </td>
                                                <td>
                                                   <?php echo $products[0]->clat_appearing_year;?>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                                <?php }?>
                                <?php if($products3[0]->net_details==1){?>
                                 <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">Net Details</span> </legend>
                                    <table class="shipment-table">
                                        <tbody>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Net Enrolment Id:</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->netenrolment_id;?>
                                                </td>
                                                <td>
                                                    <strong>Net Registration No:</strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->netregistration_no;?>
                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Net Appearing Year:</strong>
                                                </td>
                                                <td>
                                                   <?php echo $products[0]->net_appearing_year;?>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </fieldset>
                                <?php }?>
                                <fieldset>
    <legend>
        <span class="fieldHeader ui-widget-header">
            Choice of Posting
        </span>
    </legend>

    <table class="shipment-table">
        <tbody>

        <?php
        $choice_posting = trim(
            (string)($products[0]->ChoicePosting ?? '')
        );

        if (strcasecmp($choice_posting, 'Anywhere') === 0) {
        ?>

            <tr class="tr-bg-dark">
                <td class="textbox textBold" style="width:35%;">
                    Posting Preference
                </td>
                <td>
                    Anywhere
                </td>
            </tr>

        <?php
        } elseif ($choice_posting !== '') {

            // Stored format:
            // 1:Delhi,2:Mumbai,3:Bangalore

            $posting_choices = explode(',', $choice_posting);

            $preference_labels = [
                1 => '1st Preference',
                2 => '2nd Preference',
                3 => '3rd Preference'
            ];

            foreach ($posting_choices as $posting) {

                $parts = explode(':', $posting, 2);

                if (count($parts) !== 2) {
                    continue;
                }

                $preference_no = (int) trim($parts[0]);
                $location = trim($parts[1]);

                if (!isset($preference_labels[$preference_no])) {
                    continue;
                }
        ?>

            <tr class="tr-bg-dark">
                <td class="textbox textBold" style="width:35%;">
                    <?php echo esc_html($preference_labels[$preference_no]); ?>
                </td>

                <td>
                    <?php echo esc_html($location); ?>
                </td>
            </tr>

        <?php
            }

        } else {
        ?>

            <tr>
                <td colspan="2" style="text-align:center;">
                    No details provided
                </td>
            </tr>

        <?php } ?>

        </tbody>
    </table>
</fieldset>

                                <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">PwD Details</span> </legend>
                                    <table class="shipment-table">
                                        <tbody>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    <strong>Is PwBD</strong>
                                                </td>
                                                <td>
                                                    <?php echo $products[0]->ddlIsPwd;?>
                                                </td>
                                                <td>
                                                    <strong>PwBD Category:</strong>
                                                </td>
                                                <td>
                                                    <?php If($products[0]->pwd_category =="Oth") {?>
                                                    <?php   echo "<b>Others:</b> ".$products[0]->pwdothers; }
                                                    else { echo $products[0]->pwd_category;}?>
                                                </td>
                                            </tr>
                                            <tr class="tr-bg-dark">
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    
                                                </td>
                                                <td>
                                                    <strong>PwBD Percentage:</strong>
                                                </td>
                                                <td>
                                                     <?php echo $products[0]->DisabilityPercentage;?>
                                                </td>

                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </fieldset>
                                <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">Qualification Details</span> </legend>
                                <table class="shipment-table">
                                    
                                    <tbody>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Qualification
                                            </td>
                                            <td><?php echo $products[0]->Qualification;?>
                                            </td>
                                            <td class="textbox textBold">Percentage of Marks
                                            </td>
                                            <td>
                                                <?php echo $products[0]->MarksPercentage;?>
                                            </td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Discipline
                                            </td>
                                            <td><?php echo $products[0]->Discipline;?>
                                            </td>
                                           <td></td>
                                           <td></td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Course Duration From
                                            </td>
                                            <td><?php echo $products[0]->CourseFrom;?>
                                            </td>
                                            <td class="textbox textBold">Course Duration To
                                            </td>
                                            <td><?php echo $products[0]->CourseTo;?>
                                            </td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Date of Declaration of Result
                                            </td>
                                            <td><?php echo $products[0]->ResultDeclarationDate;?>
                                            </td>
                                            <td></td>
                                           <td></td>
                                            
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            
                                            <td class="textbox textBold">Institute Name
                                            </td>
                                            <td><?php echo $products[0]->Institution;?>
                                            </td>
                                            <td></td>
                                           <td></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                    </fieldset>

                                 
                                 <fieldset class="resume-desirable-section">
                                     <legend><span class="fieldHeader ui-widget-header">Desirable Qualification</span></legend>
                                     <div class="resume-desirable-scroll">
                                         <table class="shipment-table resume-desirable-table">
                                             <thead>
                                                 <tr>
                                                     <th scope="col">Sr. No.</th>
                                                     <th scope="col">Degree / Qualification</th>
                                                     <th scope="col">Institute / University</th>
                                                     <th scope="col">Discipline</th>
                                                     <th scope="col">Pursuing</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php foreach ($products_professional_exp as $i => $qualification) { ?>
                                                 <tr>
                                                     <td><?php echo (int) $i + 1; ?></td>
                                                     <td><?php echo esc_html($qualification->degree ?? $qualification->qualification ?? $qualification->Degree ?? ''); ?></td>
                                                     <td><?php echo esc_html($qualification->institute_university ?? $qualification->institute ?? $qualification->university ?? $qualification->Institute ?? ''); ?></td>
                                                     <td><?php echo esc_html($qualification->discipline ?? $qualification->Discipline ?? ''); ?></td>
                                                     <td><?php echo esc_html($qualification->pursuning ?? $qualification->pursuning ?? ''); ?></td>
                                                 </tr>
                                                 <?php } ?>
                                                 <?php if (empty($products_professional_exp)) { ?>
                                                 <tr class="resume-empty-row"><td colspan="5">No details provided</td></tr>
                                                 <?php } ?>
                                             </tbody>
                                         </table>
                                     </div>
                                 </fieldset>
                                 

                                 
                                 <fieldset class="resume-desirable-section resume-project-section">
                                     <legend><span class="fieldHeader ui-widget-header">Project / Papers Published / Article Details</span></legend>
                                     <div class="resume-desirable-scroll">
                                         <table class="shipment-table resume-desirable-table">
                                             <thead>
                                                 <tr>
                                                     <th scope="col">Sr. No.</th>
                                                     <th scope="col">Title</th>
                                                     <th scope="col">Type</th>
                                                     <th scope="col">Brief Description</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php foreach ($products_project as $i => $project) { ?>
                                                 <tr>
                                                     <td><?php echo (int) $i + 1; ?></td>
                                                     <td><?php echo esc_html($project->title); ?></td>
                                                     <td><?php echo esc_html($project->type); ?></td>
                                                     <td><?php echo nl2br(esc_html($project->brief)); ?></td>
                                                 </tr>
                                                 <?php } ?>
                                                 <?php if (empty($products_project)) { ?>
                                                 <tr class="resume-empty-row"><td colspan="4">No details provided</td></tr>
                                                 <?php } ?>
                                             </tbody>
                                         </table>
                                     </div>
                                 </fieldset>
                                 

                                 
                                 <fieldset class="resume-desirable-section resume-interest-section">
                                     <legend><span class="fieldHeader ui-widget-header">Statement of Interest / Objectives</span></legend>
                                     <div class="resume-desirable-scroll">
                                         <table class="shipment-table resume-desirable-table">
                                             <thead>
                                                 <tr>
                                                     <th scope="col" style="width:80px;">Sr. No.</th>
                                                     <th scope="col">Brief Description</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php foreach ($product_intrest as $i => $interest) { ?>
                                                 <tr>
                                                     <td><?php echo (int) $i + 1; ?></td>
                                                     <td><?php echo nl2br(esc_html($interest->description)); ?></td>
                                                 </tr>
                                                 <?php } ?>
                                                 <?php if (empty($product_intrest)) { ?>
                                                 <tr class="resume-empty-row"><td colspan="2">No details provided</td></tr>
                                                 <?php } ?>
                                             </tbody>
                                         </table>
                                     </div>
                                 </fieldset>
                                 

                                 
                                 <fieldset class="resume-desirable-section resume-contribution-section">
                                     <legend><span class="fieldHeader ui-widget-header">How Will This Internship Contribute to Your Academic / Professional Development?</span></legend>
                                     <div class="resume-desirable-scroll">
                                         <table class="shipment-table resume-desirable-table">
                                             <thead>
                                                 <tr>
                                                     <th scope="col" style="width:80px;">Sr. No.</th>
                                                     <th scope="col">Brief Description</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <?php foreach ($internship_countiribution as $i => $contribution) { ?>
                                                 <tr>
                                                     <td><?php echo (int) $i + 1; ?></td>
                                                     <td><?php echo nl2br(esc_html($contribution->description)); ?></td>
                                                 </tr>
                                                 <?php } ?>
                                                 <?php if (empty($internship_countiribution)) { ?>
                                                 <tr class="resume-empty-row"><td colspan="2">No details provided</td></tr>
                                                 <?php } ?>
                                             </tbody>
                                         </table>
                                     </div>
                                 </fieldset>
                                 

                                 <fieldset class="resume-address-section">
                                    <legend><span class="fieldHeader ui-widget-header">Address Details</span></legend>
                                    <table class="shipment-table resume-address-comparison">
                                        <thead>
                                            <tr><th scope="col">Present Address</th><th scope="col">Permanent Address</th></tr>
                                        </thead>
                                        <tbody>
                                        <tr class="tr-bg-dark">
                                            <td><span class="address-field-label">Address Line 1</span><span class="address-field-value"><?php echo $products[0]->PresentAddress; ?></span></td>
                                            <td><span class="address-field-label">Address Line 1</span><span class="address-field-value"><?php echo !empty($products[0]->SameAddress) ? $products[0]->PresentAddress : $products[0]->PermanentAddress; ?></span></td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td><span class="address-field-label">Address Line 2 / Landmark</span><span class="address-field-value"><?php echo $products[0]->PresentLandmark; ?></span></td>
                                            <td><span class="address-field-label">Address Line 2 / Landmark</span><span class="address-field-value"><?php echo !empty($products[0]->SameAddress) ? $products[0]->PresentLandmark : $products[0]->PermanentLandmark; ?></span></td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td><span class="address-field-label">City / Town / Village</span><span class="address-field-value"><?php echo $products[0]->PresentCity; ?></span></td>
                                            <td><span class="address-field-label">City / Town / Village</span><span class="address-field-value"><?php echo !empty($products[0]->SameAddress) ? $products[0]->PresentCity : $products[0]->PermanentCity; ?></span></td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td><span class="address-field-label">District</span><span class="address-field-value"><?php echo $products[0]->PresentDistrict; ?></span></td>
                                            <td><span class="address-field-label">District</span><span class="address-field-value"><?php echo !empty($products[0]->SameAddress) ? $products[0]->PresentDistrict : $products[0]->PermanentDistrict; ?></span></td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td><span class="address-field-label">State / UT</span><span class="address-field-value"><?php echo $products[0]->PresentState; ?></span></td>
                                            <td><span class="address-field-label">State / UT</span><span class="address-field-value"><?php echo !empty($products[0]->SameAddress) ? $products[0]->PresentState : $products[0]->PermanentState; ?></span></td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td><span class="address-field-label">PIN Code</span><span class="address-field-value"><?php echo $products[0]->PresentPin; ?></span></td>
                                            <td><span class="address-field-label">PIN Code</span><span class="address-field-value"><?php echo !empty($products[0]->SameAddress) ? $products[0]->PresentPin : $products[0]->PermanentPin; ?></span></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p class="address-same-note">Same as Present Address: <?php echo !empty($products[0]->SameAddress) ? 'Yes' : 'No'; ?></p>
                                 </fieldset>
                                <fieldset>
                                    <legend><span class="fieldHeader ui-widget-header">Contact Details</span> </legend>
                                <table class="shipment-table">
                                    
                                    <tbody>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Mobile Number
                                            </td>
                                            <td><?php echo $products[0]->MobileNumber;?>
                                            </td>
                                            <td class="textbox textBold">STD Code
                                            </td>
                                            <td>
                                                <?php echo $products[0]->StdCode;?>
                                            </td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Landline Number
                                            </td>
                                            <td><?php echo $products[0]->Landline;?>
                                            </td>
                                            <td class="textbox textBold">Primary E-mail
                                            </td>
                                            <td><?php echo $products[0]->Email;?>
                                            </td>
                                        </tr>
                                        <tr class="tr-bg-dark">
                                            <td class="textbox textBold">Alternate E-mail
                                            </td>
                                            <td colspan="3"><?php echo $products[0]->AlternateEmail;?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                    </fieldset>
                                
                      
                     
                    
                    
                    <fieldset class="resume-institute-noc-section">
                        <legend><span class="fieldHeader ui-widget-header">Institute Recommendation / NOC</span></legend>
                        <div class="resume-desirable-scroll">
                            <table class="shipment-table resume-desirable-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr. No.</th>
                                        <th scope="col">Faculty Coordinator / Head of Department</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">Department</th>
                                        <th scope="col">Official Email</th>
                                        <th scope="col">Contact Number</th>
                                        <th scope="col">Recommendation / NOC Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($institute_noc as $i => $noc) { ?>
                                    <tr>
                                        <td><?php echo (int) $i + 1; ?></td>
                                        <td><?php echo esc_html($noc->faculty_cordinator ?? ''); ?></td>
                                        <td><?php echo esc_html($noc->designation ?? ''); ?></td>
                                        <td><?php echo esc_html($noc->department ?? ''); ?></td>
                                        <td><?php echo esc_html($noc->contact_email ?? ''); ?></td>
                                        <td><?php echo esc_html($noc->contact_number ?? ''); ?></td>
                                        <td><?php echo esc_html($noc->document_status ?? ''); ?></td>
                                    </tr>
                                    <?php } ?>
                                                 <?php if (empty($institute_noc)) { ?>
                                                 <tr class="resume-empty-row"><td colspan="7">No details provided</td></tr>
                                                 <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    

                    
                    <fieldset class="resume-previous-work-section">
                        <legend><span class="fieldHeader ui-widget-header">Previous Internship / Work Experience</span></legend>
                        <div class="resume-desirable-scroll">
                            <table class="shipment-table resume-desirable-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sr. No.</th>
                                        <th scope="col">Name of Organization</th>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col">Area / Project</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products_digree_exp as $i => $experience) { ?>
                                    <tr>
                                        <td><?php echo (int) $i + 1; ?></td>
                                        <td><?php echo esc_html($experience->name_of_organization ?? ''); ?></td>
                                        <td><?php echo esc_html($experience->from ?? ''); ?></td>
                                        <td><?php echo esc_html($experience->to ?? ''); ?></td>
                                        <td><?php echo esc_html($experience->basicpay ?? ''); ?></td>
                                        <td><?php echo esc_html($experience->responsbilty ?? ''); ?></td>
                                    </tr>
                                    <?php } ?>
                                                 <?php if (empty($products_digree_exp)) { ?>
                                                 <tr class="resume-empty-row"><td colspan="6">No details provided</td></tr>
                                                 <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                    
                
                







            </div>
        </div>
        <br>
        <div style="padding-left: 5px;">
            <span><span style="color: #333366; font-size: 10pt"><strong><span>CERTIFICATE</span><br>
            </strong></span></span><span style="font-size: 12px">
            <ul>
            <li>
             I hereby declare that the information provided in this application is true and correct to the best of my knowledge. I understand that submission of this application does not guarantee selection. I agree to comply with applicable rules, confidentiality requirements, safety procedures, and instructions during the internship.
            <br/>
            </li>
            <li>
            
            I hereby declare that I have not previously availed benefits under the PM Internship Scheme from any organisation and have not previously undergone apprenticeship in a Central or State Government organisation under NATS, NAPS or another applicable apprenticeship scheme.
            </li>
            </ul>
            </span>
            <table style="width: 100%">
                <tbody><tr>
                    <td style="float: right; padding-right: 15%;">
                        <br>
                        
                        <span style="font-size: 10pt"><strong>Signature: &nbsp;&nbsp;&nbsp;</strong></span>
                         <?php if(!empty($document[0]->signature)){?>
                                    <img id="b_iSignature" src="<?php echo site_url()."/wp-content/plugins/internship/upload/".$document[0]->signature;?>" style="height:60px;width:200px;">
                                    <?php }?>
                    </td>
                </tr>
                <tr>
                
                    <td style="float: right; padding-right: 15%;">
                        <span style="font-size: 10pt"><strong>
                        Date:<?php 
                        $date= date_create($products[0]->created_date);
                        echo date_format($date,"d-M-Y H:i:s");
                        //echo $products[0]->created_date;?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></span>
                    </td>
                </tr>
            </tbody></table>
            <br>
        </div>
        <div class="noprint" style="font-weight: bold; padding-left: 15px; color: green;">
            <input type="button" id="printpagebutton" onclick="printpage()" value="Print Resume" class="btn btn-primary" name="Print" class="noprint btn btn-success">
        </div>
    </form>
    </div>
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        //Print the page content
        window.print()
        //Set the print button to 'visible' again 
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
    }
</script>
