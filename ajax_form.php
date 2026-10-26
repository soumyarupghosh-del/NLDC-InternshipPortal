<?php
include("../../../wp-config.php");
	global $wpdb;
	header('Content-Type: application/json; charset=UTF-8');
	header('X-Content-Type-Options: nosniff');
	require_once get_template_directory() . '/functions.php';
	$ajax_nonce = wp_create_nonce('apprentice_ajax_nonce');
		// Optional WAF
	if (function_exists('custom_waf_protection')) {
		custom_waf_protection();
	}

	// POST only
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		wp_send_json_error('Invalid request');
	}
		
	
	
	if(isset($_POST['valu'])){
	$value = intval($_POST['valu']);
		/** Add New Code on 06-01-2026 **/
		$value = absint($_POST['valu']); // safer than intval()

			/** Add New Code on 06-01-2026 **/

			/*$discipline = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT discipline FROM wp_career_discipline_int WHERE category_id = %d",
					$value
				),
				OBJECT
			);

			$qualification = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT qualification FROM wp_career_qualification_int WHERE post_applied_id = %d",
					$value
				),
				OBJECT
			);*/

			$products3 = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM post_applied_details_int WHERE status = %d AND id = %d",
					1,
					$value
				),
				OBJECT
			);
	
		/** End Code **/
		
		
		$html = '';
            $html .='<!-- Preliminary Details -->
            <script> $(function(){ $( "#dob" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "1978:2008",
				
            });
            
				$( "#b_tXsmServiceTo" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2026",
				maxDate: 0,
            });
            $( "#b_tXsmServiceFrom" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2026",
				maxDate: 0,
            });
            $( "#b_tXsmDateOfDischarge" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2026",
				maxDate: 0,
            });
            $( "#b_tCourseFrom" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2025",
            });
            $( "#b_tCourseTo" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2025",
            });
            $( "#b_tResultDeclarationDate" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2025",
            });
            $( "#b_tPgcilServiceFrom" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2025",
            });
            $( "#b_tPgcilServiceTo" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "MM dd yy",
				yearRange: "2000:2025",
            });
             }) </script>';

$title = $products3[0]->post_name;

//$title = str_replace('Apprentices', 'Apprenticeship', $title);

$html .= '
<div id="b_p2" style="width:100%; background-color:#fff3a0; padding:10px;">
  <h3 style="color:red; font-weight:bold;">
    Apply for '.$title.'
  </h3>
</div>';

