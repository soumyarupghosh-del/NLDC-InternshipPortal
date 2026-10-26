<?php
	//ob_start();
	//session_start();
	date_default_timezone_set('Asia/Kolkata');
	global $wpdb;
	
?>
 <?php 
require_once get_template_directory() . '/functions.php';

// Start WAF Protection
custom_waf_protection();
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
	
    .error
	{
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
}
</style>


<?php
 
	$today = strtotime("now");
    $date1 = strtotime("2026-10-16 00:00:00");
	$date2 = strtotime("2026-10-20 23:59:00");

$products3 = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM post_applied_details_int WHERE status = %d", 
        1
    ), 
    OBJECT
	);

	/** Adding New Code on 06-01-2025 **/
	/*	if(isset($_POST['ctl00$b$bSubmit'])=='Continue'){
        if($today>=$date2)
      {
        wp_safe_redirect(home_url('/apprentice'));
        exit;
      }
	}*/
	/** End Code **/
//print_r($_SESSION);
	//	exit();
	if (
    isset($_POST['ctl00$b$bSubmit']) &&
    $_POST['ctl00$b$bSubmit'] === 'Continue'
) {

    global $wpdb;

    // ==========================================
    // 1. APPLICATION DATE VALIDATION
    // ==========================================

    if ($today >= $date2) {
        wp_safe_redirect(home_url('/internship'));
        exit;
    }

    // ==========================================
    // 2. GENERATE APPLICATION NUMBER
    // ==========================================

    $post_aplyied_id = sanitize_text_field(
        wp_unslash($_POST['post_aplyied_id'] ?? '')
    );

    $enrollvalue = '';

    if ($post_aplyied_id == '1') {

        $enrollvalue = 'ST1INT2026' .
            substr(str_shuffle('0123456789'), 0, 5);
    }

    // ==========================================
    // 3. GENERATE AND HASH PASSWORD
    // ==========================================

    $generated_pass = wp_generate_password(12, true, false);

    $hashed_password = wp_hash_password($generated_pass);

    // ==========================================
    // 4. CHOICE OF POSTING
    // ==========================================

    $pref1 = sanitize_text_field(
        wp_unslash($_POST['PostingPref1'] ?? '')
    );

    $pref2 = sanitize_text_field(
        wp_unslash($_POST['PostingPref2'] ?? '')
    );

    $pref3 = sanitize_text_field(
        wp_unslash($_POST['PostingPref3'] ?? '')
    );

    $anywhere = sanitize_text_field(
        wp_unslash($_POST['PostingAnywhere'] ?? '')
    );

    $ChoicePosting = '';

    if (
        in_array(
            strtolower($anywhere),
            ['1', 'yes', 'on', 'anywhere'],
            true
        )
    ) {

        // Candidate selected Anywhere
        $ChoicePosting = 'Anywhere';

    } else {

        // Candidate must select three different locations

        $allowedLocations = [
                'Delhi',
                'Kolkata',
                'Guwahati',
                'Shillong',
                'Mumbai',
                'Bengaluru'
        ];

        $preferences = [
            $pref1,
            $pref2,
            $pref3
        ];

        if (
            in_array('', $preferences, true) ||
            count(array_unique($preferences)) !== 3 ||
            count(array_diff($preferences, $allowedLocations)) !== 0
        ) {

            wp_send_json_error([
                'message' =>
                    'Please select three different posting preferences or Anywhere.'
            ]);
        }

        $ChoicePosting =
            '1:' . $pref1 .
            ',2:' . $pref2 .
            ',3:' . $pref3;
    }

    // ==========================================
    // 5. PRESENT ADDRESS
    // ==========================================

    $PresentAddress = sanitize_textarea_field(
        wp_unslash($_POST['PresentAddress'] ?? '')
    );

    $PresentLandmark = sanitize_text_field(
        wp_unslash($_POST['PresentLandmark'] ?? '')
    );

    $PresentCity = sanitize_text_field(
        wp_unslash($_POST['PresentCity'] ?? '')
    );

    $PresentDistrict = sanitize_text_field(
        wp_unslash($_POST['PresentDistrict'] ?? '')
    );

    $PresentState = sanitize_text_field(
        wp_unslash($_POST['PresentState'] ?? '')
    );

    $PresentPin = sanitize_text_field(
        wp_unslash($_POST['PresentPin'] ?? '')
    );

    // ==========================================
    // 6. SAME ADDRESS HANDLING
    // ==========================================

    $SameAddress = (
        isset($_POST['SameAddress']) &&
        in_array(
            strtolower((string) $_POST['SameAddress']),
            ['1', 'yes', 'on', 'true'],
            true
        )
    ) ? 1 : 0;

    if ($SameAddress === 1) {

        // Copy present address to permanent address

        $PermanentAddress  = $PresentAddress;
        $PermanentLandmark = $PresentLandmark;
        $PermanentCity     = $PresentCity;
        $PermanentDistrict = $PresentDistrict;
        $PermanentState    = $PresentState;
        $PermanentPin      = $PresentPin;

    } else {

        // Use separately entered permanent address

        $PermanentAddress = sanitize_textarea_field(
            wp_unslash($_POST['PermanentAddress'] ?? '')
        );

        $PermanentLandmark = sanitize_text_field(
            wp_unslash($_POST['PermanentLandmark'] ?? '')
        );

        $PermanentCity = sanitize_text_field(
            wp_unslash($_POST['PermanentCity'] ?? '')
        );

        $PermanentDistrict = sanitize_text_field(
            wp_unslash($_POST['PermanentDistrict'] ?? '')
        );

        $PermanentState = sanitize_text_field(
            wp_unslash($_POST['PermanentState'] ?? '')
        );

        $PermanentPin = sanitize_text_field(
            wp_unslash($_POST['PermanentPin'] ?? '')
        );
    }

    // ==========================================
    // 7. VALIDATE PIN CODES
    // ==========================================

    if (
        !preg_match('/^[0-9]{6}$/', $PresentPin) ||
        !preg_match('/^[0-9]{6}$/', $PermanentPin)
    ) {

        wp_send_json_error([
            'message' => 'Please enter valid 6-digit PIN codes.'
        ]);
    }

    // ==========================================
    // 8. PREPARE DATABASE INSERT DATA
    // ==========================================

    $data = [

        // APPLICATION DETAILS

        'applyed_post_id' => $post_aplyied_id,

        'gateenrolment_id' => sanitize_text_field(
            wp_unslash($_POST['gateenrolment_id'] ?? '')
        ),

        'gateregistration_no' => sanitize_text_field(
            wp_unslash($_POST['gateregistration_no'] ?? '')
        ),

        'gate_appearing_year' => sanitize_text_field(
            wp_unslash($_POST['gate_appearing_year'] ?? '')
        ),

        'gatescore_no' => sanitize_text_field(
            wp_unslash($_POST['gatescore_no'] ?? '')
        ),

        'netenrolment_id' => sanitize_text_field(
            wp_unslash($_POST['netenrolment_id'] ?? '')
        ),

        'netregistration_no' => sanitize_text_field(
            wp_unslash($_POST['netregistration_no'] ?? '')
        ),

        'net_appearing_year' => sanitize_text_field(
            wp_unslash($_POST['net_appearing_year'] ?? '')
        ),

        'clatenrolment_id' => sanitize_text_field(
            wp_unslash($_POST['clatenrolment_id'] ?? '')
        ),

        'clatregistration_no' => sanitize_text_field(
            wp_unslash($_POST['clatregistration_no'] ?? '')
        ),

        'clat_appearing_year' => sanitize_text_field(
            wp_unslash($_POST['clat_appearing_year'] ?? '')
        ),

        // PERSONAL DETAILS

        'name_of_condidate' => sanitize_text_field(
            wp_unslash($_POST['name_of_condidate'] ?? '')
        ),

        'guardianType' => sanitize_text_field(
            wp_unslash($_POST['guardianType'] ?? '')
        ),

        'guardianName' => sanitize_text_field(
            wp_unslash($_POST['guardianName'] ?? '')
        ),

        'motherName' => sanitize_text_field(
            wp_unslash($_POST['motherName'] ?? '')
        ),

        'apaarid' => sanitize_text_field(
            wp_unslash($_POST['apaardigit'] ?? '')
        ),

        'Dob' => sanitize_text_field(
            wp_unslash($_POST['Dob'] ?? '')
        ),

        'Gender' => sanitize_text_field(
            wp_unslash($_POST['Gender'] ?? '')
        ),

        'MaritalStatus' => sanitize_text_field(
            wp_unslash($_POST['MaritalStatus'] ?? '')
        ),

        'ddlCategory' => sanitize_text_field(
            wp_unslash($_POST['ddlCategory'] ?? '')
        ),

        'MinorityCommunity' => sanitize_text_field(
            wp_unslash($_POST['MinorityCommunity'] ?? '')
        ),

        'DomicileState' => sanitize_text_field(
            wp_unslash($_POST['DomicileState'] ?? '')
        ),

        'Nationality' => sanitize_text_field(
            wp_unslash($_POST['Nationality'] ?? '')
        ),

        'WrittenExamLanguage' => sanitize_text_field(
            wp_unslash($_POST['WrittenExamLanguage'] ?? '')
        ),

        'aadhar_card' => sanitize_text_field(
            wp_unslash($_POST['aadhar_card'] ?? '')
        ),

        // EMPLOYMENT EXCHANGE DETAILS

        'IsEeReg' => sanitize_text_field(
            wp_unslash($_POST['IsEeReg'] ?? '')
        ),

        'StatesE' => sanitize_text_field(
            wp_unslash($_POST['StatesE'] ?? '')
        ),

        'RegistrationNo' => sanitize_text_field(
            wp_unslash($_POST['RegistrationNo'] ?? '')
        ),

        // PWD DETAILS

        'ddlIsPwd' => sanitize_text_field(
            wp_unslash($_POST['ctl00$b$ddlIsPwd'] ?? '')
        ),

        'DisabilityPercentage' => sanitize_text_field(
            wp_unslash($_POST['DisabilityPercentage'] ?? '')
        ),

        'pwd_category' => sanitize_text_field(
            wp_unslash($_POST['ctl00$b$ddlPhCategory'] ?? '')
        ),

        'pwd_sub_category' => sanitize_text_field(
            wp_unslash($_POST['PhSubCategory'] ?? '')
        ),

        'pwdothers' => sanitize_text_field(
            wp_unslash($_POST['pwdothers'] ?? '')
        ),

        // POSTING PREFERENCES - SINGLE COLUMN

        'ChoicePosting' => $ChoicePosting,

        // POWERGRID EMPLOYEE DETAILS

        'IsPowerGridEmployee' => sanitize_text_field(
            wp_unslash($_POST['IsPowerGridEmployee'] ?? '')
        ),

        'EmployeeNumber' => sanitize_text_field(
            wp_unslash($_POST['EmployeeNumber'] ?? '')
        ),

        'PgcilServiceFrom' => sanitize_text_field(
            wp_unslash($_POST['PgcilServiceFrom'] ?? '')
        ),

        'PgcilServiceTo' => sanitize_text_field(
            wp_unslash($_POST['PgcilServiceTo'] ?? '')
        ),

        // PRESENT ADDRESS

        'PresentAddress'  => $PresentAddress,
        'PresentLandmark' => $PresentLandmark,
        'PresentCity'     => $PresentCity,
        'PresentDistrict' => $PresentDistrict,
        'PresentState'    => $PresentState,
        'PresentPin'      => $PresentPin,

        // SAME ADDRESS

        'SameAddress' => $SameAddress,

        // PERMANENT ADDRESS

        'PermanentAddress'  => $PermanentAddress,
        'PermanentLandmark' => $PermanentLandmark,
        'PermanentCity'     => $PermanentCity,
        'PermanentDistrict' => $PermanentDistrict,
        'PermanentState'    => $PermanentState,
        'PermanentPin'      => $PermanentPin,

        // CONTACT DETAILS

        'MobileNumber' => sanitize_text_field(
            wp_unslash($_POST['MobileNumber'] ?? '')
        ),

        'StdCode' => sanitize_text_field(
            wp_unslash($_POST['StdCode'] ?? '')
        ),

        'Landline' => sanitize_text_field(
            wp_unslash($_POST['Landline'] ?? '')
        ),

        'Email' => sanitize_email(
            wp_unslash($_POST['Email'] ?? '')
        ),

        'EmailAgain' => sanitize_email(
            wp_unslash($_POST['EmailAgain'] ?? '')
        ),

        'AlternateEmail' => sanitize_email(
            wp_unslash($_POST['AlternateEmail'] ?? '')
        ),

        // QUALIFICATION DETAILS

        'Qualification' => sanitize_text_field(
            wp_unslash($_POST['Qualification'] ?? '')
        ),

        'check_apearing_mode' => sanitize_text_field(
            wp_unslash($_POST['check_apearing_mode'] ?? '')
        ),

        'MarksPercentage' => sanitize_text_field(
            wp_unslash($_POST['MarksPercentage'] ?? '')
        ),

        'Discipline' => sanitize_text_field(
            wp_unslash($_POST['Discipline'] ?? '')
        ),

        'Cgpa' => sanitize_text_field(
            wp_unslash($_POST['Cgpa'] ?? '')
        ),

        'CourseFrom' => sanitize_text_field(
            wp_unslash($_POST['CourseFrom'] ?? '')
        ),

        'CourseTo' => sanitize_text_field(
            wp_unslash($_POST['CourseTo'] ?? '')
        ),

        'ResultDeclarationDate' => sanitize_text_field(
            wp_unslash($_POST['ResultDeclarationDate'] ?? '')
        ),

        'CourseMode' => sanitize_text_field(
            wp_unslash($_POST['CourseMode'] ?? '')
        ),

        'Division' => sanitize_text_field(
            wp_unslash($_POST['Division'] ?? '')
        ),

        'University' => sanitize_text_field(
            wp_unslash($_POST['University'] ?? '')
        ),

        'Institution' => sanitize_text_field(
            wp_unslash($_POST['Institution'] ?? '')
        ),

        // RELATIVE DETAILS

        'IsRelativeInPowergrid' => sanitize_text_field(
            wp_unslash($_POST['IsRelativeInPowergrid'] ?? '')
        ),

        'ddlIsEmployeeOrDirector' => sanitize_text_field(
            wp_unslash(
                $_POST['ctl00$b$ddlIsEmployeeOrDirector'] ?? ''
            )
        ),

        // BANK DETAILS

        'account_hname' => sanitize_text_field(
            wp_unslash($_POST['account_hname'] ?? '')
        ),

        'bank_name' => sanitize_text_field(
            wp_unslash($_POST['bank_name'] ?? '')
        ),

        'branch_name' => sanitize_text_field(
            wp_unslash($_POST['branch_name'] ?? '')
        ),

        'branch_city' => sanitize_text_field(
            wp_unslash($_POST['branch_city'] ?? '')
        ),

        'account_number' => sanitize_text_field(
            wp_unslash($_POST['account_number'] ?? '')
        ),

        'ifsc_code' => sanitize_text_field(
            wp_unslash($_POST['ifsc_code'] ?? '')
        ),

        // APPLICATION NUMBER AND PASSWORD

        'career_uniqe_id' => $enrollvalue,

        'password' => $hashed_password
    ];

    // ==========================================
    // 9. OPTIONAL ALTERNATE MOBILE
    // ==========================================

    // Add this only if the column exists in the database.

    $alternate_mobile_column = $wpdb->get_var(
        $wpdb->prepare(
            "SHOW COLUMNS FROM `career_details_int` LIKE %s",
            'MobileNumberalternet'
        )
    );

    if ($alternate_mobile_column) {

        $data['MobileNumberalternet'] = sanitize_text_field(
            wp_unslash($_POST['MobileNumberalternet'] ?? '')
        );
    }

    // ==========================================
    // 10. INSERT INTO DATABASE
    // ==========================================

    $insert_result = $wpdb->insert(
        'career_details_int',
        $data
    );

    // ==========================================
    // 11. CHECK INSERT RESULT
    // ==========================================

    if ($insert_result === false) {

        error_log(
            'Internship Registration Error: ' .
            $wpdb->last_error
        );

        wp_send_json_error([
            'message' =>
                'Registration could not be saved. Please try again.'
        ]);
    }  
        
        $lastid = absint($wpdb->insert_id);

		$wpdb->insert(
			'xcareer_audit_int',
			array(
				'career_id'               => $lastid,
				'status'                  => 1,
				'career_registration_no'  => sanitize_text_field($enrollvalue),
				'system_ip'               => sanitize_text_field($_SERVER['REMOTE_ADDR']),
			),
			array(
				'%d',
				'%d',
				'%s',
				'%s'
			)
		);
				if ( ! empty($_POST['ctl00$b$tEmployeeName1']) && is_array($_POST['ctl00$b$tEmployeeName1']) ) {

			$career_id = absint($lastid);
			$total     = count($_POST['ctl00$b$tEmployeeName1']);

			for ( $i = 0; $i < $total; $i++ ) {

				// Skip empty rows
				if ( empty($_POST['ctl00$b$tEmployeeName1'][$i]) ) {
					continue;
				}

				$wpdb->insert(
					'career_emp_details_int',
					array(
						'career_id'                   => $career_id,
						'ctl00$b$tEmployeeName1'      => sanitize_text_field($_POST['ctl00$b$tEmployeeName1'][$i]),
						'ctl00$b$tDesignation1'       => sanitize_text_field($_POST['ctl00$b$tDesignation1'][$i] ?? ''),
						'ctl00$b$tEmpNo1'             => sanitize_text_field($_POST['ctl00$b$tEmpNo1'][$i] ?? ''),
						'ctl00$b$tPlaceOfPosting1'    => sanitize_text_field($_POST['ctl00$b$tPlaceOfPosting1'][$i] ?? ''),
						'ctl00$b$tRelationship1'      => sanitize_text_field($_POST['ctl00$b$tRelationship1'][$i] ?? ''),
					),
					array(
						'%d',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s'
					)
				);
			}
}
				if ( ! empty($_POST['ctl00$b$tDirectorName']) ) {

			$wpdb->insert(
				'career_director_details_int',
				array(
					'career_id'                     => absint($lastid),
					'ctl00$b$tDirectorName'          => sanitize_text_field($_POST['ctl00$b$tDirectorName']),
					'ctl00$b$tDirectorRelationship'  => sanitize_text_field($_POST['ctl00$b$tDirectorRelationship'] ?? ''),
				),
				array(
					'%d',
					'%s',
					'%s'
				)
			);
		}
		/** Adding New Code on 06-01-2025 **/
		/*if (session_status() === PHP_SESSION_NONE) {
		    session_start([
		        'cookie_httponly' => true,
		        'cookie_secure' => true,  
		        'cookie_samesite' => 'Strict',
		    ]);
		}*/
		//session_regenerate_id(true);
		/** End Code **/
		// Start output buffer first
			
	/*	if (session_status() === PHP_SESSION_NONE) {
		ob_start(); // ensures no headers sent early
		session_start([
			'cookie_httponly' => true,
			'cookie_secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
			'cookie_samesite' => 'Lax', // Lax is safe for login / redirects
		]);
	}
		*/
		
		
       /* $_SESSION['second_stage']         = 'second_stage';
		$_SESSION['cast_category']        = sanitize_text_field($_POST['ddlCategory'] ?? '');
		$_SESSION['post_applied']         = sanitize_text_field($_POST['post_aplyied_id'] ?? '');
		$_SESSION['IsEeReg']              = sanitize_text_field($_POST['IsEeReg'] ?? '');
		$_SESSION['pwd_details']          = sanitize_text_field($_POST['ctl00$b$ddlIsPwd'] ?? '');
		$_SESSION['IsPowerGridEmployee']  = sanitize_text_field($_POST['IsPowerGridEmployee'] ?? '');
		$_SESSION['check_apearing_mode']  = sanitize_text_field($_POST['check_apearing_mode'] ?? '');
		$_SESSION['user_id']              = absint($lastid); */

		/* ---------- SAFE REDIRECT ---------- */
		//$url = esc_url_raw($_SERVER['REQUEST_URI']);
		//wp_safe_redirect($url);
       
		//wp_redirect( $url );
		
		$_SESSION['second_stage']         = 'second_stage';
		$_SESSION['cast_category']        = sanitize_text_field($_POST['ddlCategory'] ?? '');
		$_SESSION['post_applied']         = sanitize_text_field($_POST['post_aplyied_id'] ?? '');
		$_SESSION['IsEeReg']              = sanitize_text_field($_POST['IsEeReg'] ?? '');
		$_SESSION['pwd_details']          = sanitize_text_field($_POST['ctl00$b$ddlIsPwd'] ?? '');
		$_SESSION['IsPowerGridEmployee']  = sanitize_text_field($_POST['IsPowerGridEmployee'] ?? '');
		$_SESSION['check_apearing_mode']  = sanitize_text_field($_POST['check_apearing_mode'] ?? '');
		$_SESSION['user_id']              = absint($lastid);

		// 2. CRITICAL: Force the session to save to the server RIGHT NOW
        session_write_close(); 

        // 3. Clear the output buffer to ensure a clean redirect
        if (ob_get_length()) {
            ob_clean();
        }

        // 4. Redirect
        $url = esc_url_raw($_SERVER['REQUEST_URI']);
        wp_redirect($url);
        exit;
		
		
		
		
		
		

}
	
