<?php
/*
Template Name: Главная
*/
?>
<?php get_header(); ?>

<section class="main_slider">
    <div class="slider owl-carousel">
        <div class="slide">
            <div class="cont">

                <div class="info">
                    <div class="title"><?php the_field("title_1"); ?></div>

                    <div class="sub_title"><?php the_field("subtitle_1"); ?></div>

                    <div class="desc"><?php the_field("desc"); ?></div>

                    <a href="<?php the_field("link_1"); ?>" class="btn"><?php the_field("text_button_1"); ?></a>
                </div>

            </div>

            <div class="bg lozad" data-background-image="<?php the_field("photo_1"); ?>"></div>
        </div>


        <div class="slide">
            <div class="cont">

                <div class="info">
                    <div class="title"><?php the_field("title_2"); ?></div>

                    <div class="pluses">
                        <?php $k=0; if( have_rows('pluses') ): ?>
                        <?php while( have_rows('pluses') ): the_row(); $k++;
                            $plus = get_sub_field('plus');                
                        ?>
                        <div><?php echo $plus; ?></div>                          
                        <?php endwhile; ?>
                        <?php endif; ?>

                    </div>

                    <a href="<?php the_field("link_2"); ?>" class="btn"><?php the_field("text_button_2"); ?></a>
                </div>

            </div>

            <div class="bg lozad" data-background-image="<?php the_field("photo_2"); ?>"></div>
        </div>


        <div class="slide">
            <div class="cont">

                <div class="info">
                    <div class="title"><?php the_field("title_3"); ?></div>

                    <div class="desc"><?php the_field("desc_3"); ?></div>

                    <a href="<?php the_field("link_3"); ?>" class="btn"><?php the_field("text_button_3"); ?></a>
                </div>

            </div>

            <div class="bg lozad" data-background-image="<?php the_field("photo_3"); ?>"></div>
        </div>
    </div>
</section>


<section class="welcome block">
    <div class="cont row">

        <div class="block_head">
            <div class="title"><?php the_field("title_4"); ?></div>

            <div class="desc text_block">
                <?php the_field("desc_4"); ?>
            </div>

            <button class="btn modal_link" data-content="#callback_modal">Заказать звонок</button>
        </div>


        <div class="img">
            <img data-src="<?php the_field("photo_4"); ?>" alt="" class="lozad">
        </div>


        <div class="advantages">
            <div class="row">
                <?php $k=0; if( have_rows('advantages') ): ?>
                <?php while( have_rows('advantages') ): the_row(); $k++;
                    $name = get_sub_field('title');     
                    $desc = get_sub_field('desc');                  
                ?>
                    <div class="item">
                        <div class="icon icon<?php echo $k; ?>">
                            <img data-src="<?php bloginfo('template_url'); ?>/images/ic_advantage<?php echo $k; ?>.svg" alt="" class="lozad">
                        </div>
                        
                        <div class="name"><?php echo $name; ?></div>
                        <div class="desc"><?php echo $desc; ?></div>
                    </div>

                <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>


<section class="steps block bg">
    <div class="cont">

        <div class="block_head center">
            <div class="title"><?php the_field("title_5"); ?></div>
        </div>


        <div class="row">
            <?php $k=0; if( have_rows('etap') ): ?>
            <?php while( have_rows('etap') ): the_row(); $k++;
                $name = get_sub_field('name');                
            ?>
                    <div class="step">
                        <div class="icon icon<?php echo $k; ?>">
                            <img data-src="<?php bloginfo('template_url'); ?>/images/ic_step<?php echo $k; ?>.svg" alt="" class="lozad">
                        </div>
                        <div class="desc"><?php echo $name; ?></div>
                    </div>

            <?php endwhile; ?>
            <?php endif; ?>

           
        </div>


        <div class="bottom">
            <img data-src="<?php the_field("photo_5"); ?>" alt="" class="lozad">

            <div class="desc text_block">
                <?php the_field("desc_5"); ?>
            </div>

            <a href="<?php the_field("link_5"); ?>" class="btn"><?php the_field("text_button_5"); ?></a>
        </div>

    </div>
</section>


<section class="devices block">
    <div class="cont">

        <div class="block_head center">
            <div class="title"><?php the_field("title_6"); ?></div>
        </div>

        <div class="row">
            <?php $k=0; if( have_rows('list') ): ?>
            <?php while( have_rows('list') ): the_row(); $k++;
                $title = get_sub_field('title');  
                $photo = get_sub_field('photo');                              
            ?>

            <a class="device">
                <div class="thumb">
                    <img data-src="<?php echo $photo; ?>" alt="" class="lozad">
                </div>
                <div class="name"><?php echo $title; ?></div>
            </a>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php get_template_part( 'block_order' );  ?>

  
<?php get_footer(); ?>
