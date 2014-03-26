<?php

namespace Rystband\Config;

Class HybridConfig {

	function getConfig() {
	return 
		array(
			"base_url" => "http://testproject.rystband.com.local/socialauth/", 

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
					"keys"    => array ( "id" => "1421129754806837", "secret" => "d965985de6dd32aa1230c552d5025b8f" ),
					"trustForwarded" => false
				),

				"Twitter" => array ( 
					"enabled" => true,
					"keys"    => array ( "key" => "TLF2hcRb2agGUV90mWkVoA", "secret" => "qMfRR0lliO931QWEvyYKuT1qkIWHzBhzfjLeyxKX7A" ) 
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


