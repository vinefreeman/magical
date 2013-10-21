<?php

 

// Do not delete these lines

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))

die ('Please do not load this page directly. Thanks!');

 

if ( post_password_required() ) { ?>

<p class="nocomments"><?php echo __("This post is password protected. Enter the password to view comments.",THEMENAME);?></p>

<?php

return;

}

?>

 

<!-- You can start editing here. -->

<?php if ( have_comments() || 'open' == $post->comment_status ) { ?>

	<div class="clear"></div>

	<div class="zn-separator zn-margin-b line"></div>

	<div class="zn_comments sixteen columns"> 

<?php } ?>



<?php if ( have_comments() ) : ?>

	<h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>

	 

	<div class="navigation">

		<div class="alignleft"><?php previous_comments_link() ?></div>

		<div class="alignright"><?php next_comments_link() ?></div>

	</div>

	 

	<ol class="commentlist">

		<?php wp_list_comments('callback=zn_comment'); ?>

	</ol>

	 

	<div class="navigation">

		<div class="alignleft"><?php previous_comments_link() ?></div>

		<div class="alignright"><?php next_comments_link() ?></div>

	</div>

	<div class="clear"></div>



<?php endif; ?>

 

<?php if ('open' == $post->comment_status) : ?>

 

	<div id="respond">

		<h3 class="zn_com_title"><?php comment_form_title(); ?></h3>

 

		<div class="cancel-comment-reply">

			<small><?php cancel_comment_reply_link(); ?></small>

		</div>

 

		<div class="clear"></div>

 

		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

			<p><?php echo __("You must be ",THEMENAME);?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php echo __("logged in",THEMENAME);?></a> <?php echo __("to post a comment.",THEMENAME);?></p>

		<?php else : ?>

 

		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

 

		<?php if ( $user_ID ) : ?>

 

			<p><?php echo __("Logged in as",THEMENAME);?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php echo __("Log out",THEMENAME);?> &raquo;</a></p>

 

		<?php else : ?>

 		<div class="row-fluid">

			<div class="span4"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" class="span12" <?php if ($req) echo "aria-required='true'"; ?> placeholder="<?php echo __("Name",THEMENAME);?> <?php if ($req) echo "(required)"; ?>" />



			</div>

			

			<div class="span4"><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" class="span12" <?php if ($req) echo "aria-required='true'"; ?> placeholder="<?php echo __("Mail (will not be published)",THEMENAME);?> <?php if ($req) echo "(required)"; ?>" />



			 </div>

			<div class="span4"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" class="span12" placeholder="<?php echo __("Website",THEMENAME);?>" />



			</div>

		</div>

		<?php endif; ?>

 		<div class="row-fluid">

			<div class="span12">

			<label for="comment"><?php echo __("Comment",THEMENAME);?></label>

			<textarea name="comment" id="comment" cols="100" rows="8" tabindex="4" class="span12"></textarea>

			</div>

 		</div>

			<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e("Submit Comment",THEMENAME);?>" class="btn" />

			<?php comment_id_fields(); ?>

			</p>

			<?php do_action('comment_form', $post->ID); ?>

 

		</form>

 

		<?php endif; // If registration required and not logged in ?>

	</div>

 

	<?php endif; // if you delete this the sky will fall on your head ?>



<?php if ( have_comments() || 'open' == $post->comment_status ) { ?>

	</div>

<?php } ?>