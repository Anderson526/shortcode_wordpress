<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 * 
 * IMPORTANTE !!
 * esto debe ser incluido en la carpeta inc/
 * @package Escuela_Seguridad_Digital
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function esd_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'esd_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function esd_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'esd_pingback_header' );

/**
 * Modifica el codigo HTML por defecto para el menu del pie del sitio web
 *
 */


/*Experimental metatag*/

function esd_meta_tags() {
	global $post;
	$post_type = $post->post_type;
	$post_title = $post->post_title;
	$post_desc = strip_tags( $post->post_content );
	$post_desc = strip_shortcodes( $post_desc );
	$post_desc = wp_strip_all_tags($post_desc);
    $post_desc = str_replace( array("\n", "\r", "\t"), ' ', $post_desc );
	$post_desc = mb_substr( $post_desc, 0, 300, 'utf8' );

	if ( has_post_thumbnail() ) : 
		$post_image = get_the_post_thumbnail_url(); 
	else: 
		$post_image = '/wp-content/uploads/2023/06/EscuelaSeguridadDigital@2x.png'; 
	endif;
	echo '<meta charset="'.get_bloginfo("charset").'">' . "\n";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
	if ( is_page() || is_singular() ) {
		echo '<meta property="description" content="' . get_bloginfo( "description" ) . '" />' . "\n";
	}
	if ( is_single() ) {
		echo '<meta property="description" content="' . $post_desc  . '" />' . "\n";
	}
	echo '<meta name="subject" content="Facilitamos el acercamiento de las organizaciones de la sociedad civil hacia una cultura de seguridad digital." />' . "\n";
	echo '<meta name="Classification" content="Non-profit organization" />' . "\n";  
	echo '<meta name="Language" content="' . get_bloginfo( "language" ) . '">' . "\n";   
	echo '<meta name="Owner" content="' . get_bloginfo( "name" ) . ' ' . get_bloginfo( "url" ) .'">' . "\n";
	echo '<meta name="Author" content="' . get_bloginfo( "name" ) . '" />' . "\n";
	echo '<meta name="copyright" content="' . get_bloginfo( "name" ) . ' ' . get_bloginfo( "url" ) .'">' . "\n";
	echo '<meta name="reply-to" content="info@escueladeseguridad.co">' . "\n";
	echo '<meta name="url" content="' . get_bloginfo( "url" ) . '">' . "\n";
	echo '<meta name="identifier-URL" content="' . get_bloginfo( "url" ) . '">' . "\n";
	echo '<meta name="Robots" content="index, follow">' . "\n";
	echo '<meta name="Distribution" content="GLOBAL">' . "\n";
	echo '<meta name="rating" content="GENERAL">' . "\n";
	echo '<meta name="coverage" content="Worldwide">' . "\n";
	echo '<meta name="directory" content="submission">' . "\n";
	echo '<meta name="resource-type" content="document">' . "\n";
	echo '<meta name="revisit-after" content="20 Days">' . "\n";
	echo '<meta name="MSSmartTagsPreventParsing" content="TRUE">' . "\n";
	echo '<meta name="theme-color" content="#D74B3F" />' . "\n";
	echo '<meta name="apple-mobile-web-app-status-bar-style" content="#009999">' . "\n";
	echo '<meta name="msapplication-navbutton-color" content="#009999">' . "\n"; 
	echo '<meta name="geo.region" content="CO-BO">' . "\n";
	echo '<meta name="geo.placename" content="BOGOTA">' . "\n";
	echo '<meta name="geo.position" content="4.59,-74.07">' . "\n";
	echo '<meta name="og:title" content="'. $post_title .'">' . "\n";
	echo '<meta name="og:type" content="'. $post_type .'">' . "\n";
	echo '<meta property="og:url" content="'. get_permalink() .'" />' . "\n";
	echo '<meta property="og:image" content="'. $post_image. '" />' . "\n";
	echo '<meta property="og:site_name" content="' . get_bloginfo( "name" ) . '" />' . "\n";
	if ( is_page() || is_singular() ) {
		echo '<meta property="og:description" content="' . get_bloginfo( "description" ) . '" />' . "\n";
	}
	if ( is_single() ) {
		echo '<meta property="og:description" content="' . $post_desc  . '" />' . "\n";
	}

	echo '<meta property="og:country-name" content="Colombia">' . "\n";
	echo '<meta property="og:email" content="info@escueladeseguridaddigital.co/">' . "\n";
	echo '<meta property="og:phonenumber" content="+57 315 2585596">' . "\n";
	echo '<meta property="og:region" content="CO-BO">' . "\n";
	echo '<meta property="og:locale" content="es_CO" />' . "\n";
	echo '<meta property="og:locale:alternate" content="es_CO"/>' . "\n";
	echo '<meta property="og:latitude" content="4.59">' . "\n";
	echo '<meta property="og:longitude" content="-74.07">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com">' . "\n";

}
add_action( 'wp_head', 'esd_meta_tags', 0);




