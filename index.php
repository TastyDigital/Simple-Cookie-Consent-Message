<?php
/* 
Plugin Name: Simple Cookie Consent Message
Plugin URI: https://github.com/TastyDigital/Simple-Cookie-Consent-Message
Description: This is a small plugin which adds a banner to the page for each visitor. This plugin is used for implied consent, which means that if the guest continues using the site they agree to cookie use!
Author: Tasty Digital
Version: 1.0
Author URI: https://tastydigital.com/
*/

// Tell WordPress we need jQuery loaded
function SCCM_enqueueScripts()  
{  
    $setting_value = get_option('SCCM');
	if (isset($setting_value['chkJquery']) && ($setting_value['chkJquery'] == 1))
	{
		wp_enqueue_script('jquery');  
	}
} 
add_action('wp_enqueue_scripts', 'SCCM_enqueueScripts'); 


// Output the message to the page footer
function SCCM_cookieMessage()
{
	// Get the settings
	$setting_value = get_option('SCCM');
	
	// Split and parse the settings array
	$title = str_replace("'", "\'", __($setting_value['notificationTitle'], 'SCCM'));
	$message = str_replace("'", "\'", __($setting_value['notificationMessage'], 'SCCM'));
	$message = str_replace("\n", "<br/>", $message);
	$message = str_replace("\r", "", $message);
	$close = str_replace("'", "\'", __($setting_value['notificationClose'], 'SCCM'));
	$padding = $setting_value['notificationPadding'];
	$style = $setting_value['notificationStyle'];
	$maxWidth = $setting_value['notificationMaxWidth'];

	
	if (isset($setting_value['chkDebug']) && $setting_value['chkDebug'] == 'on')
	{
		$debug = true;
	}
	else
	{
		$debug = false;
	}

	
	if ($style == 'dark')
	{
		$backgroundColour = '0,0,0';
		$backgroundTransparency = '0.8';
		$titleColour = '#ffffff';
		$titleSize = '1.6em';
		$titleFont = 'ariel,sans-serif';
		$messageColour = '#BEBEBE';
		$messageSize = '1em';
		$messageFont = 'ariel,sans-serif';
		$closeColour = '#ffffff';
		$closeSize = '1.25em';
		$closeFont = 'ariel,sans-serif';
	}
	else if ($style == 'light')
	{
		$backgroundColour = '255,255,255';
		$backgroundTransparency = '0.8';
		$titleColour = '#000000';
		$titleSize = '1.6em';
		$titleFont = 'ariel,sans-serif';
		$messageColour = '#444444';
		$messageSize = '1em';
		$messageFont = 'ariel,sans-serif';
		$closeColour = '#000000';
		$closeSize = '1.25em';
		$closeFont = 'ariel,sans-serif';
	}
	else
	{
		$backgroundColour = SCCM_hex2rgb($setting_value['backgroundColour']);
		$backgroundTransparency = $setting_value['backgroundTransparency'];
		$titleColour = $setting_value['titleColour'];
		$titleSize = $setting_value['titleSize'];
		$titleFont = $setting_value['titleFont'];
		$messageColour = $setting_value['messageColour'];
		$messageSize = $setting_value['messageSize'];
		$messageFont = $setting_value['messageFont'];
		$closeColour = $setting_value['closeColour'];
		$closeSize = $setting_value['closeSize'];
		$closeFont = $setting_value['closeFont'];
	}

	$localizeVars = array(
		'rightContext' 				=> $debug && current_user_can('administrator') ? 1 : 0,
		'title'						=> $title,
		'message'					=> $message,
		'closeMsg'					=> $close,
		'backgroundColour' 			=> $backgroundColour,
		'backgroundTransparency'	=> $backgroundTransparency,
		'padding'					=> $padding,
		'titleColour'				=> $titleColour,
		'titleFont'					=> $titleFont,
		'titleSize'					=> $titleSize,
		'messageColour'				=> $messageColour,
		'messageFont'				=> $messageFont,
		'messageSize'				=> $messageSize,
		'closeColour'				=> $closeColour,
		'closeFont'					=> $closeFont,
		'closeSize'					=> $closeSize,
		'maxWidth'					=> $maxWidth
	);

	wp_enqueue_script('sccm-script', plugin_dir_url( __FILE__ ) . 'js/sccm.js', array('jquery'));
	wp_localize_script('sccm-script', 'phpVars', $localizeVars);	
	
	
	// 	The actual code sent to the browser
?>

<?php
}
add_action('wp_footer', 'SCCM_cookieMessage'); 


