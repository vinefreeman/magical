<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <title>
        <?php bloginfo( 'name'); ?>
        <?php wp_title( '|',true, '');?>
    </title>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php 
		global $data;
		zn_favicon();
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); 
		wp_head(); 
	?>
</head>

<body class="offline-page">
<?php zn_f_o_g();?> 
	<div id="background"></div>
	<div class="containerbox">
		<?php echo zn_logo(); ?>
		<div class="content">
			<p><?php echo stripslashes( $data['cs_desc'] ); ?></p>
			
			<?php
				if ( !empty ( $data['cs_date']['date'] ) && !empty ( $data['cs_date']['time'] ) ) {
					
					echo '<div class="ud_counter">';
						echo '<ul id="Counter">';
							echo '<li>0<span>day</span></li>';
							echo '<li>00<span>hours</span></li>';
							echo '<li>00<span>min</span></li>';
							echo '<li>00<span>sec</span></li>';
						echo '</ul>';
						echo '<span class="till_lauch"><img src="'.MASTER_THEME_DIR.'/images/rocket.png"></span>';
					echo '</div><!-- end counter -->';
					
				}

				if ( !empty ( $data['cs_lsit_id'] ) && !empty ( $data['mailchimp_api'] ) ) {
				
					echo '<div class="mail_when_ready">';
					echo	'		<form method="post" class="newsletter_subscribe newsletter-signup" data-url="'.trailingslashit(home_url()).'" name="newsletter_form">';
					echo	'			<input type="text" name="zn_mc_email" class="nl-email" value="" placeholder="your.address@email.com" />';
					echo	'			<input type="hidden" name="zn_list_class" class="nl-lid" value="'.$data['cs_lsit_id'].'" />';
					echo	'			<input type="submit" name="submit" class="nl-submit" value="JOIN US" />';
					echo	'		</form>';
					echo 	'<span class="zn_mailchimp_result"></span>';
					echo 	'</div>';
					
				}
				
				if ( isset( $data['cs_social_icons'] ) && is_array( $data['cs_social_icons'] ) && !empty($data['cs_social_icons'][0]['cs_social_icon'] ) ) {
				
					
					echo '<ul class="social-icons fixclear">';
															
						foreach ( $data['cs_social_icons'] as $key=>$icon ){
						
							$link = '';
							$target = '';
						
							if ( isset ( $icon['cs_social_link'] ) && is_array ( $icon['cs_social_link'] )) {
								$link = $icon['cs_social_link']['url'];
								$target = 'target="'.$icon['cs_social_link']['target'].'"';
							}
							
						
							echo '<li class="'.$icon['cs_social_icon'].'"><a href="'.$link.'" '.$target.'>'.$icon['cs_social_title'].'</a></li>';
						}
						
					echo '</ul>';
					
				}
				
			?>				
			
			<div class="clear"></div>
		</div><!-- end content -->
		<div class="clear"></div>
	</div>
<?php wp_footer(); ?>
</body>
</html>