?>
<style>
.page-header{display:none;}
</style>
<div>
     <div style="width: 100%"> <img src="<?php echo site_url();?>/wp-content/plugins/careers/images/banner.jpg" alt="GRID-INDIA Recruitment"></div>             
<div class="ui-state-active" style="text-shadow: 0 FF0000 3px 0; font-size:18px; text-align:center;"><b>Important Guidelines </b></div>
       <!--  <div class="card-body text-success" style="color:green;">
            <ul style="color:green; font-size:14px;" >
                <li class="b">The application works best on Internet Explorer Version 11 or above, Mozilla Firefox
                Version 50 or above, Google Chrome Version 50 or above, Apple Safari Version 5
                or above, Opera Version 15 or above.
                </li>
                <li class="b">Ensure that JavaScript is enabled in the browser.
                </li>
                <li class="a">Kindly do not use autocomplete to fill data.
                </li>
                <li class="a">Please fill the Application Form serially. </li>

                <li class="a">Do not use special characters like ',$,&lt;,&gt;,., etc.</li>
               
                <li class="a">Do not wait till last date to fill up the application. Candidates are advised to apply well in time to avoid technical problems.</li>
                <li class="a">Print out of application should be taken only in Portrait.</li>
                <li class="a"><strong>The application system is not checking your eligibility while submission. Hence you are required to ensure your eligibility w.r.t.
                our detailed advertisement before applying. Mere submission of application will not guarantee the
                candidature for further engagement process.</strong></li>
                <li class="a">The online application can be filled from <strong>24<sup>th</sup> January 2026 </strong>to <strong>08<sup>th</sup> February 2026</strong>.</li>
                <table border="1" cellpadding="8" cellspacing="0" 
       style="border-collapse:collapse; width:100%; font-family:Arial, sans-serif;">
    <thead>
        <tr style="background-color:#003366; color:#ffffff;">
            <th>Sl.</th>
            <th>Region</th>
            
            <th>Location</th>
            <th>Detailed Advertisement</th>
        </tr>
    </thead>
    <tbody>
	<tr>
            <td align="center"><b>1</b></td>
            <td><b style="color:#003366;">Apprentices for CC</b></td>
            
            <td style="color:#006600;">New Delhi</td>
            <td  rowspan="7" style="text-align: center; vertical-align: middle;">
                <a href="https://webcdn.grid-india.in/files/grdw/2026/01/Advt%20Apprentice%202025-26_100.pdf"
   target="_blank"
   style="color:#d60000; font-weight:bold;">
   View
