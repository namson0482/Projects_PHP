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
define('AUTH_KEY',         'qCyr1 V^I-OG577 sa&m|OcYM$H%Qvf]{e}DcY+ckJzT..RNTGhIRF<</] M8[;(');
define('SECURE_AUTH_KEY',  '7G>@U9=3^g~z_A/`lMXMZlP|g]W$(bm,ImYD s~yz`}{M`bLC)(U:10L<u,W//bM');
define('LOGGED_IN_KEY',    '4UTj[I|W_LElWyaRC67F2tCaf[_9~[ W,>hEi9D1YtxY?{Jmtm?n}%D{}#sd(|Cj');
define('NONCE_KEY',        'a<:4`JaN=+ku(.!+3tIz1huWp;^TFD~L`ch&YB(|ys@Bl^|~;O/Bx}]IKt-}ioye');
define('AUTH_SALT',        'Dfi4n.1^dH`j$DbUPY(wg.-YvBYnBz5R$z{-gYHEgR`R@KO-EQ-9<*L=!B%qPhD[');
define('SECURE_AUTH_SALT', '@.ETYv5hm^8$m(]N[G>6V+eakwgD6_9wk%,?y!AN2R:g^Htfu]T P-CHq|B:YG:0');
define('LOGGED_IN_SALT',   'xaC2fTc1e{p#3Ol^t=o]q2<e=pi?S_+~`UwKjmN%ww-:Po(WFTQJ&+p.$U`WJE`Q');
define('NONCE_SALT',       'j*`a!`xc|]KK^)m%W7xTN4E21e<W_wd|5 `U~z~3!r0ej!2}F7xF}mztRhfLh3im');

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
