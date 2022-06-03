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
define( 'DB_NAME', 'woo2' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '|>[{tlcOTv+<7J%,p=r[AB`=A!M8@(epUKufrgksaCf[L6r]&cIoHU7}3_9bw;TX' );
define( 'SECURE_AUTH_KEY',  'ns3N$];lx)Oj6[Wwr(Gxo`X9U=!yS(jpqBTjS3~#$d]L{;F=zB%[I<1!Q)/-JPfS' );
define( 'LOGGED_IN_KEY',    '4a@~eCS>NGZwLrLN&`FS0yPSO43Rx0ZW%L%c0y(B<`-hW6T^Yn{J8Rz:X[T9OuEj' );
define( 'NONCE_KEY',        'MAN&Imlo0Fhnpv@$zi/UtXKLBX,.F{)T:g%G<Xa0 6<3M[V}f:SW_qDxP&_4KF=y' );
define( 'AUTH_SALT',        'OEXpnQ X>d&i7S=}&*]IS;(nKpYSqJ-3Q2*Hv:&|CALzrS:k[kD;Gl2L3?%b*T,!' );
define( 'SECURE_AUTH_SALT', '(yQ)*i.CkEJzFXk|mLE@KKzk`[%6)rU.uN3 A~HtPAjKLPA{A+?(~Aiwm=Y0r#2G' );
define( 'LOGGED_IN_SALT',   'mZ^:*L5;|^{0A >S!7f%oRr~{WcmiY_&nUOK,))^o(Ic-uJn?5yBa0U@S/?,-)Pp' );
define( 'NONCE_SALT',       'o/^L-@nW`5lP&}PE%*)O{n~q4`<1,[%r5_Wn4+C![1XUY)N~Oe{w>3|E^iR!+,J%' );

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
