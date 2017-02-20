<?php
/**
 * An extension providing the Bootstrap library to other extensions
 *
 * @see      https://www.mediawiki.org/wiki/Extension:Bootstrap
 * @see      https://getbootstrap.com/
 *
 * @author   Stephan Gambke
 * @version  1.1.5
 *
 * @defgroup Bootstrap Bootstrap
 */

/**
 * The main file of the Bootstrap extension
 *
 * @copyright (C) 2013 - 2017, Stephan Gambke
 * @license       https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Bootstrap.
 * The Bootstrap extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Bootstrap extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup       Bootstrap
 *
 * @codeCoverageIgnore
 */
call_user_func( function () {

	if ( !defined( 'MEDIAWIKI' ) ) {
		die( 'This file is part of the MediaWiki extension Bootstrap, it is not a valid entry point.' );
	}

	if ( version_compare( $GLOBALS[ 'wgVersion' ], '1.22', 'lt' ) ) {
		die( '<b>Error:</b> This version of <a href="https://www.mediawiki.org/wiki/Extension:Bootstrap">Bootstrap</a> is only compatible with MediaWiki 1.22 or above. You need to upgrade MediaWiki first.' );
	}

	/**
	 * The extension version
	 */
	define( 'BS_VERSION', '2.0-alpha' );

	// register the extension
	$GLOBALS[ 'wgExtensionCredits' ][ 'other' ][ ] = array(
		'path'           => __FILE__,
		'name'           => 'Bootstrap',
		'author' => array( '[https://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]', 'James Hong Kong' ),
		'url'            => 'https://www.mediawiki.org/wiki/Extension:Bootstrap',
		'descriptionmsg' => 'bootstrap-desc',
		'version'        => BS_VERSION,
		'license-name'   => 'GPL-3.0+',
	);

	// register message files
	$GLOBALS[ 'wgMessagesDirs' ][ 'Bootstrap' ] = __DIR__ . '/i18n';
	$GLOBALS[ 'wgExtensionMessagesFiles' ][ 'Bootstrap' ] = __DIR__ . '/Bootstrap.i18n.php';

	$GLOBALS[ 'wgHooks' ][ 'SetupAfterCache' ][ ] = function() {

		$configuration = array();
		$configuration[ 'IP' ] = $GLOBALS[ 'IP' ];

		if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {

			include_once __DIR__ . '/vendor/autoload.php';

			$configuration[ 'localBasePath' ] = __DIR__;
			$configuration[ 'remoteBasePath' ] = $GLOBALS[ 'wgExtensionAssetsPath' ] . '/' . basename( __DIR__ ) ;

		} else {

			$configuration[ 'localBasePath' ] = $GLOBALS[ 'IP' ];
			$configuration[ 'remoteBasePath' ] = $GLOBALS[ 'wgScriptPath' ];

		}

		$configuration[ 'localBasePath' ] .= '/vendor/twbs/bootstrap';
		$configuration[ 'remoteBasePath' ] .= '/vendor/twbs/bootstrap';

		$setupAfterCache = new \Bootstrap\Hooks\SetupAfterCache( $configuration );
		$setupAfterCache->process();
	};

	// register skeleton resource module with the Resource Loader
	// do not add paths, globals are not set yet
	$GLOBALS[ 'wgResourceModules' ][ 'ext.bootstrap.styles' ] = array(
		'class'          => 'Bootstrap\ResourceLoaderBootstrapModule',
		'position'       => 'top',
		'styles'         => array(),
		'variables'      => array(),
		'dependencies'   => array(),
		'cachetriggers'   => array(
			'LocalSettings.php' => null,
			'composer.lock'     => null,
		),
	);

	$GLOBALS[ 'wgResourceModules' ][ 'ext.bootstrap.scripts' ] = array(
		'scripts'        => array(),
	);

	$GLOBALS[ 'wgResourceModules' ][ 'ext.bootstrap' ] = array(
		'dependencies' => array( 'ext.bootstrap.styles', 'ext.bootstrap.scripts' ),
	);

} );
