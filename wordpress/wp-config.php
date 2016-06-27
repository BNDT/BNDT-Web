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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'G#kAwYPPAG~Q:,};9H{kUZ*3*@SQ(5V (U?Qh|N#0w2Cdx.lk(r`Fbxb[Q%Rp}Yu');
define('SECURE_AUTH_KEY',  'Wz0d8wQO8?05d6sw#[XRZ.oP-yd#=Q@{:oX5*i>/#=_h):<&w)Di!/W[:DnR!VDB');
define('LOGGED_IN_KEY',    ':+`|^NP#{L-3?r5[#YSnKh~^Oa{9Y[li8J}g(ur9QpjT`_);R2w$d2Ogb~oclYT1');
define('NONCE_KEY',        'Q8/ICUuZaZ$}.?EnrD&)j+.Yb9U&:^-|`&p9>XEo)n<<)BL>mt1b8:Pcl(I:?E*0');
define('AUTH_SALT',        's~L2@ELsc36(u>kMRAD?LHNSP5*w8Ck^H-}vpD_D_>ZX}>3 {N?mTT<]8/UV#io!');
define('SECURE_AUTH_SALT', 'nP=J9VE,c)4H!y_ZF]Q}Q,wfo[Y:$kTm1Bz+5+FRV1UGD0DynS=&y4^Z&a/V8K|3');
define('LOGGED_IN_SALT',   'zyNwq~8vBo*XSc$tXb/.uyx0lQK5?hoc!@l,b&?1O<{>No6XtjANZ.~L;NOI$K]^');
define('NONCE_SALT',       '=4*-X`a^AJu7$I}[[as|8)u4~])e>L1+IHCU[qaofYkf~<eRAPAw8%<yY.=|LQ7-');

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
