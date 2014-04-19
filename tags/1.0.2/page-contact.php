<?php
/*
 * Template Name: Contact
*/
?>
 
<?php

$commentError = '';
$nameError = '';
$emailError = '';

if(isset($_POST['submitted'])) {
        if(trim($_POST['contactName']) === '') {
               $nameError = 'Please enter your name.';
               $hasError = true;
        } else {
               $name = trim($_POST['contactName']);
        }
 
        if(trim($_POST['email']) === '')  {
               $emailError = 'Please enter your email address.';
               $hasError = true;
        } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
               $emailError = 'You entered an invalid email address.';
               $hasError = true;
        } else {
               $email = trim($_POST['email']);
        }
 
        if(trim($_POST['comments']) === '') {
               $commentError = 'Please enter a message.';
               $hasError = true;
        } else {
                       $comments = stripslashes(trim($_POST['comments']));
        }
 
        if(!isset($hasError)) {
               $emailTo = get_option('tz_email');
               if (!isset($emailTo) || ($emailTo == '') ){
                       $emailTo = get_option('admin_email');
               }
               $subject = '[PHP Snippets] From '.$name;
               $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
               $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
 
               wp_mail($emailTo, $subject, $body, $headers);
               $emailSent = true;
        }
 
} ?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

 
                       <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                       <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                               <h1><?php the_title(); ?></h1>
                                      <div>
                                              <?php if(isset($emailSent) && $emailSent == true) { ?>
                                                      <div>
                                                             <p class="messsage_sent"><?php _e('Thanks, your email was sent successfully.', 'cwp_megar'); ?></p>
                                                      </div>
                                              <?php } else { ?>
                                              		  <div class="content-contact">
                                                      	<?php the_content(); ?>
                                                      </div><!-- .content-contact -->
                                                      <?php if(isset($hasError) || isset($captchaError)) { ?>
                                                             <p class="messsage_error"><?php _e('Sorry, an error occured.', 'cwp_megar'); ?><p>
                                                      <?php } ?>
 										
                                            <div class="cotnact-form-wrap">
                                            
                                              <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
                                                      <ul>
                                                      <li>
                                                             <label for="contactName"><?php _e('Name', 'cwp-megar'); ?></label>
                                                             <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" />
                                                             <?php if($nameError != '') { ?>
                                                                     <span><?php $nameError;?></span>
                                                             <?php } ?>
                                                      </li>
 
                                                      <li>
                                                             <label for="email"><?php _e('Email:', 'cwp-megar'); ?></label>
                                                             <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" />
                                                             <?php if($emailError != '') { ?>
                                                                     <span><?php $emailError;?></span>
                                                             <?php } ?>
                                                      </li>
 
                                                      <li><label for="commentsText"><?php _e('Message:', 'cwp-megar'); ?></label>
                                                             <textarea name="comments" id="commentsText" rows="7" cols="10"><?php if(isset($_POST['comments'])) { echo stripslashes($_POST['comments']); } ?></textarea>
                                                             <?php if($commentError != '') { ?>
                                                                     <span><?php $commentError;?></span>
                                                             <?php } ?>
                                                      </li>
 
                                                      <li>
                                                             <input type="submit" value="Send email"></input>
                                                      </li>
                                              </ul>
                                              <input type="hidden" name="submitted" id="submitted" value="true" />
                                      </form>
                                      </div><!-- .cotnact-form-wrap -->
                                      
                               <?php } ?>
                               </div><!-- .entry-content -->
                       </div><!-- .post -->
 
                               <?php endwhile; endif; ?>




		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>