</a>
            </td>
        </tr>
        <tr>
            <td align="center"><b>2</b></td>
            <td><b style="color:#003366;">Apprentices for NLDC</b></td>
           
            <td style="color:#006600;">New Delhi</td>
            
        </tr>
        <tr style="background-color:#f9f9f9;">
            <td align="center"><b>3</b></td>
            <td><b style="color:#003366;">Apprentices for NRLDC</b></td>
           
            <td style="color:#006600;">New Delhi</td>
            
        </tr>
        <tr>
            <td align="center"><b>4</b></td>
            <td><b style="color:#003366;">Apprentices for WRLDC</b></td>
           
            <td style="color:#006600;">Mumbai</td>
            
        </tr>
        <tr style="background-color:#f9f9f9;">
            <td align="center"><b>5</b></td>
            <td><b style="color:#003366;">Apprentices for SRLDC</b></td>
           
            <td style="color:#006600;">Bangaluru</td>
            
        </tr>
		<tr>
            <td align="center"><b>6</b></td>
            <td><b style="color:#003366;">Apprentices for ERLDC</b></td>
           
            <td style="color:#006600;">Kolkata</td>
            
        </tr>
        <tr>
            <td align="center"><b>7</b></td>
            <td><b style="color:#003366;">Apprentices for NERLDC</b></td>
            
            <td style="color:#006600;">Guwahati / Shillong</td>
            
        </tr>
		
    </tbody>
