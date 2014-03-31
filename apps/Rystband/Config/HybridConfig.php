<?php

namespace Rystband\Config;

Class HybridConfig {

	function getConfig() {

	$f3 = \Base::instance();

	return 
		array(
			"base_url" =>  $f3->get('SCHEME') . "://" . $f3->get('HOST') . $f3->get('BASE'). "/attendee/social", 

			"providers" => array ( 
				// openid providers
				"OpenID" => array (
					"enabled" => true
				),

				"Yahoo" => array ( 
					"enabled" => true,
					"keys"    => array ( "id" => "", "secret" => "" ),
				),

				"AOL"  => array ( 
					"enabled" => true 
				),

				"Google" => array ( 
					"enabled" => true,
					"keys"    => array ( "id" => "", "secret" => "" ), 
				),

				"Facebook" => array ( 
					"enabled" => true,
					"keys"    => array ( "id" => "108795075865055", "secret" => "34bf0bfb1ede7a0f7cb5febf00c47ed0" ),
					"trustForwarded" => false
				),

				"Twitter" => array ( 
					"enabled" => true,
					"keys"    => array ( "key" => "QOW09CO0jKeCxFwiRMHuDA", "secret" => "bTeaho5QT81TnI0lqExVL3VuKTQs2bd3persK4yTMU" ) 
				),

				// windows live
				"Live" => array ( 
					"enabled" => true,
					"keys"    => array ( "id" => "", "secret" => "" ) 
				),

				"MySpace" => array ( 
					"enabled" => true,
					"keys"    => array ( "key" => "", "secret" => "" ) 
				),

				"LinkedIn" => array ( 
					"enabled" => true,
					"keys"    => array ( "key" => "", "secret" => "" ) 
				),

				"Foursquare" => array (
					"enabled" => true,
					"keys"    => array ( "id" => "", "secret" => "" ) 
				),
			),

			// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
			"debug_mode" => false,

			"debug_file" => "",
		);	
	}

}
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------


