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
define('DB_NAME', 'beefab_site');

/** MySQL database username */
//define('DB_USER', 'beefab_site');
define('DB_USER', 'root');

/** MySQL database password */
//define('DB_PASSWORD', 'gh456rty');
define('DB_PASSWORD', 'gd9WhJ4KzOXR');

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
define('AUTH_KEY',         'x1VumDAK1244jXlwhMC5vXZBWFaa5eUWlBAJevKRreKWq9O21HSNQphuxfTYsoyE');
define('SECURE_AUTH_KEY',  'mTL8rqQi2DOCmgdS86hNYDYSssE9fmNJNYkpdjWVNhhWIyQB5xclXFJSfle50xtt');
define('LOGGED_IN_KEY',    '2oMoXATcDPN4PI2zv4JV1LEGD0725hMZ3HeRuy2cndOnn9I9Ps56nENrTTNntbOp');
define('NONCE_KEY',        'VqOdALlSm8ya1JgFOiadoxBx2rQW4SawPVGXlMbBw50HZXORgyHsBxhacCDrhxZZ');
define('AUTH_SALT',        'PkleqdKh3z1J7NCbKsRZNvkfG6ba7fPNwLkrquaI2aXlB9WRefCJDEj6A8w4Qc5G');
define('SECURE_AUTH_SALT', 'SDagDMdSJD7rhZjxBhOpGuaAISc6h8Iv0s1dZljZp603Ty9PgAyR7h6gNkzwRoiM');
define('LOGGED_IN_SALT',   'sgcUdedQyhHWGnSqIXtk1n47aQ3nVbygepXxuJXvnPJWfRV2cyhlnl5g1PUP1QMA');
define('NONCE_SALT',       'i2BKLq9pDG3YpXUIxdqwTLFuOWAER2e8gznPZw9C4tqWBNibTk9yC2Gldm0B8QTL');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
