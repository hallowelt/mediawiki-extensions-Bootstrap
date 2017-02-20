<?php

namespace Bootstrap\Tests;

use Bootstrap\BootstrapManager;

/**
 * File holding the BootstrapManagerTest class
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
 * @uses \Bootstrap\BootstrapManager
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
class BootstrapManagerTest extends \PHPUnit_Framework_TestCase {

	protected $wgResourceModules = null;

	protected function setUp() {
		parent::setUp();
		$this->wgResourceModules = $GLOBALS['wgResourceModules'];

		// Preset with empty default values to verify the initialization status
		// during invocation
		$GLOBALS['wgResourceModules'][ 'ext.bootstrap.styles' ] = array(
			'localBasePath'   => '',
			'remoteBasePath'  => '',
			'class'           => '',
			'dependencies'    => array(),
			'styles'          => array(),
			'variables'       => array(),
			'external styles' => array()
		);

		$GLOBALS['wgResourceModules'][ 'ext.bootstrap.scripts' ] = array(
			'dependencies'    => array(),
			'scripts'         => array()
		);
	}

	protected function tearDown() {
		$GLOBALS['wgResourceModules'] = $this->wgResourceModules;
		BootstrapManager::clear();

		parent::tearDown();
	}

	public function testCanConstruct() {

		$moduleDefinition = $this->getMockBuilder( '\Bootstrap\Definition\ModuleDefinition' )
			->disableOriginalConstructor()
			->setMethods( array( 'get' ) )
			->getMock();

		$moduleDefinition->expects( $this->atLeastOnce() )
			->method( 'get' )
			->will( $this->returnValue( array() ) );

		$this->assertInstanceOf(
			'\Bootstrap\BootstrapManager',
			new BootstrapManager( $moduleDefinition )
		);

		BootstrapManager::clear();

		$this->assertInstanceOf(
			'\Bootstrap\BootstrapManager',
			BootstrapManager::getInstance()
		);
	}

	public function testLoadStylesFromModuleDefinition() {

		$this->assertEmpty( $this->getGlobalResourceModuleBootstrapStyles() );

		$moduleDefinition = $this->getMockBuilder( '\Bootstrap\Definition\ModuleDefinition' )
			->disableOriginalConstructor()
			->setMethods( array( 'get' ) )
			->getMock();

		$moduleDefinition->expects( $this->at( 0 ) )
			->method( 'get' )
			->with( $this->stringContains( 'descriptions' ) )
			->will( $this->returnValue( array( 'variables' => array( 'styles' => 'variables' ) ) ) );

		$moduleDefinition->expects( $this->at( 1 ) )
			->method( 'get' )
			->with( $this->stringContains( 'core' ) )
			->will( $this->returnValue( array( 'variables' ) ) );

		$moduleDefinition->expects( $this->at( 2 ) )
			->method( 'get' )
			->with( $this->stringContains( 'optional' ) )
			->will( $this->returnValue( array( 'foo' ) ) );

		$instance = new BootstrapManager( $moduleDefinition );
		$instance->addAllBootstrapModules();

		$this->assertNotEmpty( $this->getGlobalResourceModuleBootstrapStyles() );
	}

	public function testSetLessVariables() {

		$moduleDefinition = $this->getMockBuilder( '\Bootstrap\Definition\ModuleDefinition' )
			->disableOriginalConstructor()
			->setMethods( array( 'get' ) )
			->getMock();

		$moduleDefinition->expects( $this->atLeastOnce() )
			->method( 'get' )
			->will( $this->returnValue( array() ) );

		$instance = new BootstrapManager( $moduleDefinition );
		$instance->setScssVariables( array( 'foo' => 'bar') );
		$instance->setScssVariable( 'ichi', 'ni' );

		$this->assertArrayHasKey(
			'foo',
			$this->getGlobalResourceModuleBootstrapVariables()
		);

		$this->assertArrayHasKey(
			'ichi',
			$this->getGlobalResourceModuleBootstrapVariables()
		);
	}

	public function testAddCacheTriggerFiles() {

		$moduleDefinition = $this->getMockBuilder( '\Bootstrap\Definition\ModuleDefinition' )
			->disableOriginalConstructor()
			->setMethods( array( 'get' ) )
			->getMock();

		$moduleDefinition->expects( $this->atLeastOnce() )
			->method( 'get' )
			->will( $this->returnValue( array() ) );

		$instance = new BootstrapManager( $moduleDefinition );
		$instance-> addCacheTriggerFile( array( 'foo' => 'bar') );
		$instance-> addCacheTriggerFile( 'ichi' );

		$triggers = $this->getGlobalResourceModuleBootstrapCacheTriggers();

		$this->assertTrue(
			isset( $triggers[ 'foo' ] ) && $triggers[ 'foo' ] === 'bar'
		);

		$this->assertTrue(
			array_search( 'ichi', $triggers ) !== false
		);
	}

	public function testAddExternalModule() {

		$moduleDefinition = $this->getMockBuilder( '\Bootstrap\Definition\ModuleDefinition' )
			->disableOriginalConstructor()
			->setMethods( array( 'get' ) )
			->getMock();

		$moduleDefinition->expects( $this->atLeastOnce() )
			->method( 'get' )
			->will( $this->returnValue( array() ) );

		$instance = new BootstrapManager( $moduleDefinition );
		$instance->addExternalModule( 'ExternalFooModule', 'ExternalRemoteBarPath' );

		$this->assertArrayHasKey(
			'ExternalFooModule',
			$this->getGlobalResourceModuleBootstrapExternalStyles()
		);
	}

	private function getGlobalResourceModuleBootstrapStyles() {
		return $GLOBALS['wgResourceModules'][ 'ext.bootstrap.styles' ]['styles'];
	}

	private function getGlobalResourceModuleBootstrapVariables() {
		return $GLOBALS['wgResourceModules'][ 'ext.bootstrap.styles' ]['variables'];
	}

	private function getGlobalResourceModuleBootstrapExternalStyles() {
		return $GLOBALS['wgResourceModules'][ 'ext.bootstrap.styles' ]['external styles'];
	}

	private function getGlobalResourceModuleBootstrapCacheTriggers() {
		return $GLOBALS['wgResourceModules'][ 'ext.bootstrap.styles' ]['cachetriggers'];
	}

}
