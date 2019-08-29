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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'host_emmacustom');

/** MySQL database username */
define('DB_USER', 'host_emmacustom');

/** MySQL database password */
define('DB_PASSWORD', '2ZASZr5f9Af5nhjy');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'W=@u@Hyu{|98L9i;kWn=7M>9>!|AfKCz.;<x4Pl4~OPwrJjR49M{O]%25?IowRkh');
define('SECURE_AUTH_KEY',  '>rjMkAl*[>G$RA(`{kubM@!IlWFV#f6*95b_%O8ER;2b/_g!NxHNf>P.T`z*FN0t');
define('LOGGED_IN_KEY',    'uAad$61QU}u10HM+N?>*a)r[S66-|wN3]41(6Loy{>sPA;O >>`@ZJ|KjGV7D(=<');
define('NONCE_KEY',        'c|o7L?U[foK}:A]saz^3G#IixBLN,< &JE|bL/T1*<oHZ5QoVztUaV_/#)~?Q&@b');
define('AUTH_SALT',        '$]O/0N8iSy}x*%Wq.=,mF8H;tj5/yTp(]?j+Bf]*D6y~YVSZhkT/i[Z<`t~E*%zX');
define('SECURE_AUTH_SALT', 'o?Fn$=!xZVE^{vdq<S1gD7}k*;&&C$RY N2F[<juh`x_~&I~V;RbI{#/=:DJp|dH');
define('LOGGED_IN_SALT',   'k*+8ej~k3Dk!i}uMCgtpH:7Ht]&>.DMN% &mT>9$u9EE.bw7$D`E`D]z=N3||{A>');
define('NONCE_SALT',       'xZi:j%>.nox`YxtofJeV|V]Q;j<pA]b.ePz6(_;jLMPwWu%UXwAVz#T2LUTxb/5s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
