<?php
/**
 * File: LacigfCustomPostType/include/create-Agenda.php
 * 
 * 
 * @package Lacigf
 * @subpackage Lacigf
 * @since Lacigf V 1.0
 */

$labels = array(
    'name' => _x('Agenda', 'Post Type General Name', 'Lacigf'),
    'singular_name' => _x('Agenda', 'Post Type Singular Name', 'Lacigf'),
    'menu_name' => __('Agenda', 'Lacigf'),
    'name_admin_bar' => __('Agenda', 'Lacigf'),
    'archives' => __('Item Archives', 'Lacigf'),
    'attributes' => __('Item Attributes', 'Lacigf'),
    'parent_item_colon' => __('Parent Item:', 'Lacigf'),
    'all_items' => __('Todos los Agendas', 'Lacigf'),
    'add_new_item' => __('Añadir agenda', 'Lacigf'),
    'add_new' => __('Añadir agenda', 'Lacigf'),
    'new_item' => __('Nuevo agenda', 'Lacigf'),
    'edit_item' => __('Editar agenda', 'Lacigf'),
    'update_item' => __('Actualizar agenda', 'Lacigf'),
    'view_item' => __('Ver agenda', 'Lacigf'),
    'view_items' => __('Ver agenda', 'Lacigf'),
    'search_items' => __('Buscar agenda', 'Lacigf'),
    'not_found' => __('No se encontraron Agenda', 'Lacigf'),
    'not_found_in_trash' => __('No se encontraron Agenda en la papelera', 'Lacigf'),
    'featured_image' => __('Imagen destacada', 'Lacigf'),
    'set_featured_image' => __('Establecer imagen destacada', 'Lacigf'),
    'remove_featured_image' => __('Eliminar imagen destacada', 'Lacigf'),
    'use_featured_image' => __('Usar como imagen destacada', 'Lacigf'),
    'insert_into_item' => __('Insertar en Aliado', 'Lacigf'),
    'uploaded_to_this_item' => __('Subido en este Agenda', 'Lacigf'),
    'items_list' => __('Lista de Agenda', 'Lacigf'),
    'items_list_navigation' => __('Lista de navagación de los Agenda', 'Lacigf'),
    'filter_items_list' => __('Filtrar Agenda', 'Lacigf'),
);
$args = array(
    'label' => __('Agenda', 'Lacigf'),
    'description' => __('Agenda de Lacigf', 'Lacigf'),
    'labels' => $args,
    'supports' => array('title', 'page-attributes', 'thumbnail', 'excerpt'),
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 10,
    'menu_icon' => 'dashicons-admin-users',
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => false,
    'can_export' => true,
    'has_archive' => 'Agenda',
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'page',
    'show_in_rest' => true,
);
register_post_type('Agenda', $args);