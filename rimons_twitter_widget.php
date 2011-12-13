<?php
/* Plugin Name: Rimons Twitter Widget
 * Plugin URI: http://rimonhabib.com
 * Description: This plugin allow you to grab your tweets from twitter and show your theme's sidebar as widget. You can customize   color schemes and size to fit it to your sidebar.after installing, See the <a href="/wp-admin/widgets.php">Widget page</a> to configure twitter widget
 * Version: 0.3
 * Author: Rimon Habib
 * Author URI: http://rimonhabib.com
 *
 */



register_activation_hook( __FILE__,'activate');

register_deactivation_hook( __FILE__,'deactivate');

 function activation_notice(){
    echo '<div class="updated" style="background-color: #53be2a; border-color:#199b57">
	
       <p>Thank you for installing <strong>Rimons Twitter Widget</strong>. See the <a href="/wp-admin/widgets.php">Widget page</a> to configure twitter widget.</p>
        </div>';
}




	






  function activate(){
      
      $twitter_options=array(
            
                          'twitter_id' => "",
                          'twitter_title' => "",
                          'tweeter_width' => 198,
                          'tweeter_height' => 300,
                          'shell_background' => "#c4deeb",
                          'shell_color' => '#3d2c3d',
                          'tweet_background' => '#eaf6fd',
                          'tweet_color' => '#816666',
                          'tweet_links' => '#497da8',
                          'tweet_scroll' => 'false',
                          'tweet_loop' => 'false',
                          'tweet_live' => 'false'
                           );
      
      
      
        rwr_initialize('rwr_twitter_options',$twitter_options);
        
       
  }
 

  
  function deactivate(){
  // activate();
    
  }
  
  
