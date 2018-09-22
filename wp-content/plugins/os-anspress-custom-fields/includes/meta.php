<?php
$osap = get_option( 'osap' );
$post_id = get_the_ID();
?>
<div id="ospt-design-wrapper">
<?php 
if( !empty( $osap ) ) {
    foreach( $osap as $valueObj ){
        foreach( $valueObj as $key => $object ) {
            $field_name = sanitize_title( $object['label'] );
            ?>
            <div class="osmp-row-box">
                <h3><?php _e( $object['label'], OSAP_TEXT_DOMAIN ); ?></h3>
                <div class="display area"><?php echo esc_attr( get_post_meta( $post_id, $field_name, true ) );?></div>           
            </div>    
            <div class="clear"></div>
        <?php
        }
    } 
}
?>
</div>                                                                                    