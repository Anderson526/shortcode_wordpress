<?php
/**
 * File: 
 * 
 * Línea del tiempo de impacto ESD
 * 
 * @package 
 * @subpackage 
 * @since 
 * modified by: Anderson Chila 
 */

function esd_historia_shortcode() {
    ob_start();
    
    $args = array(
        'post_type'         => array( 'historia' ),
        'post_status'       => array( 'publish' ),
        'posts_per_page'    => -1,
        'orderby'           => 'date',
        'order'             => 'ASC',
		'orderby' => 'menu_order',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        $opcionmenu = '';
        $opciondesc = '';
        while ($query->have_posts()) : $query->the_post();
			$index = $query->current_post + 1; 
            $title = esc_html(get_the_title());
            $content = apply_filters('the_content', get_the_content());
			$content2 = get_the_content();
	


// Utilizar echo para imprimir la cadena HTML
echo $content_timeline;
	
	
			$date = get_the_date('d/m/y');

            if ($index == 1) :
                $opcionmenu .= '<li><a href="#0" data-date="' . $date . '" class="cd-h-timeline__date cd-h-timeline__date--selected">' . $title . '</a></li>';
                $opciondesc .= '
                    <li class="cd-h-timeline__event cd-h-timeline__event--selected text-component">
                        <div class="cd-h-timeline__event-content container">
                            <h4 class="cd-h-timeline__event-title">Año - ' . $title . '</h4>
                            ' . $content2 . '
                        </div>
                    </li>';
            else :
                $opcionmenu .= '<li><a href="#0" data-date="' . $date . '" class="cd-h-timeline__date">' . $title . '</a></li>';
                $opciondesc .= '        
                    <li class="cd-h-timeline__event text-component">
                        <div class="cd-h-timeline__event-content container">
                            <h4 class="cd-h-timeline__event-title">Año - ' . $title . '</h4>
                            ' .  $content2 . '
                        </div>
                    </li>';
            endif;
        endwhile;
    
    ?>
</div>
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
     
		<div class="container-fluid historia">
			<div class="cd-h-timeline js-cd-h-timeline margin-bottom-md py-5">
				<div class="cd-h-timeline__container container">
					<h3 > Impacto</h3>
				</div>

    <section class="cd-h-timeline js-cd-h-timeline margin-bottom-md">
        <div class="cd-h-timeline__container container">
            <div class="cd-h-timeline__dates">
                <div class="cd-h-timeline__line">
                    <ol>
                        <?php echo $opcionmenu; ?>
                    </ol>
                    <span class="cd-h-timeline__filling-line" aria-hidden="true"></span>
                </div> <!-- .cd-h-timeline__line -->
            </div> <!-- .cd-h-timeline__dates -->
                
            <ul>
                <li><a href="#0" class="text-replace cd-h-timeline__navigation cd-h-timeline__navigation--prev cd-h-timeline__navigation--inactive">Prev</a></li>
                <li><a href="#0" class="text-replace cd-h-timeline__navigation cd-h-timeline__navigation--next">Next</a></li>
            </ul>
        </div> <!-- .cd-h-timeline__container -->

        <div class="cd-h-timeline__events">
            <ol>
                <?php echo $opciondesc; ?>
            </ol>
        </div> <!-- .cd-h-timeline__events -->
    </section>


    <?php endif;
    return ob_get_clean();
	    wp_reset_postdata();
}

add_shortcode( 'historiaTimeline', 'esd_historia_shortcode' );