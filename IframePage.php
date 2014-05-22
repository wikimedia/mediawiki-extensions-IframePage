<?php
# Alert the user that this is not a valid access point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/IframePage/IframePage.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits[ 'specialpage' ][] = array(
	'path' => __FILE__,
	'name' => 'IframePage',
	'author' => 'Ike Hecht for [//www.wikiworks.com WikiWorks]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:IframePage',
	'descriptionmsg' => 'iframepage-desc',
	'version' => '0.1',
);

# If set to true, users can set path= in the call to the special page. This will allow adding to the iframe path set by $wgifSrc in LocalSettings.
# There is a slight security risk in this in case the iframe source's server was compromised or something, so default to false.
# (Maybe there's an iframe "farm" out there where only some scripts are trustworthy.)
$wgifAllowPath = false;

$wgAutoloadClasses[ 'SpecialIframePage' ] = __DIR__ . '/SpecialIframePage.php';
$wgExtensionMessagesFiles[ 'IframePage' ] = __DIR__ . '/IframePage.i18n.php';
$wgExtensionMessagesFiles[ 'IframePageAlias' ] = __DIR__ . '/IframePage.alias.php';
$wgMessagesDirs[ 'IframePage' ] = __DIR__ . '/i18n';
$wgSpecialPages[ 'IframePage' ] = 'SpecialIframePage';

$wgResourceModules['ext.IframePage'] = array(
	'styles' => 'IframePage.css',
	'scripts' => 'IframePage.js',
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'IframePage',
);