if($products3[0]->personal_details==1){
           $html .= '<div id="b_p2" style="width:100%;">
    
                <fieldset>
                    <legend><span class="fieldHeader ui-widget-header">Personal Details</span> </legend>
                    <table class="table table-striped table-bordered table-hover table-condensed" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td class="textbox">Name of the Candidate<span style="color:red">*</span>
                                </td>
                                <td>
                                    <input name="name_of_condidate" type="text" maxlength="50" id="name_of_condidate" class="textbox form-control" autocomplete="false"  data-original-title="Please Enter Your Name">
                                </td>
                                <td class="textbox">Father`s / Spause`s Name<span style="color:red">*</span></td>
                                <td>
                                    
                                     <select name="guardianType" id="b_ddlGuardianType" class="form-control DDList"  title="" style="width:230px;">
                                            <option selected="selected" value="">Please Select an Option</option>
                                            <option value="Father">Father</option>
                                            <option value="Husband">Husband</option>

                                        </select>
                                    <br>
                                   
                                    <input name="guardianName" type="text" maxlength="100" id="b_tABCDGuardianName" class="form-control textbox"  style="width:230px;" >
                                   
                                </td>
                            </tr>
                            <tr>
                                <td class="empdettd">Mother`s Name<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <input name="motherName" type="text" maxlength="100" id="b_tMotherName" class="textbox form-control"  style="width:230px;">
                                    
                                </td>
                               <td class="empdettd">
                                APAAR <span style="color:red">*</span>
                                <br>
                                <span style="color:red; font-size:11px;">
                                    Automated Permanent Academic Account Registry
                                </span>
                            </td>
                                </td>
                                <td class="empdettd">
                                    <input
    type="text"
    maxlength="12"
    minlength="12"
    pattern="[0-9]{12}"
    inputmode="numeric"
    id="apaardigit"
    name="apaardigit"
    class="form-control"
    placeholder="Enter 12-digit APAAR ID"
    title="Please enter exactly 12 digits"
    required
/>
                                </td>
                            </tr>
                            <tr>
                                <td class="empdettd">Gender<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <select name="Gender" id="b_ddlGender" class="form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="MALE">MALE</option>
                                        <option value="FEMALE">FEMALE</option>
                                        <option value="OTHERS">OTHERS</option>

                                    </select>
                                    
                                </td>
                                <td class="empdettd">Marital Status<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <select name="MaritalStatus" id="b_ddlMaritalStatus" class="form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="MARRIED">MARRIED</option>
                                        <option value="UNMARRIED">UNMARRIED</option>
                                        <option value="WIDOWED">WIDOWED</option>
                                        <option value="SEPARATED">SEPARATED</option>
                                        <option value="WIDOWER">WIDOWER</option>

                                    </select>
                                   
                                </td>
                            </tr>
                           
                            <tr>
                                <td class="empdettd">Category<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <select name="ddlCategory" id="b_ddlCategory" class="form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="GENERAL">GENERAL</option>
                                        <option value="OBC(NCL)">OBC(NCL)</option>
										<option value="EWS">EWS</option>
                                        <option value="SC">SC</option>
                                        <option value="ST">ST</option>
                                    </select>
                                    
                                </td>
                                <td class="empdettd">Minority Community<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <select name="MinorityCommunity" id="b_ddlMinorityCommunity" class="form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="NOT APPLICABLE">NOT APPLICABLE</option>
                                        <option value="BUDDHIST">BUDDHIST</option>
                                        <option value="CHRISTIAN">CHRISTIAN</option>
                                        <option value="ISLAM">ISLAM</option>
                                        <option value="JAIN">JAIN</option>
                                        <option value="SIKH">SIKH</option>
                                        <option value="ZOROASTRIANS">ZOROASTRIANS</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="empdettd">Domicile State<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <select name="DomicileState" id="b_ddlDomicileState" class="DDList form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select a State</option>
                                        <option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
                                        <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                                        <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                                        <option value="ASSAM">ASSAM</option>
                                        <option value="BIHAR">BIHAR</option>
                                        <option value="CHANDIGARH">CHANDIGARH</option>
                                        <option value="CHATTISGARH">CHATTISGARH</option>
                                        <option value="DADRA AND NAGAR HAVELI">DADRA AND NAGAR HAVELI</option>
                                        <option value="DAMAN AND DIU">DAMAN AND DIU</option>
                                        <option value="DELHI">DELHI</option>
                                        <option value="GOA">GOA</option>
                                        <option value="GUJARAT">GUJARAT</option>
                                        <option value="HARYANA">HARYANA</option>
                                        <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                                        <option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
                                        <option value="JHARKHAND">JHARKHAND</option>
                                        <option value="KARNATAKA">KARNATAKA</option>
                                        <option value="KERALA">KERALA</option>
                                        <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                                        <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                                        <option value="MAHARASHTRA">MAHARASHTRA</option>
                                        <option value="MANIPUR">MANIPUR</option>
                                        <option value="MEGHALAYA">MEGHALAYA</option>
                                        <option value="MIZORAM">MIZORAM</option>
                                        <option value="NAGALAND">NAGALAND</option>
                                        <option value="ODISHA">ODISHA</option>
                                        <option value="PUDUCHERRY">PUDUCHERRY</option>
                                        <option value="PUNJAB">PUNJAB</option>
                                        <option value="RAJASTHAN">RAJASTHAN</option>
                                        <option value="SIKKIM">SIKKIM</option>
                                        <option value="TAMIL NADU">TAMIL NADU</option>
                                        <option value="TELANGANA">TELANGANA</option>
                                        <option value="TRIPURA">TRIPURA</option>
                                        <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                                        <option value="UTTARAKHAND">UTTARAKHAND</option>
                                        <option value="WEST BENGAL">WEST BENGAL</option>
                                    </select>
                                </td>
                                <td class="textbox">Nationality<span style="color:red">*</span>
                                </td>
                                <td>
                                    <select name="Nationality" id="b_ddlNationality" class="form-control DDList" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="INDIAN">INDIAN</option>
                                    </select>
                                </td>
                            </tr>
                           
							<tr>
							<td class="empdettd"><b> PWD Status: </b> Are you a Person with Disability<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <select name="ctl00$b$ddlIsPwd"  id="b_ddlIsPwd" class="form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
								<td></td>
								<td></td>
							</tr>';
                            if($products3[0]->pwd_details==1){
                                $html .='<tr id="firstpwdtr" style="display:none;">
                              
                                <td class="empdettd">Percentage of Disability<br>
                                    <span style="color: green">Minimum 40% disability is required to avail
                                        PwD benefits.</span>
                                </td>
                                <td class="empdettd" colspan="3">
                                    <input name="DisabilityPercentage" type="text" maxlength="100" id="b_tDisabilityPercentage" class="form-control" style="width:230px;">
                                </td>

                            </tr>
                            <tr id="secondpwdtr" style="display:none;">
                                <td class="empdettd">PwD Category
                                </td>
                                <td class="empdettd">
                                    <select name="ctl00$b$ddlPhCategory" id="b_ddlPhCategory" class="form-control" style="width:230px;">
                                    <option selected="selected" value="">Please Select an Option</option>
                                        <option value="OH">OH</option>
                                        <option value="HH">HH</option>
                                        <option value="VH">VH</option>
                                        <option value="Oth">Others</option>
                                        
                                    </select>
                                    
                                </td>

                                <td name="dd" id="dd" style="display:none;" >Details</td>
                                <td name="dd1" id="dd1" style="display:none;"><input name="pwdothers" id="pwdothers" style="display:none;" type="text" maxlength="100" class="form-control textbox"></td>
                               
                            </tr>';
                            }
                            $html .='<tr>
                                <td class="empdettd">Date of Birth<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <input name="Dob" type="text" readonly="true" id="dob" class="textbox form-control">
                                    
                                </td>
                                                             <td class="textbox">
                                Aadhaar No. <span style="color:red">*</span>
                            </td>
                            <td>
                                <input type="text"
                                    value=""
                                    name="aadhar_card"
                                    id="b_aadhar_card"
                                    maxlength="12"
                                    minlength="12"
                                    pattern="[2-9][0-9]{11}"
                                    inputmode="numeric"
                                    class="form-control"
                                    placeholder="Enter 12-digit Aadhaar Number"
                                    title="Enter a valid 12-digit Aadhaar number"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,\'\').slice(0,12)"
                                    required
                                />
                            </td>
								</tr>
								';
                                if($products3[0]->writen_exam_language==1){
                                $html .='<tr><td class="empdettd">Language Known <span style="color:red">*</span>
                                   </td>
                                <td class="empdettd">
                                    <select name="WrittenExamLanguage" id="b_ddlWrittenExamLanguage" class="form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="English">English</option>
                                        <option value="Hindi">Hindi</option>
										<option value="English / Hindi both">English / Hindi both</option>
                                    </select>
                                </td> </tr>';
                                }
                           $html .=' 

                                
                                 
                            
                        </tbody>
                    </table>
                </fieldset>
                <br>
            
</div>';
}


           $html .=' <!-- PwD Details -->
            <div id="b_pPosting">
    <fieldset>
        <legend>
            <span class="fieldHeader ui-widget-header">
                 Location Preference <span style="color:red">*</span>
    
    <span style="color:red; font-size:11px;">
        (Rank up to 3 locations in order of preference)
    </span>
            </span>
        </legend>

        <table class="table table-striped table-bordered table-hover table-condensed"
               style="width:100%;">
            <tbody>

                <!-- Anywhere -->
                <tr>
                    <td class="empdettd" style="width:35%;">
                        Willing to be posted Anywhere
                    </td>
                    <td class="empdettd">
                        <label>
                            <input type="checkbox"
                                   name="PostingAnywhere"
                                   id="b_PostingAnywhere"
                                   value="1">
                            Anywhere
                        </label>
                    </td>
                </tr>

                <!-- First Preference -->
                <tr>
                    <td class="empdettd">
                        1st Preference <span style="color:red">*</span>
                    </td>
                    <td class="empdettd">
                        <select name="PostingPref1"
                                id="b_PostingPref1"
                                class="form-control posting-pref"
                                style="width:230px;"
                                required>
                            <option value="">Please Select a Location</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Kolkata">Kolkata</option>
                            <option value="Guwahati">Guwahati</option>
                            <option value="Shillong">Shillong</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Bengaluru">Bengaluru</option>
                        </select>
                    </td>
                </tr>

                <!-- Second Preference -->
                <tr>
                    <td class="empdettd">
                        2nd Preference <span style="color:red">*</span>
                    </td>
                    <td class="empdettd">
                        <select name="PostingPref2"
                                id="b_PostingPref2"
                                class="form-control posting-pref"
                                style="width:230px;"
                                required>
                            <option value="">Please Select a Location</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Kolkata">Kolkata</option>
                            <option value="Guwahati">Guwahati</option>
                            <option value="Shillong">Shillong</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Bengaluru">Bengaluru</option>
                        </select>
                    </td>
                </tr>

                <!-- Third Preference -->
                <tr>
                    <td class="empdettd">
                        3rd Preference <span style="color:red">*</span>
                    </td>
                    <td class="empdettd">
                        <select name="PostingPref3"
                                id="b_PostingPref3"
                                class="form-control posting-pref"
                                style="width:230px;"
                                required>
                            <option value="">Please Select a Location</option>
                           <option value="Delhi">Delhi</option>
                            <option value="Kolkata">Kolkata</option>
                            <option value="Guwahati">Guwahati</option>
                            <option value="Shillong">Shillong</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Bengaluru">Bengaluru</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <span style="color:green;">
                            Select exactly three different posting locations
                            in order of preference, or select Anywhere.
                        </span>
                    </td>
                </tr>

            </tbody>
        </table>
    </fieldset>
</div>
            <br>';
		
		if($products3[0]->registration_emploment_exchange==1){
          $html .='  <!-- Employment Exchange Registration Details -->
            <div id="b_p2a">
    
                <fieldset>
                    <legend><span class="fieldHeader ui-widget-header">एनएटीएस रजिस्ट्रेशन संख्या /  NATS REGISTRATION NO</span> </legend>
                    <table class="table table-striped table-bordered table-hover table-condensed" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td class="empdettd">Have you Registered with NATS
                                </td>
                                <td class="empdettd">
                                    <select name="IsEeReg"  id="b_ddlIsEeReg" class="form-control" style="width:230px;">
                                        
										<option value="YES">YES</option>
                                    </select>
                                </td>
                                <td class="textbox">State
                                </td>
                                <td>
                                    <select name="StatesE" id="b_ddlStatesE" class="form-control textbox" style="width:230px;">
                                       <option selected="selected" value="">Please Select a State</option>
                                        <option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
                                        <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                                        <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                                        <option value="ASSAM">ASSAM</option>
                                        <option value="BIHAR">BIHAR</option>
                                        <option value="CHANDIGARH">CHANDIGARH</option>
                                        <option value="CHATTISGARH">CHATTISGARH</option>
                                        <option value="DADRA AND NAGAR HAVELI">DADRA AND NAGAR HAVELI</option>
                                        <option value="DAMAN AND DIU">DAMAN AND DIU</option>
                                        <option value="DELHI">DELHI</option>
                                        <option value="GOA">GOA</option>
                                        <option value="GUJARAT">GUJARAT</option>
                                        <option value="HARYANA">HARYANA</option>
                                        <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                                        <option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
                                        <option value="JHARKHAND">JHARKHAND</option>
                                        <option value="KARNATAKA">KARNATAKA</option>
                                        <option value="KERALA">KERALA</option>
                                        <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                                        <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                                        <option value="MAHARASHTRA">MAHARASHTRA</option>
                                        <option value="MANIPUR">MANIPUR</option>
                                        <option value="MEGHALAYA">MEGHALAYA</option>
                                        <option value="MIZORAM">MIZORAM</option>
                                        <option value="NAGALAND">NAGALAND</option>
                                        <option value="ODISHA">ODISHA</option>
                                        <option value="PUDUCHERRY">PUDUCHERRY</option>
                                        <option value="PUNJAB">PUNJAB</option>
                                        <option value="RAJASTHAN">RAJASTHAN</option>
                                        <option value="SIKKIM">SIKKIM</option>
                                        <option value="TAMIL NADU">TAMIL NADU</option>
                                        <option value="TELANGANA">TELANGANA</option>
                                        <option value="TRIPURA">TRIPURA</option>
                                        <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                                        <option value="UTTARAKHAND">UTTARAKHAND</option>
                                        <option value="WEST BENGAL">WEST BENGAL</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="textbox">Registration No.
                                </td>
                                <td colspan="3">
                                    <input name="RegistrationNo" type="text" maxlength="50" id="b_tEeRegistrationNo" class="form-control textbox" style="width:230px;">  
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </fieldset>
            
</div>
            <br>';
}
		
		if($products3[0]->work_experinece==1){
            $html .= '<!-- Internal Candidate Details -->
            <div id="b_p4" style="width:100%;">
    
                <fieldset>
                    <legend>
                        <span class="fieldHeader ui-widget-header">Prior work experience with Power System Operation Corporation</span>
                    </legend>
                    <table class="table table-striped table-bordered table-hover table-condensed" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td class="textbox">Whether you have worked/working in POSOCO ?<span style="color:red">*</span>
                                </td>
                                <td>
                                    <select name="IsPowerGridEmployee"  id="b_ddlIsPowerGridEmployee" class="DDList form-control" style="width:230px;">
                                        <option selected="selected" value="">Please Select an Option</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                                <td class="textbox">POSOCO Employee Number<span style="color:red">*</span>
                                </td>
                                <td>
                                    <input name="EmployeeNumber" type="text" maxlength="8" id="b_tEmployeeNumber" class="textbox form-control" style="width:230px;">
                             
                                </td>
                            </tr>
                            <tr>
                                <td class="textbox">Region<span style="color:red">*</span>
                                </td>
                                <td colspan="3">
                                    <select name="PowergridRegion" id="b_ddlPowergridRegion" class="DDList form-control"  style="width:230px;">
										<option value="CC-POSOCO">CC-POSOCO</option>
										<option value="National Load Despatch Centre">National Load Despatch Centre</option>
										<option value="Northern Regional Despatch Centre">Northern Regional Load Despatch Centre</option>
										<option value="Western Regional Despatch Centre">Western Regional Load Despatch Centre</option>
										<option value="Eeastern Regional Despatch Centre">Eeastern Regional Load Despatch Centre</option>
										<option value="Sourthen Regional Despatch Centre">Sourthen Regional Load Despatch Centre</option>
										<option value="North Eeastern Regional Load Despatch Centre">North Eeastern Regional Load Despatch Centre</option>
                                    </select>
                                   
                                </td>
                            </tr>
                            <tr>
                            <td class="empdettd">Employed From Date<span style="color:red">*</span>
                                </td>
                                <td class="empdettd">
                                    <input name="PgcilServiceFrom" readonly="true" type="text" id="b_tPgcilServiceFrom" class="form-control "  style="width:230px;">
                                    
                                </td>
                            
                                <td class="empdettd">Employed Upto Date<span style="color:red">*</span>
								<!--<br>
                                    <span style="font-size: smaller; color: green">(For Current POSOCO Employee please put date of the Application.)</span> -->
								
                                </td>
                                <td class="empdettd">
                                    <input name="PgcilServiceTo" readonly="true" type="text" id="b_tPgcilServiceTo" class="form-control" style="width:230px;">
                                   
                                </td>
                        </tr></tbody>
                    </table>
                </fieldset>
                <br>
            
</div>';
}
	if($products3[0]->malling_address==1){
           $html .=' <!-- Mailing Address - Current -->
            <div id="b_pAddress">

    <fieldset>

        <legend>
            <span class="fieldHeader ui-widget-header">
                Address Details
            </span>
        </legend>

        <table class="table table-striped table-bordered table-hover table-condensed"
               style="width:100%;">

            <tbody>

                <!-- PRESENT ADDRESS HEADING -->
                <tr>
                    <td colspan="4"
                        style="background:#e9ecef;font-weight:bold;">
                        Present Address
                    </td>
                </tr>

                <!-- ADDRESS LINE 1 -->
                <tr>
                    <td class="empdettd" style="width:25%;">
                        Address Line 1
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd" colspan="3">
                        <textarea
                            name="PresentAddress"
                            id="b_PresentAddress"
                            maxlength="200"
                            rows="2"
                            class="form-control"
                            required></textarea>
                    </td>
                </tr>

                <!-- LANDMARK -->
                <tr>
                    <td class="empdettd">
                        Address Line 2 / Landmark
                    </td>

                    <td class="empdettd" colspan="3">
                        <input
                            type="text"
                            name="PresentLandmark"
                            id="b_PresentLandmark"
                            maxlength="100"
                            class="form-control">
                    </td>
                </tr>

                <!-- CITY AND DISTRICT -->
                <tr>
                    <td class="empdettd">
                        City / Town / Village
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            type="text"
                            name="PresentCity"
                            id="b_PresentCity"
                            maxlength="100"
                            class="form-control"
                            required>
                    </td>

                    <td class="empdettd">
                        District
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            type="text"
                            name="PresentDistrict"
                            id="b_PresentDistrict"
                            maxlength="100"
                            class="form-control"
                            required>
                    </td>
                </tr>

                <!-- STATE AND PIN -->
                <tr>
                    <td class="empdettd">
                        State / UT
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <select
                            name="PresentState"
                            id="b_PresentState"
                            class="form-control"
                            required>

                            <option value="">
                                Please Select State
                            </option>
                            <option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
                                        <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                                        <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                                        <option value="ASSAM">ASSAM</option>
                                        <option value="BIHAR">BIHAR</option>
                                        <option value="CHANDIGARH">CHANDIGARH</option>
                                        <option value="CHATTISGARH">CHATTISGARH</option>
                                        <option value="DADRA AND NAGAR HAVELI">DADRA AND NAGAR HAVELI</option>
                                        <option value="DAMAN AND DIU">DAMAN AND DIU</option>
                                        <option value="DELHI">DELHI</option>
                                        <option value="GOA">GOA</option>
                                        <option value="GUJARAT">GUJARAT</option>
                                        <option value="HARYANA">HARYANA</option>
                                        <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                                        <option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
                                        <option value="JHARKHAND">JHARKHAND</option>
                                        <option value="KARNATAKA">KARNATAKA</option>
                                        <option value="KERALA">KERALA</option>
                                        <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                                        <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                                        <option value="MAHARASHTRA">MAHARASHTRA</option>
                                        <option value="MANIPUR">MANIPUR</option>
                                        <option value="MEGHALAYA">MEGHALAYA</option>
                                        <option value="MIZORAM">MIZORAM</option>
                                        <option value="NAGALAND">NAGALAND</option>
                                        <option value="ODISHA">ODISHA</option>
                                        <option value="PUDUCHERRY">PUDUCHERRY</option>
                                        <option value="PUNJAB">PUNJAB</option>
                                        <option value="RAJASTHAN">RAJASTHAN</option>
                                        <option value="SIKKIM">SIKKIM</option>
                                        <option value="TAMIL NADU">TAMIL NADU</option>
                                        <option value="TELANGANA">TELANGANA</option>
                                        <option value="TRIPURA">TRIPURA</option>
                                        <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                                        <option value="UTTARAKHAND">UTTARAKHAND</option>
                                        <option value="WEST BENGAL">WEST BENGAL</option>

                        </select>
                    </td>

                    <td class="empdettd">
                        PIN Code
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            type="text"
                            name="PresentPin"
                            id="b_PresentPin"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            inputmode="numeric"
                            class="form-control"
                            required>
                    </td>
                </tr>

                <!-- PERMANENT ADDRESS HEADING -->
                <tr>
                    <td colspan="4"
                        style="background:#e9ecef;font-weight:bold;">
                        Permanent Address
                    </td>
                </tr>

                <!-- SAME AS PRESENT -->
                <tr>
                    <td class="empdettd">
                        Same as Present Address
                    </td>

                    <td class="empdettd" colspan="3">
                        <label>
                            <input
                                type="checkbox"
                                name="SameAddress"
                                id="b_SameAddress"
                                value="1">
                            Yes, my Permanent Address is the same
                            as my Present Address.
                        </label>
                    </td>
                </tr>

            </tbody>

            <!-- PERMANENT ADDRESS FIELDS -->
            <tbody id="b_PermanentAddressFields">

                <!-- ADDRESS LINE 1 -->
                <tr>
                    <td class="empdettd">
                        Address Line 1
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd" colspan="3">
                        <textarea
                            name="PermanentAddress"
                            id="b_PermanentAddress"
                            maxlength="200"
                            rows="2"
                            class="form-control"
                            required></textarea>
                    </td>
                </tr>

                <!-- LANDMARK -->
                <tr>
                    <td class="empdettd">
                        Address Line 2 / Landmark
                    </td>

                    <td class="empdettd" colspan="3">
                        <input
                            type="text"
                            name="PermanentLandmark"
                            id="b_PermanentLandmark"
                            maxlength="100"
                            class="form-control">
                    </td>
                </tr>

                <!-- CITY AND DISTRICT -->
                <tr>
                    <td class="empdettd">
                        City / Town / Village
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            type="text"
                            name="PermanentCity"
                            id="b_PermanentCity"
                            maxlength="100"
                            class="form-control"
                            required>
                    </td>

                    <td class="empdettd">
                        District
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            type="text"
                            name="PermanentDistrict"
                            id="b_PermanentDistrict"
                            maxlength="100"
                            class="form-control"
                            required>
                    </td>
                </tr>

                <!-- STATE AND PIN -->
                <tr>
                    <td class="empdettd">
                        State / UT
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <select
                            name="PermanentState"
                            id="b_PermanentState"
                            class="form-control"
                            required>

                            <option value="">
                                Please Select State
                            </option>
                            <option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
                                        <option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
                                        <option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
                                        <option value="ASSAM">ASSAM</option>
                                        <option value="BIHAR">BIHAR</option>
                                        <option value="CHANDIGARH">CHANDIGARH</option>
                                        <option value="CHATTISGARH">CHATTISGARH</option>
                                        <option value="DADRA AND NAGAR HAVELI">DADRA AND NAGAR HAVELI</option>
                                        <option value="DAMAN AND DIU">DAMAN AND DIU</option>
                                        <option value="DELHI">DELHI</option>
                                        <option value="GOA">GOA</option>
                                        <option value="GUJARAT">GUJARAT</option>
                                        <option value="HARYANA">HARYANA</option>
                                        <option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
                                        <option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
                                        <option value="JHARKHAND">JHARKHAND</option>
                                        <option value="KARNATAKA">KARNATAKA</option>
                                        <option value="KERALA">KERALA</option>
                                        <option value="LAKSHADWEEP">LAKSHADWEEP</option>
                                        <option value="MADHYA PRADESH">MADHYA PRADESH</option>
                                        <option value="MAHARASHTRA">MAHARASHTRA</option>
                                        <option value="MANIPUR">MANIPUR</option>
                                        <option value="MEGHALAYA">MEGHALAYA</option>
                                        <option value="MIZORAM">MIZORAM</option>
                                        <option value="NAGALAND">NAGALAND</option>
                                        <option value="ODISHA">ODISHA</option>
                                        <option value="PUDUCHERRY">PUDUCHERRY</option>
                                        <option value="PUNJAB">PUNJAB</option>
                                        <option value="RAJASTHAN">RAJASTHAN</option>
                                        <option value="SIKKIM">SIKKIM</option>
                                        <option value="TAMIL NADU">TAMIL NADU</option>
                                        <option value="TELANGANA">TELANGANA</option>
                                        <option value="TRIPURA">TRIPURA</option>
                                        <option value="UTTAR PRADESH">UTTAR PRADESH</option>
                                        <option value="UTTARAKHAND">UTTARAKHAND</option>
                                        <option value="WEST BENGAL">WEST BENGAL</option>

                        </select>
                    </td>

                    <td class="empdettd">
                        PIN Code
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            type="text"
                            name="PermanentPin"
                            id="b_PermanentPin"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            inputmode="numeric"
                            class="form-control"
                            required>
                    </td>
                </tr>

            </tbody>

        </table>

    </fieldset>

</div>

<br>';
}
if($products3[0]->contact_details==1){
            $html .='<!-- Contact Details -->
            <div id="b_p6" style="width:100%;">

    <fieldset>

        <legend>
            <span class="fieldHeader ui-widget-header">
                Contact Details
            </span>
        </legend>

        <table class="table table-striped table-bordered table-hover table-condensed"
               style="width:100%;">

            <tbody>

                <!-- MOBILE NUMBERS -->
                <tr>
                    <td class="empdettd" style="width:25%;">
                        Mobile Number
                        <span style="color:red">*</span>
                        <br>
                        <small>(Without leading 0 or +91)</small>
                    </td>

                    <td class="empdettd" style="width:25%;">
                        <input
                            name="MobileNumber"
                            type="text"
                            maxlength="10"
                            id="b_tMobileNumber"
                            class="form-control"
                            inputmode="numeric"
                            pattern="[6-9][0-9]{9}"
                            required>
                    </td>

                    <td class="empdettd" style="width:25%;">
                        Alternate Mobile Number
                        <br>
                        <small>(Without leading 0 or +91)</small>
                    </td>

                    <td class="empdettd" style="width:25%;">
                        <input
                            name="MobileNumberalternet"
                            type="text"
                            maxlength="10"
                            id="b_tMobileNumber1"
                            class="form-control"
                            inputmode="numeric"
                            pattern="[6-9][0-9]{9}">
                    </td>
                </tr>

                <!-- LANDLINE DETAILS -->
                <tr>
                    <td class="empdettd">
                        STD Code
                    </td>

                    <td class="empdettd">
                        <input
                            name="StdCode"
                            type="text"
                            maxlength="5"
                            id="b_tStdCode"
                            class="form-control"
                            inputmode="numeric">
                    </td>

                    <td class="empdettd">
                        Landline Number
                    </td>

                    <td class="empdettd">
                        <input
                            name="Landline"
                            type="text"
                            maxlength="8"
                            id="b_tLandline"
                            class="form-control"
                            inputmode="numeric">
                    </td>
                </tr>

                <!-- EMAIL DETAILS -->
                <tr>
                    <td class="empdettd">
                        E-mail ID
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            name="Email"
                            type="email"
                            maxlength="50"
                            id="b_tEmail"
                            class="form-control"
                            required>
                    </td>

                    <td class="empdettd">
                        Re-Enter E-mail ID
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            name="EmailAgain"
                            type="email"
                            maxlength="50"
                            id="b_tEmailAgain"
                            class="form-control"
                            required>
                    </td>
                </tr>

                <!-- ALTERNATE EMAIL -->
                <tr>
                    <td class="empdettd">
                        Alternate E-mail ID
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            name="AlternateEmail"
                            type="email"
                            maxlength="50"
                            id="b_tAlternateEmail"
                            class="form-control"
                            required>
                    </td>

                    <td class="empdettd" colspan="2">
                        &nbsp;
                    </td>
                </tr>

            </tbody>

        </table>

    </fieldset>

</div>

<br>';
}
if($products3[0]->qualification_details==1){
            $html .= '<!-- Qualification Details -->
           <div id="b_p7" style="width:100%;">

    <fieldset>

        <legend>
            <span class="fieldHeader ui-widget-header">
                Essential Qualification Details
            </span>
        </legend>

        <table class="table table-striped table-bordered table-hover table-condensed"
               style="width:100%;">

            <tbody>

                <!-- QUALIFICATION STATUS AND QUALIFICATION -->
                <tr>
                    <td class="empdettd" style="width:25%;">
                        Qualification Status
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd" style="width:25%;">
                        <select
                            name="check_apearing_mode"
                            id="check_apearing_mode"
                            class="form-control DDList"
                            required>

                            <option value="Passed">Passed</option>

                        </select>
                    </td>

                    <td class="empdettd" style="width:25%;">
                        Qualification
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd" style="width:25%;">
                        <select
                            name="Qualification"
                            id="b_ddlQualification"
                            class="form-control DDList"
                            required>

                            <option value="">Please Select an Option</option>
                            <option value="BE">B.E.</option>
                            <option value="BTech">B.Tech</option>
                            <option value="BSc Engg">BSc. Engg</option>
                            <option value="IDD">IDD</option>

                        </select>
                    </td>
                </tr>

                <!-- DISCIPLINE AND PERCENTAGE -->
                <tr>
                    <td class="empdettd">
                        Discipline
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <select
                            name="Discipline"
                            id="b_ddlDiscipline"
                            class="form-control DDList"
                            disabled
                            required>

                            <option value="">Please Select an Option</option>

                            <!-- Engineering -->
                            <option value="Electrical" data-group="engg">
                                Electrical
                            </option>

                            <option value="Electrical (Power)" data-group="engg">
                                Electrical (Power)
                            </option>

                            <option value="Electrical and Electronics" data-group="engg">
                                Electrical and Electronics
                            </option>

                            <option value="Power Systems Engineering" data-group="engg">
                                Power Systems Engineering
                            </option>

                            <option value="Power Engineering (Electrical)" data-group="engg">
                                Power Engineering (Electrical)
                            </option>

                            <!-- Management -->
                            <option value="HR" data-group="mgmt">
                                HR
                            </option>

                            <option value="Finance" data-group="mgmt">
                                Finance
                            </option>

                        </select>
                    </td>

                    <td class="empdettd">
                        Percentage of Marks
                        <br>
                        <small style="color:green;">
                            Enter percentage up to 2 decimal places
                            (e.g. 70.00)
                        </small>
                    </td>

                    <td class="empdettd">
                        <input
                            name="MarksPercentage"
                            type="text"
                            maxlength="6"
                            id="b_tMarksPercentage"
                            class="form-control textbox"
                            inputmode="decimal"
                            placeholder="e.g. 70.00">
                    </td>
                </tr>

                <!-- COURSE DURATION -->
                <tr>
                    <td class="empdettd">
                        Course Duration – From
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            name="CourseFrom"
                            type="text"
                            readonly="readonly"
                            id="b_tCourseFrom"
                            class="form-control textbox"
                            required>
                    </td>

                    <td class="empdettd">
                        Course Duration – To
                        <span style="color:red">*</span>
                    </td>

                    <td class="empdettd">
                        <input
                            name="CourseTo"
                            type="text"
                            readonly="readonly"
                            id="b_tCourseTo"
                            class="form-control textbox"
                            required>
                    </td>
                </tr>

                <!-- RESULT DATE AND INSTITUTE -->
                <tr>
                    <td class="empdettd">
                        Date of Declaration of Result
                        <span style="color:red">*</span>
                        <br>
                        <small style="color:green;">
                            Enter the date of issue of the final-year marksheet.
                        </small>
                    </td>

                    <td class="empdettd">
                        <input
                            name="ResultDeclarationDate"
                            type="text"
                            readonly="readonly"
                            id="b_tResultDeclarationDate"
                            class="form-control textbox"
                            required>
                    </td>

                    <td class="empdettd">
                        Institute Name
                        <span style="color:red">*</span>
                        <br>
                        <small style="color:green;">
                            Enter the complete institute name.
                            Do not use abbreviations.
                        </small>
                    </td>

                    <td class="empdettd">
                        <input
                            name="Institution"
                            type="text"
                            maxlength="100"
                            id="b_tInstitution"
                            class="form-control textbox"
                            required>
                    </td>
                </tr>

            </tbody>

        </table>

    </fieldset>

</div><br/>';
}
	if($products3[0]->bank_details==1){
           $html .= '<!-- Bank Account Details -->
           <div id="b_p8" style="width:100%;">
    
                <fieldset>
                    <legend><span class="fieldHeader ui-widget-header">Bank Details (DBT enabled account details)</span>
                    </legend>
                    <table class="table table-hover table-striped">
                        <tbody>
                            <tr>
                                <td class="textbox">Account Holder Name
                                </td>
                                <td>
                                    <input name="account_hname" type="text" maxlength="100" id="b_tAccountHolderName" class="form-control textbox">
                                    
                                </td>
                                <td class="textbox">Bank Name
                                </td>
                                <td>
                                    <input name="bank_name" type="text" maxlength="100" id="b_tBankName"  class="form-control textbox">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td class="textbox">Branch Name
                                </td>
                                <td>
                                    <input name="branch_name" type="text" maxlength="100" id="b_tBranchName" class="form-control textbox" style="width:230px;">
                                    
                                </td>
                                <td class="textbox">Branch City
                                </td>
                                <td>
                                    <input name="branch_city" type="text" maxlength="100" id="b_tBranchCity" class="form-control textbox" style="width:230px;" >
                                    
                                </td>
                            </tr>
                            <tr>
                                <td class="textbox">Account Number
                                </td>
                                <td>
                                    <input name="account_number" type="text" maxlength="100" id="b_tAccountNumber" class="form-control textbox" style="width:230px;">
                                    
                                </td>
                                <td class="textbox">IFSC Code
                                </td>
                                <td>
                                    <input name="ifsc_code" type="text" maxlength="11" id="b_tIfscCode"  class="form-control textbox" style="width:230px;">
                                    
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </fieldset>
                <br>
            
</div>';
}
if($products3[0]->relationship_declaration==1){
          $html .='  <!-- Transparency / Relationship Declaration -->
            <div id="b_p11" style="width:100%;">
    
                <fieldset>
                    <legend><span class="fieldHeader ui-widget-header">Transparency / Relationship Declaration</span> </legend>
                    <table class="table table-hover table-striped" style="width: 100%;">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label class="control-label" for="">Do you have any relative working / employed in POSOCO?<span style="color:red">*</span></label>
                                        <div class="form-group">
                                            <select name="IsRelativeInPowergrid"  id="b_ddlIsRelativeInPowergrid" class="DDList form-control">
                                                <option selected="selected" value="">Please Select an Option</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>

                                            </select>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr id="as_employe_as_director'.$value.'" style="display:none;">
                                <td>
                                    <div id="b_dIsEmployeeOrDirector" class="form-group" id="b_dIsEmployeeOrDirector">
                                        <label class="control-label" for="">Whether he/ she is working as Employee or as Director in the Board of Directors</label>
                                        <div class="form-group">
                                            <select name="ctl00$b$ddlIsEmployeeOrDirector" id="b_dIsEmployeeOrDirector" class="form-control">
                                                <option selected="selected" value="">Please Select an Option</option>
                                                <option value="Employee">Employee</option>
                                                <option value="Director">Director</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table id="b_tEmployeeDetails1" style="display:none;" class="table table-hover table-striped"><tbody>
                    <tr>
                        <td class="textbox">Name of Employee</td>
                        <td><input name="ctl00$b$tEmployeeName1[]" type="text" maxlength="100" id="b_tEmployeeName1" class="form-control textbox"></td>
                        <td class="textbox">Designation</td>
                        <td><input name="ctl00$b$tDesignation1[]" type="text" class="form-control textbox" style="width:230px;">
                        </td>
                    </tr>
                    <tr>
                        <td class="textbox">Employee Number</td>
                        <td>
                        <input name="ctl00$b$tEmpNo1[]" type="text" id="b_tEmpNo1" class="form-control textbox" style="width:230px;">
                        </td>
                        <td class="textbox">Place of Posting</td>
                        <td><input name="ctl00$b$tPlaceOfPosting1[]" type="text" id="b_tPlaceOfPosting1" class="form-control textbox" style="width:230px;">
                        </td>
                    </tr>
                    <tr>
                        <td class="textbox">Relationship</td>
                        <td colspan="3">
                        <input name="ctl00$b$tRelationship1[]" type="text" maxlength="100" id="b_tRelationship1" class="form-control textbox" style="width:230px;">
                        </td>
                    </tr></tbody></table> 
                    <div id="InputsWrapper">
                    </div>
                    <input type="button" name="ctl00$b$bAddRelativeEmployee" value="Add New Relative Employee Detail" id="b_bAddRelativeEmployee" class="btn btn-success" style="display:none;">
                    <!-- Relative Employee Details -->
                    
                    <table id="b_tDirectorDetail" class="table table-hover table-striped" style="display:none;">
        <tbody><tr>
            <td class="textbox">Name of Director
                                </td>
            <td>
                                    <input name="ctl00$b$tDirectorName" type="text" maxlength="100" id="b_tDirectorName" class="form-control textbox">
                                    
                                </td>
            <td class="textbox">Relationship
                                </td>
            <td>
                                    <input name="ctl00$b$tDirectorRelationship" type="text" maxlength="100" id="b_tDirectorRelationship" class="form-control textbox" style="width:230px;" >
                                    
                                </td>
        </tr>
    </tbody></table>
                    &nbsp;
                </fieldset>      
</div>
            <br>';
		}
		
           $html .='<div data-val-headertext="Correct the Following Errors:" id="b_v1" class="err" data-valsummary="true" style="display:none;">
            </div>
            <hr>
            <table style="text-align: center; width: 100%;">
                <tbody><tr>
                    <td style="height: 16px; text-align: center" colspan="5">
                        <input type="submit" name="ctl00$b$bSubmit" value="Continue" id="b_bSubmit" class="btn btn-success">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="reset" name="ctl00$b$bReset" value="Reset All Fields" id="b_bReset" class="btn btn-danger">
                    </td>
                </tr>
            </tbody></table>';
           
		
            echo json_encode($html);
		
		
		
	}


   if(isset($_POST['submit_all'])){
        $_SESSION['second_three'] = 'three_stage';
		$user_id     = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

       
		
        //global $wpdb;
		
		$discipline = $wpdb->get_results($wpdb->prepare("SELECT * FROM career_details_int WHERE id = %d", $user_id), OBJECT);
			
		if($discipline[0]->applyed_post_id==1){
			 $x = 9999+$user_id;
			$enrollvalue = "INT2026".$x;
		}
		
		$enrollvalue = sanitize_text_field( $enrollvalue );
		
		 if ( $user_id > 0 ) {

			// Update career_details_int
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE career_details_int
					 SET 
						 career_uniqe_id = %s
					 WHERE id = %d",
					
					$enrollvalue,
					$user_id
				)
			);

			// Update xcareer_audit_int
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE xcareer_audit_int
					 SET status = %d,
						 career_registration_no = %s
					 WHERE career_id = %d",
					2,
					$enrollvalue,
					$user_id
				)
			);
		}
		
		
		
		// Generate a random 12-character password
        $generated_pass = wp_generate_password(12, false, false);

        // Hash password for database storage
        $hashed_password = wp_hash_password($generated_pass);

        $wpdb->query("UPDATE career_details_int SET password='".$hashed_password."' , career_uniqe_id='".$enrollvalue."' WHERE id=".$_SESSION['user_id']."");
		$wpdb->query("UPDATE xcareer_audit_int SET status='2', career_registration_no='".$enrollvalue."' WHERE career_id=".$_SESSION['user_id']."");
		
			
			$email = $discipline[0]->Email;//<-----Put Your email address here.
			
					$body = '<html><body>'; 

				  $body .= '<div>
					<p>Dear '.$discipline[0]->name_of_condidate.', <b>(Registration No.: '.$enrollvalue.'),</b></p>

					
					<p>Your Login information is below.</p>

					Username: '.$discipline[0]->Email.' </br>
					
                    Password: '.$generated_pass.'

					<p><a href="https://recruitment.grid-india.in/loginint/">Click here to login.</a> To get your Application Form.</p>
					
					

					<p>Thank you for the interest shown in pursuing a career with Grid Controller of India Ltd. (Grid-India)<p>

					------------------------------------------------------------------------
					This is a system generated mail. Please do not reply.
					------------------------------------------------------------------------
			';
			$body .= '</body></html>';
				
				
			

			mailercheck($email,$body);  
			$insert_array = array(
								'to_email' => $email,
								'cid' => intval($_SESSION['user_id']),
								'cuid' => $enrollvalue,
								'subject' => '',
								'email_body' => $body,
								'email_status' => '', 
							);
			$table = "career_int_email_log";
			$wpdb->insert($table,$insert_array);
				
			
		echo 1;
		
		
        exit();
		
	// SMS and Mail Code end
    }
	/* Delete work experience */
		if ( isset($_POST['delete_work']) ) {

			$work_id = intval( $_POST['delete_work'] );

			if ( $work_id > 0 ) {
				$wpdb->query(
					$wpdb->prepare(
						"DELETE FROM career_work_int WHERE work_id = %d",
						$work_id
					)
				);
			}

			echo 1;
			exit();
		}

		/* Delete professional experience */
        if ( isset($_POST['project_val']) ) {

            $professional_id = intval( $_POST['project_val'] );

            if ( $professional_id > 0 ) {
                $wpdb->query(
                    $wpdb->prepare(
                        "DELETE FROM career_project_details_int WHERE id = %d",
                        $professional_id
                    )
                );
            }

            echo 1;
            exit();
        }
        if(isset($_POST['description_statement_of_intrest']))
        {
            $career_id          = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            $description_statement_of_intrest = sanitize_text_field( $_POST['description_statement_of_intrest'] );
            if ( $career_id > 0 ) {

                $wpdb->insert(
                    'statement_of_intrest_int',
                    array(
                        'career_id'             => $career_id,
                        'description'  => $description_statement_of_intrest
                    ),
                    array(
                        '%d', '%s'
                    )
                );

                echo "1";
                exit();
            }
        }
        if(isset($_POST['description_intership_contribution']))
        {
            $career_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            $description_intership_contribution = isset($_POST['description_intership_contribution']) ? sanitize_textarea_field(wp_unslash($_POST['description_intership_contribution'])) : '';
            if ( $career_id > 0 ) {

                $wpdb->insert(
                    'internship_countiribution',
                    array(
                        'career_id'             => $career_id,
                        'description'  => $description_intership_contribution
                    ),
                    array(
                        '%d', '%s'
                    )
                );
                echo "1";
                exit();
            }
        }
        
        if(isset($_POST['update_intership_contribution']))
        {
            
            $career_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            $update_intership_contribution = isset($_POST['update_intership_contribution']) ? sanitize_textarea_field(wp_unslash($_POST['update_intership_contribution'])) : '';
            $intership_id = isset($_POST['intership_id']) ? intval($_POST['intership_id']) : 0;
        if ($career_id > 0) {

            global $wpdb;

            $result = $wpdb->update(
                'internship_countiribution',
                array(
                    'description' => $update_intership_contribution
                ),
                array(
                    'id' => $intership_id,
                    'career_id'  => $career_id
                ),
                array('%s'),
                array('%d', '%d')
            );

            if ($result !== false) {
                echo "1";
            } else {
                error_log('Statement Update Error: ' . $wpdb->last_error);
                echo "0";
            }

            exit();

        }
    }
        if(isset($_POST['update_statement_of_intrest']))
        {
            
            $career_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            $description_statement_of_intrest = isset($_POST['update_statement_of_intrest']) ? sanitize_textarea_field(wp_unslash($_POST['update_statement_of_intrest'])) : '';
            $intrest_id = isset($_POST['intrest_id']) ? intval($_POST['intrest_id']) : 0;
        if ($career_id > 0) {

            global $wpdb;

            $result = $wpdb->update(
                'statement_of_intrest_int',
                array(
                    'description' => $description_statement_of_intrest
                ),
                array(
                    'id' => $intrest_id,
                    'career_id'  => $career_id
                ),
                array('%s'),
                array('%d', '%d')
            );

            if ($result !== false) {
                echo "1";
            } else {
                error_log('Statement Update Error: ' . $wpdb->last_error);
                echo "0";
            }

            exit();

        }
    }
		if ( isset($_POST['attr_value_pro']) ) {

			$professional_id = intval( $_POST['attr_value_pro'] );

			if ( $professional_id > 0 ) {
				$wpdb->query(
					$wpdb->prepare(
						"DELETE FROM career_professional_int WHERE professional_id = %d",
						$professional_id
					)
				);
			}

			echo 1;
			exit();
		}
	
		if (isset($_POST['name_of_organization'])) {

    global $wpdb;

    $career_id = isset($_SESSION['user_id'])
        ? intval($_SESSION['user_id'])
        : 0;

    // Safely retrieve and sanitize fields
    $name_of_organization = sanitize_text_field(
        wp_unslash($_POST['name_of_organization'] ?? '')
    );

    

    $basicpay = sanitize_text_field(
        wp_unslash($_POST['basicpay'] ?? '')
    );

    $from = sanitize_text_field(
        wp_unslash($_POST['from'] ?? '')
    );

    $to = sanitize_text_field(
        wp_unslash($_POST['to'] ?? '')
    );

    $responsibility = sanitize_textarea_field(
        wp_unslash($_POST['responsblity'] ?? '')
    );

    $employee_type = sanitize_text_field(
        wp_unslash($_POST['employee_type'] ?? '')
    );

    $employment_type = sanitize_text_field(
        wp_unslash($_POST['emploment_type'] ?? '')
    );

    $industry_type = sanitize_text_field(
        wp_unslash($_POST['industry_type'] ?? '')
    );

    // Validate mandatory fields
    if (
        $career_id <= 0 ||
        empty($name_of_organization)
        
    ) {
        echo "0";
        exit();
    }

    // Insert into database
    $result = $wpdb->insert(
        'career_work_int',
        array(
            'career_id'            => $career_id,
            'name_of_organization' => $name_of_organization,
            
            'basicpay'             => $basicpay,
            'from'                 => $from,
            'to'                   => $to,
            'responsbilty'         => $responsibility,
            'employee_type'        => $employee_type,
            'type_of_emp'          => $employment_type,
            'industrty_type'       => $industry_type
        ),
        array(
            '%d', '%s', '%s', '%s', '%s',
            '%s', '%s', '%s', '%s', '%s'
        )
    );

    if ($result !== false) {
        echo "1";
    } else {
        echo  $wpdb->last_error;
        exit();
        error_log('Work Experience Insert Error: ' . $wpdb->last_error);
        echo "0";
    }

    exit();
}
        if(isset($_POST['faculty_cordinator_update']))
        {
            $faculty_cordinator_update = sanitize_text_field(wp_unslash($_POST['faculty_cordinator_update'] ?? ''));
            $designation_update = sanitize_text_field(wp_unslash($_POST['designation_update'] ?? ''));
            $department_update = sanitize_text_field(wp_unslash($_POST['department_update'] ?? ''));
            $contact_email_update = sanitize_text_field(wp_unslash($_POST['contact_email_update'] ?? ''));
            $contact_number_update = sanitize_text_field(wp_unslash($_POST['contact_number_update'] ?? ''));
            $document_status_update = sanitize_text_field(wp_unslash($_POST['document_status_update'] ?? ''));
            $career_id       = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            $noc_id_update = sanitize_text_field(wp_unslash($_POST['noc_id_update'] ?? ''));
            if ( $career_id > 0 ) {

             $result = $wpdb->update(
        'institute_noc',

        // Fields to update
        array(
            'faculty_cordinator' => $faculty_cordinator_update,
            'designation'        => $designation_update,
            'department'         => $department_update,
            'contact_email'      => $contact_email_update,
            'contact_number'     => $contact_number_update,
            'document_status'    => $document_status_update
        ),

        // WHERE condition
        array(
            'id'    => $noc_id_update,
            'career_id' => $career_id
        ),

        // Data formats
        array(
            '%s', '%s', '%s', '%s', '%s', '%s'
        ),

        // WHERE formats
        array(
            '%d', '%d'
        )
    );
            echo "1";
            exit();
        }
        }
        if(isset($_POST['faculty_cordinator']))
        {
            $faculty_cordinator = sanitize_text_field(wp_unslash($_POST['faculty_cordinator'] ?? ''));
            $designation = sanitize_text_field(wp_unslash($_POST['designation'] ?? ''));
            $department = sanitize_text_field(wp_unslash($_POST['department'] ?? ''));
            $contact_email = sanitize_text_field(wp_unslash($_POST['contact_email'] ?? ''));
            $contact_number = sanitize_text_field(wp_unslash($_POST['contact_number'] ?? ''));
            $document_status = sanitize_text_field(wp_unslash($_POST['document_status'] ?? ''));
            $career_id       = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            if ( $career_id > 0 ) {

            $wpdb->insert(
                'institute_noc',
                array(
                    'career_id'        => $career_id,
                    'faculty_cordinator'      => $faculty_cordinator,
                    'designation'     => $designation,
                    'department'            => $department,
                    'contact_email'            => $contact_email,
                    'contact_number'            => $contact_number,
                    'document_status'            => $document_status,

                ),
                array(
                    '%d', '%s', '%s', '%s','%s','%s','%s'
                )
            );
            echo "1";
            exit();
        }
    }
        if(!empty($_POST['title_paper']))
        {
            $career_id       = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
            $title_paper     = sanitize_text_field( $_POST['title_paper'] );
            $paper_type    = sanitize_text_field( $_POST['paper_type'] );
            $brief_description           = sanitize_text_field( $_POST['brief_description'] );
            if ( $career_id > 0 ) {

            $wpdb->insert(
                'career_project_details_int',
                array(
                    'career_id'        => $career_id,
                    'title'      => $title_paper,
                    'type'     => $paper_type,
                    'brief'            => $brief_description,
                ),
                array(
                    '%d', '%s', '%s', '%s'
                )
            );
            echo "1";
            exit();
        }

        echo "0";
        exit();
        }
		if ( isset( $_POST['exam_passed'] ) ) {

		// Sanitize inputs
		$career_id       = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
		$exam_passed     = sanitize_text_field( $_POST['exam_passed'] );
		$year_passing    = sanitize_text_field( $_POST['year_passing'] );
		$marks           = sanitize_text_field( $_POST['markes'] );
		$marks_percent   = sanitize_text_field( $_POST['marks_percent'] );
		$board_university = sanitize_text_field( $_POST['board_university'] );

		if ( $career_id > 0 ) {

			$wpdb->insert(
				'career_professional_int',
				array(
					'career_id'        => $career_id,
					'degree'      => $exam_passed,
					'institute'     => $year_passing,
					'discipline'            => $marks,
					'pursuning'    => $marks_percent,
					'dateof_complication' => $board_university,
				),
				array(
					'%d', '%s', '%s', '%s', '%s', '%s'
				)
			);
			echo "1";
			exit();
		}

		echo "0";
		exit();
	}
    
?>




