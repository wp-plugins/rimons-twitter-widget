<?php
/* Plugin Name: Rimons Twitter Widget
 * Plugin URI: http://rimonhabib.com
 * Description: This plugin allow you to grab your tweets from twitter and show your theme's sidebar as widget. You can customize   color schemes and size to fit it to your sidebar.after installing, See the <a href="/wp-admin/widgets.php">Widget page</a> to configure twitter widget
 * Version: 1.2.5
 * Author: Rimon Habib
 * Author URI: http://rimonhabib.com
 *
 */
define('RTW_VERSION','1.2.5');
define('RTW_ROOT',dirname(__FILE__).'/');
define('RTW_INC',BNCF_ROOT.'include/');
define('RTW_LIB',BNCF_ROOT.'lib/');
define('RTW_SKIN',BNCF_ROOT.'skins/');
define('RTW_DIR',basename(dirname(__FILE__)));

define('RTW_CSS_URL',  trailingslashit(plugins_url('/css/', __FILE__) ));
define('RTW_IMG_URL',  trailingslashit(plugins_url('/images/', __FILE__) ));

//////////////////////////////////////////////////////////////////////////////

register_activation_hook( __FILE__,'rtw_activate');
register_deactivation_hook( __FILE__,'rtw_deactivate');

/////////////////////////////////////////////////////////////////////////////////////////

function rtw_activate(){
    update_option('rtw_admin_notice','TRUE');
}

/////////////////////////////////////////////////////////////////////////////////////////

function rtw_deactivate(){ }

//////////////////////////////////////////////////////////////////////////////

function rtw_activation_notice(){
    echo    '<div class="updated" style="background-color: #53be2a; border-color:#199b57">
            <p>Thank you for installing <strong>Rimons Twitter Widget</strong>.Configure your twitter API from <a href="'.site_url().'/wp-admin/admin.php?page=rimons_twitter_widget">here</a>. See the <a href="'.site_url().'/wp-admin/widgets.php">Widget page</a> to configure twitter widget.</p>
            </div>';
}

//////////////////////////////////////////////////////////////////////////////

function rtw_register_admin_menu_page(){
    add_menu_page( 'Rimons Twitter Widget', 'Rimons Twitter Widget', 'manage_options', 'rimons_twitter_widget', 'rtw_admin_menu_page' ); 
}
add_action( 'admin_menu', 'rtw_register_admin_menu_page' );

//////////////////////////////////////////////////////////////////////////////

function rtw_admin_menu_page(){
    $rtw = get_option('rtw_settings',true);
    $rtw_config = $rtw['config'];
    $consumer_key = $rtw_config['consumer_key'];
    $consumer_secret = $rtw_config['consumer_secret'];
    $access_token = $rtw_config['access_token'];
    $access_token_secret = $rtw_config['access_token_secret'];

    if($_POST['rtw_save_settings']){
        $consumer_key = trim($_POST['rtw_consumer_key']);
        $consumer_secret = trim($_POST['rtw_consumer_secret']);
        $access_token = trim($_POST['rtw_access_token']);
        $access_token_secret = trim($_POST['rtw_access_token_secret']);

        $rtw = array();
        $rtw['config'] = array(
            'consumer_key' => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'access_token' => $access_token,
            'access_token_secret' => $access_token_secret
        );
        update_option('rtw_settings',$rtw);
    }
?>
<div class="rtw_twitter_widget_option_container">
    <h3>Twitter API settings</h3>
    <p>Getting problem with configuration? see how to get api information from <a target="_blank" href="http://rimonhabib.com/how-to-get-twitter-api-key/">here</a></p>
    <form id="rtw_twitter_account_config" method="post" action="">
        <div class="rtw_single_field">
            <p>Consumer Key<p>
            <input type='text' name="rtw_consumer_key" id="rtw_consumer_key" value="<?php echo $consumer_key ?>"/>
        </div>
        <div class="rtw_single_field">
            <p>Consumer Secret<p>
            <input type='text' name="rtw_consumer_secret" id="rtw_consumer_secret" value="<?php echo $consumer_secret ?>"/>
        </div>
        <div class="rtw_single_field">
            <p>Access Token<p>
            <input type='text'name="rtw_access_token" id="rtw_access_token" value="<?php echo $access_token ?>"/>
        </div>
        <div class="rtw_single_field">
            <p>Access Token Secret<p>
            <input  type='text' name="rtw_access_token_secret" id="rtw_access_token_secret" value="<?php echo $access_token_secret ?>"/>
        </div>
        <div class="rtw_single_field">
            <input type='submit' name="rtw_save_settings" id="rtw_save_settings" value="save" class="update button"/>
        </div>
    </form>   
</div>
<?php
}

