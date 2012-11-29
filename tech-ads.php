<?php
$tech_ad_code = of_get_option( 'ad_code', '' );
if ( !empty( $tech_ad_code ) && $tech_ii <= 3 ) {
    $tech_i++;
    if ( $tech_i == of_get_option( 'ad_int', '3' ) ) {
        ?>
        <div class="aligncenter">
            <?php
            $tech_ad_code = stripslashes( of_get_option( 'ad_code', '' ) );
            echo do_shortcode( $tech_ad_code );
            ?>
        </div>
        <?php
        $tech_i = 0;
        $tech_ii++;
    }
} //End Ad Loop
?>