</table>

                <li class="a">In case of any queries, candidates are advised to send an e-mail to 
<a href="mailto:apprenticeship@grid-india.in">apprenticeship@grid-india.in</a> 
ONLY with <strong>&lt;&lt;Engagement of Apprentices&gt;&gt;</strong> in the subject line.</li>
				
				
				<li class="a">Applicants are advised to retain the Registration details to log in to the career portal.</li>
            </ul>
        </div>


			   <h3 class="ui-state-active" style="text-align: center;">Welcome to Online System for Engagement of Apprentices
                </h3>
            </div> -->
            <br>
            <!-- Posts -->
            <form name="careers_first" id="careers_first" method="post" action="<?php echo  $_SERVER['REQUEST_URI'];?>">
            <div id="b_p1" style="width:100%;">
				
                <fieldset>
				<?php if ($today > $date1 && $today < $date2) { ?>
                    <legend><span class="fieldHeader ui-widget-header">Apply For Internship</span> </legend>
                    <div class="form-group" style="padding-left: 1%;">
                        <div class="form-group">
                            <select id="b_ddlPosts" name="post_aplyied_id"  class="select form-control">
								<option value="">Please Select an Option</option>
								<?php 
									foreach($products3 as $key_val){?>
										<option value="<?php echo $key_val->id;?>"><?php echo $key_val->post_name;?></option>
									<?php }
								?>
							</select>
                            
                        </div>
                    </div>
					<?php } else { ?>
							
								<marquee>**** Online application has been closed for Engagement of Apprenticeship ****</marquee>
							<?php }?>
                </fieldset>
            