//////////////////////////////////////////////////////////////////////////////

function rtw_featch_tweets(){

$rtw = get_option('rtw_settings');
$rtw_config = $rtw['config'];

$consumer_key = $rtw_config['consumer_key'];
$consumer_secret = $rtw_config['consumer_secret'];
$access_token = $rtw_config['access_token'];
$access_token_secret = $rtw_config['access_token_secret'];

$oauth_hash = '';
$oauth_hash .= 'oauth_consumer_key='.$consumer_key;
$oauth_hash .= '&oauth_nonce=' . time();
$oauth_hash .= '&oauth_signature_method=HMAC-SHA1';
$oauth_hash .= '&oauth_timestamp=' . time();
$oauth_hash .= '&oauth_token='.$access_token;
$oauth_hash .= '&oauth_version=1.0';

$base = '';
$base .= 'GET';
$base .= '&';
$base .= rawurlencode('https://api.twitter.com/1.1/statuses/user_timeline.json');
$base .= '&';
$base .= rawurlencode($oauth_hash);
$key = '';
$key .= rawurlencode($consumer_secret);
$key .= '&';
$key .= rawurlencode($access_token_secret);

$signature = base64_encode(hash_hmac('sha1', $base, $key, true));
$signature = rawurlencode($signature);

$oauth_header = '';
$oauth_header .= 'oauth_consumer_key="'.$consumer_key.'", ';
$oauth_header .= 'oauth_nonce="' . time() . '", ';
$oauth_header .= 'oauth_signature="' . $signature . '", ';
$oauth_header .= 'oauth_signature_method="HMAC-SHA1", ';
$oauth_header .= 'oauth_timestamp="' . time() . '", ';
$oauth_header .= 'oauth_token="'.$access_token.'", ';
$oauth_header .= 'oauth_version="1.0", ';
$curl_header = array("Authorization: Oauth {$oauth_header}", 'Expect:');

$curl_request = curl_init();
curl_setopt($curl_request, CURLOPT_HTTPHEADER, $curl_header);
curl_setopt($curl_request, CURLOPT_HEADER, false);
curl_setopt($curl_request, CURLOPT_URL, 'https://api.twitter.com/1.1/statuses/user_timeline.json');
curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, false);
$json = curl_exec($curl_request);
curl_close($curl_request);

return json_decode($json);
}


/////////////////////////////////////////////////////////////////////////////////////////

function rtw_make_links($tweet = ''){
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";                
    if( preg_match( $reg_exUrl, $tweet, $url ) ) 
    $tweet = preg_replace( $reg_exUrl, "<a target=\"_blank\" href=".$url[0].">{$url[0]}</a> ", $tweet);
    return $tweet;
}

/////////////////////////////////////////////////////////////////////////////////////////

function rtw_make_mentions($tweet = ''){
    $regex = "/@[a-zA-Z0-9\_]*/";                
    if( preg_match_all( $regex, $tweet, $matches ) ){ 
        foreach( (array) $matches[0] as $match ){
            $url = 'https://twitter.com/'.str_replace('@', '', $match);
            $tweet = str_replace( $match, "<a target=\"_blank\" href=".$url.">{$match}</a> ", $tweet);
        }
    }
    return $tweet;
}

/////////////////////////////////////////////////////////////////////////////////////////

function rtw_make_hashes($tweet = ''){
    $regex = "/#[a-zA-Z0-9\_\-]*/";                
    if( preg_match_all( $regex, $tweet, $matches ) ){ 
        foreach( (array) $matches[0] as $match ){
            $url = 'https://twitter.com/search?q=%23'.str_replace('#', '', $match).'&src=hash';
            $tweet = str_replace( $match, "<a target=\"_blank\" href=".$url.">{$match}</a> ", $tweet);
        }
    }
    return $tweet;
}
/////////////////////////////////////////////////////////////////////////////////////////

