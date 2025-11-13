<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'pixl2026' );

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
define( 'AUTH_KEY',         '.OF|EtX_K9?Y,`yQ=8djqLu0q!`d7!RtN]b<1|d{RaEbZL,jJ=4I^cWxW!u.lh`.' );
define( 'SECURE_AUTH_KEY',  '>TJ.I<nBX|!di,qd98>#o^espJxZS>)oULZ+OUb`[IlLg+XCVK_r#b,+#@SNA*X0' );
define( 'LOGGED_IN_KEY',    '2I@UfFQzsq; &N)r_)p9`sCz]:atMV64KKJ)-7ACH(<wJ1:7Mpo~8+|.NtFvT{rO' );
define( 'NONCE_KEY',        ',X@H[FjF,=9_v(E}y5-:q@SC?qfV;SRKm!Ba:Iay?:U/Pb?U|Y{i%$ntvVYU`oP5' );
define( 'AUTH_SALT',        '*Kr}JxEdbhRhwwzKtb0EzUs1YXlAk}KdG9>bzbq/`Ua>4Xejf-;b-s_ubpk|8 @=' );
define( 'SECURE_AUTH_SALT', '1c~<JpClj/mk%JeQH.4!d0zDk|_cG<@Fdv[<H>H;48QVW^1[4(J[UI%L&/-|mjX/' );
define( 'LOGGED_IN_SALT',   '9=tIQC<8$^__|7PIM%5%6:>>?:GRx-&DA&z~FpjZCPY=L}dELD$*5wp r:4FIv%S' );
define( 'NONCE_SALT',       'WXk0[7F7E((I@ecE7s0RIxzQ:v?gQqW2!wVaMO$h,-;`RjUUsc1`x3A<bXy5u@Ks' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'pxl_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
