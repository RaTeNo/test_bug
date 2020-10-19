<?php get_header(); ?>
<section class="where_buy block tabs_container">
	<div class="cont">

		<div class="block_head">
			<div class="title"><?php single_cat_title(); ?></div>

			<div class="your_location">Ваше местоположение: <span>Russia</span></div>
		</div>


		<div class="text_block">
			<?php echo category_description(); ?>
		</div>


		<form action="" class="filter form">
			<div class="columns row">
				<div class="line width1of3">
					<div class="field">
						<input type="text" value="Россия" disabled>
					</div>
				</div>

				<div class="line width1of3">
					<div class="field">
						<input type="text" value="Вся техника" disabled>						
					</div>
				</div>

				<div class="line width1of3">
					<div class="field">
						<input type="text" value="Москва" disabled>						
					</div>
				</div>
			</div>
		</form>


		<div class="head">
			<div class="tabs">
				<button data-content="#where_buy_tab1" data-level="level1" class="active">Списов всех магазинов</button>
				<!-- <button data-content="#where_buy_tab2" data-level="level1">Интернет-магазины</button>
				<button data-content="#where_buy_tab3" data-level="level1">Карта</button> -->
			</div>

			<!-- <div class="sort">Сортировать по: <button>имени (А-Я)</button></div> -->
		</div>


		<div class="tab_content level1 active" id="where_buy_tab1">
			<div class="table_wrap">
				<table>
					<thead>
						<tr>
							<th>Название магазина</th>
							<th>Информация о магазине</th>
							<th>Виды продукции</th>
						</tr>
					</thead>

					<tbody>
						<?php $k=0;  if ( have_posts() ) : while ( have_posts() ) : the_post(); $k++;  ?>  
						<tr>
							<td class="name"><?php the_title(); ?></td>
							<td>
								<div class="location">
									<svg class="icon"><use xlink:href="<?php bloginfo('template_url'); ?>/images/sprite.svg#ic_location"></use></svg>
									<?php the_field("info"); ?>
								</div>

								<div class="site">
									<svg class="icon"><use xlink:href="<?php bloginfo('template_url'); ?>/images/sprite.svg#ic_site"></use></svg>
									<?php the_field("site"); ?>
								</div>
							</td>
							<td><?php the_field("type"); ?></td>
						</tr>
						<?php endwhile; else: ?><?php endif; ?>
					</tbody>
				</table>
			</div>

			<?php wp_corenavi(); ?>
		</div>


		<div class="tab_content level1" id="where_buy_tab2">

		</div>


		<div class="tab_content level1" id="where_buy_tab3">

		</div>

	</div>
</section>



<?php get_footer(); ?>

