<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'woo1' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Riz{UXt)K0zwLPv8wD{f,D _%3iNX-a:s%<9#6X?|_%! >=@@qS]vLC5pglG;u+<' );
define( 'SECURE_AUTH_KEY',  'wpI6O},7m5v`ISLY<}ti X~yAwJpHb:>*b/wXa-ZrMiEcPV+IK:]HbU{f^o){Kvg' );
define( 'LOGGED_IN_KEY',    '?N#l_,_x%DHkv)qp/Z-<r rLS|mB,yUk^S5]JDEM)&S!2OxD[x^gh6_AL3Tv2Jp]' );
define( 'NONCE_KEY',        '#.n971`fLF%puc|`3~6=v2m~WLtmoMz@)k>hnjhbR-LUOnO.RC0Cql92HgX6+l V' );
define( 'AUTH_SALT',        'tQiW7nTI-Z/N$= FZTyXJ?N=,.R!mwFahNY N&fu@}N4!|X3mdK,{uX?Rjb7D,@x' );
define( 'SECURE_AUTH_SALT', '2&8AzLE {TF,~|D!7uhX,extb^hpFOT3|y}_g)!mQnYH9v}2V!1zk-=AZPrhFV|N' );
define( 'LOGGED_IN_SALT',   '].h@M$4sJz<]VH`;uB9UXX^K@TT@`%0.vleF/L06;P/rzuKX+n-FDI#N-%N=W$zc' );
define( 'NONCE_SALT',       '>8)`?~>}]!0p2|:48Xl&~vi*g;tiPn}@EX&_tA#Oy6yY:Ci)Y:L|3N.b58[3@Sbl' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
