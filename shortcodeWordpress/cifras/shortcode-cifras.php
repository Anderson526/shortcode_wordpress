<?php
/**
 * File:
 * 
 *  Creación del ShortCode para añadir cifras
 * 
 * @package 
 * @subpackage 
 * @since 
 */

function ESD_cifras_shortcode($atts, $content = null){
ob_start();
$args = array(
'post_type' => array('cifra'),
'post_status' => array('Publish'),
'posts_per_page' => 4,
'nopaging' => true,
'order' => 'ASC',
'orderby' => 'date',
);
$query = new WP_Query($args);
?>


<section class="torrente">
<div class="container">
<div class="row text-center">
	<?php if ($query->have_posts()):
		$cont = 0;
		$item_limit = 4;
		while ($query->have_posts() && $cont < $item_limit):
			$query->the_post(); ?>
			<div class="col-6 col-md-3">
				<div class="counter ocultarcifra">
					<?php if (has_post_thumbnail()): ?><img class="ico-contador"
							src="<?php the_post_thumbnail_url(); ?>" alt="Gráfica alusiva a <?php the_title(); ?>"><?php endif; ?>
					<div class="count-title"
						data-to="<?php echo esc_attr(get_post_meta(get_the_ID(), 'campo-cifras', true)); ?>"
						data-speed="9" data-interval="1">0</div>

					<div class="">
						<p class="count-text">
							<?php the_title(); ?>
						</p>
						<div class="mas-aliado btn-lg"></div>
					</div>


				</div>
			</div>
			<?php $cont++;
		endwhile; ?>
	<?php else: ?>
		<p>
			<?php esc_html_e('Lo sentimos, Actualmente no existen cifras'); ?>
		</p>
	<?php endif; ?>
</div>
</div>

</section>


<?php
wp_reset_postdata();
return ob_get_clean();
}
add_shortcode('cifrasesd', 'ESD_cifras_shortcode');