</div>
            <br>
            <div id="post_wise_form">
            
            </div>
            </form>
			
          <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  
  
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
           <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            
           <script>
		   var $=jQuery;
		   $.validator.addMethod(
    "indianPin",
    function(value, element) {
        return this.optional(element) || /^[1-9][0-9]{5}$/.test(value);
    },
    "Please enter a valid 6-digit Indian PIN Code"
);
		   $.validator.addMethod("categoryMarks", function(value, element) {

    if (this.optional(element)) {
        return true;
    }

    var category = $.trim($('[name="ddlCategory"]').val() || "")
                    .toUpperCase();

    var marks = parseFloat(value);

    if (isNaN(marks)) {
        return false;
    }

    // General, EWS and OBC: Minimum 65%
    if (["GENERAL", "GEN", "UR", "EWS", "OBC", "OBC-NCL"].includes(category)) {
        return marks >= 65;
    }

    return true;

}, "Minimum 65% marks are required for General, EWS and OBC candidates.");
		   $(document).bind("contextmenu",function(e){
					return false;
					});
			$(document).ready(function(){
				//jQuery(document).ready(function($){
					
					

				$('.site-content').removeClass('entry-content');
				
				$(document).on("change","#b_ddlIsEeReg",function(){
					var value = $(this).val();
					if(value=='YES'){
						$("#b_ddlStatesE").prop("disabled", false);
						$("#b_tEeRegistrationNo").prop("disabled", false);
						
					}
					if(value=='NO'){
						$("#b_ddlStatesE").prop("disabled", true);
						$("#b_tEeRegistrationNo").prop("disabled", true);
						
					}
				});
				$(document).on("change","#b_ddlIsPwd",function(){
					var value = $(this).val();
					if(value=='YES'){
						$("#b_tDisabilityPercentage").prop("disabled", false);
						$("#b_tDisabilityPercentage").css('background-color', "#fff !important");
						$("#b_ddlPhCategory").prop("disabled", false);
						$("#b_ddlPhCategory").css('background-color', "#fff !important");
						$('#b_ddlPhSubCategory').prop("disabled",false);
						$("#b_ddlPhSubCategory").css('background-color', "#fff !important");
						$("#pwdothers").hide();
						$("#firstpwdtr").show();
						$("#secondpwdtr").show();
						
					}
					if(value=='NO'){
						$("#b_tDisabilityPercentage").prop("disabled", true);
						$("#b_tDisabilityPercentage").css('background-color', "#c0c0c0 !important");
						$("#b_ddlPhCategory").prop("disabled", true);
						$("#b_ddlPhCategory").css('background-color', "#c0c0c0 !important");
						$('#b_ddlPhSubCategory').prop("disabled",true);
						$("#b_ddlPhSubCategory").css('background-color', "#c0c0c0 !important");
						$("#pwdothers").hide();
						$("#dd").hide();
						$("#dd1").hide();
						$("#firstpwdtr").hide();
						$("#secondpwdtr").hide();
					}
				});
				$(document).on("change","#b_ddlPhCategory",function(){
					var current_val = $(this).val();
					if(current_val=='Oth'){
						$("#dd").show();
						$("#dd1").show();
						$("#pwdothers").show();
						
					
						
					}
					else
					{
						$("#dd").hide();
						$("#dd1").hide();
						$("#pwdothers").hide();
						
					}
				
				});
				$(document).on("change","#name_of_condidate",function(){
				$('#name_of_condidate').val($('#name_of_condidate').val().toUpperCase())
				});
				$(document).on("change","#b_tMotherName",function(){
				$('#b_tMotherName').val($('#b_tMotherName').val().toUpperCase())
				});
				$(document).on("change","#b_tABCDGuardianName",function(){
				$('#b_tABCDGuardianName').val($('#b_tABCDGuardianName').val().toUpperCase())
				});
				$(document).on("change","#b_tAddressC",function(){
				$('#b_tAddressC').val($('#b_tAddressC').val().toUpperCase())
				});
				$(document).on("change","#b_tLandmark",function(){
				$('#b_tLandmark').val($('#b_tLandmark').val().toUpperCase())
				});
				$(document).on("change","#b_tNearestRlyStationC",function(){
				$('#b_tNearestRlyStationC').val($('#b_tNearestRlyStationC').val().toUpperCase())
				});
				$(document).on("change","#b_tCityC",function(){
				$('#b_tLandmark').val($('#b_tCityC').val().toUpperCase())
				});
				$(document).on("change","#b_tDistrictC",function(){
				$('#b_tDistrictC').val($('#b_tDistrictC').val().toUpperCase())
				});
				$(document).on("change","#b_tUniversity",function(){
				$('#b_tUniversity').val($('#b_tUniversity').val().toUpperCase())
				});
				$(document).on("change","#b_tInstitution",function(){
				$('#b_tInstitution').val($('#b_tInstitution').val().toUpperCase())
				});
				$(document).on("change","#b_aadhar_card",function(){
				$('#b_aadhar_card').val($('#b_aadhar_card').val().toUpperCase())
				});
				
				$(document).on("change","#b_ddlIsPowerGridEmployee",function(){
					var value = $(this).val();
					if(value=='YES'){
						$("#b_tEmployeeNumber").prop("disabled", false);
						$("#b_ddlPowergridRegion").prop("disabled", false);
						$('#b_tPgcilServiceFrom').prop("disabled",false);
						$('#b_tPgcilServiceTo').prop("disabled",false);
						$("#b_tEmployeeNumber-error").show();
						$("#b_tEmployeeNumber").addClass('error');
						$("#b_ddlPowergridRegion-error").show();
						$("#b_ddlPowergridRegion").addClass('error');
						$("#b_tPgcilServiceFrom-error").show();
						$("#b_tPgcilServiceFrom").addClass('error');
						$("#b_tPgcilServiceTo-error").show();
						$("#b_tPgcilServiceTo").addClass('error');
						
					}
					if(value=='NO'){
						$("#b_tEmployeeNumber").prop("disabled", true);
						$("#b_ddlPowergridRegion").prop("disabled", true);
						$('#b_tPgcilServiceFrom').prop("disabled",true);
						$('#b_tPgcilServiceTo').prop("disabled",true);
						$("#b_tEmployeeNumber-error").hide();
						$("#b_tEmployeeNumber").removeClass('error');
						$("#b_ddlPowergridRegion-error").hide();
						$("#b_ddlPowergridRegion").removeClass('error');
						$("#b_tPgcilServiceFrom-error").hide();
						$("#b_tPgcilServiceFrom").removeClass('error');
						$("#b_tPgcilServiceTo-error").hide();
						$("#b_tPgcilServiceTo").removeClass('error');
						
					}
				});
				$(document).on("change","#check_apearing_mode",function(){
					var value = $(this).val();
					if(value == 'Appearing'){
						$("#b_tMarksPercentage").prop("disabled", true);
						$("#b_tCgpa").prop("disabled", true);
						$("#b_tCourseTo").prop("disabled", true);
						$("#b_tResultDeclarationDate").prop("disabled", true);
						$("#b_ddlDivision").prop("disabled", true);
					}
					else{
						$("#b_tMarksPercentage").prop("disabled", false);
						$("#b_tCgpa").prop("disabled", false);
						$("#b_tCourseTo").prop("disabled", false);
						$("#b_tResultDeclarationDate").prop("disabled", false);
						$("#b_ddlDivision").prop("disabled", false);
					}
				});
				
				
				/** Adding New Code at 06-01-2026**/
				$(document).on("change","#b_ddlPosts",function(){
					var valu = $(this).val();
					if (!/^[a-zA-Z0-9-_]+$/.test(valu)) {
				        alert("Invalid selection.");
				        return;
				    }
					var ajax_url = '/wp-content/plugins/internship/ajax_form.php';
					
					$.ajax({
						type:"post",
						url:ajax_url,
						data:{valu:valu},
						dataType:"JSON",
						success:function(data){
							$("#post_wise_form").html(data);
							$("#b_ddlPosts").prop('disabled');
							 initializeQualificationDates();
						},
					});
				});
				/** End Code **/
				$("#careers_first").validate({
					rules:{
							name_of_condidate:{required:true},
							guardianType:{required:true},
							guardianName:{required:true},
							motherName:{required:true},
							Dob:{required:true},
							Gender:{required:true},
							MaritalStatus:{required:true},
							//IsExServiceMan:{required:true},
							ddlCategory:{required:true},
							MinorityCommunity:{required:true},
							DomicileState:{required:true},
							Nationality:{required:true},
							WrittenExamLanguage:{required:true},
							//IsJnKDomicile:{required:true},
							ctl00$b$ddlIsPwd:{required:true},
							IsPowerGridEmployee:{required:true},
							PresentAddress: {
    required: true,
    maxlength: 200
},

PresentLandmark: {
    maxlength: 100
},

PresentCity: {
    required: true,
    maxlength: 100
},

PresentDistrict: {
    required: true,
    maxlength: 100
},

PresentState: {
    required: true
},

PresentPin: {
    required: true,
    indianPin: true
},



// =====================================
// PERMANENT ADDRESS VALIDATION
// =====================================

PermanentAddress: {
    required: function() {
        return !$("#b_SameAddress").is(":checked");
    },
    maxlength: 200
},

PermanentLandmark: {
    maxlength: 100
},

PermanentCity: {
    required: function() {
        return !$("#b_SameAddress").is(":checked");
    },
    maxlength: 100
},

PermanentDistrict: {
    required: function() {
        return !$("#b_SameAddress").is(":checked");
    },
    maxlength: 100
},

PermanentState: {
    required: function() {
        return !$("#b_SameAddress").is(":checked");
    }
},
PermanentPin: {
    required: function() {
        return !$("#b_SameAddress").is(":checked");
    },
    indianPin: true
},

							MobileNumber:{required:true},
							Email:{required:true,email:true},
							EmailAgain:{required:true,email:true},
							AlternateEmail:{required:true,email:true},
							Qualification:{required:true},
							MarksPercentage: {
    required: true,
    number: true,
    min: 0,
    max: 100,
    step: 0.01,
    categoryMarks: true
},
							Discipline:{required:true},
							CourseFrom:{required:true},
							CourseTo:{required:true},
							ResultDeclarationDate:{required:true},
							CourseMode:{required:true},
							Division:{required:true},
							University:{required:true},
							Institution:{required:true},
							IsRelativeInPowergrid:{required:true},
							EmployeeNumber:{required:true},
							PowergridRegion:{required:true},
							PgcilServiceFrom:{required:true},
							PgcilServiceTo:{required:true},
							gatescore_no:{required:true},
							account_hname:{required:true},
							bank_name:{required:true},
							branch_name:{required:true},
							branch_city:{required:true},
							account_number:{required:true},
							ifsc_code:{required:true},
							RegistrationNo :{required:true},
							StatesE:{required:true},
							aadhar_card:{required:true},
							
						},
						messages:{
						name_of_condidate:{required:"Please Enter Your Full Name"},
						guardianType:{required:"Please Select an option "},
						guardianName:{required:"Please Enter Your Father's / Spouse's Name"},
						motherName:{required:"Please Enter your Mother's Name"},
						Dob:{required:"Please Select Your Date of Birth"},
						Gender:{required:"Please Select an option"},
						MaritalStatus:{required:"Please Select Your Marital Status"},
						//IsExServiceMan:{required:"Please Select an Option"},
						ddlCategory:{required:"Please Select a Category"},
						MinorityCommunity:{required:"Please Select a Minoroty Community"},
						DomicileState:{required:"Please Select an Option"},
						Nationality:{required:"Please Select an Option"},
						WrittenExamLanguage:{required:"Please Select an Option"},
						//IsJnKDomicile:{required:"Please Select an Option"},
						ctl00$b$ddlIsPwd:{required:"Please Select an Option"},
						IsPowerGridEmployee:{required:"Please Select an Option"},
						PresentAddress: {
    required: "Please enter your Present Address",
    maxlength: "Maximum 200 characters allowed"
},

PresentLandmark: {
    maxlength: "Maximum 100 characters allowed"
},

PresentCity: {
    required: "Please enter your City / Town / Village",
    maxlength: "Maximum 100 characters allowed"
},

PresentDistrict: {
    required: "Please enter your District",
    maxlength: "Maximum 100 characters allowed"
},

PresentState: {
    required: "Please select your State / UT"
},

PresentPin: {
    required: "Please enter your PIN Code",
    digits: "Only numbers are allowed",
    minlength: "PIN Code must contain exactly 6 digits",
    maxlength: "PIN Code must contain exactly 6 digits"
},

// =====================================
// PERMANENT ADDRESS MESSAGES
// =====================================

PermanentAddress: {
    required: "Please enter your Permanent Address",
    maxlength: "Maximum 200 characters allowed"
},

PermanentLandmark: {
    maxlength: "Maximum 100 characters allowed"
},

PermanentCity: {
    required: "Please enter your Permanent City / Town / Village",
    maxlength: "Maximum 100 characters allowed"
},

PermanentDistrict: {
    required: "Please enter your Permanent District",
    maxlength: "Maximum 100 characters allowed"
},

PermanentState: {
    required: "Please select your Permanent State / UT"
},

PermanentPin: {
    required: "Please enter your Permanent PIN Code",
    digits: "Only numbers are allowed",
    minlength: "PIN Code must contain exactly 6 digits",
    maxlength: "PIN Code must contain exactly 6 digits"
},
						MobileNumber:{required:"Please Enter your Mobile Number"},
						Email:{required:"Please Enter Your E-mail Id"},
						EmailAgain:{required:"Please Re-Enter Your E-mail Id"},
						AlternateEmail:{required:"Please Enter Your Alternate E-mail Id "},
						Qualification:{required:"Please Select your Qualification "},
						MarksPercentage: {
    required: "Please enter your Percentage of Marks",
    number: "Please enter a valid percentage",
    min: "Percentage cannot be less than 0",
    max: "Percentage cannot exceed 100",
    step: "Please enter percentage up to 2 decimal places",
    categoryMarks: "Minimum 65% marks are required for General, EWS and OBC candidates."
},
						Discipline:{required:"Please Select a Discipline"},
						CourseFrom:{required:"Please Select From Year"},
						CourseTo:{required:"Please Select To Year"},
						ResultDeclarationDate:{required:"Please Select Result Declaration Date"},
						CourseMode:{required:"Please Select an Option "},
						Division:{required:"Please Select an Option"},
						University:{required:"Please Enter the Name of the University"},
						Institution:{required:"Please Enter the Name of the Institution"},
						IsRelativeInPowergrid:{required:"Please Select an Option"},
						gatescore_no:{required:"Please Enter GATE Score"},
						account_hname:{required:"Please Enter Account Holder Name "},
							bank_name:{required:"Please Enter Bank Name"},
							branch_name:{required:"Please Enter Branch Name"},
							branch_city:{required:"Please Enter Branch City"},
							account_number:{required:"Please Enter Account Number "},
							ifsc_code:{required:"Please Enter IFCI Code"},
							RegistrationNo:{required:"Please Enter NAT No"},
							StatesE:{required:"Please Select a State"},
							aadhar_card:{required:"Please Select a Aadhar No."},
					 },
				
					
				});
				$(document).on("focusout","#b_tEmailAgain",function(){
					var b_tEmail = $("#b_tEmail").val();
					var confirm_email = $(this).val();
					if(b_tEmail!=confirm_email){
						alert("Entered email id is not match");
						return false;
					}
				});
				$(document).on("change", '[name="ddlCategory"]', function() {

    var marks = $("#b_tMarksPercentage");

    if (marks.length && $("#careers_first").data("validator")) {
        marks.valid();
    }

});
				(function ($) {

    // Duration limits in months.
    // Adjust these values according to approved eligibility rules.
    const courseDuration = {
        "BE":       { min: 42, max: 54 },
        "BTech":    { min: 42, max: 54 },
        "BSc Engg": { min: 42, max: 54 },
        "IDD":      { min: 54, max: 66 }
    };

    function addMonths(date, months) {
        const result = new Date(date.getFullYear(), date.getMonth(), 1);
        result.setMonth(result.getMonth() + months);

        // Preserve day where possible
        const lastDay = new Date(
            result.getFullYear(),
            result.getMonth() + 1,
            0
        ).getDate();

        result.setDate(Math.min(date.getDate(), lastDay));

        return result;
    }

    function initializeQualificationDates() {

        const $qualification = $("#b_ddlQualification");
        const $from = $("#b_tCourseFrom");
        const $to = $("#b_tCourseTo");
        const $result = $("#b_tResultDeclarationDate");

        if (!$qualification.length || !$from.length ||
            !$to.length || !$result.length) {
            return;
        }

        // Destroy previously initialized datepickers
        [$from, $to, $result].forEach(function ($field) {
            if ($field.hasClass("hasDatepicker")) {
                $field.datepicker("destroy");
            }
        });

        $from.datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1980:c",
            maxDate: 0,

            onSelect: function () {

                $to.val("");
                $result.val("");

                const fromDate = $from.datepicker("getDate");
                const duration = courseDuration[$qualification.val()];

                if (!fromDate || !duration) {
                    return;
                }

                const minToDate = addMonths(fromDate, duration.min);
                const maxToDate = addMonths(fromDate, duration.max);
                const today = new Date();

                $to.datepicker("option", {
                    minDate: minToDate,
                    maxDate: maxToDate < today ? maxToDate : today
                });

                $result.datepicker("option", "minDate", null);
            }
        });

        $to.datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1980:c",
            maxDate: 0,

            onSelect: function () {

                $result.val("");

                const toDate = $to.datepicker("getDate");

                $result.datepicker("option", {
                    minDate: toDate,
                    maxDate: new Date()
                });
            }
        });

        $result.datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "1980:c",
            maxDate: 0
        });

        // Clear dates when qualification or discipline changes
        $(document)
            .off("change.qualificationDates",
                "#b_ddlQualification, #b_ddlDiscipline")
            .on("change.qualificationDates",
                "#b_ddlQualification, #b_ddlDiscipline",
                function () {

                    $from.val("");
                    $to.val("");
                    $result.val("");

                    $to.datepicker("option", {
                        minDate: null,
                        maxDate: new Date()
                    });

                    $result.datepicker("option", {
                        minDate: null,
                        maxDate: new Date()
                    });
                }
            );
    }

    window.initializeQualificationDates = initializeQualificationDates;

})(jQuery);
				$(document).on("change","#b_ddlIsRelativeInPowergrid",function(){

					var val = $(this).val();
					var synamic_val = $("#b_ddlPosts option:selected").val();
					if(val=='YES'){
						$("#as_employe_as_director"+synamic_val).show();
					}
					else{
						$("#as_employe_as_director"+synamic_val).hide();
						$("#b_tEmployeeDetails1").hide();
						$("#b_bAddRelativeEmployee").hide();
						$("#b_tDirectorDetail").hide();
					}
				});
				$(document).on("change","#b_ddlIsPwd",function(){
					$("#dob").val('');
				});
				$(document).on("change","#dob",function(){
					 var exser = $("#b_ddlIsExServiceMan").val();
					 var cat0 = $("#b_ddlCategory").val();
					 var jkd = $("#b_ddlIsJnKDomicile").val();
					 var roit = $("#b_ddlIsRiotVictim").val();
					 var pwd = $("#b_ddlIsPwd").val();
					 var mdate = new Date($(this).val());
					// alert(mdate);
					 //var mdate = Date.parseExact($("#dob").val(),"d/M/yyyy");
					 // age = today.getFullYear() - birthDate.getFullYear();
					  var yr = mdate.getFullYear();
					 
					  var mn = mdate.getMonth() + 1;
					 
					  var dd = mdate.getDate();
					  
					  
					 // alert(yr);
					 // alert(mn);
					  //alert(dd);
					  var now =20250731;
					  //var now = parseInt(new Date().toISOString().slice(0, 10).replace(/-/g, ''));
					  dob = (yr * 10000) + mn * 100 + dd * 1; // Coerces strings to integers
					 
					  diffage=now-dob;
					 
						if (exser != 'YES' && jkd != 'YES' && roit != 'YES'  && pwd !='YES' )
						{							
							//alert("hello");
						    if(cat0=='GENERAL' || cat0=='EWS' )
							{
								if(diffage>280000)
								{
									//alert(diffage);
									alert("As per age criteria, Your age not eligible for this post.");
									$("#dob").val('');
									return false;
								}
							}
							if(cat0=='OBC(NCL)')
							{
								if(diffage>310000)
								{
									//alert(diffage);
									alert("As per age criteria, Your age not eligible for this post.");
									$("#dob").val('');
									return false;
								}
							}
								
							if(cat0=='SC' || cat0=='ST' )
							{
								if(diffage>330000)
								{
									alert("As per age criteria, Your age not eligible for this post.");
									$("#dob").val('');
									return false;
								}
							}
						
					
					
					 } 
				}); 
				
				var MaxInputs       = 3; //maximum extra input boxes allowed
