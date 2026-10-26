<?php
    include_once(ABSPATH . 'wp-config.php');
    global $wpdb;
    date_default_timezone_set('Asia/Kolkata');
    //echo ABSPATH . WPINC . '/phpmaller/PHPMailerAutoload.php';
    //exit();
?>
 <?php 
require_once get_template_directory() . '/functions.php';

// Start WAF Protection
custom_waf_protection();
 ?>
 <?php
 $today = strtotime("now");
    $date1 = strtotime("2026-10-16 00:00:00");
    $date2 = strtotime("2026-10-20 23:59:00");
    
     if ($today >= $date2) {

    // Clear ALL session data
    $_SESSION = [];
    session_destroy();

    // Redirect
    wp_safe_redirect(home_url('/internship'));
    exit;
}
 
 
 
 ?>

<style>
    .form-control{display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;}
    .a {
        list-style-type: square !important;
    }
    .error{
            color:red;
        }
    .ui-datepicker .ui-datepicker-title {
    margin: 0 2.3em;
    line-height: 1.8em;
    text-align: center;
    display: flex
;
    justify-content: center;
    justify-content: space-between;


}

.ui-datepicker select.ui-datepicker-year {
    width: 50% !important;
</style>
<?php

    $industry_type_array = array('Accommodation And Food Service Activities','Activities Of Extraterritorial Organization And Bodies',
'Activities Of Households As Employers; Undifferentiated Goods-And Services Producing Activities Of Households For Own Use',
'Administrative And Support Service Activities',
'Agriculture, Forestry And Fishing',
'Arts, Entertainment And Recreation',
'BPO & IT',
'Construction',
'Education',
'Electricity, Gas, Steam And Air Conditioning Supply',
'Financial And Insurance Activities',
'Human Health And Social Work Activities',
'Indian Armed Forces',
'Information And Communication',
'Manufacturing',
'Mining And Quarrying',
'Other Service Activities (including Placement and Employment)',
'Professional, Scientific And Technical Activities',
'Public Administration And Defence; Compulsory Social Security',
'Real Estate Activities',
'Transportation And Storage',
'Unorganised Sector',
'Water Supply; Sewerage, Waste  Management And Remediation Activities',
'Wholesale And Retail Trade; Repair Of Motor Vehicles And Motorcycles',
'Travel and Tourism',
'Chemical Industry and Pharma',
'Others',
);

    $products3 = $wpdb->get_results($wpdb->prepare("SELECT * FROM post_applied_details_int WHERE id = %d AND status = 1", intval($_SESSION['post_applied'])), OBJECT);
    $products = $wpdb->get_results($wpdb->prepare("SELECT * FROM career_document_int WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    $products_digree_exp = $wpdb->get_results($wpdb->prepare("SELECT * FROM career_work_int WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    $products_professional_exp =$wpdb->get_results($wpdb->prepare("SELECT * FROM career_professional_int WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    $total_count = count($products_professional_exp);

    $products_project =$wpdb->get_results($wpdb->prepare("SELECT * FROM career_project_details_int WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    $project_count = count($products_project);

    $product_intrest =$wpdb->get_results($wpdb->prepare("SELECT * FROM statement_of_intrest_int WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    $internship_countiribution =$wpdb->get_results($wpdb->prepare("SELECT * FROM internship_countiribution WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    $institute_noc =$wpdb->get_results($wpdb->prepare("SELECT * FROM institute_noc WHERE career_id = %d", intval($_SESSION['user_id'])), OBJECT);
    
    $user_id  = absint($_SESSION['user_id']);
        /*echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
        exit();*/
    $mimeExtsAllowed = array('image/jpeg', 'image/png', 'image/jpg', 'application/pdf'); 
    function filename($y) {
    
    return $fname = hash('ripemd160', $_SESSION['user_id'].$y);
    }
    
    if(isset($_POST['experience_data'])){
        
        foreach($_POST['exam_passed'] as $key=>$exampassed){
            $wpdb->insert('career_professional_int', array(
                'career_id' => $_SESSION['user_id'],
                'degree' => $exampassed,
                'institute' => $_POST['year_passing'][$key],
                'discipline' => $_POST['markes'][$key],
                'pursuning' => $_POST['marks_percent'][$key],
                'dateof_complication' => $_POST['board_university'][$key],
                
            ));    
        }
        
        foreach($_POST['name_of_organization'] as $key1=> $nameof_organization){
            $wpdb->insert('career_work_int', array(
                'career_id' => $_SESSION['user_id'],
                'name_of_organization' => $nameof_organization,
                'designation' => $_POST['deginations'][$key1],
                'basicpay' => $_POST['basicpay'][$key1],
                'from' => $_POST['from'][$key1],
                'to' => $_POST['to'][$key1],
                'responsbilty' => $_POST['responsblity'][$key1],
                'employee_type' => $_POST['employee_type'][$key1],
                'type_of_emp' => $_POST['emploment_type'][$key1],
                'industrty_type' => $_POST['industry_type'][$key1],
                
            ));    
        }
        
    }
   
    
    if ( isset($_POST['uploadphoto']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error1 = '';
    $file     = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    if ( ! in_array( $file_mime, $mimeExtsAllowed, true ) ) {
        $error1 = 'Invalid file type.';
    } elseif ( $file_size > 50000 ) {
        $error1 = 'Only 50 KB allowed.';
    } elseif ( ! in_array( $file_ext, array( 'jpg', 'jpeg', 'png' ), true ) ) {
        $error1 = 'Allowed formats: JPG, JPEG, PNG.';
    } else {

        $newfilename = filename('CandidateImage') . '.' . $file_ext;
            
        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'image'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}
    
   if ( isset($_POST['uploadsignature']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error2 = ''; 
    $file     = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    if ( ! in_array( $file_mime, $mimeExtsAllowed, true ) ) {
        $error2 = 'Invalid file type.';
    } elseif ( $file_size > 30000 ) {
        $error2 = 'Only 30 KB allowed.';
    } elseif ( ! in_array( $file_ext, array( 'jpg', 'jpeg', 'png' ), true ) ) {
        $error2 = 'Allowed formats: JPG, JPEG, PNG.';
    } else {

        $newfilename = filename('CandidateSign') . '.' . $file_ext;
            
        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'signature'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}

    if ( isset($_POST['uploaddob']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error3 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error3 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error3 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error3 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('DoBCertificate') . '.pdf';

        if ( int_upload_candidate(
               
                $file_tmp,
                $user_id,
                $newfilename,
                'birth_certificate'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}
    if ( isset($_POST['uploadpay']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error14 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error14 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error14 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error14 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('CandidateAadhar') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'payslip'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}

    if ( isset($_POST['uploaddbt']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error140 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error140 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error140 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error140 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('Candidatedbt') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'dbtacc'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}
    if ( isset($_POST['uploadpan']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error150 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error150 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error150 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error150 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('Candidatepan') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'pan'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}


    if ( isset($_POST['UploadCertificate']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error4 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error4 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error4 = 'Invalid PDF file.';
    } elseif ( $file_size > ( 5 * 1024 * 1024 ) ) { // ✅ 5 MB
        $error4 = 'Maximum allowed file size is 5 MB.';
    } else {

        $newfilename = filename('DegreeCertificate') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'degree_certificate'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}

if ( isset($_POST['UploadProjectDocument']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
     $error6 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error6 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error6 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error6 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('UploadProjectDocument') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'project_paper_document'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}

    if ( isset($_POST['UploadDesiableCertificate']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
     $error6 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error6 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error6 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error6 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('DesirableCertificate') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'desirable_certificate'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}

    if ( isset($_POST['UploadPwdCertificate']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
     $error6 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error6 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error6 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error6 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('PWDCertificate') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'pwd_certificate'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}
    
    if ( isset($_POST['UploadEmpExchangeCertificate']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error8 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error8 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error8 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error8 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('CandidateNATs') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'exchange_certificate'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}
    
    if ( isset($_POST['uploadsc_stcertificate']) && isset($_FILES['ctl00$b$fPhotoUpload']) ) {
    $error13 = '';
    $file = $_FILES['ctl00$b$fPhotoUpload'];

    $file_tmp  = $file['tmp_name'];
    $file_size = absint( $file['size'] );
    $file_name = sanitize_file_name( wp_unslash( $file['name'] ) );
    $file_ext  = strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
    $file_mime = mime_content_type( $file_tmp );

    /* ✅ STRICT PDF ONLY */
    if ( $file_ext !== 'pdf' ) {
        $error13 = 'Only PDF files are allowed.';
    } elseif ( ! in_array( $file_mime, array( 'application/pdf' ), true ) ) {
        $error13 = 'Invalid PDF file.';
    } elseif ( $file_size > ( .5 * 1024 * 1024 ) ) {
        $error13 = 'Only 500 KB allowed.';
    } else {

        $newfilename = filename('SCSTOBCCastCert') . '.pdf';

        if ( int_upload_candidate(
                
                $file_tmp,
                $user_id,
                $newfilename,
                'sc_st_certificate'
            )
        ) {
            wp_safe_redirect( esc_url_raw( $_SERVER['REQUEST_URI'] ) );
            exit;
        }
    }
}
    

?>
<style>
.page-header{display:none;}
</style>
<div id="b_ctl00">
     <div style="width: 100%"> <img src="<?php echo site_url();?>/wp-content/plugins/careers/images/banner.jpg" alt="GRID-INDIA Recruitment"></div>
            <h3 style="text-align: center; padding-bottom: 0; margin-bottom: 0;" class="alert alert-danger">Important Guidelines</h3>
            <ul class="alert alert-success" style="padding-left: 2%">
                <li class="a">Fill in the details for each organization.</li>
                <li class="a">Detail of more than one post held within the same organization should be filled
            separately.</li>
                <li class="a">Fill in the details in chronological order starting from the first employment to
            present employment.</li>
                <li class="a">Do not include teaching and trainee period in experience.
                </li>
            </ul>
            
            
            
            
            <div id="b_p3">
        
                <form name="experience_data" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                    <style>
    .desirable-section {
        border: 1px solid #d8e2ee;
        border-radius: 8px;
        padding: 18px;
        margin-top: 15px;
        background: #ffffff;
    }

    .desirable-section legend {
        width: auto;
        padding: 0 10px;
        font-size: 16px;
        font-weight: 600;
        color: #174578;
    }

    .desirable-table {
        width: 100%;
        min-width: 1050px;
        margin-bottom: 0;
    }

    .desirable-table thead th {
        background: #174578;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        padding: 12px 10px;
        vertical-align: middle;
        border: 1px solid #dce4ed;
    }

    .desirable-table tbody td {
        padding: 10px 8px;
        vertical-align: middle;
        border: 1px solid #e2e8f0;
    }

    .desirable-table .form-control {
        width: 100%;
        min-height: 38px;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-radius: 5px;
        padding: 7px 9px;
        box-sizing: border-box;
    }

    .desirable-table .form-control:focus {
        border-color: #3678bb;
        box-shadow: 0 0 0 2px rgba(54,120,187,0.12);
        outline: none;
    }

    .desirable-table .form-control:disabled {
        background-color: #edf0f4;
        color: #777;
        cursor: not-allowed;
    }

    .desirable-table .btn-add {
        background: #198754;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 9px 20px;
        font-weight: 600;
        cursor: pointer;
    }

    .desirable-table .btn-delete {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 7px 12px;
        cursor: pointer;
    }

    .desirable-note {
        font-size: 12px;
        color: #64748b;
        margin: 8px 0 12px;
    }

    .desirable-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }
</style>


<fieldset class="desirable-section">

    <legend>
        Desirable Qualification
    </legend>

    <p class="desirable-note" style="color: red;">
        
        Select “Yes” under “Pursuing” if the qualification has not yet been completed. If “Yes” is selected, upload the relevant supporting document in the “Desirable Qualification” section under “Photo and Signature / Document Uploads.”
    </p>

    <div class="desirable-table-wrapper">

        <table class="table table-hover table-striped order-list1 desirable-table">

            <thead>
                <tr>
                    <th style="width: 16%;">Examination / Degree</th>
                    <th style="width: 29%;">Institute / Board / University</th>
                    <th style="width: 20%;">Discipline</th>
                    <th style="width: 12%;">Pursuing</th>
                    <th style="width: 15%;">Date of Completion</th>
                    <th style="width: 8%;">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($products_professional_exp)) {

                    for ($i = 0; $i < count($products_professional_exp); $i++) {
                ?>

                <tr>

                    <td>
                        <?php
                        echo esc_html($products_professional_exp[$i]->degree);
                        ?>
                    </td>

                    <td>
                        <?php
                        echo esc_html($products_professional_exp[$i]->institute);
                        ?>
                    </td>

                    <td>
                        <?php
                        echo esc_html($products_professional_exp[$i]->discipline);
                        ?>
                    </td>

                    <td>
                        <?php
                        echo esc_html($products_professional_exp[$i]->pursuning);
                        ?>
                    </td>

                    <td>
                        <?php
                        echo esc_html($products_professional_exp[$i]->dateof_complication);
                        ?>
                    </td>

                    <td>
                        <input
                            type="button"
                            id="delete_row1"
                            class="btn-delete"
                            attr_value_pro="<?php
                                echo esc_attr(
                                    $products_professional_exp[$i]->professional_id
                                );
                            ?>"
                            value="Delete">
                    </td>

                </tr>

                <?php
                    }
                }
                ?>

                <!-- NEW QUALIFICATION ENTRY -->

                <tr>

                    <!-- Degree -->
                    <td>
                        <select
                            name="exam_passed[]"
                            id="exam_passed"
                            class="form-control">

                            <option value="">Select Degree</option>
                            <option value="M.Tech.">M.Tech.</option>
                            <option value="MSR">MSR</option>
                            <option value="M.E.">M.E.</option>
                            <option value="PHD">Ph.D.</option>

                        </select>
                    </td>

                    <!-- Institute / University -->
                    <td>
                        <input
                            type="text"
                            name="year_passing[]"
                            id="year_passing"
                            class="form-control"
                            placeholder="Enter Institute / University Name"
                            maxlength="255">
                    </td>

                    <!-- Discipline -->
                    <td>
                        <input
                            type="text"
                            name="markes[]"
                            id="markes"
                            class="form-control"
                            placeholder="Enter Discipline"
                            maxlength="150">
                    </td>

                    <!-- Pursuing -->
                    <td>
                        <select
                            name="marks_percent[]"
                            id="marks_percent"
                            class="form-control pursuing-select">

                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>

                        </select>
                    </td>

                    <!-- Completion Date -->
                    <td>
                        <input
                            type="date"
                            name="board_university[]"
                            id="board_university"
                            class="form-control completion-date">
                    </td>

                    <!-- Add Button -->
                    <td>
                        <input
                            type="button"
                            id="addrow1"
                            class="btn-add"
                            value="+ Add">
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</fieldset>

<fieldset class="desirable-section">

    <legend>
        Project / Papers Published / Artical Details
    </legend>

    <p class="desirable-note" style="color: red;">
    If you provide details under “Project / Papers Published / Article Details”,
    please upload the relevant supporting documents in the
    “Desirable Qualification” section under
    “Photo and Signature / Document Uploads.”
</p>

    <div class="desirable-table-wrapper">

        <table class="table table-hover table-striped order-list1 desirable-table">

            <thead>
                <tr>
                    <th style="width: 16%;">Title</th>
                    <th style="width: 29%;">Type</th>
                    <th style="width: 20%;">Brief Description</th>
                    
                    <th style="width: 8%;">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($products_project)) {

                    for ($i = 0; $i < count($products_project); $i++) {
                ?>

                <tr>

                    <td>
                        <?php
                        echo esc_html($products_project[$i]->title);
                        ?>
                    </td>

                    <td>
                        <?php
                        echo esc_html($products_project[$i]->type);
                        ?>
                    </td>

                    

                    <td>
                        <?php
                        echo esc_html($products_project[$i]->brief);
                        ?>
                    </td>

                    <td>
                        <input
                            type="button"
                            id="delete_project"
                            class="btn-delete"
                            attr_value_pro="<?php
                                echo esc_attr(
                                    $products_project[$i]->id
                                );
                            ?>"
                            value="Delete">
                    </td>

                </tr>

                <?php
                    }
                }
                ?>

                <!-- NEW QUALIFICATION ENTRY -->
<style>
.project-row td {
    padding: 12px;
    vertical-align: top;
}

.project-description {
    min-height: 110px;
    resize: vertical;
    line-height: 1.5;
}

.word-counter {
    text-align: right;
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.word-counter.warning {
    color: #d97706;
    font-weight: bold;
}

.word-counter.limit {
    color: #dc2626;
    font-weight: bold;
}

.word-warning {
    display: block;
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.btn-add {
    background: #198754;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 6px;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}
</style>
                <tr class="project-row">

    <!-- Title -->
    <td style="width:25%; vertical-align:top;">
        <input type="text"
               class="form-control"
               name="title[]"
               maxlength="200"
               placeholder="Enter project / paper title" id="title_paper"
               >
    </td>

    <!-- Type -->
    <td style="width:20%; vertical-align:top;">
        <select class="form-control"
                name="type[]" id="paper_type"
                >
            <option value="">Select Type</option>
            <option value="Project">Project</option>
            <option value="Paper">Paper</option>
            <option value="Research Work">Research Work</option>
            <option value="Published Article">Published Article</option>
        </select>
    </td>

    <!-- Brief Description -->
    <td style="width:45%; vertical-align:top;">

        <textarea
            class="form-control project-description"
            name="brief_description[]"
            rows="4"
            maxlength="1500" id="brief_description"
            placeholder="Enter brief description (maximum 150 words)"
            ></textarea>

        <div class="word-counter">
            <span class="word-count">0</span> / 150 words
        </div>

        <small class="word-warning"></small>

    </td>

    <!-- Add / Delete -->
    <td style="width:10%; vertical-align:top;">

        <button type="button"
                class="btn-add add-project" id="project_paper">
            + Add
        </button>

        <button type="button"
                class="btn-remove remove-project"
                style="display:none;">
            Delete
        </button>

    </td>

</tr>

            </tbody>

        </table>

    </div>

</fieldset>

<fieldset class="desirable-section">

    <legend>
        Statement of interest/objectives:*
    </legend>

    
    <div class="desirable-table-wrapper">

        <table class="table table-hover table-striped order-list1 desirable-table">

            <thead>
                <tr>
                    
                    <th style="width: 20%;">Brief Description</th>
                    
                    <th style="width: 8%;">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($product_intrest)) {

                    for ($i = 0; $i < count($product_intrest); $i++) {
                ?>

                <tr>

                   

                    

                    <td>
                        <textarea
            class="form-control project-description"
            name="update_statement_of_intress[]" id="update_statement_of_intrest"
            rows="4"
            maxlength="1500"
            placeholder="Enter brief description (maximum 150 words)"
            required><?php
                        echo esc_html($product_intrest[$i]->description);
                        ?></textarea>
                        <input type="hidden" name="intrest_id" id="intrest_id" value="<?php
                                echo esc_attr(
                                    $product_intrest[$i]->id
                                );
                            ?>" />
                    </td>

                    <td>
                        <input
                            type="button"
                            id="update_button_statement_of_intrest"
                            
                            value="Update">
                        
                    </td>

                </tr>

                <?php
                    }
                }
                ?>

                <!-- NEW QUALIFICATION ENTRY -->
<style>
.project-row td {
    padding: 12px;
    vertical-align: top;
}

.project-description {
    min-height: 110px;
    resize: vertical;
    line-height: 1.5;
}

.word-counter {
    text-align: right;
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.word-counter.warning {
    color: #d97706;
    font-weight: bold;
}

.word-counter.limit {
    color: #dc2626;
    font-weight: bold;
}

.word-warning {
    display: block;
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.btn-add {
    background: #198754;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 6px;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}
</style>

<?php if(empty($product_intrest)){?>
                <tr class="project-row">

    
    <td style="width:45%; vertical-align:top;">

        <textarea
            class="form-control project-description"
            name="brief_description[]"
            rows="4"
            maxlength="1500" id="description_statement_of_intrest"
            placeholder="Enter brief description (maximum 150 words)"
            required></textarea>

        <div class="word-counter">
            <span class="word-count">0</span> / 150 words
        </div>

        <small class="word-warning"></small>

    </td>

    <!-- Add / Delete -->
    <td style="width:10%; vertical-align:top;">

        <button type="button"
                class="btn-add add-project" id="addstatementofintress">
            + Add
        </button>


    </td>

</tr>
<?php }?>
            </tbody>

        </table>

    </div>

</fieldset>

<fieldset class="desirable-section">

    <legend>
        How will this internship contribute to your academic /professional development?
    </legend>


    <div class="desirable-table-wrapper">

        <table class="table table-hover table-striped order-list1 desirable-table">

            <thead>
                <tr>
                    
                    <th style="width: 20%;">Brief Description</th>
                    
                    <th style="width: 8%;">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($internship_countiribution)) {

                    for ($i = 0; $i < count($internship_countiribution); $i++) {
                ?>

                <tr>

                   

                    

                    <td>
                        <textarea
            class="form-control project-description"
            name="update_statement_of_intress[]" id="update_intership_contribution"
            rows="4"
            maxlength="1500"
            placeholder="Enter brief description (maximum 150 words)"
            required><?php
                        echo esc_html($internship_countiribution[$i]->description);
                        ?></textarea>
                        <input type="hidden" name="intership_id" id="intership_id" value="<?php
                                echo esc_attr(
                                    $internship_countiribution[$i]->id
                                );
                            ?>" />
                    </td>

                    <td>
                        <input
                            type="button"
                            id="update_button_internship_contribution"
                            
                            value="Update">
                        
                    </td>

                </tr>

                <?php
                    }
                }
                ?>

                <!-- NEW QUALIFICATION ENTRY -->
<style>
.project-row td {
    padding: 12px;
    vertical-align: top;
}

.project-description {
    min-height: 110px;
    resize: vertical;
    line-height: 1.5;
}

.word-counter {
    text-align: right;
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.word-counter.warning {
    color: #d97706;
    font-weight: bold;
}

.word-counter.limit {
    color: #dc2626;
    font-weight: bold;
}

.word-warning {
    display: block;
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.btn-add {
    background: #198754;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 6px;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}
</style>

<?php if(empty($internship_countiribution)){?>
                <tr class="project-row">

    
    <td style="width:45%; vertical-align:top;">

        <textarea
            class="form-control project-description"
            name="brief_description[]"
            rows="4"
            maxlength="1500" id="description_intership_contribution"
            placeholder="Enter brief description (maximum 150 words)"
            required></textarea>

        <div class="word-counter">
            <span class="word-count">0</span> / 150 words
        </div>

        <small class="word-warning"></small>

    </td>

    <!-- Add / Delete -->
    <td style="width:10%; vertical-align:top;">

        <button type="button"
                class="btn-add add-project" id="addinternshipcontribution">
            + Add
        </button>


    </td>

</tr>
<?php }?>
            </tbody>

        </table>

    </div>

</fieldset>
                    <div id="Message" class="alert alert-danger" style="display: none"></div>
                    
                    
                </fieldset>
                <style>
                input.break {
    word-wrap: break-word;
    word-break: break-all;
    height: 80px;
}
                </style>
                <style>
/* Work Experience Section */
.work-exp-section {
    border: none;
    border-top: 1px solid #d5e1ee;
    margin-top: 10px;
    padding: 0;
}

.work-exp-section legend {
    width: auto;
    padding: 0 15px;
    margin-left: 2px;
    border: none;
    color: #003b71;
    font-size: 23px;
    font-weight: 500;
}

.work-exp-instruction {
    color: #52749a;
    font-size: 16px;
    margin: 25px 0 18px;
}

/* Table */
.work-exp-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.work-exp-table thead th {
    background-color: #194779 !important;
    color: #ffffff !important;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    padding: 20px 12px;
    border: 1px solid #d9e3ee;
    vertical-align: middle;
}

/* Saved records */
.work-exp-table tbody tr.saved-record td {
    background: #f5f5f5;
    padding: 20px 12px;
    font-size: 17px;
    color: #222;
    border: 1px solid #dce4ed;
}

/* New entry */
.work-exp-table tbody tr.new-entry td {
    background: #ffffff;
    padding: 12px;
    border: 1px solid #dce4ed;
    vertical-align: middle;
}

.work-exp-table .form-control {
    width: 100%;
    height: 56px;
    padding: 12px;
    border: 1px solid #cbd9e8;
    border-radius: 8px;
    font-size: 16px;
    box-sizing: border-box;
}

.work-exp-table textarea.form-control {
    height: 70px;
    min-height: 70px;
    resize: vertical;
}

.work-exp-table .form-control:focus {
    border-color: #428bca;
    outline: none;
    box-shadow: 0 0 0 2px rgba(66,139,202,0.12);
}

.work-exp-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.work-exp-add-btn {
    background: #198754;
    color: white;
    border: none;
    padding: 12px 18px;
    border-radius: 6px;
    cursor: pointer;
}

.work-exp-delete-btn {
    background: #dc3545;
    color: white;
    border: none;
    padding: 12px 15px;
    border-radius: 6px;
    cursor: pointer;
}

.work-exp-note {
    font-size: 13px;
    color: #52749a;
    margin-top: 12px;
}
</style>
                 <fieldset class="work-exp-section">

    <legend>PREVIOUS INTERNSHIP / WORK EXPERIENCE</legend>

    

    <div class="work-exp-table-wrapper">

        <table class="table order-list work-exp-table">

            <thead>
                <tr>
                    <th>Name of Organization</th>
                    
                    
                    <th style="width:150px;">From</th>
                    <th style="width:150px;">To</th>
                    <th>Area / Project</th>
                    <th>Descrition</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php if (!empty($products_digree_exp)) {

                for ($i = 0; $i < count($products_digree_exp); $i++) { ?>

                    <tr class="saved-record">

                        <td>
                            <?php echo esc_html($products_digree_exp[$i]->name_of_organization); ?>
                        </td>

                       
                        <td>
                            <?php echo esc_html($products_digree_exp[$i]->from); ?>
                        </td>

                        <td>
                            <?php echo esc_html($products_digree_exp[$i]->to); ?>
                        </td>
                        <td>
                            <?php echo esc_html($products_digree_exp[$i]->basicpay); ?>
                        </td>

                        

                        <td>
                            <?php echo esc_html($products_digree_exp[$i]->responsbilty); ?>
                        </td>

                        <td>
                            <input type="button"
                                   id="deletedigree"
                                   attr_value="<?php echo esc_attr($products_digree_exp[$i]->work_id); ?>"
                                   value="Delete"
                                   class="work-exp-delete-btn">
                        </td>

                    </tr>

                <?php }

                $end_array_datas = end($products_digree_exp);
            } ?>

                <tr class="new-entry">

                    <td>
                        <textarea name="name_of_organization[]"
                                  id="name_of_organization"
                                  class="form-control"></textarea>
                    </td>

                    <td>
                        <?php if (!empty($products_digree_exp)) { ?>
                            <input type="hidden"
                                   value="<?php echo esc_attr($end_array_datas->to); ?>"
                                   id="to_date">
                        <?php } ?>

                        <input type="text"
                               name="from[]"
                               id="from"
                               class="form-control"
                               <?php if (!empty($products_digree_exp)) echo 'readonly="true"'; ?>
                               tabindex="-1">
                    </td>

                    <td>
                        <input type="text"
                               name="to[]"
                               id="to"
                               class="form-control"
                               <?php if (!empty($products_digree_exp)) echo 'readonly="true"'; ?>
                               tabindex="-1">
                    </td>

                    <td>
                        <input type="text"
                               name="basicpay[]"
                               id="basicpay"
                               class="form-control"
                               tabindex="-1">
                    </td>

                    

                    <td>
                        <textarea name="responsblity[]"
                                  id="responsblity"
                                  class="form-control"></textarea>
                    </td>

                    <td>
                        <input type="button"
                               id="addrow"
                               value="+ Add"
                               class="work-exp-add-btn">
                    </td>

                </tr>

            </tbody>
        </table>

    </div>

    <p class="work-exp-note">
        <strong># Basic Pay:</strong> For candidates from Government / PSUs.
        <strong>CTC:</strong> Monthly emoluments from the private sector.
    </p>
<style>
.project-row td {
    padding: 12px;
    vertical-align: top;
}

.project-description {
    min-height: 110px;
    resize: vertical;
    line-height: 1.5;
}

.word-counter {
    text-align: right;
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

.word-counter.warning {
    color: #d97706;
    font-weight: bold;
}

.word-counter.limit {
    color: #dc2626;
    font-weight: bold;
}

.word-warning {
    display: block;
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.btn-add {
    background: #198754;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 6px;
}

.btn-remove {
    background: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
}
</style>
</fieldset>
         <fieldset class="desirable-section">

    <legend>
        INSTITUTE RECOMMENDATION / NOC 
    </legend>

    <p class="desirable-note" style="color: red; font-size: 12px;">
    If “Attached” is selected, please combine the Institute Recommendation / NOC
    with the Desirable Qualification supporting document into a single PDF
    and upload it under “Desirable Qualification” in the
    “Photo and Signature / Document Uploads” section.
</p>

    <div class="desirable-table-wrapper">

        <table class="table table-hover table-striped order-list1 desirable-table">

            <thead>
                <tr>
                    <th style="width: 16%;">Faculty Coordinator / Head of Department</th>
                    <th style="width: 29%;">Designation</th>
                    <th style="width: 20%;">Department</th>
                    <th style="width: 12%;">Official Email</th>
                    <th style="width: 12%;">Contact Number</th>
                    <th style="width: 15%;">Recommendation / NOC</th>
                    <th style="width: 8%;">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($institute_noc)) {

                    for ($i = 0; $i < count($institute_noc); $i++) {
                ?>

                <tr>

                    <!-- Degree -->
                    <td>
                        <input type="text" name="faculty_cordinator" id="faculty_cordinator_update" class="form-control" value="<?php echo esc_html($institute_noc[$i]->faculty_cordinator);?>">
                    </td>

                    <!-- Institute / University -->
                    <td>
                        <input type="text" name="designation" id="designation_update" class="form-control" value="<?php echo esc_html($institute_noc[$i]->designation);?>">
                    </td>

                    <!-- Discipline -->
                    <td>
                        <input type="text" name="department" id="department_update" class="form-control" value="<?php echo esc_html($institute_noc[$i]->department);?>">
                    </td>

                    <!-- Pursuing -->
                    <td>
                        <input type="text" name="contact_email" id="contact_email_update" class="form-control" value="<?php echo esc_html($institute_noc[$i]->contact_email);?>">
                    </td>
                    <td>
                        <input type="text" name="contact_number" id="contact_number_update" class="form-control" value="<?php echo esc_html($institute_noc[$i]->contact_number);?>">
                        <input type="hidden" name="noc_id" id="noc_id_update" class="form-control" value="<?php echo esc_html($institute_noc[$i]->id);?>">
                    </td>

                    <!-- Completion Date -->
                    <td>
    <label style="margin-right:15px;">
        <input type="radio"
               name="document_status_update" id="document_status_update"
               value="Attached" <?php if($institute_noc[$i]->document_status=='Attached'){?>checked<?php }?>
               >
        Attached
    </label>

    <label>
        <input type="radio"
               name="document_status_update" id="document_status_update"
               value="To be submitted" <?php if($institute_noc[$i]->document_status=='To be submitted'){?>checked<?php }?>>
        To be submitted
    </label>
</td>

                    <!-- Add Button -->
                    <td>
                        <input
                            type="button"
                            id="institute_recomendation_update"
                            class="btn-edit"
                            value="Update">
                    </td>

                </tr>

                <?php
                    }
                }
                ?>

                <!-- NEW QUALIFICATION ENTRY -->
                <?php if(empty($institute_noc)){?>
                <tr>

                    <!-- Degree -->
                    <td>
                        <input type="text" name="faculty_cordinator" id="faculty_cordinator" class="form-control">
                    </td>

                    <!-- Institute / University -->
                    <td>
                        <input type="text" name="designation" id="designation" class="form-control">
                    </td>

                    <!-- Discipline -->
                    <td>
                        <input type="text" name="department" id="department" class="form-control">
                    </td>

                    <!-- Pursuing -->
                    <td>
                        <input type="text" name="contact_email" id="contact_email" class="form-control">
                    </td>
                    <td>
                        <input type="text" name="contact_number" id="contact_number" class="form-control">
                    </td>

                    <!-- Completion Date -->
                    <td>
    <label style="margin-right:15px;">
        <input type="radio"
               name="document_status" id="document_status"
               value="Attached"
               >
        Attached
    </label>

    <label>
        <input type="radio"
               name="document_status" id="document_status"
               value="To be submitted">
        To be submitted
    </label>
</td>

                    <!-- Add Button -->
                    <td>
                        <input
                            type="button"
                            id="institute_recomendation"
                            class="btn-add"
                            value="+ Add">
                    </td>

                </tr>
<?php }?>
            </tbody>

        </table>

    </div>

</fieldset>   
    </div>
   <br/>

            <div id="b_p3">
        
                <fieldset>
                    <legend><span class="fieldHeader ui-widget-header">Photo and Signature / Document Uploads.</span> </legend>
                    <table class="table table-hover table-striped">
                        <tbody>
                            <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox" style="width: 30%">Upload Your Photo
                                    <br>
                                    <span style="color: green">Maximum size is 50 KB</span>

                                </td>
                                <td style="width: 30%">
                                    <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error1)){ echo $error1; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>

                                </td>
                                <td style="width: 30%">
                                    
                                    <input type="submit" name="uploadphoto" value="Upload Photo" id="b_bUploadPhoto" class="btn btn-info">
                                    <?php if(!empty($products[0]->image)){?>
                                    <input type="hidden" name="upload_image" id="upload_image" value="1" /> 
                                    <img id="b_iPhoto" src="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->image;?>" style="height:175px;width:150px;">
                                    <?php }?>
                                    
                                </td>
                            </tr>
                         </form>
                         <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox">Upload Your Signature<br>
                                    <span style="color: green">Maximum size is 30 KB</span>
                                </td>
                                <td>
                                     <input type="file" name="ctl00$b$fPhotoUpload" style="font-size: 15px;" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                     <br/><p style="color:red; font-size: 10px;" >   <?php if(isset($error2)){ echo $error2; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
                                <td>
                                    
                                    <input type="submit" name="uploadsignature" value="Upload Signature" style="font-size: 15px;"  id="b_bUploadSignature" class="btn btn-info">
                                    <?php if(!empty($products[0]->signature)){?>
                                    <input type="hidden" name="upload_signature" id="upload_signature" value="1" />
                                    <img id="b_iSignature" src="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->signature;?>" style="height:60px;width:200px;">
                                    <?php }?>
                                    
                                </td>
                            </tr>
                            </form>
                            <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox">Date of Birth Certificate / SSC Certificate / 10<sup>th</sup> Certificate<br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
                                <td>
                                    <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                     <br/><p style="color:red; font-size: 10px;" >   <?php if(isset($error3)){ echo $error3; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
                                <td>
                                    <input type="submit" name="uploaddob" value="Upload Certificate" style="font-size: 15px;"  id="b_bUploadDob" class="btn btn-info">
                                    <?php if(!empty($products[0]->birth_certificate)){?>
                                    <input type="hidden" id="birth_certificate" name="birth_certificate" value="1" /> 
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->birth_certificate;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                      <?php }?>
                                </td>
                            </tr>
                        </form>
                        <?php if($_SESSION['check_apearing_mode']=='Passed'){?>
                        <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox">
                                    Degree Certificate and All Mark Sheets of Degree indicating marks (*) (alongwith CGPA conversion document, if applicable)
                                    <br>
                                    <span style="color: green">Maximum size is 5 MB</span>
                                </td>
                                <td>
                                     <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" > <?php if(isset($error4)){ echo $error4; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
                                <td>
                                    <input type="submit" name="UploadCertificate" value="Upload Certificate/Marksheet" id="b_bUploadCertificate" class="btn btn-info">
                                    <?php if(!empty($products[0]->degree_certificate)){?>
                                    <input type="hidden" id="degr" name="degr" value="1" />
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->degree_certificate;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                    <?php }?>
                                      
                                </td>
                            </tr>
                           </form>
                           <?php } ?>
                           
                            <?php if($total_count > 0){?>
                           
                           <form name="upload_desirable" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            
                            <tr id="b_trPwdCertificate">
            <td class="textbox">Desirable examnination degree certificate
                                    <br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
            <td>
                                     <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error6)){ echo $error6; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    <span id="b_lPhotoMsg"></span>
                                </td>
            <td>
                                    <input type="submit" name="UploadDesiableCertificate" value="Upload Desirable Certificate"  id="UploadDesiableCertificate" class="btn btn-info">
                                    <?php if(!empty($products[0]->desirable_certificate)){?>
                                    <input type="hidden" id="desiraablevariable" name="desiraablevariable" value="1" />
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->desirable_certificate;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                    <?php }?>
                                    
                                </td>
        </tr>
        
                           </form>
                           <?php }?>
                           <?php if($project_count > 0){?>
                           
                           <form name="upload_project_document" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            
                            <tr id="b_trPwdCertificate">
            <td class="textbox">Project Document
                                    <br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
            <td>
                                     <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error6)){ echo $error6; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
            <td>
                                    <input type="submit" name="UploadProjectDocument" value="Upload Project Document"  id="UploadDesiableCertificate" class="btn btn-info">
                                    <?php if(!empty($products[0]->project_paper_document)){?>
                                    <input type="hidden" id="project_hidden" name="project_hidden" value="1" />
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->project_paper_document;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                    <?php }?>
                                    
                                </td>
        </tr>
        
                           </form>
                           <?php }?>
                           <?php if($_SESSION['pwd_details']=='YES'){?>
                           <input type="hidden" id="pwdflag" name="pwdflag" value="1" />
                           <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            
                            <tr id="b_trPwdCertificate">
            <td class="textbox">PwD Certificate
                                    <br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
            <td>
                                     <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error6)){ echo $error6; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
            <td>
                                    <input type="submit" name="UploadPwdCertificate" value="Upload PwD Certificate"  id="b_bUploadPwdCertificate" class="btn btn-info">
                                    <?php if(!empty($products[0]->pwd_certificate)){?>
                                    <input type="hidden" id="pwdclat" name="pwdclat" value="1" />
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->pwd_certificate;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                    <?php }?>
                                    
                                </td>
        </tr>
        
                           </form>
                           <?php }?>
                           
                            <?php if($_SESSION['IsEeReg']=='YES'){?>
                            <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr id="b_trEmpExchangeCertificate">
            <td class="textbox">NATS Profile Screenshot
                                    <br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
            <td>
                                    <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error8)){ echo $error8; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
            <td>
                                    <input type="submit" name="UploadEmpExchangeCertificate" value="Upload NATS Docs. " id="b_bUploadEmpExchangeCertificate" class="btn btn-info">
                                    <?php if(!empty($products[0]->exchange_certificate)){?>
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->exchange_certificate;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                    <?php }?>
                                    
                                </td>
        </tr>
        </form>
        <?php }?>
        
   
        <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox">Adhaar<br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
                                <td>
                                    <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error14)){ echo $error14; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
                                <td>
                                    <input type="submit" name="uploadpay" value="Upload Certificate" style="font-size: 15px;"  id="b_buploadpay" class="btn btn-info">
                                    <?php if(!empty($products[0]->payslip)){?>
                                    <input type="hidden" id="flag_payslip" name="flag_payslip" value="1" /> 
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->payslip;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                      <?php }?>
                                </td>
                            </tr>
                        </form>
                        
        <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox">Bank Cancelled Cheque/ First Page of Passbook (DBT enabled Acc. Details)<br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
                                <td>
                                    <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error140)){ echo $error140; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
                                <td>
                                    <input type="submit" name="uploaddbt" value="Upload Certificate" style="font-size: 15px;"  id="b_uploaddbt" class="btn btn-info">
                                    <?php if(!empty($products[0]->dbtacc)){?>
                                    <input type="hidden" id="flag_dbt" name="flag_dbt" value="1" /> 
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->dbtacc;?>" target="_blank" style="color:black !important;">View Details</a>
                                      <?php }?>
                                </td>
                            </tr>
                        </form> 
                        
        <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                            <tr>
                                <td class="textbox">PAN Details<br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
                                <td>
                                    <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error150)){ echo $error150; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
                                <td>
                                    <input type="submit" name="uploadpan" value="Upload Certificate" style="font-size: 15px;"  id="b_uploadpan" class="btn btn-info">
                                    <?php if(!empty($products[0]->pan)){?>
                                    <input type="hidden" id="flag_pan" name="flag_pan" value="1" /> 
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->pan;?>" target="_blank" style="color:black !important;">View Details</a>
                                      <?php }?>
                                </td>
                            </tr>
                        </form> 
                        
       
        
         <?php if($_SESSION['cast_category']=='SC' || $_SESSION['cast_category']=='ST' || $_SESSION['cast_category']=='OBC(NCL)' || $_SESSION['cast_category']=='EWS'){?>
         <input type="hidden" id="scflag" name="scflag" value="1" />
            <form name="upload_photo" action="<?php echo  $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                             <tr id="b_trOthercertificate">
            <td class="textbox">
                
                <?php echo $_SESSION['cast_category']; ?> Certificate
                                    <br>
                                    <span style="color: green">Maximum size is 500 KB</span>
                                </td>
            <td> <input type="file" name="ctl00$b$fPhotoUpload" id="b_fPhotoUpload" class="form-control" required tabindex="-1">
                                      <br/><p style="color:red; font-size: 10px;" >  <?php if(isset($error13)){ echo $error13; }?> </p>
                                    <div class="bootstrap-filestyle input-group"><label for="b_fPhotoUpload" class="btn btn-default "></div>
                                    
                                    <span id="b_lPhotoMsg"></span>
                                </td>
            <td>
                                    <input type="submit" name="uploadsc_stcertificate" value="Upload Certificate" class="btn btn-info">
                                    <?php if(!empty($products[0]->sc_st_certificate)){?>
                                    <input type="hidden" id="flag_sc" name="flag_sc" value="1" />
                                    <a id="b_hDobCertificate" class="btn btn-warning" href="<?php echo "/wp-content/plugins/internship/upload/".$products[0]->sc_st_certificate;?>" target="_blank" style="color:black !important;">View Certificate</a>
                                    <?php }?>
                                    
                                </td>
        </tr>
    </form>
        <?php }?>
        
                        </tbody>
                    </table>
                    <div id="Message" class="alert alert-danger" style="display: none"></div>
                    
                    
                </fieldset>
            
    </div>
    <br/>
    <div id="b_p3">
<!--<fieldset>
                                    
                                    <div>
                                    <table>
                                    <tbody>
                                    <tr id="b_trOthercertificate">
            <td class="textbox">
                
                क्या आपने पहले शिक्षुता प्रशिक्षण प्राप्त किया है या शिक्षुता अधिनियम, 1961 के अनुसार शिक्षुता प्रशिक्षण प्राप्त कर रहे हैं  <br/> Have you undergone internshiphip training earlier or pursuing internshiphip training as per the internshiphip Act, 1961?  
                                    
                                </td>
            <td> <select class="form-control" name="flag1" id="flag1">
             <option value="">Please Select</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            </select>
                                      
                                </td>
            
        </tr>
        <tr id="b_trOthercertificate">
            <td class="textbox">
                
                क्या आपके पास डिग्री प्राप्त करने के बाद एक वर्ष या उससे अधिक की अवधि के लिए प्रशिक्षण या नौकरी का अनुभव है  <br/>Do you have training or job experience for a period of one  year or more after the attainment of Degree?   
                                    
                                </td>
            <td> <select class="form-control" name="flag2" id="flag2">
             <option value="">Please Select</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            </select>
                                      
                                </td>
            
        </tr>
                                    </tbody>
                                    </table>
                                    </div>
                </fieldset>

         </br>   -->

        </div>

            <br>
            <p style="text-align: justify; font-weight: bold; padding-left: 10px; padding-right: 10px; color: green">
                <span style="display:inline-block;border-color:Red;border-width:4px;border-style:solid;width:20px;"><input id="b_chkAgree1" type="checkbox" name="ctl00$b$chkAgree1"></span>&nbsp; I hereby declare that the information provided in this application is true and correct to the best of my knowledge. I understand that submission of this application does not guarantee selection. I agree to comply with applicable rules, confidentiality requirements, safety procedures, and instructions during the internship.
                <br>
            </p>
            
            <p style="text-align: justify; font-weight: bold; padding-left: 10px; padding-right: 10px; color: green">
                <span style="display:inline-block;border-color:Red;border-width:4px;border-style:solid;width:20px;"><input id="b_chkAgree" type="checkbox" name="ctl00$b$chkAgree"></span>&nbsp; I hereby declare that I have not previously availed benefits under the PM Internship Scheme from any organisation and have not previously undergone apprenticeship in a Central or State Government organisation under NATS, NAPS or another applicable apprenticeship scheme.  
                <br>
            </p>
            
             
            <div id="b_d1" style="display:none;" class="alert alert-danger">Please acknowledge the data by checking the checkbox before Submitting application.</div>
            <div id="b_d44" style="display:none;" class="alert alert-danger">Please upload all document first.</div>
            &nbsp;&nbsp;&nbsp; 
            <div style="text-align: center">
                <input type="submit" name="ctl00$b$bSubmit" value="Submit Application" id="b_bSubmit" class="btn btn-success btn-primary">
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
           <?php if( false && (($_SESSION['cast_category']=='GENERAL' || $_SESSION['cast_category']=='OBC(NCL)'  || $_SESSION['cast_category']=='EWS') && $_SESSION['pwd_details']=='NO')) {?>
            <p>
                You have to Pay ₹ 500 as Application Fee, Kindly submit application and generate your registartion ID and Pay against Registartion ID.<br/>
                <!--<a href="https://www.onlinesbi.com/prelogin/icollecthome.htm" target="_blank">https://www.onlinesbi.com/prelogin/icollecthome.htm</a>-->
            </p>
            <?php }?>
            <br>
            <style>
            .alert-danger {
    background-color: #f2dede;
    border-color: #eed3d7;
    color: #b94a48;
}
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
#b_bSubmit:disabled {
    opacity: 1;          /* remove fade */
    background-color: #007bff; /* same as normal */
    color: #fff;
    cursor: not-allowed;
}
        </style>

<!-- Unified Step 2 visual design. Existing IDs, names, PHP and JavaScript are unchanged. -->
<style id="step2-unified-design">
/* Reference: Desirable Qualification section */
#b_ctl00 { --step-blue:#174578; --step-border:#d8e2ee; --step-text:#263648; }
#b_ctl00 fieldset.desirable-section,
#b_ctl00 fieldset.work-exp-section,
#b_ctl00 fieldset:has(> legend .fieldHeader) {
    min-width:0; margin:15px 0; padding:18px;
    border:1px solid var(--step-border); border-radius:8px;
    background:#fff;
}
#b_ctl00 fieldset.desirable-section > legend,
#b_ctl00 fieldset.work-exp-section > legend,
#b_ctl00 fieldset:has(> legend .fieldHeader) > legend {
    width:auto; max-width:100%; padding:0 10px; margin:0;
    border:0; background:transparent; color:var(--step-blue);
    font-size:16px; font-weight:600; line-height:1.5;
}
#b_ctl00 fieldset:has(> legend .fieldHeader) > legend .fieldHeader {
    background:transparent !important; border:0 !important;
    color:var(--step-blue) !important; font-size:16px; font-weight:600;
    padding:0 !important;
}
#b_ctl00 .desirable-table-wrapper,
#b_ctl00 .work-exp-table-wrapper,
#b_ctl00 fieldset:has(> legend .fieldHeader) > table {
    max-width:100%;
}
#b_ctl00 .desirable-table-wrapper,
#b_ctl00 .work-exp-table-wrapper {overflow-x:auto;}
#b_ctl00 .desirable-table,
#b_ctl00 .work-exp-table,
#b_ctl00 fieldset:has(> legend .fieldHeader) table.table {
    width:100%; border-collapse:collapse; margin-bottom:0;
}
#b_ctl00 .desirable-table thead th,
#b_ctl00 .work-exp-table thead th,
#b_ctl00 fieldset:has(> legend .fieldHeader) table.table thead th {
    background:var(--step-blue) !important; color:#fff !important;
    padding:12px 10px !important; font-size:13px !important;
    font-weight:600; line-height:1.4; text-align:left;
    vertical-align:middle; border:1px solid #dce4ed;
}
#b_ctl00 .desirable-table tbody td,
#b_ctl00 .work-exp-table tbody td,
#b_ctl00 .work-exp-table tbody tr.saved-record td,
#b_ctl00 .work-exp-table tbody tr.new-entry td,
#b_ctl00 fieldset:has(> legend .fieldHeader) table.table tbody td {
    padding:10px 8px !important; font-size:13px;
    vertical-align:middle; border:1px solid #e2e8f0;
}
#b_ctl00 .desirable-table tbody tr:nth-child(even) td,
#b_ctl00 .work-exp-table tbody tr:nth-child(even) td,
#b_ctl00 fieldset:has(> legend .fieldHeader) table.table tbody tr:nth-child(even) td {
    background:#f8fafc;
}
#b_ctl00 .desirable-table .form-control,
#b_ctl00 .work-exp-table .form-control,
#b_ctl00 fieldset:has(> legend .fieldHeader) .form-control {
    display:block; width:100%; height:auto; min-height:38px;
    padding:7px 9px; font-size:13px; line-height:1.4;
    color:var(--step-text); background:#fff;
    border:1px solid #cbd5e1; border-radius:5px;
    box-sizing:border-box;
}
#b_ctl00 .desirable-table textarea.form-control,
#b_ctl00 .work-exp-table textarea.form-control {
    height:auto; min-height:90px; resize:vertical;
}
#b_ctl00 .desirable-table .form-control:focus,
#b_ctl00 .work-exp-table .form-control:focus,
#b_ctl00 fieldset:has(> legend .fieldHeader) .form-control:focus {
    outline:none; border-color:#3678bb;
    box-shadow:0 0 0 2px rgba(54,120,187,.12);
}
#b_ctl00 .desirable-note {font-size:12px; line-height:1.5; margin:8px 0 12px;}
#b_ctl00 .desirable-note[style*="red"] {color:#c62828 !important;}
#b_ctl00 .word-counter {font-size:12px; color:#64748b;}
#b_ctl00 .desirable-section .btn-add,
#b_ctl00 .work-exp-add-btn {background:#198754; color:#fff; border:0; border-radius:5px; padding:9px 15px; font-weight:600; cursor:pointer;}
#b_ctl00 .desirable-section .btn-delete,
#b_ctl00 .desirable-section .btn-remove,
#b_ctl00 .work-exp-delete-btn {background:#dc3545; color:#fff; border:0; border-radius:5px; padding:9px 15px; font-weight:600; cursor:pointer;}
#b_ctl00 .desirable-section .btn-edit,
#b_ctl00 fieldset:has(> legend .fieldHeader) input[type="submit"],
#b_ctl00 fieldset:has(> legend .fieldHeader) button[type="submit"] {
    background:#246bb2; color:#fff; border:0; border-radius:5px;
    padding:9px 15px; font-weight:600; cursor:pointer;
}
#b_ctl00 fieldset:has(> legend .fieldHeader) input[type="file"] {max-width:100%;}
#b_ctl00 .desirable-table input[type="radio"] {width:auto; height:auto; min-height:0; display:inline-block;}
@media(max-width:650px) {
    #b_ctl00 fieldset.desirable-section,
    #b_ctl00 fieldset.work-exp-section,
    #b_ctl00 fieldset:has(> legend .fieldHeader) {padding:12px;}
    #b_ctl00 fieldset:has(> legend .fieldHeader) {overflow-x:auto;}
}
</style>

           <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
                var $=jQuery;
                $(document).bind("contextmenu",function(e){
                    return false;
                    });
                $(document).ready(function(){
                    
                    
            $( "#from" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
                yearRange: "1960:2026",
            });
            
                $( "#to" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd-mm-yy",
                yearRange: "1960:2026",
            });
            
           
        });
            </script>
            <script>
                jQuery(document).ready(function ($) {

    // Disable date when pursuing is Yes
    $(document).on('change', '.pursuing-select', function () {

        var row = $(this).closest('tr');

        var pursuing = $(this).val();

        var completionDate = row.find('.completion-date');

        if (pursuing === 'Yes') {

            completionDate.val('');

            completionDate.prop('disabled', true);

            completionDate.prop('required', false);

        } else {

            completionDate.prop('disabled', false);

            completionDate.prop('required', pursuing === 'No');

        }

    });

    // Apply correct state when page loads
    $('.pursuing-select').trigger('change');

});
                $(document).ready(function () {
                    $(document).on("click","#institute_recomendation_update",function(){
                        var faculty_cordinator_update = $("#faculty_cordinator_update").val();
                        var designation_update = $("#designation_update").val();
                        var department_update = $("#department_update").val();
                        var contact_email_update = $("#contact_email_update").val();
                        var contact_number_update = $("#contact_number_update").val();
                        //var document_status_update = $("#document_status_update").val();
                        var document_status_update =  $('input[name="document_status_update"]:checked').val();
                        var noc_id_update = $("#noc_id_update").val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{faculty_cordinator_update:faculty_cordinator_update,designation_update:designation_update,department_update:department_update,contact_email_update:contact_email_update,contact_number_update:contact_number_update,document_status_update:document_status_update,noc_id_update:noc_id_update},
                            success:function(data)
                            {
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            }
                        });
                    });
                    $(document).on("click","#institute_recomendation",function(){
                        var faculty_cordinator = $("#faculty_cordinator").val();
                        var designation = $("#designation").val();
                        var department = $("#department").val();
                        var contact_email = $("#contact_email").val();
                        var contact_number = $("#contact_number").val();
                        var document_status =  $('input[name="document_status"]:checked').val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{faculty_cordinator:faculty_cordinator,designation:designation,department:department,contact_email:contact_email,contact_number:contact_number,document_status:document_status},
                            success:function(data)
                            {
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            }
                        });
                    });
    var counter = 0;
    
    $(document).on("click","#addrow",function(){
            
        var name_of_organization = $("#name_of_organization").val();
        if(name_of_organization==''){
            alert("Organization Feild blank");
            return false;
        }
        var deginations = $("#deginations").val();
        var basicpay = $("#basicpay").val();
        var from = $("#from").val();
        var to_date = $("#to_date").val();
                // alert(to_date);
        var df = from.split("-").reverse().join("-");
                //alert(df);
        // var dateOne = new Date(from[2], from[1] - 1, from[0]); //Year, Month, Date  
      // var dateTwo = new Date(to_date);
        if (typeof to_date!="undefined"){
            //if(to_date !=''){
                //alert("check");
                
                
                var dt = to_date.split("-").reverse().join("-");
                //alert(dt);
                // alert("to date " +dt);
        if(df < dt ){
            
        alert("From date not less then To Date " + to_date );
        return false;
        }
        }
        
        var to = $("#to").val();
        var count = $("#responsblity").val().length;
        if(count > 255){
            alert(" Enter Responsblity Only 255 Character");
    $("#responsblity").val('');
            return false;
        }
        var responsblity = $("#responsblity").val();
        var employee_type = '';
        var emploment_type = '';
        var industry_type = '';
        var siteurl = "<?php echo plugins_url();; ?>";
        //alert (siteurl); return false;
        var ajax_url = siteurl+'/internship/ajax_form.php';
        //var ajax_url = 'https://posoco.in/wp-content/plugins/xcareers/ajax_form.php';
        //alert(ajax_url); return false;
        //var ajax_url = '/wp-content/plugins/xcareers/ajax_form.php';
        $('#b_bSubmit').prop('disabled', true);
        $.ajax({
            type:"post",
            url:ajax_url,
            data:{name_of_organization:name_of_organization,basicpay:basicpay,from:from,to:to,responsblity:responsblity,employee_type:employee_type,emploment_type:emploment_type,industry_type:industry_type},
            success:function(data){
                
                if(data==1)
                {
                    window.location.reload();
                }
                else{
                   alert("Mail not sent");
                    window.location.reload();
                }
            },
            error:function(){}
        });
        
        
       
    });



    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});


            </script>
            <script>
                $(document).ready(function () {
                    $(document).on("click","#addinternshipcontribution",function(){
                        var description_intership_contribution = $("#description_intership_contribution").val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{description_intership_contribution:description_intership_contribution},
                            success:function(data){
                                
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            },
                            error:function(){}
                        });
                    });
                    $(document).on("click","#update_button_internship_contribution",function(){
                        var update_intership_contribution = $("#update_intership_contribution").val();
                        var intership_id = $("#intership_id").val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{update_intership_contribution:update_intership_contribution,intership_id:intership_id},
                            success:function(data){
                                
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            },
                            error:function(){}
                        });
                    });
                    $(document).on("click","#update_button_statement_of_intrest",function(){
                        var update_statement_of_intrest = $("#update_statement_of_intrest").val();
                        var intrest_id = $("#intrest_id").val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{update_statement_of_intrest:update_statement_of_intrest,intrest_id:intrest_id},
                            success:function(data){
                                
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            },
                            error:function(){}
                        });
                    });
                    $(document).on("click","#addstatementofintress",function(){
                        var description_statement_of_intrest = $("#description_statement_of_intrest").val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{description_statement_of_intrest:description_statement_of_intrest},
                            success:function(data){
                                
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            },
                            error:function(){}
                        });
                    });
                    $(document).on("click","#project_paper",function(){
                        var title_paper = $("#title_paper").val();
                        var paper_type = $("#paper_type").val();
                        var brief_description = $("#brief_description").val();
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        //var ajax_url = '/wp-content/plugins/xcareers/ajax_form.php';
                        $('#b_bSubmit').prop('disabled', true);
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{title_paper:title_paper,paper_type:paper_type,brief_description:brief_description},
                            success:function(data){
                                
                                if(data==1)
                                {
                                    window.location.reload();
                                }
                                else{
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            },
                            error:function(){}
                        });
                    });
    var counter = 0;
    $(document).on("click","#addrow1",function(){
        var exam_passed = $("#exam_passed").val();
        if(exam_passed==''){
            alert("Exam passed feild blank");
            return false;
        }
        var year_passing = $("#year_passing").val();
        var last_inserted_year = $("#last_year_passing").val();
        
        var markes = $("#markes").val();
        var marks_percent = $("#marks_percent").val();
        var board_university = $("#board_university").val();
        
        var siteurl = "<?php echo plugins_url();; ?>";
        var ajax_url = siteurl+'/internship/ajax_form.php';
        //var ajax_url = '/wp-content/plugins/xcareers/ajax_form.php';
        $('#b_bSubmit').prop('disabled', true);
        $.ajax({
            type:"post",
            url:ajax_url,
            data:{exam_passed:exam_passed,year_passing:year_passing,markes:markes,marks_percent:marks_percent,board_university:board_university},
            success:function(data){
                
                if(data==1)
                {
                    window.location.reload();
                }
                else{
                   alert("Mail not sent");
                    window.location.reload();
                }
            },
            error:function(){}
        });
    });



    $("table.order-list1").on("click", ".ibtnDel1", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });


});


            </script>
            <script>
            var $=jQuery;
                $(document).ready(function(){

                    $('.entry-content').removeClass('entry-content');
                    $("#b_BtnAddQualDetails").click(function(){
                        $("#b_p1").show();
                    });
                    $("#b_bNoAdditionalQualification").click(function(){
                         $("#b_p1").hide();
                    });
                    $("#b_bAddExperience").click(function(){
                         $("#b_p2").show();
                    });
                     $("#b_bNoExperience").click(function(){
                         $("#b_p2").hide();
                    });
                     $(document).on("click","#b_bSubmit",function(){
                         
                        var isValid = true;

                        // Reset errors
                        $(".error-msg").html("");
                        $("select").removeClass("error");

                        // Validate flag1
                        if ($("#flag1").val() === "") {
                            $("#flag1").addClass("error");
                            $("#flag1_error").html("Please select an option.");
                            isValid = false;
                        }

                        // Validate flag2
                        if ($("#flag2").val() === "") {
                            $("#flag2").addClass("error");
                            $("#flag2_error").html("Please select an option.");
                            isValid = false;
                        }

                        if (!isValid) {
                            e.preventDefault(); // stop form submission
                        }
                        
                        if (($('#b_chkAgree').is(":checked")) && ($('#b_chkAgree1').is(":checked"))  )
                        {
                          $("#b_d1").hide();

                        }
                        else{
                            $("#b_d1").show();
                            return false;
                        }
                        
                        var upload_image = $("#upload_image").val();
                        var upload_signature = $("#upload_signature").val();
                        var birth_certificate=$("#birth_certificate").val();
                        var updeg =$("#degr").val();
                        
                        var flag_payslip=$("#flag_payslip").val();
                        
                        //var flag_wrkexp1=$("#flag_wrkexp").val();
                        var flag_dbt = $("#flag_dbt").val();
                        var flag_pan =$("#flag_pan").val();
                        var pwdflag= $("#pwdflag").val();
                        var pwdclat = $("#pwdclat").val();
                        var scflag = $("#scflag").val();
                        var flag_sc = $("#flag_sc").val();
                        var desiraablevariable = $("#desiraablevariable").val();
                        //alert($(':hidden#exflag').val());
                        //alert(exflag);
                        
                        if (typeof pwdflag!="undefined"){
                            //alert(pwdflag);
                        if(pwdclat!=1 ){
                            //alert("gggg");
                            
                            $("#b_d44").show();
                             return false;
                            
                        }
                        }
                        var total_count = <?php echo (int)$total_count; ?>;
                        var desiraablevariable = $("#desiraablevariable").val();
                        if (total_count > 0) {

                            if (desiraablevariable != "1") {

                                $("#b_d44").show();
                                return false;

                            }

                        }
                        var project_count = <?php echo (int)$project_count; ?>;
                        var project_hidden = $("#project_hidden").val();
                        if (project_count > 0) {

                            if (project_hidden != "1") {

                                $("#b_d44").show();
                                return false;

                            }

                        }
                        if(upload_image !=1 || upload_signature!=1 || birth_certificate!=1 || updeg!=1){
                             $("#b_d44").show();
                             return false;
                        }
                        
                        
                        if(flag_payslip!=1){
                            //alert("gggg");
                            
                            $("#b_d44").show();
                             return false;
                            
                        }
                        if(flag_dbt!=1){
                            //alert("gggg");
                            
                            $("#b_d44").show();
                             return false;
                            
                        }
                        if(flag_pan!=1){
                            //alert("gggg");
                            
                            $("#b_d44").show();
                             return false;
                            
                        }
                        
                        if (typeof scflag!="undefined"){
                        if(flag_sc!=1){
                            //alert("gggg");
                            
                            $("#b_d44").show();
                             return false;
                            
                        }
                        }
                        var flag1 = $("#flag1").val();
                        var flag2 = $("#flag2").val();
                        
                        var user_id = "<?php echo $_SESSION['user_id'];?>";
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        var siteurl1 = "<?php echo site_url(); ?>/internship/";
                        $('#b_bSubmit').prop('disabled', true);
                        $.ajax({
                            type:"post",
                            url:ajax_url,
                            data:{submit_all:123},
                            success:function(data){
                                
                                if(data==1)
                                {
                                   // window.location.href=siteurl1+"?msg=success";
                                   window.location.href="https://recruitment.grid-india.in/internship/?msg=success";
                                }
                                else{
                                    //alert(data);
                                    //return false;
                                   alert("Mail not sent");
                                    window.location.reload();
                                }
                            },
                            error:function(){}
                        });
                     });
                     $(document).on("click","#deletedigree",function(){
                        var delete_work = $(this).attr('attr_value');
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        var con = confirm("Are you sure want to delete");
                        if(con==true){
                             $.ajax({
                                type:"post",
                                url:ajax_url,
                                data:{delete_work:delete_work},
                                success:function(data){
                                    
                                    if(data==1)
                                    {
                                         window.location.reload();
                                    }
                                    else{
                                       alert("Data not deleted");
                                        window.location.reload();
                                    }
                                },
                                error:function(){}
                            });
                        }
                    });
                    
                    $(document).on("click","#delete_project",function(){
                        var attr_value_pro = $(this).attr('attr_value_pro');
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        var con = confirm("Are you sure want to delete");
                        if(con==true){
                             $.ajax({
                                type:"post",
                                url:ajax_url,
                                data:{project_val:attr_value_pro},
                                success:function(data){
                                    
                                    if(data==1)
                                    {
                                         window.location.reload();
                                    }
                                    else{
                                       alert("Data not deleted");
                                        window.location.reload();
                                    }
                                },
                                error:function(){}
                            });
                        }
                    });
                    $(document).on("click","#delete_row1",function(){
                        var attr_value_pro = $(this).attr('attr_value_pro');
                        var siteurl = "<?php echo plugins_url();; ?>";
                        var ajax_url = siteurl+'/internship/ajax_form.php';
                        var con = confirm("Are you sure want to delete");
                        if(con==true){
                             $.ajax({
                                type:"post",
                                url:ajax_url,
                                data:{attr_value_pro:attr_value_pro},
                                success:function(data){
                                    
                                    if(data==1)
                                    {
                                         window.location.reload();
                                    }
                                    else{
                                       alert("Data not deleted");
                                        window.location.reload();
                                    }
                                },
                                error:function(){}
                            });
                        }
                    });
                });
            </script>
            <script>
document.addEventListener("input", function (event) {

    if (!event.target.classList.contains("project-description")) {
        return;
    }

    const textarea = event.target;
    const row = textarea.closest(".project-row");

    const counter = row.querySelector(".word-counter");
    const countDisplay = row.querySelector(".word-count");
    const warning = row.querySelector(".word-warning");

    const MAX_WORDS = 150;

    let text = textarea.value;

    let words = text.trim()
        ? text.trim().split(/\s+/)
        : [];

    // Restrict maximum 150 words
    if (words.length > MAX_WORDS) {

        textarea.value = words.slice(0, MAX_WORDS).join(" ");

        words = words.slice(0, MAX_WORDS);

        warning.textContent =
            "Maximum 150 words allowed.";

    } else if (words.length >= 140) {

        warning.textContent =
            "Only " + (MAX_WORDS - words.length) +
            " words remaining.";

    } else {

        warning.textContent = "";
    }

    countDisplay.textContent = words.length;

    counter.classList.toggle(
        "warning",
        words.length >= 140 && words.length < 150
    );

    counter.classList.toggle(
        "limit",
        words.length >= 150
    );

});
</script>
        
</div>
