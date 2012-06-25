<?php
/* Plugin Name: Rimons Twitter Widget
 * Plugin URI: http://rimonhabib.com
 * Description: This plugin allow you to grab your tweets from twitter and show your theme's sidebar as widget. You can customize   color schemes and size to fit it to your sidebar.after installing, See the <a href="/wp-admin/widgets.php">Widget page</a> to configure twitter widget
 * Version: 0.8
 * Author: Rimon Habib
 * Author URI: http://rimonhabib.com
 *
 */



register_activation_hook( __FILE__,'rtw_activate');

register_deactivation_hook( __FILE__,'rtw_deactivate');

 function rtw_activation_notice(){
    echo '<div class="updated" style="background-color: #53be2a; border-color:#199b57">
	
       <p>Thank you for installing <strong>Rimons Twitter Widget</strong>. See the <a href="'.site_url().'/wp-admin/widgets.php">Widget page</a> to configure twitter widget.</p>
        </div>';
}





  function rtw_activate(){
            update_option('rtw_admin_notice','TRUE');
  }
 

  
  function rtw_deactivate(){
  // activate();
    
  }
  
  
  
	$twitter_options=get_option('rtw_admin_notice');  
	if($twitter_options=='TRUE' && is_admin())
        add_action('admin_notices','rtw_activation_notice');
        update_option('rtw_admin_notice','FALSE');
        




class rtw_twitter_widget extends WP_Widget
{

    function rtw_twitter_widget()
    {
      parent::WP_Widget( $id = 'rtw_twitter_widget', $name = 'Rimons Twitter Widget'/*get_class($this)*/, $options = array( 'description' => 'Grab your tweets from twitter and show it to your sidebar' ) );
	
    }
    



                            
                            
        

