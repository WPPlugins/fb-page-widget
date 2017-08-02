<?php
/*
Plugin Name: Facebook Page Widget
Plugin URI: http://wojtek1150.com/blog/wordpress-fb-page-plugin/
Description: The Page Plugin lets you easily embed and promote any Facebook Page on your website. Just like on Facebook, your visitors can like and share the Page without having to leave your site.
Author: Wojciech Parys
Version: 1.4
Author URI: http://wojtek1150.com/
*/

//actions
add_action( 'admin_menu', 'fpw_add_admin_menu' );
add_action( 'admin_init', 'fpw_settings_init' );

//menu declaration
function fpw_add_admin_menu() {
	add_menu_page( 'FB Page Widget', 'FB Page Widget', 'manage_options', 'facebook_page_widget', 'fpw_options_page', 'dashicons-facebook' );
}

/**
 * create settings page
 */
function fpw_settings_init() {

	register_setting( 'pluginPage', 'fpw_settings' );

	add_settings_section(
		'fpw_pluginPage_section',
		'',
		'',
		'pluginPage'
	);

	add_settings_field(
		'fpw_app_id',
		__( 'APP ID', 'fpw_lang' ),
		'fpw_app_id_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_page_name',
		__( 'Page name', 'fpw_lang' ),
		'fpw_page_name_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_width',
		__( 'Width', 'fpw_lang' ),
		'fpw_width_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_height',
		__( 'Height', 'fpw_lang' ),
		'fpw_height_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_lang',
		__( 'Adjust Language', 'fpw_lang' ),
		'fpw_lang_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_timeline',
		__( 'Timeline tab', 'fpw_lang' ),
		'fpw_tab_timeline_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_events',
		__( 'Events tab', 'fpw_lang' ),
		'fpw_tab_events_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_messages',
		__( 'Messages tab', 'fpw_lang' ),
		'fpw_tab_messages_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_cover',
		__( 'Cover Photo', 'fpw_lang' ),
		'fpw_cover_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_posts',
		__( 'Page Posts', 'fpw_lang' ),
		'fpw_posts_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_friends',
		__( 'Friends Faces', 'fpw_lang' ),
		'fpw_friends_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

	add_settings_field(
		'fpw_position',
		__( 'Widget position', 'fpw_lang' ),
		'fpw_position_render',
		'pluginPage',
		'fpw_pluginPage_section'
	);

}

function fpw_app_id_render() {
	$options = get_option( 'fpw_settings' );
	?>
    <input type='text' class='regular-text' name='fpw_settings[fpw_app_id]'
           value='<?php echo $options['fpw_app_id']; ?>' placeholder='<?php _e( 'Aplication ID', 'fpw_lang' ); ?>'>
    <p class="description" id="tagline-description"><?php _e( 'Leave empty to use my API', 'fpw_lang' ); ?></p>
	<?php
}

function fpw_page_name_render() {
	$options = get_option( 'fpw_settings' );
	?>
    <input type='text' class='regular-text' name='fpw_settings[fpw_page_name]'
           value='<?php echo $options['fpw_page_name']; ?>' placeholder='<?php _e( 'Page id or name', 'fpw_lang' ); ?>'>
    <p class="description" id="tagline-description"><?php _e( 'Default:', 'fpw_lang' ); ?> <strong>facebook</strong></p>
	<?php
}

function fpw_width_render() {
	$options = get_option( 'fpw_settings' );
	?>
    <input type='number' min='180' max='500' class='regular-text' name='fpw_settings[fpw_width]'
           value='<?php echo $options['fpw_width']; ?>'
           placeholder='<?php _e( 'The pixel width of the embed (Min. 180 to Max. 500)', 'fpw_lang' ); ?>'>
    <p class="description" id="tagline-description"><?php _e( 'Default:', 'fpw_lang' ); ?>: <strong>280px</strong></p>
	<?php
}

function fpw_height_render() {
	$options = get_option( 'fpw_settings' );
	?>
    <input type='number' min='70' type='text' class='regular-text' name='fpw_settings[fpw_height]'
           value='<?php echo $options['fpw_height']; ?>'
           placeholder='<?php _e( 'The pixel height of the embed (Min. 70)', 'fpw_lang' ); ?>'>
    <p class="description" id="tagline-description"><?php _e( 'Default:', 'fpw_lang' ); ?>: <strong>280px</strong></p>
	<?php
}

function fpw_lang_render() {
	$options = get_option( 'fpw_settings' );
	?>
    <select name='fpw_settings[fpw_lang]'>
		<?php foreach ( FPW_LANGUAGE_BY_LOCALE as $key => $value ) { ?>
            <option value="<?php echo $key ?>" <?php echo selected( $options['fpw_lang'], $key, false ); ?>><?php echo $value ?></option>
		<?php } ?>
    </select>
    <p class="description" id="tagline-description"><?php _e( 'Default:', 'fpw_lang' ); ?>: <strong>English</strong></p>
	<?php
}

function fpw_cover_render() {
	$options              = get_option( 'fpw_settings' );
	$options['fpw_cover'] = ! empty( $options['fpw_cover'] ) ? 1 : 0;
	?>
    <label for='cover_photo'>
        <input type='checkbox' id='cover_photo'
               name="fpw_settings[fpw_cover]" <?php echo checked( 1, $options['fpw_cover'], false ); ?> value='1'>
        Hide Cover Photo
    </label>
	<?php
}

function fpw_posts_render() {
	$options              = get_option( 'fpw_settings' );
	$options['fpw_posts'] = ! empty( $options['fpw_posts'] ) ? 1 : 0;
	?>
    <label for='page_posts'>
        <input type='checkbox' id='page_posts'
               name="fpw_settings[fpw_posts]" <?php echo checked( 1, $options['fpw_posts'], false ); ?> value='1'>
        Show Page Posts
    </label>
	<?php
}

function fpw_friends_render() {
	$options                = get_option( 'fpw_settings' );
	$options['fpw_friends'] = ! empty( $options['fpw_friends'] ) ? 1 : 0;
	?>
    <label for='faces'>
        <input type='checkbox' id='faces'
               name="fpw_settings[fpw_friends]" <?php echo checked( 1, $options['fpw_friends'], false ); ?> value='1'>
        Show Friends Faces
    </label>
	<?php
}

function fpw_tab_timeline_render() {
	$options                 = get_option( 'fpw_settings' );
	$options['fpw_timeline'] = ! empty( $options['fpw_timeline'] ) ? 1 : 0;
	?>
    <label for='timeline'>
        <input type='checkbox' id='timeline'
               name="fpw_settings[fpw_timeline]" <?php echo checked( 1, $options['fpw_timeline'], false ); ?> value='1'>
        Show timeline tab
    </label>
	<?php
}

function fpw_tab_events_render() {
	$options               = get_option( 'fpw_settings' );
	$options['fpw_events'] = ! empty( $options['fpw_events'] ) ? 1 : 0;
	?>
    <label for='events'>
        <input type='checkbox' id='events'
               name="fpw_settings[fpw_events]" <?php echo checked( 1, $options['fpw_events'], false ); ?> value='1'>
        Show events tab
    </label>
	<?php
}

function fpw_tab_messages_render() {
	$options                 = get_option( 'fpw_settings' );
	$options['fpw_messages'] = ! empty( $options['fpw_messages'] ) ? 1 : 0;
	?>
    <label for='messages'>
        <input type='checkbox' id='messages'
               name="fpw_settings[fpw_messages]" <?php echo checked( 1, $options['fpw_messages'], false ); ?> value='1'>
        Show messages tab
    </label>
	<?php
}

function fpw_position_render() {
	$options = get_option( 'fpw_settings' );
	?>
    <select name='fpw_settings[fpw_position]'>
        <option value='1' <?php selected( $options['fpw_position'], 1 ); ?>>Right center</option>
        <option value='2' <?php selected( $options['fpw_position'], 2 ); ?>>Left center</option>
    </select>
	<?php
}

/**
 * Render settings page
 */
function fpw_options_page() {
	?>
    <form action='options.php' method='post'>
        <h2>Facebook Page Widget settings</h2>
		<?php if ( isset( $_GET['settings-updated'] ) ) { ?>
            <div id="message" class="updated">
                <p><strong><?php _e( 'Settings saved.' ) ?></strong></p>
            </div>
		<?php } ?>
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
    </form>
	<?php
}

/**
 * Render widget in footer
 */
function render_fpw_widget() {
	$options  = get_option( 'fpw_settings' );
	$tabs     = '';
	$position = 'right';

	// APP
	if ( $options['fpw_page_name'] ) {
		$page_name = $options['fpw_page_name'];
	} else {
		$page_name = "facebook";
	}

	// WIDTH
	if ( $options['fpw_width'] ) {
		$widget_width = $options['fpw_width'];
	} else {
		$widget_width = "280";
	}

	// HEIGHT
	if ( $options['fpw_height'] ) {
		$widget_height = $options['fpw_height'];
	} else {
		$widget_height = "280";
	}

	// COVER
	if ( $options['fpw_cover'] ) {
		$cover = "true";
	} else {
		$cover = "false";
	}

	// POSTS WALL
	if ( $options['fpw_posts'] ) {
		$posts = "true";
	} else {
		$posts = "false";
	}

	// FRIENDS FACES
	if ( $options['fpw_friends'] ) {
		$friends = "true";
	} else {
		$friends = "false";
	}

	// TABS
	if ( $options['fpw_timeline'] ) {
		$tabs .= "timeline,";
	}
	if ( $options['fpw_events'] ) {
		$tabs .= "events,";
	}
	if ( $options['fpw_messages'] ) {
		$tabs .= "messages,";
	}

	// POSITION
	if ( $options['fpw_position'] == 2 ) {
		$position = 'left';
	}
	$content = sprintf(
		'<div id="fpw_widget" class="' . $position . '"><div id="fpw_icon"></div><div class="fb-page" '
		. 'data-href="https://www.facebook.com/' . $page_name . '" '
		. 'data-tabs="' . $tabs . '" '
		. 'data-width="' . $widget_width . '" '
		. 'data-height="' . $widget_height . '" '
		. 'data-hide-cover="' . $cover . '" '
		. 'data-show-facepile="' . $friends . '" '
		. 'data-show-posts="' . $posts . '">'
		. '<div class="fb-xfbml-parse-ignore"><blockquote '
		. 'cite="https://www.facebook.com/' . $page_name . '"><a '
		. 'href="https://www.facebook.com/' . $page_name . '">' . $page_name . '</a></blockquote></div></div></div>'
	);
	echo apply_filters( 'show_fpw_widget', $content, $options );
}

add_action( 'wp_footer', 'render_fpw_widget', 1000 );

/**
 * Add facebook js api
 */
function add_fpw_widget_js() {
	$options = get_option( 'fpw_settings' );
	if ( $options['fpw_app_id'] ) {
		$app_id = $options['fpw_app_id'];
	} else {
		$app_id = "936044369739777";
	}
	if ( $options['fpw_lang'] ) {
		$language = $options['fpw_lang'];
	} else {
		$language = "en_GB";
	}
	$js_content = '<div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/%s/sdk.js#xfbml=1&version=v2.3&appId=%s";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, \'script\', \'facebook-jssdk\'));</script>';
	echo sprintf( $js_content, $language, $app_id );
}

add_action( 'wp_head', 'add_fpw_widget_js' );

/**
 * Generate css
 */
function add_fpw_widget_css() {
	$options = get_option( 'fpw_settings' );
	if ( $options['fpw_width'] ) {
		$widget_width = $options['fpw_width'];
	} else {
		$widget_width = "280";
	}
	$content_width = $widget_width + 50;
	echo '<style type="text/css" media="screen">            
                #fpw_widget{
                    position:fixed;
                    top:50%;
                    width: ' . $content_width . 'px;
                    z-index:999;
                    transition: all .4s cubic-bezier(0.65, 0.05, 0.36, 1);           
                    -webkit-transform: translateY(-50%);
                    -moz-transform: translateY(-50%);
                    -ms-transform: translateY(-50%);
                    transform: translateY(-50%);
                }
                #fpw_icon{
                    display:block;
                    width:50px;
                    height:80px;
                    background:#3B5999 url(' . plugins_url() . '/fb-page-widget/fb_icon.png) no-repeat 0 10px;
                    background-size:contain;
                }
                #fpw_widget.right{
                    right: -' . $widget_width . 'px;            
                }
                #fpw_widget.right:hover{
                    right:0;
                }
                #fpw_widget.left{
                    left: -' . $widget_width . 'px;            
                }
                #fpw_widget.left:hover{
                    left:0;
                }
                #fpw_widget.right #fpw_icon{
                    float:left;
                    border-radius:7px 0 0 7px;
                } 
                #fpw_widget.right .fb_iframe_widget{
                    float:right;
                }
                #fpw_widget.left #fpw_icon{
                    float:right;
                    border-radius:0 7px 7px 0;
                } 
                #fpw_widget.left .fb_iframe_widget{
                    float:right;
                }            
            </style>';
}

