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
define( 'DB_NAME', 'wordpress_tut' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'Nshammary1' );

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
define( 'AUTH_KEY',         ';owz+gu}c@I;$B,+jj1V2%_@DY#eO[~MCF0~,bl=u2v|~lRyM3}C1P0^;u!Uo}%j' );
define( 'SECURE_AUTH_KEY',  'Cvi%=kBctoN/_t({Wpds|U%=M5Sb-w91>8Zs@IlRCs0nkCah^oW6~3aJ`*H-$A2%' );
define( 'LOGGED_IN_KEY',    'e=;0Qf1w1O*FL}(-Hjz+rm9D~&= NC =X]:q2%V q~j<%=e^`gd&kNwnOJ!luUL[' );
define( 'NONCE_KEY',        '0A11-LY2}zJ@&n5?s;#c]a;5SJ!azwM$#SdaG?B@GpGUWeH4eREbOn]`W12NtszF' );
define( 'AUTH_SALT',        'ie_lWT>zI.)UUm)AMW>5[~9tTIuN-v!X=:f^a`seu.aaZ=[}3!u:ZkHr4tZE5:RO' );
define( 'SECURE_AUTH_SALT', 'N?_R=1`A>;H]C)y&Udvj1Dq18NN;_}GYPsJ?TebG5t&I*]He<X3*)[`13N0[G32q' );
define( 'LOGGED_IN_SALT',   'JW@!Tmj `wHc%JU[+h*9 B{sF?=mx/3ZmyEJTV`[!f[&yuT1Lb|:b<U..@p{X_0f' );
define( 'NONCE_SALT',       '*ZJb*iI{mqe;/wM)*%/D*<&^!bnZ7<DI#Vp`p+cE[,^[b!?Q5VR7#G*9ElU8p!am' );

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
