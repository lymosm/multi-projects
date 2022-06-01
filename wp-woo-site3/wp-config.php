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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'woo3' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '^[v w61fPU 8|8g{onPzgVg:7`H^8q6$nx1QcM3 xBaXntp?Hlr;G/zbiOR!}spR' );
define( 'SECURE_AUTH_KEY',  '+ZVE[&F;&lBUXl>Pb4e<wYC5(?a^Wt_FIl$O2exz@5GK4.&d5h$C1KP2Th-LMB35' );
define( 'LOGGED_IN_KEY',    'dKc(Kzbg81r*f&t!RB5TYl:0&}Uar(XWfT0F!K5Eg}im6{q&5%V+%I}q<b~fVH{+' );
define( 'NONCE_KEY',        'JQLm2C+?;sS(OD9I72sS~@Z)l4hY8x{.nxBQ3v?/!jZR_fCl|DgBMx3#:BTB[-Nv' );
define( 'AUTH_SALT',        'X5plJ3?Eg){S[K}f*haoye9NO%a~J2DB[)~t*F.S9O#,42D!oHNHi1-v@}~#sGd|' );
define( 'SECURE_AUTH_SALT', 'jTaDiXG@86i&CZ[?Xq]<O]4i3Tq2}COBw9u ZO(68_F+^C[BQx94Dt?+4iBlVj*`' );
define( 'LOGGED_IN_SALT',   '_nxWf:@ldpH2$7Ld!*qKEQ.nggX}sc~Gn ^h)wiQL!z^0!QhpS= ,!>^d)>(htXo' );
define( 'NONCE_SALT',       'OZmP&DGbCY`TS&WTOtO1fg[G[PZYQwxJ[ HaH#z:Cu!)K%rRXiPc;`Se&w).K*Xl' );

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
