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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tussin' );

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
define( 'AUTH_KEY',         'e%w7H/=dI0=X;<&_<g1|,tF_4F>!*Qg_]zQE7J)n{yL9hi[:}T^8?r`7_S<^IPDn' );
define( 'SECURE_AUTH_KEY',  'YtidE+0Mh{W`_Fd|)x=WK=&LjvH`|[.Wkr%8Bpi`$&-i*kSfwqM[gJcU@*D9:+IH' );
define( 'LOGGED_IN_KEY',    'f5-)Gb:Dyo*Ogj8ZR|li[C}N2q?:`PEWpY)q^KZ0M9rZn~k&Wvm=eRznh}JhCOi~' );
define( 'NONCE_KEY',        'jhw^;JSRbLe$yw]ShsXy5^FZKRVM^)PPlS+P/!Qk|IZGV;egOp8iVQQ1ur|FkQq_' );
define( 'AUTH_SALT',        '|e&;h/YHj5gty@~D%6pAjK4zjYn?oU.l)U7eA2^)%$gCKB.{&^e=8SH xp(8tU:[' );
define( 'SECURE_AUTH_SALT', 'DrRo?`w^isrEO)>M~+:7DbL`LF:;X/0h&]CR#`_dJlV0NVF  !{0EF>*r9lFAnv7' );
define( 'LOGGED_IN_SALT',   'S+t|5Cx)@j@m)*{Uu@J;uSZ;./KjQ3_0C/~xy^xmILT<VvAHlv])F(c(ml@5S=tL' );
define( 'NONCE_SALT',       ']Kf/0-Ai9 QCO@|bAhIYbML_[_yF%Wnc*zrI:apKjg+U5]*obx_+5!g@I amMo{=' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
