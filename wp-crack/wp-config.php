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
define( 'DB_NAME', 'wp_crack' );

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
define( 'AUTH_KEY',         'Z2?X;TQ<$+dD{Jwy!QG@x|xX;Ty*uA{8bt9!DQQ,R6C(al&6x%F=~+R;s/n{XKd`' );
define( 'SECURE_AUTH_KEY',  'HIgkD+OYG7gd{Sm.<-my1t9:~{~::GR`;j.?-nAjPf37-LIerqAWj8g!VLC!Q%6Z' );
define( 'LOGGED_IN_KEY',    '%S}pqqmakfq4&7B$k_go[Bo^@P#RC 3:l5dcg`ryN%.T=[{}3T-ggiXT$@)=&95;' );
define( 'NONCE_KEY',        '*05x<yJA~(ZNIHQ75=+j@S)?X~NKF@|P;(,/_Kp4~9(5bsj02Z)k0h,e^&sL|pU2' );
define( 'AUTH_SALT',        '(U2SL,{|M;aJMbAO|6e]]&9EMk72=[QvG]I(r%+`mJsisY/JzQ2@<b-0tXI#@JK5' );
define( 'SECURE_AUTH_SALT', 'l#56D#(H#Ie[b{r;hv;nS{7|~{{x0X8iNKp(fAW C}159/yy~zW213o~LoLCwXed' );
define( 'LOGGED_IN_SALT',   '*!6tj!{O] [^{c/:.Zr1jZ`mD/nz!b05MeN@rPfynJk$E.59JMngL@* 9I=iTXL-' );
define( 'NONCE_SALT',       '7Rh/d_}W_`%+<yMQnZ=6:7.m1TX6R-g~Wt2uB+/L(C}BhL3=k ;t1uDvws.lU8vs' );

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
