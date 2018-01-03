<?php
/**
 * @package WPSEO\XML_Sitemaps
 */

if ( ! defined( 'WPSEO_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

// This is to prevent issues with New Relics stupid auto injection of code. It's ugly but I don't want
// to deal with support requests for other people's wrong code...
if ( extension_loaded( 'newrelic' ) && function_exists( 'newrelic_disable_autorum' ) ) {
	if ( ! defined( 'DONOTAUTORUM' ) ) {
		define( 'DONOTAUTORUM', true ); // Resolves conflict with W3TC's NR extension.
	}

	newrelic_disable_autorum();
}

$sitemap_xsl = new WPSEO_Sitemap_XSL();

// Echo so opening tag doesn't get confused for PHP. R.
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo $sitemap_xsl->generate();
