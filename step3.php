<?php
global $wpdb;
 
require_once get_template_directory() . '/functions.php';

// Start WAF Protection
custom_waf_protection();
 

// Redirect if user_id is not set or empty
if (empty($_SESSION['user_id']) || !is_numeric($_SESSION['user_id'])) {
    header("Location: https://recruitment.grid-india.in/loginint/");
    exit;
}

// Fetch the unique career ID securely using prepared statements
$user_id = intval($_SESSION['user_id']);
$products3 = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT career_uniqe_id FROM career_details_int WHERE id = %d",
        $user_id
    ),
    OBJECT
);

// Sanitize the career unique ID for output
$career_unique_id = !empty($products3[0]->career_uniqe_id) ? esc_html($products3[0]->career_uniqe_id) : 'N/A';
?>
<style>
.page-header{display:none;}
</style>
<div id="b_ctl00">
     <div style="width: 100%"> <img src="<?php echo site_url();?>/wp-content/plugins/careers/images/banner.jpg" alt="GRID-INDIA Recruitment"></div>
</div>
<div class="container alert" style="padding: 12px; text-align: justify; font-size: 14px; padding-bottom: 15px;">
    <ul>
        <li><strong>Application filled successfully.</strong></li>
        <li><strong>Your registration ID is <?php echo $career_unique_id; ?>.</strong></li>
        <li><strong>Kindly check your registered email for candidate login details.</strong></li>
        <li><strong>You can also login by <a href="<?php echo esc_url(site_url('/loginint/')); ?>" target="_blank">clicking here</a>.</strong></li>
        <li><strong><a href="<?php echo esc_url(site_url('/wp-content/plugins/internship/details.php')); ?>">Click here to Download your Application</a></strong></li>
    </ul>
</div>

<?php 
// Conditional application fee message
if (false && !empty($_SESSION['cast_category']) && !empty($_SESSION['pwd_details']) &&
    in_array($_SESSION['cast_category'], ['GENERAL', 'OBC(NCL)', 'EWS'], true) &&
    $_SESSION['pwd_details'] === 'NO') :
?>
    <p>
        Application Fee ₹500/- Please click below link for payment.<br/>
        <a href="https://www.onlinesbi.com/sbicollect/icollecthome.htm?corpID=893411" target="_blank">
            Click here to pay
        </a> 
        Kindly login and submit your payment details against your registration ID.
    </p>
<?php endif; ?>

<!-- jQuery Validation & UI -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
jQuery(document).ready(function($) {
    // Disable right-click
    $(document).on("contextmenu", function(e) {
        return false;
    });
});
</script>
