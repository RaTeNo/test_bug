</div> 
    
            <footer>
                <div class="cont row">

                     <?php wp_nav_menu ( array ( 'theme_location'  => 'footer-menu',  
                        'menu'            => '',   
                        'container'       => '',   
                        'container_class' => '',   
                        'container_id'    => '',  
                        'menu_class'      => 'menu row',   
                        'menu_id'         => '',  
                        'echo'            => true,  
                        'fallback_cb'     => 'wp_page_menu',  
                        'before'          => '',  
                        'after'           => '',  
                        'link_before'     => '',  
                        'link_after'      => '',  
                        'depth'           => 0 ,
                        ) );  ?>


                    <div class="copyright">
                        <span>Powered by Syntes</span> Copyright &copy; 2020 Razer Inc. Все права защищены.
                    </div>


                    <div class="socials">
                        <a href="/" target="_blank" rel="noopener nofollow">
                            <img data-src="<?php bloginfo('template_url'); ?>/images/ic_soc_vk.png" alt="" class="lozad">
                        </a>

                        <a href="/" target="_blank" rel="noopener nofollow">
                            <img data-src="<?php bloginfo('template_url'); ?>/images/ic_soc_fb.png" alt="" class="lozad">
                        </a>

                        <a href="/" target="_blank" rel="noopener nofollow">
                            <img data-src="<?php bloginfo('template_url'); ?>/images/ic_soc_youtube.png" alt="" class="lozad">
                        </a>

                        <a href="/" target="_blank" rel="noopener nofollow">
                            <img data-src="<?php bloginfo('template_url'); ?>/images/ic_soc_insta.png" alt="" class="lozad">
                        </a>
                    </div>

                </div>
            </footer>


            <div class="overlay"></div>
        </div>


        <div class="supports_error">
            Ваш браузер устарел рекомендуем обновить его до последней версии<br> или использовать другой более современный.
        </div>


        <section class="modal" id="callback_modal">
            <div class="modal_title">Ваш телефон</div>

            <form action="" class="form custom_submit">
                <div class="line">
                    <div class="field">
                        <input type="tel" name="phone" value="" class="input required" placeholder="+7 ">
                    </div>
                </div>

                <div class="submit">
                    <button type="submit" class="submit_btn btn">Отправить</button>
                </div>
                <input type="hidden" value="Заказ с формы обратной связи" name="title">
            </form>
        </section>


        <section class="modal" id="success_modal">
            <div class="modal_title">Спасибо, ваша<br> заявка отправлена</div>

            <div class="text">Наш менеджер свяжется<br> с вами <b>в течении 15 минут</b></div>
        </section>




        <!-- Подключение javascript файлов -->
        <?php wp_footer(); ?>
        <script src="<?php bloginfo('template_url'); ?>/js/jquery-3.5.0.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/lozad.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/owl.carousel.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/inputmask.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/nice-select.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/fancybox.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/functions.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/js/scripts.js"></script>


        <?php the_field("counters", "option"); ?>
    </body>
</html>
        