// Create the admin menu
function SCCM_createMenu() 
{
	add_submenu_page('options-general.php', __('Simple Cookie Message', 'SCCM'), __('Simple Cookie Message', 'SCCM'), 'administrator', 'SCCM_settings', 'SCCM_settingsPage');
	add_action('admin_init', 'SCCM_registerSettings');
}
add_action('admin_menu', 'SCCM_createMenu');

// Output the admin option page
function SCCM_settingsPage() 
{
?>
<div class="wrap">
<h2><?php _e('Simple Implied Cookie Consent Message', 'SCCM'); ?></h2>
<form method="post" action="options.php">
    <?php settings_fields('SCCM'); ?>
    <?php do_settings_sections('SCCM_settings'); ?>
</form>
</div>
<?php 
}

// Tell WordPress what settings we are going to be using
function SCCM_registerSettings() 
{
	register_setting('SCCM', 'SCCM');
	
	add_settings_section('SCCM_main', 'Main Settings', 'SCCM_main_text', 'SCCM_settings');
	add_settings_field('notificationTitle', 'Notification Title', 'SCCM_notificationTitle', 'SCCM_settings', 'SCCM_main');
	add_settings_field('notificationMessage', 'Message', 'SCCM_notificationMessage', 'SCCM_settings', 'SCCM_main');
	add_settings_field('notificationClose', 'Close Link Text', 'SCCM_notificationClose', 'SCCM_settings', 'SCCM_main');
	add_settings_field('notificationPadding', 'Content Padding', 'SCCM_notificationPadding', 'SCCM_settings', 'SCCM_main');
	add_settings_field('notificationMaxWidth', 'Message Maximum Width', 'SCCM_notificationMaxWidth', 'SCCM_settings', 'SCCM_main');
	add_settings_field('notificationStyle', 'Visual Style', 'SCCM_notificationStyle', 'SCCM_settings', 'SCCM_main');
	add_settings_field('chkJquery', 'Enqueue jQuery', 'SCCM_chkJquery', 'SCCM_settings', 'SCCM_main');
	add_settings_field('chkDebug', 'Debug Mode', 'SCCM_chkDebug', 'SCCM_settings', 'SCCM_main');
	add_settings_field('chkReset', 'Reset Options', 'SCCM_chkReset', 'SCCM_settings', 'SCCM_main');
	add_settings_field('submit', '', 'SCCM_Submit', 'SCCM_settings', 'SCCM_main');
	
	add_settings_section('SCCM_custom', 'Custom Styles (advanced)', 'SCCM_custom_text', 'SCCM_settings');
	add_settings_field('backgroundColour', 'Message Background Colour', 'SCCM_backgroundColour', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('backgroundTransparency', 'Message Transparency', 'SCCM_backgroundTransparency', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('titleColour', 'Title Heading Colour', 'SCCM_titleColour', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('titleSize', 'Title Heading Font Size', 'SCCM_titleSize', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('titleFont', 'Title Heading Font Family', 'SCCM_titleFont', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('messageColour', 'Message Colour', 'SCCM_messageColour', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('messageSize', 'Message Font Size', 'SCCM_messageSize', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('messageFont', 'Message Font Family', 'SCCM_messageFont', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('closeColour', 'Close Link Colour', 'SCCM_closeColour', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('closeSize', 'Close Link Font Size', 'SCCM_closeSize', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('closeFont', 'Close Link Font Family', 'SCCM_closeFont', 'SCCM_settings', 'SCCM_custom');
	add_settings_field('submit', '', 'SCCM_Submit', 'SCCM_settings', 'SCCM_custom');
}

// Callback function to output forms
function SCCM_main_text() {
?><p><?php _e('Change the settings below to alter how the Cookie message will be shown. You can select the light theme, the dark theme or create your own by selecting custom.');?></p><?php
}

function SCCM_custom_text() {
?><p><?php _e('If you set the Visual Style to custom, you can use these options to customise the Cookie Message styles.');?></p><?php
}

function SCCM_Submit() {
	submit_button();
}

function SCCM_notificationTitle() {
$setting_value = get_option('SCCM');
$setting_value = esc_textarea($setting_value['notificationTitle']);
?><input type="text" name="SCCM[notificationTitle]" value="<?php echo $setting_value; ?>" class="regular-text"/><?php
}
function SCCM_notificationMessage() {
$setting_value = get_option('SCCM');
$setting_value = esc_textarea($setting_value['notificationMessage']);
?><textarea name="SCCM[notificationMessage]" class="large-text" rows="6"><?php echo $setting_value; ?></textarea><?php
}
function SCCM_notificationClose() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['notificationClose']);
?><input type="text" name="SCCM[notificationClose]" value="<?php echo $setting_value; ?>" class="regular-text"/><?php
}
function SCCM_notificationPadding() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['notificationPadding']);
?><input type="text" name="SCCM[notificationPadding]" value="<?php echo $setting_value; ?>" class="regular-text"/><?php
}
function SCCM_notificationMaxWidth() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['notificationMaxWidth']);
?><input type="text" name="SCCM[notificationMaxWidth]" value="<?php echo $setting_value; ?>" class="regular-text"/><?php
}
function SCCM_notificationStyle() {
$setting_value = get_option('SCCM');
$setting_value = $setting_value['notificationStyle'];
?><select name="SCCM[notificationStyle]"><option value="dark" <?php if ($setting_value == 'dark') echo ' selected';?>>Dark - Black Background, White Text</option><option value="light"<?php if ($setting_value == 'light') echo ' selected';?>>Light - White Background, Dark Grey Text</option><option value="custom"<?php if ($setting_value == 'custom') echo ' selected';?>>Custom - Enter Your Own Values Below</option></select>
<?php
}
function SCCM_chkReset() {
$setting_value = get_option('SCCM');
if (isset($setting_value['chkReset'])) $setting_value = $setting_value['chkReset']; else $setting_value = '';
if($setting_value) { $checked = ' checked="checked" '; } else { $checked = ''; }
?><input type='checkbox' name='SCCM[chkReset]' <?php echo $checked; ?> id="chkReset" /> <label for='chkReset'> Tick this and click save changes to reset back to default.</label><?php
}
function SCCM_chkDebug() { 
$setting_value = get_option('SCCM');
if (isset($setting_value['chkDebug'])) $setting_value = $setting_value['chkDebug']; else $setting_value = '';
if($setting_value) { $checked = ' checked="checked" '; } else { $checked = ''; }
?><input type='checkbox' name='SCCM[chkDebug]' <?php echo $checked; ?> id="chkDebug" /> <label for='chkDebug'> If enabled the cookie will not be set, so as an Administrator you can reload the page many times and still view the message!</label><?php
}
function SCCM_chkJquery() { 
$setting_value = get_option('SCCM');
if (isset($setting_value['chkJquery'])) $setting_value = $setting_value['chkJquery']; else $setting_value = '';
if($setting_value) { $checked = ' checked="checked" '; } else { $checked = ''; }
?><input type='checkbox' name='SCCM[chkJquery]' <?php echo $checked; ?> id="chkJquery" /> <label for='chkJquery'> If enabled the plugin will enqueue jQuery. If disabled, the plugin will not attempt to load jQuery so you must ensure that your theme includes jQuery. If in doubt leave checked.</label><?php
}




function SCCM_backgroundColour() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['backgroundColour']);
?>
<input type="text" name="SCCM[backgroundColour]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Hexadecimal colour code to use for the background of the message bar.</small><?php
}
function SCCM_backgroundTransparency() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['backgroundTransparency']);
?><input type="text" name="SCCM[backgroundTransparency]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Enter the transparency for the message background. 0 is invisible and 1 is solid colour. Default is 0.8.</small><?php
}
function SCCM_titleColour() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['titleColour']);
?><input type="text" name="SCCM[titleColour]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Hexadecimal colour code to use for the message title.</small><?php
}
function SCCM_titleSize() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['titleSize']);
?><input type="text" name="SCCM[titleSize]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Font size for the message title. Can be in pixels (px), ems (em), points (pt) or percent (%).</small><?php
}
function SCCM_titleFont() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['titleFont']);
?><input type="text" name="SCCM[titleFont]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>The HTML font family to use for the message title. You can use any valid font-family declarations.</small><?php
}
function SCCM_messageColour() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['messageColour']);
?><input type="text" name="SCCM[messageColour]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Hexadecimal colour code to use for the message body text.</small><?php
}
function SCCM_messageSize() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['messageSize']);
?><input type="text" name="SCCM[messageSize]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Font size for the message body text.</small><?php
}
function SCCM_messageFont() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['messageFont']);
?><input type="text" name="SCCM[messageFont]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>The HTML font family to use for the message title.</small><?php
}
function SCCM_closeColour() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['closeColour']);
?><input type="text" name="SCCM[closeColour]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Hexadecimal colour code to use for the close message link.</small><?php
}
function SCCM_closeSize() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['closeSize']);
?><input type="text" name="SCCM[closeSize]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>Font size for the close message link.</small><?php
}
function SCCM_closeFont() {
$setting_value = get_option('SCCM');
$setting_value = esc_attr($setting_value['closeFont']);
?><input type="text" name="SCCM[closeFont]" value="<?php echo $setting_value; ?>" class="regular-text"/><br/>
<small>The HTML font family to use for the close message link.</small>
</div><?php
}