/* 
 * Function name: rwr_initialize($option_name, $value)
 * Parameters: 2, $option_name , $value
 * Description: Initializing the options with default values
 * Returns: none  
 *  
 */
  
  function rwr_initialize($option_name,$value)
  {
      
      
        if ( ! get_option("$option_name")){
            add_option("$option_name" , $value);
        } else {
            update_option("$option_name" , $value);
        }
   
  }
  
  
  
  function rwr_twitter_widget_backend()
  {
      
      $twitter_options=get_option('rwr_twitter_options');
      
      ?>
      <p><label>Title:<input name="twitter_title" type="text" value="<?php echo $twitter_options['twitter_title'] ?>" /> </label> </p>
      <p><label>Your twitter ID: <input name="twitter_id" type="text" value="<?php echo $twitter_options['twitter_id'] ?>" /> </label> </p>
      <p><label>Width: <input name="twitter_width" type="text" size="3" value="<?php echo $twitter_options['tweeter_width'] ?>" /> </label>
         <label>Height: <input name="twitter_height" type="text" size="3" value="<?php echo $twitter_options['tweeter_height'] ?>" /> </label>
      
      </p>
      <p><label> Container Background: <input name="shell_background" type="text" size="7" value="<?php echo $twitter_options['shell_background'] ?>" /> </label>
          <br>  <label> Container Text Color: <input name="shell_color" type="text" size="7" value="<?php echo $twitter_options['shell_color'] ?>" /> </label>
      
      </p> 
      <p><label> Tweet Background: <input name="tweet_background" type="text" size="7" value="<?php echo $twitter_options['tweet_background'] ?>" /> </label>
        <br> <label> tweet Color: <input name="tweet_color" type="text" size="7" value="<?php echo $twitter_options['tweet_color'] ?>" /> </label>
      
      </p> 
      <p><label> Tweet links color: <input name="tweet_links" type="text" size="7" value="<?php echo $twitter_options['tweet_links'] ?>" /> </label></p>
      
      <p><label> Scrool: 
		<select name="tweet_scroll">
			<option value="true">True</option>
			<option value="false" <?php if($twitter_options['tweet_scroll']=='false') echo 'selected'; ?>>False
			</option>
			</select>
	</label><br>
         <label> Loop: <select name="tweet_loop">

		<option value="true">True</option>
		<option value="false" <?php if($twitter_options['tweet_loop']=='false') echo 'selected'; ?>>False
			</option>
		</select> </label>
	<br>

         <label> Live: <select name="tweet_live">

		<option value="true">True</option>
		<option value="false" <?php if($twitter_options['tweet_live']=='false') echo 'selected'; ?>>False
			</option>
		</select>
	</label><br>
      </p> 
      
      <?php
       
      if(!$_POST['twitter_id'])
          $twitter_id = $twitter_options['twitter_id'];
      else 
      $twitter_id = attribute_escape($_POST['twitter_id']);
               
       
      if(!$_POST['twitter_title'])
          $twitter_title = $twitter_options['twitter_title'];
      else 
      $twitter_title = attribute_escape($_POST['twitter_title']);
      
      
      if(!$_POST['twitter_title'])
          $twitter_title = $twitter_options['twitter_title'];
      else 
      $twitter_title = attribute_escape($_POST['twitter_title']);
      
      
      if(!$_POST['twitter_width'])
          $width = $twitter_options['tweeter_width'];
      else 
      $width = attribute_escape($_POST['twitter_width']);
      
      
      if(!$_POST['twitter_height'])
          $height = $twitter_options['tweeter_height'];
      else 
      $height = attribute_escape($_POST['twitter_height']);
      
      
      
      if(!$_POST['shell_background'])
          $shell_background = $twitter_options['shell_background'];
      else 
      $shell_background = attribute_escape($_POST['shell_background']);
      
      
      
      if(!$_POST['shell_color'])
          $shell_color = $twitter_options['shell_color'];
      else 
      $shell_color = attribute_escape($_POST['shell_color']);
      
      
      if(!$_POST['tweet_background'])
          $tweet_background = $twitter_options['tweet_background'];
      else 
      $tweet_background = attribute_escape($_POST['tweet_background']);
      
    
      if(!$_POST['tweet_color'])
          $tweet_color = $twitter_options['tweet_color'];
      else 
      $tweet_color = attribute_escape($_POST['tweet_color']);
      
      
      if(!$_POST['tweet_links'])
          $tweet_links = $twitter_options['tweet_links'];
      else 
      $tweet_links = attribute_escape($_POST['tweet_links']);
      
      if(!$_POST['tweet_scroll'])
          $scroll = $twitter_options['tweet_scroll'];
      else 
      $scroll = attribute_escape($_POST['tweet_scroll']);
      
      if(!$_POST['tweet_loop'])
          $loop = $twitter_options['tweet_loop'];
      else 
      $loop = attribute_escape($_POST['tweet_loop']);
      
      
      if(!$_POST['tweet_live'])
          $live = $twitter_options['tweet_live'];
      else 
      $live = attribute_escape($_POST['tweet_live']);
      
       
            
             $twitter_options=array(
            
                          'twitter_id' => "$twitter_id",
                          'twitter_title' => "$twitter_title",
                          'tweeter_width' => "$width",
                          'tweeter_height' => "$height",
                          'shell_background' => "$shell_background",
                          'shell_color' => "$shell_color",
                          'tweet_background' => "$tweet_background",
                          'tweet_color' => "$tweet_color",
                          'tweet_links' => "$tweet_links",
                          'tweet_scroll' => "$scroll",
                          'tweet_loop' => "$loop",
                          'tweet_live' => "$live"
                           );
 
             
             
                         update_option('rwr_twitter_options', $twitter_options);
    
             
             
    }
	$twitter_options=get_option('rwr_twitter_options');  
	if(!$twitter_options['twitter_id'] && is_admin())
	add_action('admin_notices','activation_notice');

 function rwr_twitter_widget_frontend($args)
 {
       $twitter_options=get_option('rwr_twitter_options');
       
        echo $args['before_widget'];
        echo $args['before_title'] . $twitter_options['twitter_title'] . $args['after_title'];
        if($twitter_options['twitter_id']):
     ?>
               <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                     <script>
                    new TWTR.Widget({
                      version: 2,
                      type: 'profile',
                      rpp: 7,
                      interval: 30000,
                      width: <?php echo $twitter_options['tweeter_width'] ?>,
                      height: <?php echo $twitter_options['tweeter_height'] ?> ,
                      theme: {
                        shell: {
                          background: '<?php echo $twitter_options['shell_background'] ?>',
                          color: '<?php echo $twitter_options['shell_color'] ?>'
                        },
                        tweets: {
                          background: '<?php echo $twitter_options['tweet_background'] ?>',
                          color: '<?php echo $twitter_options['tweet_color'] ?>',
                          links: '<?php echo $twitter_options['tweet_links'] ?>'
                        }
                      },
                      features: {
                        scrollbar: <?php echo $twitter_options['tweet_scroll'] ?>,
                        loop: <?php echo $twitter_options['tweet_loop'] ?>,
                        live: <?php echo $twitter_options['tweet_live'] ?>,
                        behavior: 'all'
                      }
                    }).render().setUser('<?php echo $twitter_options['twitter_id'] ?>').start();
                    </script>
      <?php
      
      else :
      echo "<p>Please Enter your twitter ID to show tweets from twitter</p>";
	
      endif;
      
        echo $args['after_widget'];
 }
  
  
   function register(){
    wp_register_sidebar_widget('twitter_widget',"Twitter Widget","rwr_twitter_widget_frontend" );
    wp_register_widget_control('twitter_widget',"Twitter Widget", "rwr_twitter_widget_backend");
  }

  
add_action("widgets_init",'register');

?>
