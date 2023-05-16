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
define( 'DB_NAME', 'fashion' );

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
define( 'AUTH_KEY',         '55M[V?n3>k=V6NcjmNCqdj^,Nw]i8Hwd23pljDuAH2N,Xxcbil?VLi/?]qVOYM>z' );
define( 'SECURE_AUTH_KEY',  'F+Eb?:0d:rx-PO#Vu=!^#d-{]Ujb}u}EZ3[?J-g|@IS7_O33KKzZ9_,!Tu~q#f}(' );
define( 'LOGGED_IN_KEY',    '2}+6,HRR(P]>c@5v,0=A;x,_gJ?V)[ux5#OkkOj`:Ff3iSAYFtpHI}3(%9++~Tgd' );
define( 'NONCE_KEY',        'Xkf*c NA2SfHe[DO`@ fIykZ:BlU:e=2H72YUTmc/c7B)d70p?}+=2navTEoeXox' );
define( 'AUTH_SALT',        '>Tc?j?-?fRD5Bt=87}SIYo1Cv8h:]gNdmvTx}ol6`e.dziQvE/,4]F)xU=l6YN*D' );
define( 'SECURE_AUTH_SALT', ',m~P=V(<rN$v3jxQOx-B8jy;?97?po)|jk2NSqChjUMEy)G/D9L;c7&p:%IAfrPM' );
define( 'LOGGED_IN_SALT',   'i_.SC4XeUE)luq>q~Y7LOLk4L_N}KMz-BX3*5geMTvw;/m/D}1!sf`MASn5hWj71' );
define( 'NONCE_SALT',       '-94?K>zBk;98p=f=e9=!#]XHf=8~O`6.aM cLXi861v?CkQVV8Hj*m{.SF31b P&' );

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