var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
var AddButton       = $("#b_bAddRelativeEmployee"); //Add button ID

var x = InputsWrapper.length; //initlal text box count
var FieldCount=1; //to keep track of text box added

//on add input button click
$(document).on("click","#b_bAddRelativeEmployee",function(){
		var x = 1;
        if(x <= MaxInputs) {
            FieldCount++; //text box added ncrement
            //add input box
            $("#InputsWrapper").append('<div id="removediv'+x+'"><table id="b_tEmployeeDetails1" class="table table-hover table-striped"><tbody><tr><td class="textbox">Name of Employee</td><td><input name="ctl00$b$tEmployeeName1[]" type="text" maxlength="100" id="b_tEmployeeName1" class="form-control textbox"></td><td class="textbox">Designation</td><td><input name="ctl00$b$tDesignation1[]" type="text" class="form-control textbox" style="width:230px;"></td></tr><tr><td class="textbox">Employee Number</td><td><input name="ctl00$b$tEmpNo1[]" type="text" id="b_tEmpNo1" class="form-control textbox" style="width:230px;"></td><td class="textbox">Place of Posting</td><td><input name="ctl00$b$tPlaceOfPosting1[]" type="text" id="b_tPlaceOfPosting1" class="form-control textbox" style="width:230px;"></td></tr><tr><td class="textbox">Relationship</td><td colspan="3"><input name="ctl00$b$tRelationship1[]" type="text" maxlength="100" id="b_tRelationship1" class="form-control textbox" style="width:230px;"></td></tr></tbody></table></div>');
              x++; //text box increment
            
            $("#b_bAddRelativeEmployee").show();
            
            
            
            // Delete the "add"-link if there is 3 fields.
            if(x == 3) {
                $("#b_bAddRelativeEmployee").hide();
             	$("#lineBreak").html("<br>");
            }
        }
        return false;
});