// Configure the defaults and option resets
function SCCM_defaults() 
{
	$tmp = get_option('SCCM');
    if ((!is_array($tmp)) || ((isset($tmp['chkReset'])) && ($tmp['chkReset'] =='on')))
	{
		$arr = array(
			'notificationTitle' => 'Cookies on this website',
			'notificationMessage' => 'We use cookies to ensure that we give you the best experience on our website. If you continue without changing your settings, we’ll assume that you are happy to receive all cookies from this website. If you would like to change your preferences you may do so by following the instructions <a href="http://www.aboutcookies.org/Default.aspx?page=1" rel="nofollow">here</a>.',
			'notificationClose' => 'I accept',
			'notificationPadding' => '20px',
			'notificationStyle' => 'dark',
			'notificationMaxWidth' => '980px',
			'chkReset' => '',
			'chkDebug' => '',
			'chkJquery' => '1',
			'backgroundColour' => '#000000',
			'backgroundTransparency' => '0.8',
			'titleColour' => '#ffffff',
			'titleSize' => '1.6em',
			'titleFont' => 'ariel,sans-serif',
			'messageColour' => '#BEBEBE',
			'messageSize' => '1em',
			'messageFont' => 'ariel,sans-serif',
			'closeColour' => '#ffffff',
			'closeSize' => '1.25em',
			'closeFont' => 'ariel,sans-serif',
		);
		update_option('SCCM', $arr);
	}
}
add_action('admin_init','SCCM_defaults');

// Utility function to convert hex colour code to RGB
// Credit: http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
function SCCM_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}


?>