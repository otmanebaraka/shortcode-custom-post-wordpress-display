<?php
/*
* Plugin Name: Tours Grid display ShortCode
* Description: Create gird of Tours.
* Version: 1.0
* Author: OTMANE BARAKA
* Author URI: https://www.OTMDEV.com
*/



function register_shortcodes() {
    add_shortcode( 'produtos', 'Grid_Tours_Shows' );
    add_shortcode( 'ToursSlider', 'Tours_Slider_Shows' );

}
add_action( 'init', 'register_shortcodes' );

/**
 * Produtos Shortcode Callback
 * 
 * @param Array $atts
 *
 * @return string
 */
function Grid_Tours_Shows( $atts ) {
    ob_start();
    global $wp_query,
        $post;

    $atts = shortcode_atts( array(
        'line' => '',
        'number' =>'',
        'justify'=>''
    ), $atts );
echo "<div class='row ' style='justify-content:".$atts['justify']."'>";
    $loop = new WP_Query( array(
        'posts_per_page'    => 200,
        'post_type'         => 'tours',
        'orderby'           => '',
        'order'             => '',
           'posts_per_page' =>  $atts['number'],
        'tax_query'         => array( array(
            'taxonomy'  => 'tours_category',
            'field'     => 'slug',
            'terms'     => array( sanitize_title( $atts['line'] ) )
        ) )
    ) );

    if( ! $loop->have_posts() ) {
        return false;
    }
    
    while( $loop->have_posts() ) {
        $loop->the_post();
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
        $featured_img_alt = get_post_meta(get_post_thumbnail_id() , '_wp_attachment_image_alt', true);
        ?>
            <div class="card pb-3 mb-5" style="max-width: 290px; margin-right: 30px;min-height: 380px;">
                 <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo ($featured_img_url); ?>" alt="<?php echo($featured_img_alt); ?>" class="card-img-top img-thumbnail p-0">
                </a>
              <div class="card-body">
                    <h5 class="card-title text-dark "><?php the_title(); ?></h5>
                <a href="<?php the_permalink(); ?>" class="btn-outline-primary">Book now</a>
                <div class="desc">
                	<span class="text-danger">3 days</span>
                	<span class="text-success">155 Euro</span>
                </div>
              </div>
             
            </div>
            <?php
    }
    echo "</div>";

    wp_reset_postdata();
    return ob_get_clean();
}
/**
 * Produtos Shortcode Callback
 * 
 * @param Array $atts
 *
 * @return string
 */
 function Tours_Slider_Shows( $atts ) {

    ob_start();
    global $wp_query,
        $post;

    $atts = shortcode_atts( array(
        'line' => '',
        'number' =>'',
    ), $atts );

echo "<div class='row'>
        <div class='col-12'>
";
echo "<div class='tours-slider d-flex' style='min-height:400px'>";
    $loop = new WP_Query( array(
        'posts_per_page'    => 200,
        'post_type'         => 'tours',
        'orderby'           => '',
        'order'             => '',
           'posts_per_page' =>  $atts['number'],
        'tax_query'         => array( array(
            'taxonomy'  => 'tours_category',
            'field'     => 'slug',
            'terms'     => array( sanitize_title( $atts['line'] ) )
        ) )
    ) );

    if( ! $loop->have_posts() ) {
        return false;
    }
    
    while( $loop->have_posts() ) {
        $loop->the_post();
        $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
        $featured_img_alt = get_post_meta(get_post_thumbnail_id() , '_wp_attachment_image_alt', true);
        ?>
            <div class="card pb-3" style="max-width: 340px; margin-right: 30px;min-height: 380px;">
              <a href="<?php the_permalink(); ?>">
                <img src="<?php echo ($featured_img_url); ?>" alt="<?php echo($featured_img_alt); ?>" class="card-img-top img-thumbnail p-0">
            </a>
              <div class="card-body">
                <h5 class="card-title text-dark "><?php the_title(); ?></h5>
                <a href="<?php the_permalink(); ?>" class="btn-outline-primary">Book now</a>
              </div>
            
            </div>
            <?php
    }
    ?>

     </div>
  
</div>
<div>
   <?php
    wp_reset_postdata();
    return ob_get_clean();
}