    function widget( $args, $instance ) {
                  
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['rtw_twitter_title'] );
                    
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; 
		

 
                    if($instance['rtw_twitter_username']){ ?>
                         
                                   <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                                         <script>
                                        
                                       new TWTR.Widget({
                                          version: 2,
                                          type: 'profile',
                                          rpp: <?php echo $instance['rtw_twitter_number'] ?>,
                                          interval: 30000,
                                          width: <?php echo $instance['rtw_twitter_width'] ?>,
                                          height: <?php echo $instance['rtw_twitter_height'] ?> ,
                                          theme: {
                                            shell: {
                                              background: '<?php echo $instance['rtw_twitter_container_background'] ?>',
                                              color: '<?php echo $instance['rtw_twitter_container_color'] ?>'
                                            },
                                            tweets: {
                                              background: '<?php echo $instance['rtw_twitter_tweet_background'] ?>',
                                              color: '<?php echo $instance['rtw_twitter_tweet_color'] ?>',
                                              links: '<?php echo $instance['rtw_twitter_tweet_link_color'] ?>'
                                            }
                                          },
                                          features: {
                                            scrollbar: <?php echo $instance['rtw_twitter_scroll'] ?>,
                                            loop: <?php echo $instance['rtw_twitter_loop'] ?>,
                                            live: <?php echo $instance['rtw_twitter_live'] ?>,
                                            behavior: 'all',
                                            avatars: <?php echo $instance['rtw_twitter_show_avatar'] ?>,
                                            
                                           
                                          }
                                        }).render().setUser('<?php echo $instance['rtw_twitter_username'] ?>').start();
                                        
                                   </script>
                          <?php
                          
                            
                          }
                          else {
                          echo "<p>Please Enter your twitter ID to show tweets from twitter</p>";

                          }
                            echo $after_widget;
                            
                        
                        
	}
    
    
    

        
        
        
        
        function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['rtw_twitter_title'] = strip_tags($new_instance['rtw_twitter_title']);
                $instance['rtw_twitter_font_size'] = strip_tags($new_instance['rtw_twitter_font_size']);
                
                $instance['rtw_twitter_username'] = $new_instance['rtw_twitter_username'];
                $instance['rtw_twitter_number'] = $new_instance['rtw_twitter_number'];
                $instance['rtw_twitter_width'] = $new_instance['rtw_twitter_width'];
                $instance['rtw_twitter_height'] = $new_instance['rtw_twitter_height'];
                $instance['rtw_twitter_container_background'] = $new_instance['rtw_twitter_container_background'];
                $instance['rtw_twitter_container_color'] = $new_instance['rtw_twitter_container_color'];
                $instance['rtw_twitter_tweet_background'] = $new_instance['rtw_twitter_tweet_background'];
                $instance['rtw_twitter_tweet_color'] = $new_instance['rtw_twitter_tweet_color'];
                $instance['rtw_twitter_tweet_link_color'] = $new_instance['rtw_twitter_tweet_link_color'];
                $instance['rtw_twitter_scroll'] = $new_instance['rtw_twitter_scroll'];
                $instance['rtw_twitter_loop'] = $new_instance['rtw_twitter_loop'];
                $instance['rtw_twitter_live'] = $new_instance['rtw_twitter_live'];
                $instance['rtw_twitter_show_logo'] = $new_instance['rtw_twitter_show_logo'];
                $instance['rtw_twitter_show_username'] = $new_instance['rtw_twitter_show_username'];
                $instance['rtw_twitter_show_credit'] = $new_instance['rtw_twitter_show_credit'];
                $instance['rtw_twitter_show_avatar'] = $new_instance['rtw_twitter_show_avatar'];
		return $instance;
	}
        
        
        
        
        
        
    
    
    
    
    function form ($instance)
    { 
        global $logo;
        
        $instance['rtw_twitter_number']= ($instance['rtw_twitter_number'] ?  $instance['rtw_twitter_number'] : 7 );
        $instance['rtw_twitter_width']= ($instance['rtw_twitter_width'] ?  $instance['rtw_twitter_width'] : '198' );
        $instance['rtw_twitter_height']= ($instance['rtw_twitter_height'] ?  $instance['rtw_twitter_height'] : '300' );
        $instance['rtw_twitter_height']= ($instance['rtw_twitter_height'] ?  $instance['rtw_twitter_height'] : '300' );
        $instance['rtw_twitter_container_background']= ($instance['rtw_twitter_container_background'] ?  $instance['rtw_twitter_container_background'] : '#c4deeb' );
        $instance['rtw_twitter_container_color']= ($instance['rtw_twitter_container_color'] ?  $instance['rtw_twitter_container_color'] : '#3d2c3d' );
        $instance['rtw_twitter_tweet_background']= ($instance['rtw_twitter_tweet_background'] ?  $instance['rtw_twitter_tweet_background'] : '#eaf6fd' );
        $instance['rtw_twitter_font_size']= ($instance['rtw_twitter_number'] ?  $instance['rtw_twitter_font_size'] : '' );
        
        $instance['rtw_twitter_tweet_color']= ($instance['rtw_twitter_tweet_color'] ?  $instance['rtw_twitter_tweet_color'] : '#816666' );
        $instance['rtw_twitter_tweet_link_color']= ($instance['rtw_twitter_tweet_link_color'] ?  $instance['rtw_twitter_tweet_link_color'] : '#497da8' );
        $scroll_select= ($instance['rtw_twitter_scroll']=='false' ? " selected " : '');
        $loop_select= ($instance['rtw_twitter_loop']=='false' ? " selected " : '');
        $live_select= ($instance['rtw_twitter_live']=='false' ? " selected " : '');
        $logo_select= ($instance['rtw_twitter_show_logo']=='false' ? " selected " : '');
        $username_select= ($instance['rtw_twitter_show_username']=='false' ? " selected " : '');
        $credit_select= ($instance['rtw_twitter_show_avatar']=='false' ? " selected " : '');
        $show_avatar= ($instance['rtw_twitter_show_credit']=='false' ? " selected " : '');
        
        
        
        ?>
                                   
                             
            <label for="<?php echo $this->get_field_id('rtw_twitter_title'); ?>"><?php _e('Title:'); ?></label>			
            <input class="widefat" id="<?php echo $this->get_field_id('rtw_twitter_title'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_title'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_title']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_username'); ?>"><?php _e('Your Twitter Username:'); ?></label>			
            <input class="widefat" id="<?php echo $this->get_field_id('rtw_twitter_username'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_username'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_username']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_number'); ?>"><?php _e('number of tweets:'); ?></label>			
            <input class="widefat" id="<?php echo $this->get_field_id('rtw_twitter_number'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_number'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_number']); ?>" />
            <br>
            
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_width'); ?>"><?php _e('Width:'); ?></label>			
            <input class="widefat" size="3" id="<?php echo $this->get_field_id('rtw_twitter_width'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_width'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_width']); ?>" />
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_height'); ?>"><?php _e('Height:'); ?></label>			
            <input class="widefat" size="3" id="<?php echo $this->get_field_id('rtw_twitter_height'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_height'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_height']); ?>" />
            <br>

            
            <label for="<?php echo $this->get_field_id('rtw_twitter_container_background'); ?>"><?php _e('Container Background:'); ?></label>			
            <input class="widefat"  id="<?php echo $this->get_field_id('rtw_twitter_container_background'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_container_background'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_container_background']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_container_color'); ?>"><?php _e('Container Text Color:'); ?></label>			
            <input class="widefat"  id="<?php echo $this->get_field_id('rtw_twitter_container_color'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_container_color'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_container_color']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_tweet_background'); ?>"><?php _e('Tweets Background:'); ?></label>			
            <input class="widefat"  id="<?php echo $this->get_field_id('rtw_twitter_tweet_background'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_tweet_background'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_tweet_background']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_font_size'); ?>"><?php _e('Font size (in px):'); ?></label>			
            <input class="widefat" id="<?php echo $this->get_field_id('rtw_twitter_font_size'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_font_size'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_font_size']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_tweet_color'); ?>"><?php _e('Tweet Text Color:'); ?></label>			
            <input class="widefat"  id="<?php echo $this->get_field_id('rtw_twitter_tweet_color'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_tweet_color'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_tweet_color']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_tweet_link_color'); ?>"><?php _e('Tweets Link Color:'); ?></label>			
            <input class="widefat"  id="<?php echo $this->get_field_id('rtw_twitter_tweet_link_color'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_tweet_link_color'); ?>" type="text" value="<?php echo esc_attr($instance['rtw_twitter_tweet_link_color']); ?>" />
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_scroll'); ?>"><?php _e('Scroll:'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_scroll'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_scroll'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $scroll_select; ?> >False</option>
                
            </select>
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_loop'); ?>"><?php _e('Loop:'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_loop'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_loop'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $loop_select; ?> >False</option>
                
            </select>
            <br>
            
            
            
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_live'); ?>"><?php _e('Live:'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_live'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_live'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $live_select; ?> >False</option>
                
            </select>
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_show_logo'); ?>"><?php _e('Show Twitter Logo'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_show_logo'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_show_logo'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $logo_select; ?> >False</option>
                
            </select>
            
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_show_username'); ?>"><?php _e('Show Twitter Username'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_show_username'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_show_username'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $username_select; ?> >False</option>
                
            </select>
            
            
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_show_avatar'); ?>"><?php _e('Show avatar on tweets'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_show_avatar'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_show_avatar'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $show_avatar; ?> >False</option>
                
            </select>
            
            
            <br>
            
            <label for="<?php echo $this->get_field_id('rtw_twitter_show_credit'); ?>"><?php _e('Credit link'); ?></label>			
            <select  id="<?php echo $this->get_field_id('rtw_twitter_show_credit'); ?>" name="<?php echo $this->get_field_name('rtw_twitter_show_credit'); ?>" >
            
                <option value="true">True</option>
                <option value="false" <?php echo $credit_select; ?> >False</option>
                
            </select>
            
            
    <?
    }
    
    
    
    
    public function get_logo_view()
    {
       $ops = get_option('widget_'.$this->id_base);
       $i=0;
       $extra_option = array();
       $extra_option['got_logo'] = FALSE;
       $extra_option['got_username'] = FALSE;
       $extra_option['got_credit'] = FALSE;
       
       foreach((array)$ops as $key=>$vals){
           
           if( $extra_option['got_logo'] && $extra_option['got_username'] && $extra_option['got_credit'])
               break;
           
           if(isset($ops[$key]['rtw_twitter_show_logo']) && $ops[$key]['rtw_twitter_show_logo'] != 'false')
                   $extra_option['got_logo'] = TRUE;
           
           if(isset($ops[$key]['rtw_twitter_show_username']) && $ops[$key]['rtw_twitter_show_username'] != 'false' )
                   $extra_option['got_username'] = TRUE;
           
           if(isset($ops[$key]['rtw_twitter_show_credit']) && $ops[$key]['rtw_twitter_show_credit'] != 'false' )
                   $extra_option['got_credit'] = TRUE;
           
           if($ops[$key]['rtw_twitter_font_size'])
                   $extra_option['font_size'] = $ops[$key]['rtw_twitter_font_size'];
           
           
               $i++;
            
       }
       
       return $extra_option;
    }

    
    
 } // rtw_twitter_widget Class Ends

add_action( 'widgets_init', create_function( '', 'register_widget("rtw_twitter_widget");' ) );

            
 
      
      
      
function twitter_logo_hider()
{ 
     $obj = new rtw_twitter_widget();
     $view = $obj->get_logo_view();
     if($view['font_size']) {
       ?> 
     
            <style type="text/css">
                
                .twtr-tweet-text p {
                    font-size: <?php  echo $view['font_size']?>px;
                }
            </style>
     
     
     <?php   
     }
     if(!$view['got_logo'])
     {
        ?>
                <style type="text/css">
                    .twtr-ft a img {
                        display: none;
                        
                    }
                    
                    
                 </style>
                 
        <?php
     }
     
     if(!$view['got_username'])
     {
        ?>
                <style type="text/css">
                    .twtr-hd h4 {
                        display: none;
                        
                    } 
                 </style>
                
        <?php
     }
     
     if($view['got_credit'])
     {
         
        add_action('wp_footer','rimon_credit_link');
     }
    }
    
add_action('wp_head','twitter_logo_hider');
      




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


?>