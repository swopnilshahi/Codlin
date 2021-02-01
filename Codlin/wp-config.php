<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'codlin' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'b1<m;S3Hg[%$EBlWvzu6vYFl/faU-l6XjPaOw5~P?y*HO}`^.5*@?N)A7R,K$}%u' );
define( 'SECURE_AUTH_KEY',  'G(QgoG,~9SH[4m9R$;M6C?^76G=D~:qb#Kv?xbMI65~c1k ,;^1(8X^<Jf~5#ezw' );
define( 'LOGGED_IN_KEY',    '66vWGWR.;=vX;O$)wT33_Zi&}3QiFT ;B5AmqiWQO#4BG3f-vP4CDi5h4@!?jM ,' );
define( 'NONCE_KEY',        'u)f3,Iu0Q|!.A(+30W&uWQgyQC#P4M)]H#T ]l(n2}(}tK44%-nf6U} BUF4-a*u' );
define( 'AUTH_SALT',        '4>kfLE3e?=BY^ M/NX:zT9oglDBALZVE6e:*iYl&nS^nSXLrPxb%w&rJZTO:Bg59' );
define( 'SECURE_AUTH_SALT', '%)][s4NqSRSd~qD(J~^Ou%?_e1rsYeTEg_p}kouLNZRr<z.:}=j/U,:}<s+ *5mV' );
define( 'LOGGED_IN_SALT',   ')b0/m]f2cs|D,J=CPMlps#^O+Y#LT)Z6(EC@Q`YsGj,>,r !~@EncTHX=s2+SD-W' );
define( 'NONCE_SALT',       '_0@(*/mDBgaige|f0v;OqxpP,aOOz R%||Xiq9H_IF9,f|vWu5=tP]f,&NO$T1O9' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
