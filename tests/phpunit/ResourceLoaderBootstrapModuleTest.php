<?php

namespace Bootstrap\Tests;

use Bootstrap\ResourceLoaderBootstrapModule;

use HashBagOStuff;

/**
 * File holding the ResourceLoaderBootstrapModuleTest class
 *
 * @copyright (C) 2013-2017, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup       Bootstrap
 */

/**
 * @uses \Bootstrap\ResourceLoaderBootstrapModule
 *
 * @ingroup Test
 *
 * @group extension-bootstrap
 * @group mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class ResourceLoaderBootstrapModuleTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Bootstrap\ResourceLoaderBootstrapModule',
			new ResourceLoaderBootstrapModule()
		);
	}

	public function testGetStyles() {

		$resourceLoaderContext = $this->getMockBuilder( '\ResourceLoaderContext' )
			->disableOriginalConstructor()
			->getMock();

		$instance = new ResourceLoaderBootstrapModule;
		$instance->setCache( new HashBagOStuff );

		$this->assertArrayHasKey( 'all', $instance->getStyles( $resourceLoaderContext ) );
	}

	public function testGetStylesFromPresetCache() {

		$resourceLoaderContext = $this->getMockBuilder( '\ResourceLoaderContext' )
			->disableOriginalConstructor()
			->getMock();

		$cache = new HashBagOStuff;

		$cache->set(
			wfMemcKey( 'ext', 'bootstrap', $resourceLoaderContext->getHash() ),
			array(
				'storetime' => time(),
				'styles'    => 'foo'
			)
		);

		$instance = new ResourceLoaderBootstrapModule;
		$instance->setCache( $cache );

		$styles = $instance->getStyles( $resourceLoaderContext );

		$this->assertArrayHasKey( 'all', $styles );
		$this->assertEquals( 'foo', $styles['all'] );
	}

	public function testGetStylesTryCatchExceptionIsThrownByLessParser() {

		$resourceLoaderContext = $this->getMockBuilder( '\ResourceLoaderContext' )
			->disableOriginalConstructor()
			->getMock();

		$options = array(
			'external styles' => array( 'Foo' => 'bar' )
		);

		$instance = new ResourceLoaderBootstrapModule( $options );
		$instance->setCache( new HashBagOStuff );

		$result = $instance->getStyles( $resourceLoaderContext );

		$this->assertContains( 'SCSS compile error', $result['all'] );
	}

	public function testSupportsURLLoading() {
		$instance = new ResourceLoaderBootstrapModule();
		$this->assertFalse( $instance->supportsURLLoading() );
	}
}
