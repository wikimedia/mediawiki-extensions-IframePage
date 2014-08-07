<?php

class SpecialIframePage extends SpecialPage {

	function __construct() {
		parent::__construct( 'IframePage' );
	}

	//$srcName is expected to be a key in the $wgifSrc array. It is set by navigating to a subpage of this special page.
	//If set, it will be used as the Page Title.
	function execute( $srcName ) {
		global $wgIframePageSrc, $wgIframePageAllowPath;
		$request = $this->getRequest();
		$output = $this->getOutput();
		$output->addModules( 'ext.IframePage' );
		$this->setHeaders();

		$path = $request->getVal( 'path' );

		if ( !isset( $wgIframePageSrc ) ) {
			throw new ErrorPageError( 'errorpagetitle', 'iframepage-error-wgifsrc' );
		}

		$srcName = $name = str_replace( '_', ' ', urldecode( $srcName ) );

		if ( isset( $wgIframePageSrc[$srcName] ) ) {
			$src = $wgIframePageSrc[$srcName];
		} else {
			//Default to first key/value pair of array
			$srcName = key( $wgIframePageSrc );
			$src = reset( $wgIframePageSrc );
		}

		if ( $wgIframePageAllowPath && isset( $path ) ) {
			$src .= $path;
		}

		//User can set $wgifSrc without a key. If so, we don't want the page title to be '0'
		if ( $srcName != '0' ) {
			//Do users always want this to be the page title?
			/** @todo This should really be an i18n msg key. But that's not so simple. */
			$output->setPageTitle( $srcName );
		}

		$html = Html::openElement( 'div', array( 'id' => 'iframeframe' ) );
		$html .= Html::element( 'iframe',
				array( 'id' => "iframe-$srcName",
				'src' => $src,
				'frameborder' => '0',
				'width' => '100%',
				'height' => '100%'
				)
		);
		$html .= Html::closeElement( 'div' );

		$output->addHTML( $html );
	}

	protected function getGroupName() {
		return 'other';
	}
}
