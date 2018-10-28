<?php
/*
* Register Class
*/
defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );


if( !class_exists('MC_ACF_Editor_Blocks') ) {
    class MC_ACF_Editor_Blocks {

        function __construct() {
            add_action( 'acf/init', array( $this, 'mc_acf_register_blocks' ) );
            add_filter( 'acf/settings/save_json', array( $this, 'mc_acf_save_json' ) );
            add_filter( 'acf/settings/load_json', array( $this, 'mc_acf_json_load_point' ) );
        }

        public function mc_acf_register_blocks() {
            // check function exists
            if( function_exists('acf_register_block') ) {
                
                // register a testimonial block
                acf_register_block(array(
                    'name'              => 'testimonial',
                    'title'             => __('Testimonial'),
                    'description'       => __('A custom testimonial block.'),
                    'render_callback'   => array( $this, 'my_acf_block_render_callback' ),
                    'category'          => 'formatting',
                    'icon'              => 'admin-comments',
                    'keywords'          => array( 'testimonial', 'quote' ),
                ));
            }
        }

        public function my_acf_block_render_callback( $block ) {
            
            // convert name ("acf/testimonial") into path friendly slug ("testimonial")
            $slug = str_replace('acf/', '', $block['name']);

            // include a template part from within the "template-parts/block" folder
            if( file_exists( MC_ACF_EB . "/template-parts/block/content-{$slug}.php" ) ) {
                include( MC_ACF_EB . "/template-parts/block/content-{$slug}.php" );
            }
        }

        public function mc_acf_save_json( $path ) {
            // update path
            $path = MC_ACF_EB . 'acf-json';      
            // return
            return $path;
        }

        function mc_acf_json_load_point( $paths ) {
            // remove original path (optional)
            unset($paths[0]);
            // append path
            $paths[] = MC_ACF_EB . 'acf-json';
            // return
            return $paths;
        }
    }

    global $mc_acf_eb;
    
    if ( ! isset( $mc_acf_eb ) ) {

        $mc_acf_eb = new MC_ACF_Editor_Blocks();

    }
}