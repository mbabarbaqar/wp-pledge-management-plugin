<?php
/* CLASSMAP: IGNORE */

/**
 * This provides backwards compatibility for any extensions that 
 * attempt to load the Hs_Upgrade class from here.
 *
 * @deprecated
 */

if ( class_exists( 'Hs_Upgrade' ) ) {
    return;
}

require_once( hspg()->get_path( 'includes' ) . 'upgrades/class-hs-upgrade.php' );