<?php
/*--------------------------------------------------------------------------------------------------
	Content and Sidebar
--------------------------------------------------------------------------------------------------*/
	function _content_sidebar( $options )
	{

		global $post,$data;
		$element_size = zn_get_size( $options['_sizer'] );


		// WE HAVE NORMAL POST TYPE
		if ( 'post' == get_post_type() ) {
		?>
		<div class="span12">
		<div class="container">
			
			<div id="mainbody">
				
				<div class="row">
				<?php while(have_posts()) : the_post(); 

					// GET POST OPTIONS 
					$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
					$post_meta_fields = maybe_unserialize( $post_meta_fields );
					
					$image = '';
					
					// Create the featured image html
					if ( has_post_thumbnail( $post->ID ) ) {
					
						$thumb = get_post_thumbnail_id($post->ID) ;
						$f_image = wp_get_attachment_url($thumb) ;
						if (  $f_image  ) {
						
							$feature_image = wp_get_attachment_url( $thumb );
							$image = vt_resize( '', $f_image  , 280,187 , true );
							$image = '<a data-rel="prettyPhoto" href="'.$feature_image.'" class="hoverBorder pull-left" style="margin-right: 20px;margin-bottom:4px;"><img class="shadow" src="'.$image['url'].'" alt=""/></a>';
							
						}

					}
					
					// Here will check if sidebar is enabled
					$content_css = 'span12'; 
					$sidebar_css = ''; 
					$has_sidebar = false;
					$mainbody_css = '';
					
					// WE CHECK IF THIS IS NOT A PAGE FROM OUR THEME	
					if ( empty ( $post_meta_fields['page_layout'] ) || empty ( $post_meta_fields['sidebar_select'] ) ) {
						if ( $data['default_sidebar_position'] == 'left_sidebar' ) {
							$content_css = 'span9 zn_float_right zn_content';
							$sidebar_css = 'sidebar-left';
							$has_sidebar = true;
							$mainbody_css = 'zn_has_sidebar';
						}
						elseif ( $data['default_sidebar_position'] == 'right_sidebar' ) {
							$content_css = 'span9 zn_content';
							$sidebar_css = 'sidebar-right';
							$has_sidebar = true;
							$mainbody_css = 'zn_has_sidebar';
						}
					}	
					// WE CHECK IF WE HAVE LEFT SIDEBAR
					elseif ( $post_meta_fields['page_layout'] == 'left_sidebar' || ( $post_meta_fields['page_layout'] == 'default' && !empty ( $data['default_sidebar_position'] ) && $data['default_sidebar_position'] == 'left_sidebar' )   )
					{
						$content_css = 'span9 zn_float_right zn_content';
						$sidebar_css = 'sidebar-left';
						$has_sidebar = true;
						$mainbody_css = 'zn_has_sidebar';
					}
					// WE CHECK IF WE HAVE RIGHT SIDEBAR
					elseif ( $post_meta_fields['page_layout'] == 'right_sidebar' || ( $post_meta_fields['page_layout'] == 'default' && !empty ( $data['default_sidebar_position'] ) && $data['default_sidebar_position'] == 'right_sidebar' )  )
					{
						$content_css = 'span9 zn_content';
						$sidebar_css = 'sidebar-right ';
						$has_sidebar = true;
						$mainbody_css = 'zn_has_sidebar';
					}	
				
				?>
				
					<div class="<?php echo $content_css; ?> post-<?php the_ID(); ?>">
				
						<h1 class="page-title"><?php the_title();?></h1>

						<div class="itemView clearfix eBlog">

							<div class="itemHeader">
								<div class="post_details">
									<span class="itemAuthor"><?php echo __("by ", THEMENAME);?><?php the_author_posts_link(); ?></span>
									<span class="infSep"> / </span>
									<span class="itemDateCreated"><span class="icon-calendar"></span> <?php the_time('l, d F Y');?></span>
									<span class="infSep"> / </span>
									<span class="itemCommentsBlock"></span>
									<span class="itemCategory"><span class="icon-folder-close"></span> <?php echo __( 'Published in ', THEMENAME );?></span><?php the_category(", ");  ?>
								</div>
							</div><!-- end itemheader -->

							<div class="itemBody">
								<!-- Blog Image -->
								<?php echo $image; ?>
								
								<!-- Blog Content -->
								<?php the_content(); ?>
								
							</div><!-- end item body -->
							<div class="clear"></div>

						<?php
						
						wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', THEMENAME ) . '</span>', 'after' => '</div>' ) );
						
							if ( !empty($post_meta_fields['show_social']) && $post_meta_fields['show_social'] == 'show' || ( !empty($post_meta_fields['show_social']) &&  $post_meta_fields['show_social'] == 'default' && $data['show_social'] == 'show' ) ) {
							
							
						?>
							
							
							
								<!-- Social sharing -->
								<div class="itemSocialSharing clearfix">

									<!-- Twitter Button -->
									<div class="itemTwitterButton">
										<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
										<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
									</div>

									<!-- Facebook Button -->
									<div class="itemFacebookButton">
										<div id="fb-root"></div>
										<div class="fb-like" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
									</div>

									<!-- Google +1 Button -->
									<div class="itemGooglePlusOneButton">	
										<script type="text/javascript">
										(function() {
										var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
										po.src = 'https://apis.google.com/js/plusone.js';
										var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
										})();
										</script>
										<div class="g-plusone" data-size="medium"></div>
									</div>

									<div class="clear"></div>
								</div><!-- end social sharing -->
							<?php
							}
						?>

							<?php	
								if (has_tag()) { 
								?>
									<!-- TAGS -->
									<div class="itemTagsBlock">
										<span><?php echo __( 'Tagged under:', THEMENAME );?></span>
										<?php the_tags('');?>
										<div class="clear"></div>
									</div><!-- end tags blocks -->
							<?php	
								}	
								?>	
														
							<div class="clear"></div>
								
						<!-- DISQUS comments block -->
						<div class="disqusForm">
							<?php comments_template(); ?>
						</div>
						<div class="clear"></div>
						<!-- end DISQUS comments block -->

						</div>
						<!-- End Item Layout -->
						
						
						
					</div>
					
					<?php 
					endwhile;
					
					// START SIDEBAR OPTIONS
					// WE CHECK IF THIS IS NOT A PAGE FROM THE THEME
					if ( empty ( $post_meta_fields['page_layout'] ) || empty ( $post_meta_fields['sidebar_select'] ) ) {
						if ( $data['default_sidebar_position'] == 'left_sidebar' || $data['default_sidebar_position'] == 'right_sidebar' ) {
							echo '<div class="span3">';
								echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
									if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['single_sidebar']) ) : endif;
								echo '</div>';
							echo '</div>';
						}
					}
					// WE CHECK IF WE HAVE A SIDEBAR SET IN PAGE OPTIONS
					elseif ( ( ( $post_meta_fields['page_layout'] == 'left_sidebar' || $post_meta_fields['page_layout'] == 'right_sidebar' ) && $post_meta_fields['sidebar_select'] != 'default' ) || (  $post_meta_fields['page_layout'] == 'default' && $data['default_sidebar_position'] != 'no_sidebar' && $post_meta_fields['sidebar_select'] != 'default' ) ) 
					{ 
							
								echo '<div class="span3">';
									echo '<div id="sidebar" class="sidebar '. $sidebar_css.'">';
										if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $post_meta_fields['sidebar_select'] ) ) : endif;
									echo '</div>';
								echo '</div>';
					}
					// WE CHECK IF WE HAVE A SIDEBAR SET FROM THEME'S OPTIONS
					elseif ( $post_meta_fields['page_layout'] == 'default' && $data['default_sidebar_position'] != 'no_sidebar' && $post_meta_fields['sidebar_select'] == 'default' || ( ( $post_meta_fields['page_layout'] == 'left_sidebar' || $post_meta_fields['page_layout'] == 'right_sidebar' ) && $post_meta_fields['sidebar_select'] == 'default' ) ) {
						echo '<div class="span3">';
							echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['single_sidebar']) ) : endif;
							echo '</div>';
						echo '</div>';
					}
					
					?>
				</div><!-- end row -->
				
			</div><!-- end mainbody -->
			
		</div><!-- end container -->
		</div><!-- end span12 -->


		<?php

		}
		elseif ( 'page' == get_post_type() ) {
	
			global $post,$data,$meta_fields;

			// Here will check if sidebar is enabled
			$content_css = 'span12'; 
			$sidebar_css = ''; 
			$has_sidebar = false;
			$mainbody_css = '';
				
			// WE CHECK IF THIS IS NOT A PAGE FROM OUR THEME	
			if ( empty ( $meta_fields['page_layout'] ) || empty ( $meta_fields['sidebar_select'] ) ) {
				if ( $data['page_sidebar_position'] == 'left_sidebar' ) {
					$content_css = 'span9 zn_float_right zn_content';
					$sidebar_css = 'sidebar-left';
					$has_sidebar = true;
					$mainbody_css = 'zn_has_sidebar';
				}
				elseif ( $data['page_sidebar_position'] == 'right_sidebar' ) {
					$content_css = 'span9 zn_content';
					$sidebar_css = 'sidebar-right';
					$has_sidebar = true;
					$mainbody_css = 'zn_has_sidebar';
				}
			}	
			// WE CHECK IF WE HAVE LEFT SIDEBAR
			elseif ( $meta_fields['page_layout'] == 'left_sidebar' || ( $meta_fields['page_layout'] == 'default' && !empty ( $data['page_sidebar_position'] ) && $data['page_sidebar_position'] == 'left_sidebar' )   )
			{
				$content_css = 'span9 zn_float_right zn_content';
				$sidebar_css = 'sidebar-left';
				$has_sidebar = true;
				$mainbody_css = 'zn_has_sidebar';
			}
			// WE CHECK IF WE HAVE RIGHT SIDEBAR
			elseif ( $meta_fields['page_layout'] == 'right_sidebar' || ( $meta_fields['page_layout'] == 'default' && !empty ( $data['page_sidebar_position'] ) && $data['page_sidebar_position'] == 'right_sidebar' )  )
			{
				$content_css = 'span9 zn_content';
				$sidebar_css = 'sidebar-right ';
				$has_sidebar = true;
				$mainbody_css = 'zn_has_sidebar';
			}

			while (have_posts()) : the_post();
			
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			if ( !empty($content) || ( isset ( $meta_fields['page_title_show'] ) && $meta_fields['page_title_show'] == 'yes' ) ) {

				echo '<div class="span12">';
				$row_margin = 'zn_content_no_margin';
			
				if ( get_the_content() || $has_sidebar ) {
					$row_margin = '';
				}
			
				echo '<div class="container">';
				
				echo '<div class="mainbody '.$mainbody_css.'">';
				
						echo '<div class="row '.$row_margin.'">';
						
							echo '<div class="'.$content_css.'">';
						
								// TITLE CHECK
								if ( isset ( $meta_fields['page_title_show'] ) && $meta_fields['page_title_show'] == 'yes' ) {
									echo '<h1 class="page-title">'.get_the_title().'</h1>';
								}
								
								// PAGE CONTENT
								the_content();

								if ( !empty($data['zn_enable_page_comments']) && $data['zn_enable_page_comments'] == 'yes'  ) {
									?>
									<!-- DISQUS comments block -->
									<div class="disqusForm">
										<?php comments_template(); ?>
									</div>
									<div class="clear"></div>
									<!-- end DISQUS comments block -->
									<?php
								}

							echo '</div>';

							
							// START SIDEBAR OPTIONS
							// WE CHECK IF THIS IS NOT A PAGE FROM THE THEME
							if ( empty ( $meta_fields['page_layout'] ) || empty ( $meta_fields['sidebar_select'] ) ) {
								if ( $data['page_sidebar_position'] == 'left_sidebar' || $data['page_sidebar_position'] == 'right_sidebar' ) {
									echo '<div class="span3">';
										echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
											if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['page_sidebar']) ) : endif;
										echo '</div>';
									echo '</div>';
								}
							}
							// WE CHECK IF WE HAVE A SIDEBAR SET IN PAGE OPTIONS
							elseif ( ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] != 'default' ) || (  $meta_fields['page_layout'] == 'default' && $data['page_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] != 'default' ) ) 
							{ 
									
										echo '<div class="span3">';
											echo '<div id="sidebar" class="sidebar '. $sidebar_css.'">';
												if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar( $meta_fields['sidebar_select'] ) ) : endif;
											echo '</div>';
										echo '</div>';
							}
							// WE CHECK IF WE HAVE A SIDEBAR SET FROM THEME'S OPTIONS
							elseif ( $meta_fields['page_layout'] == 'default' && $data['page_sidebar_position'] != 'no_sidebar' && $meta_fields['sidebar_select'] == 'default' || ( ( $meta_fields['page_layout'] == 'left_sidebar' || $meta_fields['page_layout'] == 'right_sidebar' ) && $meta_fields['sidebar_select'] == 'default' ) ) {
								echo '<div class="span3">';
									echo '<div id="sidebar" class="sidebar '.$sidebar_css.'">';
										if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($data['page_sidebar']) ) : endif;
									echo '</div>';
								echo '</div>';
							}
			

						echo '</div>';
				
					echo '</div>';
					
				echo '</div>';
				echo '</div>';
				
				}
			endwhile;
		}
		elseif( 'portfolio' == get_post_type() ) {
			global $post,$data;
			?>
			<div class="span12">
			<div class="container">
				
				<div id="mainbody">
					
					<div class="row">
						<div class="span12">
						
							<?php while(have_posts()) : the_post(); 
							
								// GET POST OPTIONS 
								$post_meta_fields = get_post_meta($post->ID, 'zn_meta_elements', true);
								$post_meta_fields = maybe_unserialize( $post_meta_fields );
									
								// Sidebar check 
								$has_sidebar = false;
									
								// TITLE CHECK
								if ( isset ( $post_meta_fields['page_title_show'] ) && $post_meta_fields['page_title_show'] == 'yes' ) {
									echo '<h1 class="page-title">'.get_the_title().'</h1>';
								}
									
							?>

							<div class="hg-portfolio-item row">
                                
                                <div class="text span7">
									<?php the_content(''); ?>
                                </div><!-- end text -->
								
                                <div class="img-full span5">
								
								<?php

									if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
										
										$all_media = count( $post_meta_fields['port_media'] );
										if ( !empty ( $post_meta_fields['port_media']['0']['port_media_image_comb'] ) && !empty ( $post_meta_fields['port_media']['0']['port_media_video_comb'] ) ) {
											echo '<a href="'.$post_meta_fields['port_media']['0']['port_media_video_comb'].'" rel="prettyPhoto" class="hoverBorder">';
													$size = zn_get_size( 'span5' );
													$image = vt_resize( '', $post_meta_fields['port_media']['0']['port_media_image_comb'] , $size['width'],'' , true );
													echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.get_the_title().'" />';
													echo '</a>';
													unset( $post_meta_fields['port_media']['0'] );
											}										
											elseif ( !empty ( $post_meta_fields['port_media']['0']['port_media_image_comb'] ) ) {
												echo '<a href="'.$post_meta_fields['port_media']['0']['port_media_image_comb'].'" rel="prettyPhoto" class="hoverBorder">';
													$size = zn_get_size( 'span5');
													$image = vt_resize( '', $post_meta_fields['port_media']['0']['port_media_image_comb'] , $size['width'],'' , true );
													echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.get_the_title().'" />';
												echo '</a>';
												unset( $post_meta_fields['port_media']['0'] );										
											}										
											elseif ( !empty ( $post_meta_fields['port_media']['0']['port_media_video_comb'] ) ) {
											$size = zn_get_size( 'span5');
											echo get_video_from_link( $post_meta_fields['port_media']['0']['port_media_video_comb'] , '' , $size['width'] , $size['height'] );
													unset( $post_meta_fields['port_media']['0'] );										}	
									}
								?>	
                                    <div class="clear"></div>
                                
								<?php
									if ( !empty ( $post_meta_fields['sp_link']['url'] ) || !empty ( $post_meta_fields['sp_col'] ) ) { 
									
										echo '<div class="itemLinks">';
									
											if ( !empty ( $post_meta_fields['sp_link']['url'] ) ) {
												echo '<p><a href="'.$post_meta_fields['sp_link']['url'].'" target="'.$post_meta_fields['sp_link']['target'].'" >'.__("Live Preview: ",THEMENAME).'<strong>'.$post_meta_fields['sp_link']['url'].'</strong></a></p>';
											}
											
											if ( !empty ( $post_meta_fields['sp_col'] ) ) {
												echo '<p>'.__("Our collaborators: ",THEMENAME).'<strong>'.$post_meta_fields['sp_col'].'</strong></p>';
											}
											
											echo '<p>'.__("Category: ",THEMENAME).'<strong>'. get_the_term_list( $post->ID, 'project_category', '', ' , ', '' ) .'</strong></p>';
											
										echo '</div>';
										
									}
								?>
                                
								<?php 
									if ( !empty ( $post_meta_fields['sp_show_social'] ) && $post_meta_fields['sp_show_social'] == 'yes' ) {
								?>
                                    <div class="itemSocialSharing fixclear">
                                        
                                        <!-- Twitter Button -->
                                        <div class="itemTwitterButton">
                                            <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
                                            <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                                        </div>
                                        
                                        <!-- Facebook Button -->
                                        <div class="itemFacebookButton">
                                            <div id="fb-root"></div>
                                            <script type="text/javascript">
                                                (function(d, s, id) {
                                                var js, fjs = d.getElementsByTagName(s)[0];
                                                if (d.getElementById(id)) {return;}
                                                js = d.createElement(s); js.id = id;
                                                js.src = "http://connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
                                                fjs.parentNode.insertBefore(js, fjs);
                                                }(document, 'script', 'facebook-jssdk'));
                                            </script>
                                            <div class="fb-like" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
                                        </div>
                                        
                                        <!-- Google +1 Button -->
                                        <div class="itemGooglePlusOneButton">	
                                            <g:plusone size="medium"></g:plusone>
                                            <script type="text/javascript">
                                                (function() {
                                                window.___gcfg = {lang: 'en'}; // Define button default language here
                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                po.src = 'https://apis.google.com/js/plusone.js';
                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                })();
                                            </script>
                                        </div>
                                        
                                        <div class="clr"></div>
                                    </div><!-- social links -->
                                
								<?php
									}
								?>
								
                                </div><!-- right side -->


                                <div class="clear"></div>

								<?php
									if ( !empty ( $post_meta_fields['port_media'] ) && is_array( $post_meta_fields['port_media'] ) ) {
									
										echo '<div class="zn_other_images">';
									
										foreach ( $post_meta_fields['port_media'] as $media ) {
											if ( !empty ( $media['port_media_image_comb'] ) && !empty ( $media['port_media_video_comb'] ) ) {
												echo '<div class="span3">';
													echo '<a href="'.$media['port_media_video_comb'].'" rel="prettyPhoto" class="hoverBorder">';

															$size = zn_get_size( 'four' );
														$image = vt_resize( '', $media['port_media_image_comb'] , $size['width'],'202' , true );
														echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.get_the_title().'" />';
													echo '</a>';
												echo '</div>';
												}											elseif ( !empty ( $media['port_media_image_comb'] ) ) {
												echo '<div class="span3">';
													echo '<a href="'.$media['port_media_image_comb'].'" rel="prettyPhoto" class="hoverBorder">';

															$size = zn_get_size( 'four');
														$image = vt_resize( '', $media['port_media_image_comb'] , $size['width'],'202' , true );
														echo '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.get_the_title().'" />';
													echo '</a>';
												echo '</div>';
												}											elseif ( !empty ( $media['port_media_video_comb'] ) ) {
												echo '<div class="span3">';

													$size = zn_get_size( 'four');
													echo get_video_from_link( $media['port_media_video_comb'] , '' , $size['width'] , 202 );

													echo '</div>';
}
			
										}
										
										echo '<div class="clear"></div>';
										echo '</div>';
									}
								?>
								
                            
                            </div><!-- end Portfolio page -->
							
							<?php endwhile; wp_reset_query(); ?>
							
						</div>
					</div><!-- end row -->
					
				</div><!-- end mainbody -->
				
			</div><!-- end container -->
			</div><!-- end container -->
			<?php
		}
	}
?>