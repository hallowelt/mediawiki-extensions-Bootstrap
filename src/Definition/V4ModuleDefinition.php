<?php

namespace Bootstrap\Definition;

use InvalidArgumentException;

/**
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup   Bootstrap
 */

/**
 * Class describing the V3 Bootstrap module definitions
 */
class V4ModuleDefinition implements ModuleDefinition {

	static private $moduleDescriptions = [
		// Core variables and mixins
		'variables'        => [ 'styles' => 'variables' ],
		'mixins'           => [ 'styles' => 'mixins' ],
		'custom'           => [ 'styles' => 'custom' ],

		// Reset and dependencies
		'normalize'        => [ 'styles' => 'normalize' ],
		'print'            => [ 'styles' => 'print' ],

		// Core CSS
		'reboot'           => [ 'styles' => 'reboot' ],
		'type'             => [ 'styles' => 'type' ],
		'images'           => [ 'styles' => 'images' ],
		'code'             => [ 'styles' => 'code' ],
		'grid'             => [ 'styles' => 'grid' ],
		'tables'           => [ 'styles' => 'tables' ],
		'forms'            => [ 'styles' => 'forms' ],
		'buttons'          => [ 'styles' => 'buttons' ],

		// Components
		'transitions'      => [ 'styles' => 'transitions' ],
		'dropdown'         => [ 'styles' => 'dropdown' ],
		'button-group'     => [ 'styles' => 'button-group', 'dependencies' => 'buttons' ],
		'input-group'      => [ 'styles' => 'input-group' ],
		'custom-forms'     => [ 'styles' => 'custom-forms' ],
		'nav'              => [ 'styles' => 'nav' ],
		'navbar'           => [ 'styles' => 'navbar' ],
		'card'             => [ 'styles' => 'card' ],
		'breadcrumb'       => [ 'styles' => 'breadcrumb' ],
		'pagination'       => [ 'styles' => 'pagination' ],
		'badge'            => [ 'styles' => 'badge' ],
		'jumbotron'        => [ 'styles' => 'jumbotron' ],
		'alert'            => [ 'styles' => 'alert' ],
		'progress'         => [ 'styles' => 'progress' ],
		'media'            => [ 'styles' => 'media' ],
		'list-group'       => [ 'styles' => 'list-group' ],
		'responsive-embed' => [ 'styles' => 'responsive-embed' ],
		'close'            => [ 'styles' => 'close' ],

		// Components w/ JavaScript
		'modal'            => [ 'styles' => 'modal', 'scripts' => 'modal' ],
//		'tooltip'          => [ 'styles' => 'tooltip', 'scripts' => 'tooltip' ],
		'popover'          => [ 'styles' => 'popover', 'scripts' => 'popover' ],
		'carousel'         => [ 'styles' => 'carousel', 'scripts' => 'carousel' ],
		'dismissable alert' => [ 'scripts' => 'alert', 'dependencies' => 'alert' ],
		'togglebutton' => [ 'scripts' => 'button', 'dependencies' => 'button' ],

		// Utility classes
		'utilities'        => [ 'styles' => 'utilities' ],

		// JS-only components
		'collapse' => [ 'scripts' => 'collapse' ],
		'scrollspy' => [ 'scripts' => 'scrollspy', 'dependencies' => 'nav' ],


		 'dropdown js' => [ 'scripts' => 'dropdown' ],  // FIXME: Is this needed for basic functionality?
		 'tab' => [ 'scripts' => 'tab' ], // FIXME: Is this needed for basic functionality?
//		 'tooltip js' => [ 'scripts' => 'tooltip' ], // FIXME: Needs Tether (tether.io)
		 'util' => [ 'scripts' => 'util' ], // FIXME: Is this needed for basic functionality?
	];

		
	static private $coreModules = [
		// Core variables and mixins
		'variables',
		'mixins',
		'custom',

		// Reset and dependencies
		'normalize',
		'print',

		// Core CSS
		'reboot',
		'type',
		'images',
		'code',
		'grid',
		'tables',
		'forms',
		'buttons'
	];

	static private $optionalModules = [
		// Components
		'transitions',
		'dropdown',
		'button-group',

		'input-group',
		'custom-forms',
		'nav',
		'navbar',
		'card',
		'breadcrumb',
		'pagination',
		'badge',
		'jumbotron',
		'alert',
		'progress',
		'media',
		'list-group',
		'responsive-embed',
		'close',

		// Components w/ JavaScript
		'modal',
//		'tooltip',
//		'popover',
		'carousel',
		'dismissable alert',
		'togglebutton',

		// Utility classes
		'utilities',

		// JS-only components
		'collapse',
		'scrollspy',

		'dropdown js',  // FIXME: Is this needed for basic functionality?
		'tab', // FIXME: Is this needed for basic functionality?
//		'tooltip js', // FIXME: Needs Tether (tether.io)
		'util', // FIXME: Is this needed for basic functionality?

	];

	/**
	 * @see ModuleDefinition::get
	 *
	 * @since  1.0
	 *
	 * @param string $key
	 *
	 * @return array
	 * @throws InvalidArgumentException
	 */
	public function get( $key ) {

		switch ( $key ) {
			case 'core':
				return self::$coreModules;
			case 'optional':
				return self::$optionalModules;
			case 'descriptions':
				return self::$moduleDescriptions;
		}

		throw new InvalidArgumentException( 'Expected a valid key' );
	}

}
