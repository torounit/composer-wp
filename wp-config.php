<?php

// ** MySQL settings - You can get this info from your web host ** //
$db_data = false;

function load_config() {
	if ( file_exists( dirname( __FILE__ ) . '/config.json' ) ) {
		$config = json_decode( file_get_contents( dirname( __FILE__ ) . '/config.json' ), true );

		return $config['mysql'];
	}
}

$db_data = load_config();

/** The name of the database for WordPress */
define( 'DB_NAME', $db_data['database'] );

/** MySQL database username */
define( 'DB_USER', $db_data['username'] );

/** MySQL database password */
define( 'DB_PASSWORD', $db_data['password'] );

/** MySQL hostname */
define( 'DB_HOST', $db_data['host'] );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY', 'D8]uAE{5QY,`El_XI Nd%+H+GB*<JVz1.}m|snEFsKr/$|Si}VA7+XM{5gb6gg4a' );
define( 'SECURE_AUTH_KEY', '}s1|Nb6dU_otu6nTH1I>T--utros|hGOk5tR$w?.kkq~:rKg]GyV/>TTveYVq.Bg' );
define( 'LOGGED_IN_KEY', 'Y=y/RUYQdeyU|I:X*1]W!Nux(UZ5fa#re~H)9-R6h%D>;/^HXpEdmLdCDPg-TGP:' );
define( 'NONCE_KEY', '+`ePw/c]]q-YOG,-1vP&bZ-jWi (^|J<3 ]J|]^?J!_6>aE)[[N|sPgtyV.Vv%Zi' );
define( 'AUTH_SALT', 'W274h(Z},>qX}~pWY;25!5F[dCySEnTzRQn}kYu7WH5F6z|(Vh!seK}BO(d2|[|V' );
define( 'SECURE_AUTH_SALT', 'FJ*A/1o&[#yTCMj&xFexN8cx|xjDV+4RJd-J;p_KNFo/g>+r+Ox0?k+jU?!O:O}k' );
define( 'LOGGED_IN_SALT', 'AdiyXH8b?A^ZFZ#72w2Z%GC+Qw+.|tY-k5}qUMEPuD+%/1|8bwid+6Q9Ge>ocxJ#' );
define( 'NONCE_SALT', 'gbVg(S9cUw>Y>|{)YN)ilU]8FCS4De9e+kcV]eJGA-l{Xx.& S>`K|x$G8W9h|(4' );


$table_prefix = 'wp_';


define( 'JETPACK_DEV_DEBUG', true );
define( 'WP_DEBUG', true );
define( 'WP_SITEURL', 'http://127.0.0.1:8080/wp');
define( 'WP_HOME', 'http://127.0.0.1:8080');
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
define( 'WP_CONTENT_URL', 'http://127.0.0.1:8080/wp-content' );


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