function rtw_tweet_markup($skin,$max_tweet){
    $tweets = rtw_featch_tweets();
    $avatar = $tweets[0]->user->profile_image_url;
    $name = $tweets[0]->user->name;
    $uname = $tweets[0]->user->screen_name;
    $url = $tweets[0]->user->url;
?>
    <div class="rtw_skin <?php echo $skin ?>">
        <div class="rtw_container">
            <div class="rtw_head">
                <div class="rtw_avatar">
                    <a target="_blank" href="<?php echo $url ?>"><img src="<?php echo $avatar ?>" /></a>
                </div>
                <div class="rtw_twitter_username">
                    <p><a target="_blank" href="<?php echo $url ?>"><?php echo $name ?></a></p>
                    <h3 class=""><a target="_blank" href="<?php echo $url ?>"> <?php echo $uname ?></a></h3>
                </div>
                <div style="clear:both"></div>
            </div>

            <div class="rtw_tweets">
                <ul>
                <?php for($i=0; $i<$max_tweet; $i++){
                    $tweet = $tweets[$i]->text;
                    $tweet = rtw_make_links($tweet);
                    $tweet = rtw_make_mentions($tweet);
                    $tweet = rtw_make_hashes($tweet);

                    $tweet_id = $tweets[$i]->id_str;
                    $time = $tweets[$i]->created_at;
                    $tweet_url = 'https://twitter.com/'.$uname.'/status/'.$tweet_id;
                    ?>
                    
                        <li class="tweet">
                            <p><a href="<?php echo $url ?>"><?php echo $uname ?></a> <?php echo $tweet ?></p>
                            <p class="tweet_meta">
                                <span><a target="_blank" href="<?php echo $tweet_url ?>"><?php echo human_time_diff( strtotime($time), time() ) ?></a></span>
                                <span><a target="_blank" href="<?php echo $tweet_url ?>"> . reply</a></span>
                                <span><a target="_blank" href="<?php echo $tweet_url ?>"> . retweet</a></span>
                                <span><a target="_blank" href="<?php echo $tweet_url ?>"> . favorite</a></span>
                            <p>
                        </li>
                    
                <?php } ?>
                </ul>
            </div>

            <div class="rtw_footer">
                <div class="twitter_widget_footer_logo">
                    <a href="htts://twitter.com/"><img src="<?php echo RTW_IMG_URL.'twitter-widget-logo.png' ?>" /></a>
                </div>
                <div class="twitter_widget_footer_link">
                    <a href="<?php echo  $url ?>">join the conversation</a>
                </div>
                <div style="clear:both"></div>
            </div>
            
        </div>
    </div>
<?php
}

//////////////////////////////////////////////////////////////////////////////

function rtw_load_style_scripts(){
    wp_register_style( 'rtw-admin-style', RTW_CSS_URL.'rtw-admin.css' );
    wp_enqueue_style( 'rtw-admin-style' );

}
add_action('admin_enqueue_scripts','rtw_load_style_scripts');

//////////////////////////////////////////////////////////////////////////////

function rtw_load_style(){
    wp_register_style( 'rtw-style',RTW_CSS_URL.'rtw-style.css' );
    wp_enqueue_style( 'rtw-style' );
}
add_action('wp_enqueue_scripts','rtw_load_style');


/////////////////////////////////////////////////////////////////////////////////////////

$twitter_options=get_option('rtw_admin_notice');  
if($twitter_options=='TRUE' && is_admin())
add_action('admin_notices','rtw_activation_notice');
update_option('rtw_admin_notice','FALSE');
        
//////////////////////////////////////////////////////////////////////////////
      
function rtw_custom_style(){ 
     $obj = new rtw_twitter_widget();
     echo  $obj->rtw_get_style();
 }   
add_action('wp_head','rtw_custom_style');
      
function rimon_habib_donate()
{
    if(!strpos($_SERVER['REQUEST_URI'],'widgets.php'))
            return;
    ?>

    <div class="update-nag" style="margin-top: 10px">
    
<form id="rimon_habib_donate" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="2TXZUHA8DEEWC" />

<input type="hidden" name="on0" value="Donation" />
<p style="margin-top: 10px; font-size: 14px; color: green;" >You are using Rimons Twitter Widget Plugin
    Make a donation to support us if you liked this.</p>
<div style="margin-top: 10px">
<select name="os0" style="margin-left:0px">
    <option value="Donate5">Donate $5.00 USD</option>
    <option value="Donate10">Donate $10.00 USD</option>
    <option value="Donate15">Donate $15.00 USD</option>
        <option value="Donate20">Donate $20.00 USD</option>
</select> 
    <br>
<input type="hidden" name="currency_code" value="USD">
<input type="image" style="margin-top:5px; margin-left: 0px" src="http://rimonhabib.com/wp-content/uploads/2012/04/donate.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"
       onclick="getElementById('rimon_habib_donate').submit()">
      
<img  alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
    </div>
        
<?php
}

add_action('admin_notices','rimon_habib_donate');

function rimon_credit_link()  {
    echo '<div style="width:280px; margin-left: auto; margin-right:auto" >
        <a rel="dofollow" href="http://wordpress.org/extend/plugins/rimons-twitter-widget/">Rimons twitter widget</a> by <a rel="dofollow" href="http://rimonhabib.com">Rimon Habib</a></div>';
}

require_once(RTW_ROOT.'widget.php');

?>