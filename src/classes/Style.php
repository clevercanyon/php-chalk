<?php
/**
 * The style object allows you to combine a number of styles.
 *
 * Copyright (c) 2015 Martin Pettersson
 * Copyright (c) 2022 CLEVER CANYON LLC
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @original-author    Martin pettersson <martin_pettersson@outlook.com>
 * @original-copyright 2015 Martin Pettersson
 * @original-license   MIT
 * @original-link      https://github.com/martin-pettersson/chalk
 *
 * @author             CLEVER CANYON LLC
 * @copyright          2021 CLEVER CANYON LLC
 * @license            MIT
 * @link               https://github.com/clevercanyon/php-chalk
 */
namespace Clever_Canyon\Chalk;

/**
 * Style.
 *
 * @since 1.0.0
 */
class Style {
	public const NONE       = '0';
	public const BOLD       = '1';
	public const DIM        = '2';
	public const UNDERLINED = '4';
	public const BLINK      = '5';
	public const INVERTED   = '7';
	public const HIDDEN     = '8';

	/**
	 * Escape sequence.
	 *
	 * @since 1.0.0
	 */
	protected string $escape_sequence = '';

	/**
	 * Compiles the given styles into a single escape sequence.
	 *
	 * @since 1.0.0
	 *
	 * @param int|array $styles Styles.
	 */
	public function __construct( $styles = null ) {
		if ( ! is_null( $styles ) ) {
			$this->set_style( $styles );
		}
	}

	/**
	 * Sets style by recompiling escape sequence.
	 *
	 * @since 1.0.0
	 *
	 * @param int|array $styles Styles.
	 */
	public function set_style( $styles ) : void {
		$this->escape_sequence = '';
		$this->add_style( $styles );
	}

	/**
	 * Appends style(s) to escape sequence.
	 *
	 * @since 1.0.0
	 *
	 * @param int|array $styles Styles.
	 */
	public function add_style( $styles ) : void {
		foreach ( (array) $styles as $style ) {
			$this->escape_sequence .= Chalk::get_escape_sequence( $style );
		}
	}

	/**
	 * Gets escape sequence.
	 *
	 * @since 1.0.0
	 *
	 * @return string Escape sequence.
	 */
	public function get_escape_sequence() : string {
		return $this->escape_sequence;
	}

	/**
	 * Gets array of available colors.
	 *
	 * @since 1.0.0
	 *
	 * @return array Available colors.
	 */
	public static function enum() : array {
		return ( new \ReflectionClass( static::class ) )->getConstants();
	}

	/**
	 * Gets style reset sequence.
	 *
	 * @since 1.0.0
	 *
	 * @return string Style reset sequence.
	 */
	public static function get_reset_sequence() : string {
		return Chalk::get_escape_sequence( static::NONE );
	}

	/**
	 * Gets a style code.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $style Style name.
	 *
	 * @return string        Style code.
	 */
	public static function code( string $style ) : string {
		switch ( strtolower( $style ) ) {
			case 'bold':
			case 'bright':
				return static::BOLD;
			case 'dim':
				return static::DIM;
			case 'underline':
				return static::UNDERLINED;
			case 'blink':
				return static::BLINK;
			case 'invert':
				return static::INVERTED;
			case 'hide':
				return static::HIDDEN;
			default:
				return static::NONE;
		}
	}
}