/* cambio 18 julio 2023 MDBB */

function migas_de_pan() {
if ( !is_front_page() ) {
//$permalink = esc_url(get_permalink());
$post_type = get_query_var( 'post_type' );
$fulltext = is_single();
echo '<div class="row migas">' . "\n";
echo '<div class="col">' . "\n";
echo '<div class="container">' . "\n";
echo '<nav aria-label="breadcrumb">' . "\n";
echo '<ol class="breadcrumb">' . "\n";
echo '<li class="breadcrumb-item"><a href="';
echo get_option('home');
echo '">';
echo 'Inicio';
//echo is_single();
echo "</a></li>" . "\n";
if($fulltext == 1 && $post_type == "esdenlosmedios"){
echo '<li class="breadcrumb-item"><a href="/esd-en-los-medios/">ESD en los medios</a></li>' . "\n";
}else if($fulltext == 1 && $post_type == "servicepost"){
echo '<li class="breadcrumb-item"><a href="/servicios/">Servicios</a></li>' . "\n";	
}else if ($fulltext == 1 && $post_type == ""){
echo '<li class="breadcrumb-item"><a href="/novedades/">Novedades</a></li>' . "\n";		
}
if ( is_single() || ( is_home() && ! is_front_page() ) || ( is_page() && ! is_front_page() ) ) {
$title = single_post_title( '', false );
echo '<li class="breadcrumb-item active">'.$title.'</li>' . "\n";	
}

if ( is_post_type_archive() ) {
$post_type = get_query_var( 'post_type' );
if ( is_array( $post_type ) ) {
$post_type = reset( $post_type );
}
$post_type_object = get_post_type_object( $post_type );
if ( ! $post_type_object->has_archive ) {
$title = post_type_archive_title( '', false );
echo '<li class="breadcrumb-item active">'.$title.'</li>' . "\n";
}
}

if ( is_post_type_archive() && $post_type_object->has_archive ) {
$title = post_type_archive_title( '', false );
echo '<li class="breadcrumb-item active">'.$title.'</li>' . "\n";

}

if ( is_search() ) {
$title = sprintf( __( 'Resultados de busqueda %1$s %2$s' ), $t_sep, strip_tags( $search ) );
echo '<li class="breadcrumb-item active">'.$title.'</li>' . "\n";

}

if ( is_404() ) {
$title = __( 'Pagina no encontrada' );
echo '<li class="breadcrumb-item active">'.$title.'</li>' . "\n";
}

elseif (is_tag()) {single_tag_title();}
elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>' . "\n";}
elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>' . "\n";}
elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>' . "\n";}
elseif (is_author()) {echo"<li>Author Archive"; echo'</li>' . "\n";}
elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>' . "\n";}
echo '</ol>' . "\n";
echo '</nav>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
echo '</div>' . "\n";
} 
}






//menu principal
class menu_principal_walker extends Walker_Nav_Menu {
function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
$title = $item->title;
$permalink = $item->url;
$output .= '<li class="nav-item">';
$output .= '<a href="' . $permalink . '" class="nav-link text-uppercase" title="Pulsa para consultar '. $title.'">';
$output .= $title;
$output .= '</a>';
}
}


//menu footer
class menu_footer_walker extends Walker_Nav_Menu {
function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
$title = $item->title;
$permalink = $item->url;
$output .= '<li>';
$output .= '<a class="text-uppercase" href="' . $permalink . '"title="Pulsa para consultar '. $title.'">';
$output .= $title;
 $output .= '</a>';
}
}


//redes
class menu_redes_walker extends Walker_Nav_Menu {
function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
$title = $item->title;
$permalink = $item->url;
$output .= '<div class="'.$title. ' ">';				
$output .= '<a href="' . $permalink . '" class="nav-link" title="Pulsa para consultar '.$title.'" target="_blank"></a>';
$output .= '</div>';
}
}