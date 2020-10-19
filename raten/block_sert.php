<section class="certs block no_pad">
    <div class="cont">

        <div class="block_head center">
            <div class="title">Сертификаты производства</div>
        </div>

        <div class="slider owl-carousel">
            <?php 
                $images = get_field('sert', 'option');
                if( $images ): ?> <?php foreach( $images as $image ): ?>
                <div class="slide">
                    <a href="<?php echo esc_url($image['url']); ?>" class="item fancy_img" data-fancybox="certs">
                        <img data-src="<?php echo esc_url($image['url']); ?>" alt="" class="lozad">
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>
</section>