<?php
/*
Template Name: Гарантии
*/
?>
<?php get_header(); ?>

<section class="garanti_head">
    <div class="cont">

        <div class="info">
            <div class="title"><?php the_field("title"); ?></div>

            <div class="sub_title"><?php the_field("subtitle"); ?></div>

            <button class="btn modal_link" data-content="#callback_modal"><?php the_field("text_button"); ?></button> 

            <div class="exp"><?php the_field("subtitle_2"); ?></div>
        </div>

    </div>

    <div class="bg lozad" data-background-image="<?php the_field("foto"); ?>"></div>
</section>


<section class="garanti_info block">
    <div class="cont">

        <div class="row">
            <div class="item">
                <div class="icon icon1">
                    <img data-src="<?php bloginfo('template_url'); ?>/images/ic_garanti_info1.svg" alt="" class="lozad">
                </div>
                <div class="name"><?php the_field("prem1"); ?></div>
            </div>

            <div class="item">
                <div class="icon icon2">
                    <img data-src="<?php bloginfo('template_url'); ?>/images/ic_garanti_info2.svg" alt="" class="lozad">
                    <div class="val">2</div>
                </div>
                <div class="name"><?php the_field("prem2"); ?></div>
            </div>
        </div>


        <div class="bottom">
            <img data-src="<?php the_field("photo"); ?>" alt="" class="lozad">

            <div class="desc text_block">
                <?php the_field("desc"); ?>
            </div>

            <a href="<?php the_field("link_2"); ?>" class="btn"><?php the_field("text_button_2"); ?></a>
        </div>

    </div>
</section>



<?php get_template_part( 'block_sert' );  ?>
<?php get_template_part( 'block_order' );  ?>  
<?php get_footer(); ?>