add_action( 'wp_head', 'add_fpw_widget_css' );

// LANG CODES
CONST FPW_LANGUAGE_BY_LOCALE = [
	'af_NA'       => "Afrikaans (Namibia)",
	'af_ZA'       => "Afrikaans (South Africa)",
	'af'          => "Afrikaans",
	'ak_GH'       => "Akan (Ghana)",
	'ak'          => "Akan",
	'sq_AL'       => "Albanian (Albania)",
	'sq'          => "Albanian",
	'am_ET'       => "Amharic (Ethiopia)",
	'am'          => "Amharic",
	'ar_DZ'       => "Arabic (Algeria)",
	'ar_BH'       => "Arabic (Bahrain)",
	'ar_EG'       => "Arabic (Egypt)",
	'ar_IQ'       => "Arabic (Iraq)",
	'ar_JO'       => "Arabic (Jordan)",
	'ar_KW'       => "Arabic (Kuwait)",
	'ar_LB'       => "Arabic (Lebanon)",
	'ar_LY'       => "Arabic (Libya)",
	'ar_MA'       => "Arabic (Morocco)",
	'ar_OM'       => "Arabic (Oman)",
	'ar_QA'       => "Arabic (Qatar)",
	'ar_SA'       => "Arabic (Saudi Arabia)",
	'ar_SD'       => "Arabic (Sudan)",
	'ar_SY'       => "Arabic (Syria)",
	'ar_TN'       => "Arabic (Tunisia)",
	'ar_AE'       => "Arabic (United Arab Emirates)",
	'ar_YE'       => "Arabic (Yemen)",
	'ar'          => "Arabic",
	'hy_AM'       => "Armenian (Armenia)",
	'hy'          => "Armenian",
	'as_IN'       => "Assamese (India)",
	'as'          => "Assamese",
	'asa_TZ'      => "Asu (Tanzania)",
	'asa'         => "Asu",
	'az_Cyrl'     => "Azerbaijani (Cyrillic)",
	'az_Cyrl_AZ'  => "Azerbaijani (Cyrillic, Azerbaijan)",
	'az_Latn'     => "Azerbaijani (Latin)",
	'az_Latn_AZ'  => "Azerbaijani (Latin, Azerbaijan)",
	'az'          => "Azerbaijani",
	'bm_ML'       => "Bambara (Mali)",
	'bm'          => "Bambara",
	'eu_ES'       => "Basque (Spain)",
	'eu'          => "Basque",
	'be_BY'       => "Belarusian (Belarus)",
	'be'          => "Belarusian",
	'bem_ZM'      => "Bemba (Zambia)",
	'bem'         => "Bemba",
	'bez_TZ'      => "Bena (Tanzania)",
	'bez'         => "Bena",
	'bn_BD'       => "Bengali (Bangladesh)",
	'bn_IN'       => "Bengali (India)",
	'bn'          => "Bengali",
	'bs_BA'       => "Bosnian (Bosnia and Herzegovina)",
	'bs'          => "Bosnian",
	'bg_BG'       => "Bulgarian (Bulgaria)",
	'bg'          => "Bulgarian",
	'my_MM'       => "Burmese (Myanmar [Burma])",
	'my'          => "Burmese",
	'ca_ES'       => "Catalan (Spain)",
	'ca'          => "Catalan",
	'tzm_Latn'    => "Central Morocco Tamazight (Latin)",
	'tzm_Latn_MA' => "Central Morocco Tamazight (Latin, Morocco)",
	'tzm'         => "Central Morocco Tamazight",
	'chr_US'      => "Cherokee (United States)",
	'chr'         => "Cherokee",
	'cgg_UG'      => "Chiga (Uganda)",
	'cgg'         => "Chiga",
	'zh_Hans'     => "Chinese (Simplified Han)",
	'zh_Hans_CN'  => "Chinese (Simplified Han, China)",
	'zh_Hans_HK'  => "Chinese (Simplified Han, Hong Kong SAR China)",
	'zh_Hans_MO'  => "Chinese (Simplified Han, Macau SAR China)",
	'zh_Hans_SG'  => "Chinese (Simplified Han, Singapore)",
	'zh_Hant'     => "Chinese (Traditional Han)",
	'zh_Hant_HK'  => "Chinese (Traditional Han, Hong Kong SAR China)",
	'zh_Hant_MO'  => "Chinese (Traditional Han, Macau SAR China)",
	'zh_Hant_TW'  => "Chinese (Traditional Han, Taiwan)",
	'zh'          => "Chinese",
	'kw_GB'       => "Cornish (United Kingdom)",
	'kw'          => "Cornish",
	'hr_HR'       => "Croatian (Croatia)",
	'hr'          => "Croatian",
	'cs_CZ'       => "Czech (Czech Republic)",
	'cs'          => "Czech",
	'da_DK'       => "Danish (Denmark)",
	'da'          => "Danish",
	'nl_BE'       => "Dutch (Belgium)",
	'nl_NL'       => "Dutch (Netherlands)",
	'nl'          => "Dutch",
	'ebu_KE'      => "Embu (Kenya)",
	'ebu'         => "Embu",
	'en_AS'       => "English (American Samoa)",
	'en_AU'       => "English (Australia)",
	'en_BE'       => "English (Belgium)",
	'en_BZ'       => "English (Belize)",
	'en_BW'       => "English (Botswana)",
	'en_CA'       => "English (Canada)",
	'en_GU'       => "English (Guam)",
	'en_HK'       => "English (Hong Kong SAR China)",
	'en_IN'       => "English (India)",
	'en_IE'       => "English (Ireland)",
	'en_JM'       => "English (Jamaica)",
	'en_MT'       => "English (Malta)",
	'en_MH'       => "English (Marshall Islands)",
	'en_MU'       => "English (Mauritius)",
	'en_NA'       => "English (Namibia)",
	'en_NZ'       => "English (New Zealand)",
	'en_MP'       => "English (Northern Mariana Islands)",
	'en_PK'       => "English (Pakistan)",
	'en_PH'       => "English (Philippines)",
	'en_SG'       => "English (Singapore)",
	'en_ZA'       => "English (South Africa)",
	'en_TT'       => "English (Trinidad and Tobago)",
	'en_UM'       => "English (U.S. Minor Outlying Islands)",
	'en_VI'       => "English (U.S. Virgin Islands)",
	'en_GB'       => "English (United Kingdom)",
	'en_US'       => "English (United States)",
	'en_ZW'       => "English (Zimbabwe)",
	'en'          => "English",
	'eo'          => "Esperanto",
	'et_EE'       => "Estonian (Estonia)",
	'et'          => "Estonian",
	'ee_GH'       => "Ewe (Ghana)",
	'ee_TG'       => "Ewe (Togo)",
	'ee'          => "Ewe",
	'fo_FO'       => "Faroese (Faroe Islands)",
	'fo'          => "Faroese",
	'fil_PH'      => "Filipino (Philippines)",
	'fil'         => "Filipino",
	'fi_FI'       => "Finnish (Finland)",
	'fi'          => "Finnish",
	'fr_BE'       => "French (Belgium)",
	'fr_BJ'       => "French (Benin)",
	'fr_BF'       => "French (Burkina Faso)",
	'fr_BI'       => "French (Burundi)",
	'fr_CM'       => "French (Cameroon)",
	'fr_CA'       => "French (Canada)",
	'fr_CF'       => "French (Central African Republic)",
	'fr_TD'       => "French (Chad)",
	'fr_KM'       => "French (Comoros)",
	'fr_CG'       => "French (Congo - Brazzaville)",
	'fr_CD'       => "French (Congo - Kinshasa)",
	'fr_CI'       => "French (Côte d’Ivoire)",
	'fr_DJ'       => "French (Djibouti)",
	'fr_GQ'       => "French (Equatorial Guinea)",
	'fr_FR'       => "French (France)",
	'fr_GA'       => "French (Gabon)",
	'fr_GP'       => "French (Guadeloupe)",
	'fr_GN'       => "French (Guinea)",
	'fr_LU'       => "French (Luxembourg)",
	'fr_MG'       => "French (Madagascar)",
	'fr_ML'       => "French (Mali)",
	'fr_MQ'       => "French (Martinique)",
	'fr_MC'       => "French (Monaco)",
	'fr_NE'       => "French (Niger)",
	'fr_RW'       => "French (Rwanda)",
	'fr_RE'       => "French (Réunion)",
	'fr_BL'       => "French (Saint Barthélemy)",
	'fr_MF'       => "French (Saint Martin)",
	'fr_SN'       => "French (Senegal)",
	'fr_CH'       => "French (Switzerland)",
	'fr_TG'       => "French (Togo)",
	'fr'          => "French",
	'ff_SN'       => "Fulah (Senegal)",
	'ff'          => "Fulah",
	'gl_ES'       => "Galician (Spain)",
	'gl'          => "Galician",
	'lg_UG'       => "Ganda (Uganda)",
	'lg'          => "Ganda",
	'ka_GE'       => "Georgian (Georgia)",
	'ka'          => "Georgian",
	'de_AT'       => "German (Austria)",
	'de_BE'       => "German (Belgium)",
	'de_DE'       => "German (Germany)",
	'de_LI'       => "German (Liechtenstein)",
	'de_LU'       => "German (Luxembourg)",
	'de_CH'       => "German (Switzerland)",
	'de'          => "German",
	'el_CY'       => "Greek (Cyprus)",
	'el_GR'       => "Greek (Greece)",
	'el'          => "Greek",
	'gu_IN'       => "Gujarati (India)",
	'gu'          => "Gujarati",
	'guz_KE'      => "Gusii (Kenya)",
	'guz'         => "Gusii",
	'ha_Latn'     => "Hausa (Latin)",
	'ha_Latn_GH'  => "Hausa (Latin, Ghana)",
	'ha_Latn_NE'  => "Hausa (Latin, Niger)",
	'ha_Latn_NG'  => "Hausa (Latin, Nigeria)",
	'ha'          => "Hausa",
	'haw_US'      => "Hawaiian (United States)",
	'haw'         => "Hawaiian",
	'he_IL'       => "Hebrew (Israel)",
	'he'          => "Hebrew",
	'hi_IN'       => "Hindi (India)",
	'hi'          => "Hindi",
	'hu_HU'       => "Hungarian (Hungary)",
	'hu'          => "Hungarian",
	'is_IS'       => "Icelandic (Iceland)",
	'is'          => "Icelandic",
	'ig_NG'       => "Igbo (Nigeria)",
	'ig'          => "Igbo",
	'id_ID'       => "Indonesian (Indonesia)",
	'id'          => "Indonesian",
	'ga_IE'       => "Irish (Ireland)",
	'ga'          => "Irish",
	'it_IT'       => "Italian (Italy)",
	'it_CH'       => "Italian (Switzerland)",
	'it'          => "Italian",
	'ja_JP'       => "Japanese (Japan)",
	'ja'          => "Japanese",
	'kea_CV'      => "Kabuverdianu (Cape Verde)",
	'kea'         => "Kabuverdianu",
	'kab_DZ'      => "Kabyle (Algeria)",
	'kab'         => "Kabyle",
	'kl_GL'       => "Kalaallisut (Greenland)",
	'kl'          => "Kalaallisut",
	'kln_KE'      => "Kalenjin (Kenya)",
	'kln'         => "Kalenjin",
	'kam_KE'      => "Kamba (Kenya)",
	'kam'         => "Kamba",
	'kn_IN'       => "Kannada (India)",
	'kn'          => "Kannada",
	'kk_Cyrl'     => "Kazakh (Cyrillic)",
	'kk_Cyrl_KZ'  => "Kazakh (Cyrillic, Kazakhstan)",
	'kk'          => "Kazakh",
	'km_KH'       => "Khmer (Cambodia)",
	'km'          => "Khmer",
	'ki_KE'       => "Kikuyu (Kenya)",
	'ki'          => "Kikuyu",
	'rw_RW'       => "Kinyarwanda (Rwanda)",
	'rw'          => "Kinyarwanda",
	'kok_IN'      => "Konkani (India)",
	'kok'         => "Konkani",
	'ko_KR'       => "Korean (South Korea)",
	'ko'          => "Korean",
	'khq_ML'      => "Koyra Chiini (Mali)",
	'khq'         => "Koyra Chiini",
	'ses_ML'      => "Koyraboro Senni (Mali)",
	'ses'         => "Koyraboro Senni",
	'lag_TZ'      => "Langi (Tanzania)",
	'lag'         => "Langi",
	'lv_LV'       => "Latvian (Latvia)",
	'lv'          => "Latvian",
	'lt_LT'       => "Lithuanian (Lithuania)",
	'lt'          => "Lithuanian",
	'luo_KE'      => "Luo (Kenya)",
	'luo'         => "Luo",
	'luy_KE'      => "Luyia (Kenya)",
	'luy'         => "Luyia",
	'mk_MK'       => "Macedonian (Macedonia)",
	'mk'          => "Macedonian",
	'jmc_TZ'      => "Machame (Tanzania)",
	'jmc'         => "Machame",
	'kde_TZ'      => "Makonde (Tanzania)",
	'kde'         => "Makonde",
	'mg_MG'       => "Malagasy (Madagascar)",
	'mg'          => "Malagasy",
	'ms_BN'       => "Malay (Brunei)",
	'ms_MY'       => "Malay (Malaysia)",
	'ms'          => "Malay",
	'ml_IN'       => "Malayalam (India)",
	'ml'          => "Malayalam",
	'mt_MT'       => "Maltese (Malta)",
	'mt'          => "Maltese",
	'gv_GB'       => "Manx (United Kingdom)",
	'gv'          => "Manx",
	'mr_IN'       => "Marathi (India)",
	'mr'          => "Marathi",
	'mas_KE'      => "Masai (Kenya)",
	'mas_TZ'      => "Masai (Tanzania)",
	'mas'         => "Masai",
	'mer_KE'      => "Meru (Kenya)",
	'mer'         => "Meru",
	'mfe_MU'      => "Morisyen (Mauritius)",
	'mfe'         => "Morisyen",
	'naq_NA'      => "Nama (Namibia)",
	'naq'         => "Nama",
	'ne_IN'       => "Nepali (India)",
	'ne_NP'       => "Nepali (Nepal)",
	'ne'          => "Nepali",
	'nd_ZW'       => "North Ndebele (Zimbabwe)",
	'nd'          => "North Ndebele",
	'nb_NO'       => "Norwegian Bokmål (Norway)",
	'nb'          => "Norwegian Bokmål",
	'nn_NO'       => "Norwegian Nynorsk (Norway)",
	'nn'          => "Norwegian Nynorsk",
	'nyn_UG'      => "Nyankole (Uganda)",
	'nyn'         => "Nyankole",
	'or_IN'       => "Oriya (India)",
	'or'          => "Oriya",
	'om_ET'       => "Oromo (Ethiopia)",
	'om_KE'       => "Oromo (Kenya)",
	'om'          => "Oromo",
	'ps_AF'       => "Pashto (Afghanistan)",
	'ps'          => "Pashto",
	'fa_AF'       => "Persian (Afghanistan)",
	'fa_IR'       => "Persian (Iran)",
	'fa'          => "Persian",
	'pl_PL'       => "Polish (Poland)",
	'pl'          => "Polish",
	'pt_BR'       => "Portuguese (Brazil)",
	'pt_GW'       => "Portuguese (Guinea-Bissau)",
	'pt_MZ'       => "Portuguese (Mozambique)",
	'pt_PT'       => "Portuguese (Portugal)",
	'pt'          => "Portuguese",
	'pa_Arab'     => "Punjabi (Arabic)",
	'pa_Arab_PK'  => "Punjabi (Arabic, Pakistan)",
	'pa_Guru'     => "Punjabi (Gurmukhi)",
	'pa_Guru_IN'  => "Punjabi (Gurmukhi, India)",
	'pa'          => "Punjabi",
	'ro_MD'       => "Romanian (Moldova)",
	'ro_RO'       => "Romanian (Romania)",
	'ro'          => "Romanian",
	'rm_CH'       => "Romansh (Switzerland)",
	'rm'          => "Romansh",
	'rof_TZ'      => "Rombo (Tanzania)",
	'rof'         => "Rombo",
	'ru_MD'       => "Russian (Moldova)",
	'ru_RU'       => "Russian (Russia)",
	'ru_UA'       => "Russian (Ukraine)",
	'ru'          => "Russian",
	'rwk_TZ'      => "Rwa (Tanzania)",
	'rwk'         => "Rwa",
	'saq_KE'      => "Samburu (Kenya)",
	'saq'         => "Samburu",
	'sg_CF'       => "Sango (Central African Republic)",
	'sg'          => "Sango",
	'seh_MZ'      => "Sena (Mozambique)",
	'seh'         => "Sena",
	'sr_Cyrl'     => "Serbian (Cyrillic)",
	'sr_Cyrl_BA'  => "Serbian (Cyrillic, Bosnia and Herzegovina)",
	'sr_Cyrl_ME'  => "Serbian (Cyrillic, Montenegro)",
	'sr_Cyrl_RS'  => "Serbian (Cyrillic, Serbia)",
	'sr_Latn'     => "Serbian (Latin)",
	'sr_Latn_BA'  => "Serbian (Latin, Bosnia and Herzegovina)",
	'sr_Latn_ME'  => "Serbian (Latin, Montenegro)",
	'sr_Latn_RS'  => "Serbian (Latin, Serbia)",
	'sr'          => "Serbian",
	'sn_ZW'       => "Shona (Zimbabwe)",
	'sn'          => "Shona",
	'ii_CN'       => "Sichuan Yi (China)",
	'ii'          => "Sichuan Yi",
	'si_LK'       => "Sinhala (Sri Lanka)",
	'si'          => "Sinhala",
	'sk_SK'       => "Slovak (Slovakia)",
	'sk'          => "Slovak",
	'sl_SI'       => "Slovenian (Slovenia)",
	'sl'          => "Slovenian",
	'xog_UG'      => "Soga (Uganda)",
	'xog'         => "Soga",
	'so_DJ'       => "Somali (Djibouti)",
	'so_ET'       => "Somali (Ethiopia)",
	'so_KE'       => "Somali (Kenya)",
	'so_SO'       => "Somali (Somalia)",
	'so'          => "Somali",
	'es_AR'       => "Spanish (Argentina)",
	'es_BO'       => "Spanish (Bolivia)",
	'es_CL'       => "Spanish (Chile)",
	'es_CO'       => "Spanish (Colombia)",
	'es_CR'       => "Spanish (Costa Rica)",
	'es_DO'       => "Spanish (Dominican Republic)",
	'es_EC'       => "Spanish (Ecuador)",
	'es_SV'       => "Spanish (El Salvador)",
	'es_GQ'       => "Spanish (Equatorial Guinea)",
	'es_GT'       => "Spanish (Guatemala)",
	'es_HN'       => "Spanish (Honduras)",
	'es_419'      => "Spanish (Latin America)",
	'es_MX'       => "Spanish (Mexico)",
	'es_NI'       => "Spanish (Nicaragua)",
	'es_PA'       => "Spanish (Panama)",
	'es_PY'       => "Spanish (Paraguay)",
	'es_PE'       => "Spanish (Peru)",
	'es_PR'       => "Spanish (Puerto Rico)",
	'es_ES'       => "Spanish (Spain)",
	'es_US'       => "Spanish (United States)",
	'es_UY'       => "Spanish (Uruguay)",
	'es_VE'       => "Spanish (Venezuela)",
	'es'          => "Spanish",
	'sw_KE'       => "Swahili (Kenya)",
	'sw_TZ'       => "Swahili (Tanzania)",
	'sw'          => "Swahili",
	'sv_FI'       => "Swedish (Finland)",
	'sv_SE'       => "Swedish (Sweden)",
	'sv'          => "Swedish",
	'gsw_CH'      => "Swiss German (Switzerland)",
	'gsw'         => "Swiss German",
	'shi_Latn'    => "Tachelhit (Latin)",
	'shi_Latn_MA' => "Tachelhit (Latin, Morocco)",
	'shi_Tfng'    => "Tachelhit (Tifinagh)",
	'shi_Tfng_MA' => "Tachelhit (Tifinagh, Morocco)",
	'shi'         => "Tachelhit",
	'dav_KE'      => "Taita (Kenya)",
	'dav'         => "Taita",
	'ta_IN'       => "Tamil (India)",
	'ta_LK'       => "Tamil (Sri Lanka)",
	'ta'          => "Tamil",
	'te_IN'       => "Telugu (India)",
	'te'          => "Telugu",
	'teo_KE'      => "Teso (Kenya)",
	'teo_UG'      => "Teso (Uganda)",
	'teo'         => "Teso",
	'th_TH'       => "Thai (Thailand)",
	'th'          => "Thai",
	'bo_CN'       => "Tibetan (China)",
	'bo_IN'       => "Tibetan (India)",
	'bo'          => "Tibetan",
	'ti_ER'       => "Tigrinya (Eritrea)",
	'ti_ET'       => "Tigrinya (Ethiopia)",
	'ti'          => "Tigrinya",
	'to_TO'       => "Tonga (Tonga)",
	'to'          => "Tonga",
	'tr_TR'       => "Turkish (Turkey)",
	'tr'          => "Turkish",
	'uk_UA'       => "Ukrainian (Ukraine)",
	'uk'          => "Ukrainian",
	'ur_IN'       => "Urdu (India)",
	'ur_PK'       => "Urdu (Pakistan)",
	'ur'          => "Urdu",
	'uz_Arab'     => "Uzbek (Arabic)",
	'uz_Arab_AF'  => "Uzbek (Arabic, Afghanistan)",
	'uz_Cyrl'     => "Uzbek (Cyrillic)",
	'uz_Cyrl_UZ'  => "Uzbek (Cyrillic, Uzbekistan)",
	'uz_Latn'     => "Uzbek (Latin)",
	'uz_Latn_UZ'  => "Uzbek (Latin, Uzbekistan)",
	'uz'          => "Uzbek",
	'vi_VN'       => "Vietnamese (Vietnam)",
	'vi'          => "Vietnamese",
	'vun_TZ'      => "Vunjo (Tanzania)",
	'vun'         => "Vunjo",
	'cy_GB'       => "Welsh (United Kingdom)",
	'cy'          => "Welsh",
	'yo_NG'       => "Yoruba (Nigeria)",
	'yo'          => "Yoruba",
	'zu_ZA'       => "Zulu (South Africa)",
	'zu'          => "Zulu"
]
?>