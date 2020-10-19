<?php
/*
Template Name: Цены
*/
?>
<?php get_header(); ?>
<section class="price_list block">
    <div class="cont">

        <div class="block_head">
            <h1 class="title"><?php the_title(); ?></h1>
        </div>

        <div class="list accordion">
            <?php $k=0; if( have_rows('prices') ): ?>
            <?php while( have_rows('prices') ): the_row(); $k++;
                $title = get_sub_field('title');  
                $table = get_sub_field('table');                   
            ?>       
            <div class="item">
                <div class="head">
                    <div class="title"><?php echo $title; ?></div>
                    <div class="icon"></div>
                </div>

                <div class="data">
                    <div class="table_wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Услуга</th>
                                    <th>Трудозатраты</th>
                                    <th>Стоимость</th>
                                </tr>
                            </thead>

                            <tbody>                               
                                <?php foreach ($table as $value) { ?> 
                                <tr>
                                    <td><?php echo $value["name"]; ?></td>
                                    <td><?php echo $value["time"]; ?></td>
                                    <td><?php echo $value["price"]; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php endif; ?>


        </div>

    </div>
</section>

<?php get_template_part( 'block_order' );  ?>  
<?php get_footer(); ?>
