<?php
define( 'WPCACHEHOME', 'E:\xampp\htdocs\noithatanbinh\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define( 'WP_CACHE', true );
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
define('DB_NAME', 'noithatanbinh');

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
define('AUTH_KEY',         '{?!KAJF8fUZb>P39pIvZT6D/l~uJzWK^J)mTf/?#Fxcxo>O&MuXPN`GxYe;!vr.T');
define('SECURE_AUTH_KEY',  'nm6yrrZyl*93pZtsWCHx5OA@fY?9=d&x48oU99^|_0mU27 c%!<P2}K,-/BeG~*L');
define('LOGGED_IN_KEY',    'BppcQMOq}No]rN4aq8-FZTCHp[-RZzz^UqO@)y*I~00!E4:;Srq~W*xngNWZe_(w');
define('NONCE_KEY',        'u(A.LxG<oproywjx0-P6PUy$.vOi7I+g8q`|nRL)/b^.#uM~{cu7A::fJnp7Kd!X');
define('AUTH_SALT',        '@N,/:<pB`N*l^!gCh_z,g+hu}*EnH/qQ3KnFPm iU{mYmsf]>f[}B:UbW.f.*/D)');
define('SECURE_AUTH_SALT', 'Bd2@lt*Z9mBDBvbRiV]0#gj@1h5+/iVA|=mRD^glqQvB/UtIuir-Mc(^^4j[@i;~');
define('LOGGED_IN_SALT',   'S9SJpTBA:QxcKVT1]EEa|iqoITv,wE8BmRQXY=(wmvYO~,IHTyh>7wWFqB5D|c6X');
define('NONCE_SALT',       'Xf68`]@*FP~vo4gUgh22c#Y!{K6k$B]~A<7$~Pe`toC~|%)%N)ou?Y_wj[fb%`Fw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ab_';

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
