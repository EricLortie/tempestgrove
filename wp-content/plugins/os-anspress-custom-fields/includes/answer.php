<?php
/**
 * Answer content
 *
 * @author Jinesh P.V, Team Leader Offshorent Solutions Pvt Ltd
 * @link http://offshorent.com/
 * @since 1.1
 *
 * @package AnsPress
 */

if(!ap_answer_user_can_view()){
	include ap_get_theme_location('no-permission-post.php');
	return;
}
$osap = get_option( 'osap' );
?>
<div id="answer_<?php the_ID(); ?>" <?php post_class() ?> data-id="<?php the_ID(); ?>" data-index="<?php echo @$i; ?>" itemprop="suggestedAnswer<?php echo ap_answer_is_best() ? ' acceptedAnswer' : ''; ?>" itemtype="http://schema.org/Answer" itemscope="">
	<div class="ap-content">
		<div class="ap-single-vote"><?php ap_answer_the_vote_button(); ?></div>
		<div class="ap-avatar">
			<a href="<?php ap_answer_the_author_link(); ?>"<?php ap_hover_card_attributes(ap_answer_get_author_id()); ?>>
				<?php ap_answer_the_author_avatar(); ?>
			</a>
		</div>
		<div class="ap-a-cells clearfix">
			<div class="ap-q-metas">
				<?php ap_user_display_meta(true, false, true); ?>
				<?php ap_answer_the_time(); ?>
			</div>
			<div class="ap-q-inner">
				<div class="ap-answer-content ap-q-content" itemprop="text">
					<?php the_content(); ?>
				</div>
				<?php ap_answer_the_active_time(); ?>
				<?php ap_post_status_description(ap_answer_get_the_answer_id()) ?>
				<?php ap_post_actions_buttons() ?>
			</div>
			<?php ap_answer_the_comments(); ?>
			<div class="osap-custom-answers">
			<?php 
		    if( !empty( $osap ) ) {
	            foreach( $osap as $valueObj ){
	                foreach( $valueObj as $key => $object ) {
			        $field_name = sanitize_title( $object['label'] );
			        ?>
			        <div class="osmp-row-box">
			            <h3><?php _e( $object['label'], OSAP_TEXT_DOMAIN ); ?></h3>
			            <div class="display area"><?php echo esc_attr( get_post_meta( get_the_ID(), $field_name, true ) );?></div>           
			        </div>    
			        <div class="clear"></div>
		    		<?php 
		    		}
		    	}
			}
			?>
			</div>	
		</div>
	</div>
</div>
<style type="text/css">
.osap-custom-answers .osmp-row-box {
	background: #f5f5f5;
	padding: 10px;
	margin-bottom: 10px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-ms-border-radius: 3px;
	-o-border-radius: 3px;
	border-radius: 3px;
}
.osap-custom-answers .osmp-row-box h3{
	margin: 0;
	font-size: 14px;
}
</style>