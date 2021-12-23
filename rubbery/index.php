<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_uri() ); ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/fonts/stylesheet.css" type="text/css" />
    <title><?php wp_title( '|', true, 'right' ) ?></title>
    <?php wp_head(); ?>
</head>
<body>
<h1><?php bloginfo( 'name' ); ?></h1>
<h2><?php bloginfo( 'description' ); ?></h2>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="post">
    <h3> <?php the_title() ?> </h3>
    <?php the_content(); ?>
</div>

<?php wp_link_pages(); ?>
<?php edit_post_link(); ?>

<?php endwhile; ?>
<?php posts_nav_link() ?>
<?php endif ?>
<canvas id="poetry" ></canvas>
<?php wp_footer(); ?>
</body>
</html>