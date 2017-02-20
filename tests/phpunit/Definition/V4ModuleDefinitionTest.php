<?php

namespace Bootstrap\Tests\Definition;

use Bootstrap\Definition\V4ModuleDefinition;
use Bootstrap\BootstrapManager;

/**
 * File holding the V4ModuleDefinitionTest class
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
 * @uses \Bootstrap\Definition\V3ModuleDefinition
 *
 * @ingroup Test
 *
 * @group extension-bootstrap
 * @group mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since 2.0
 *
 * @author mwjames
 */
class V4ModuleDefinitionTest extends \PHPUnit_Framework_TestCase {

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\Bootstrap\Definition\ModuleDefinition',
			new V4ModuleDefinition()
		);
	}

	/**
	 * @dataProvider keyProvider
	 */
	public function testGet( $key ) {

		$instance = new V4ModuleDefinition();

		$this->assertInternalType(
			'array',
			$instance->get( $key )
		);
	}

	public function testBootstrapManagerIntegration() {

		$instance = new BootstrapManager( new V4ModuleDefinition() );
		$instance->addAllBootstrapModules();

		$this->assertTrue( true );
	}

	public function testGetOnInvalidKeyThrowsException() {

		$instance = new V4ModuleDefinition();

		$this->setExpectedException( 'InvalidArgumentException' );
		$instance->get( 'Foo' );
	}

	public function keyProvider() {

		$provider = array(
			array( 'core' ),
			array( 'optional' ),
			array( 'descriptions' )
		);

		return $provider;
	}

}
