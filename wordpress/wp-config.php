<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'test001');

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
define('AUTH_KEY',         '1e+$YK%:~(2scMm^2WJ|{*$cLUKpd;;c IC0Y%Kxirm ->Go:#+];M<j@x%B1Cyp');
define('SECURE_AUTH_KEY',  ':m>=fU62TM4)lwMn7cpiyp61)0obwKvQX aow5q-%#mcJ>mPw]`+(NBA4Lq|+*[8');
define('LOGGED_IN_KEY',    '3fgJ3XQ7d:>-wUJq,0t.NnApL}[;o:#}E,y42z&v7k|4+`dt:*Nwg`C6WkY@jL;f');
define('NONCE_KEY',        '{|0vbg%2NZB]c1OS7E7r`EdDjve)pD8Cv+#dODio}pe+}KLX$f0cxz;9{&vAc2HJ');
define('AUTH_SALT',        ',3tCY1:Z1IP/l7>U>Fb<>#5%P+-ctgA]:h/_PfM-.6!PU[|[Y~|yBUJIE41=Z~|+');
define('SECURE_AUTH_SALT', 'xQx=pNiFn3RR{&pIwOFql+|v[#S;+8OamNT5jv+ym:*vSX_(5Eg[Z_hp,d%|:|vU');
define('LOGGED_IN_SALT',   'M[apB`V[x*-=}QW~ h@A1$.NIGz+p==X/^XGAG!_r%sjHMe|1&:f.ntr{nHMB{nh');
define('NONCE_SALT',       'UZ*qxh9O*JjktfZsp%i5;LskOjwPXqV57NE+h$QQ`YFMZ}rQF=;5kqN>u4T2G_NZ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
