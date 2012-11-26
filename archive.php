<?php
get_header();
$date_format = get_option( 'date_format' );
if ( of_get_option( 'home_sidebar', '1' ) == "1" )
    tech_show_sidebar( "l" );
?>

<div id="content" class="<?php echo (of_get_option( 'home_sidebar', '1' ) != "1" || of_get_option( 'sidebar_pos', '3-col' ) == '1-col' ) ? "wide" : "narrow"; ?>column">

    <?php if ( have_posts() ) { 
        tech_archive_title();
    }
    ?>		
    <?php tech_nav_links(); ?>
<?php get_template_part( 'loop', 'archive' ); ?>		
    <?php tech_nav_links(); ?>
</div>
<?php
if ( of_get_option( 'home_sidebar', '1' ) == "1" ) {
    tech_show_sidebar( "r" );
}
get_footer();
?>