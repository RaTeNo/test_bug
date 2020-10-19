<?php get_header(); ?>

<section class="text_page block">
    <div class="cont">

        <div class="block_head">
            <h1 class="title"><?php the_title(); ?></h1>
        </div>

        <div class="text_block">
            <?php  if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
            <?php the_content(); ?>
            <?php endwhile; endif?>
        </div>

        <a href="<?php the_permalink(57); ?>" class="btn">Узнать о гарантии моего устройства</a>

    </div>
</section>
<?php get_template_part( 'block_sert' );  ?>
<?php get_template_part( 'block_order' );  ?>

  
<?php get_footer(); ?>
