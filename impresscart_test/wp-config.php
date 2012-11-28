<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'gmsL8S^VR>{0fuoWJ([$+WzR_~hxle&L;&Wcf,40R1<7R2cnT51X1QH~5UQk*~TV');
define('SECURE_AUTH_KEY',  '>]5_W>*@]*p_2^m^bmA<)f,4{zLZEsu 1uLp*vCX3_RT UrYNC*JY$?0;%M.VeEs');
define('LOGGED_IN_KEY',    '>cn~]}HduELHZ*X}]^afBw=TK+3/`5[~uNN<#?cV0FQ-k7Iy-:%/%ho3;^;1afOZ');
define('NONCE_KEY',        'u,*zxpfs=Qc&,>m|W}p d:~ye3qIv9w96<B45N&eFqk2F>+ps[k^~X#[m7x^%$d+');
define('AUTH_SALT',        'H_vGQ6<zF{#%X?Wesl<u^O}~@_zoA+ [y3^+iY8EzzQ=3|5Pk2/wX2L78/{1_;&e');
define('SECURE_AUTH_SALT', '&|..5uaCvfm[p*&{QD9j>:pXJ[Gqxjl>R;Z3o4-kjP4Q>+:#FJ`Gjq);5=MJ[0.t');
define('LOGGED_IN_SALT',   'xoIJ5wILi|[NbP[a-nC&!ub}`ndVHohG]#Wx2[=8Xby-^]IivVSP#3Jbp^wm73Yv');
define('NONCE_SALT',       '2 I{25@k0@~%PXu<^j4ga7oHZuDnL/j}emB!3BF~rzD_PD}xzfE^7R~.u`?ylIX?');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