$("body").on("click",".removeclass", function(e){ //user click on remove text
        if( x > 1 ) {
				var delete_id = $(this).attr('delete_id');
                $("#removediv"+delete_id).remove();
                x--; //decrement textbox
            
            	$("#b_bAddRelativeEmployee").show();
            
            	$("#lineBreak").html("");
            
                // Adds the "add" link again when a field is removed.
                $('b_bAddRelativeEmployee').html("Add field");
        }
	return false;
}) 
				$(document).on("change","#b_dIsEmployeeOrDirector",function(){
					var current_val = $(this).val();
					if(current_val=='Employee'){
						$("#b_tEmployeeDetails1").show();
						$("#b_bAddRelativeEmployee").show();
						$("#b_tDirectorDetail").hide();
						$("#InputsWrapper").show();
					}
					if(current_val=='Director'){
						$("#b_tDirectorDetail").show();
						$("#b_tEmployeeDetails1").hide();
						$("#b_bAddRelativeEmployee").hide();
						$("#InputsWrapper").hide();
					}
				});
			});
			
				function calculateAge(birthday) {
					var now = new Date();
					var past = new Date(birthday);
					var nowYear = now.getFullYear();
					var pastYear = past.getFullYear();
					var nowMonth = now.getMonth();
					var pastMonth = past.getMonth();
					var Year = nowYear - pastYear;
					var month = nowMonth - pastMonth;
					var age = Year+month;
					return age;
				};
			
		
		$(document).on("change", "#b_ddlQualification", function () {

    var qualification = $(this).val(); // FIXED
	//alert (qualification);
    // Reset discipline
    $("#b_ddlDiscipline").val("");

    // Show all options first
    $("#b_ddlDiscipline option")
        .show()
        .prop("disabled", false);

    // NON-ENGINEERING
    if (qualification === "B.A." || qualification === "BBA" || qualification === "B.Com") {
        $("#b_ddlDiscipline option[data-group='engg']")
            .hide()
            .prop("disabled", true);
    }

    // ENGINEERING
    else if (qualification === "BE" || qualification === "BTech" || qualification === "BSc Engg" || qualification === "IDD") {
        $("#b_ddlDiscipline option[data-group='mgmt']")
            .hide()
            .prop("disabled", true);
    }
});



			(function () {

    const locations = [
        'Delhi',
    'Kolkata',
    'Guwahati',
    'Shillong',
    'Mumbai',
    'Bengaluru'
    ];

    const preferenceIds = [
        "b_PostingPref1",
        "b_PostingPref2",
        "b_PostingPref3"
    ];

    function updatePostingOptions() {

        const selects = preferenceIds.map(id =>
            document.getElementById(id)
        );

        // AJAX form may not exist yet
        if (selects.some(select => !select)) {
            return;
        }

        const selectedValues = selects.map(select => select.value);

        selects.forEach((select, index) => {

            const currentValue = selectedValues[index];

            select.innerHTML = "";

            select.add(
                new Option("Please Select a Location", "")
            );

            locations.forEach(location => {

                const selectedElsewhere = selectedValues.some(
                    (value, i) =>
                        i !== index && value === location
                );

                if (!selectedElsewhere) {
                    select.add(new Option(location, location));
                }
            });

            // Restore selected value
            if (Array.from(select.options).some(
                option => option.value === currentValue
            )) {
                select.value = currentValue;
            } else {
                select.value = "";
            }

        });
    }

    // Event delegation for AJAX-generated elements
    document.addEventListener("change", function (event) {

        if (preferenceIds.includes(event.target.id)) {
            updatePostingOptions();
        }

        if (event.target.id === "b_PostingAnywhere") {

            const checked = event.target.checked;

            preferenceIds.forEach(id => {

                const select = document.getElementById(id);

                if (!select) return;

                if (checked) {
                    select.value = "";
                }

                select.disabled = checked;
                select.required = !checked;
            });

            updatePostingOptions();
        }
    });

})();
(function ($) {

    function updateDiscipline() {

        var qualification = $("#b_ddlQualification").val();
        var $discipline = $("#b_ddlDiscipline");

        if (!$discipline.length) return;

        // Clear previously selected discipline
        $discipline.val("");

        // Hide all discipline options initially
        $discipline.find("option[data-group]").prop("hidden", true);

        if (!qualification) {
            // No qualification selected
            $discipline.prop("disabled", true);
            return;
        }

        // Enable discipline dropdown
        $discipline.prop("disabled", false);

        // Engineering qualifications
        if (["BE", "BTech", "BSc Engg", "IDD"].includes(qualification)) {

            $discipline.find('option[data-group="engg"]')
                .prop("hidden", false);
        }

        // Management qualifications (if added later)
        else if (["MBA", "PGDM"].includes(qualification)) {

            $discipline.find('option[data-group="mgmt"]')
                .prop("hidden", false);
        }

        $discipline.trigger("change");
    }

    // Works with dynamically loaded AJAX forms
    $(document).on("change", "#b_ddlQualification", function () {
        updateDiscipline();
    });

})(jQuery);
(function () {

    const fields = [
        ["b_PresentAddress", "b_PermanentAddress"],
        ["b_PresentLandmark", "b_PermanentLandmark"],
        ["b_PresentCity", "b_PermanentCity"],
        ["b_PresentDistrict", "b_PermanentDistrict"],
        ["b_PresentState", "b_PermanentState"],
        ["b_PresentPin", "b_PermanentPin"]
    ];

    function updateAddress() {

        const checkbox = document.getElementById("b_SameAddress");
        const permanentSection =
            document.getElementById("b_PermanentAddressFields");

        if (!checkbox || !permanentSection) {
            return;
        }

        if (checkbox.checked) {

            fields.forEach(function(pair) {

                const present = document.getElementById(pair[0]);
                const permanent = document.getElementById(pair[1]);

                if (!present || !permanent) return;

                permanent.value = present.value;
                permanent.disabled = true;
                permanent.required = false;

            });

            permanentSection.style.display = "none";

        } else {

            fields.forEach(function(pair) {

                const permanent = document.getElementById(pair[1]);

                if (!permanent) return;

                permanent.disabled = false;

                // Landmark is optional
                permanent.required =
                    pair[1] !== "b_PermanentLandmark";
            });

            permanentSection.style.display = "";

        }
    }

    // Works even when HTML is loaded through AJAX
    document.addEventListener("change", function(event) {

        if (event.target.id === "b_SameAddress") {
            updateAddress();
        }

        // Sync if present address changes
        if (
            fields.some(pair => pair[0] === event.target.id)
        ) {
            const checkbox = document.getElementById("b_SameAddress");

            if (checkbox && checkbox.checked) {
                updateAddress();
            }
        }
    });

    document.addEventListener("input", function(event) {

        if (
            fields.some(pair => pair[0] === event.target.id)
        ) {
            const checkbox = document.getElementById("b_SameAddress");

            if (checkbox && checkbox.checked) {
                updateAddress();
            }
        }
    });

})();
           </script>
