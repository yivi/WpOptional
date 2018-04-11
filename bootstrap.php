<?php

namespace Yivoff\Wp_Optional;

$version = '0.0.11';

class bootstrap_0_0_11
{

    public $version;

    public function __construct( $version )
    {
        $this->version = $version;
    }

    public function autoload( $class )
    {
        $dir = realpath( __FILE__ );
        if ( strpos( $class, __NAMESPACE__ ) !== false ) {
            $filename = $dir . DIRECTORY_SEPARATOR . str_replace( '\\', DIRECTORY_SEPARATOR, $class ) . '.php';
            if ( file_exists( $filename ) ) {
                require $filename;

            }
        }
    }
}

if ( isset( $GLOBALS['WP_OPTIONAL_LIBRARY_LOADER'] )
     && version_compare( $GLOBALS['WP_OPTIONAL_LIBRARY_LOADER']->version, $version )
) {
    spl_autoload_unregister( [$GLOBALS['WP_OPTIONAL_LIBRARY_LOADER'], 'autoload'] );

    $wp_optional_bootstrap                 = new bootstrap_0_0_11( $version );
    $GLOBALS['WP_OPTIONAL_LIBRARY_LOADER'] = $wp_optional_bootstrap;

    spl_autoload_register( [$wp_optional_bootstrap, 'autoload'] );
}