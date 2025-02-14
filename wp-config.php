<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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
define( 'DB_NAME', 'if0_37870873_wp11' );

/** Database username */
define( 'DB_USER', '37870873_6' );

/** Database password */
define( 'DB_PASSWORD', 'i@(Sa46G2p' );

/** Database hostname */
define( 'DB_HOST', 'sql203.byetcluster.com' );

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
define( 'AUTH_KEY',         'v83yrgnzacracsbwsuczcj3jrksyo11mocpejp7hqguwal9kjna0qgn4sqigxblc' );
define( 'SECURE_AUTH_KEY',  'irt0fpjyjy0wpcz11znvtw6rpne9h461nlnziknodwzbukps1rp8mr96i5owc7gg' );
define( 'LOGGED_IN_KEY',    'sj56vr4ixxfza5x7ucv7lzsgdfgsxoutaovizlnuudjnogfkrtdxacsxywlozme8' );
define( 'NONCE_KEY',        'z49cjnihmasvy7n6nvxm8mr26yy9thzlokbq26e4cmor8mksjpqoanfvlbbb7crc' );
define( 'AUTH_SALT',        'p54owczgnkqcooxii4ymnh71obewivdiwfjdc2stejmuy5yqm2gcdiytvyzbvvxc' );
define( 'SECURE_AUTH_SALT', 'dh0jajgpduhoysauwnk9kad83w4i561ska458qvzxs9sj8kyi6pum7xumneudu8r' );
define( 'LOGGED_IN_SALT',   'lg8pa1loxtwljzj02xeazidc1msa5k3dippmqgoypambol1mdlfzydcjm53ketqc' );
define( 'NONCE_SALT',       'n0qhn5ifapksvuk84cqs4lvohlff8tmf0x4hfodxcqzk2aublcn2bffgmrywilko' );

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
$table_prefix = 'wph8_';

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

@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
