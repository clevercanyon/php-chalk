<?php
/**
 * A collection of available background colors.
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
 * Background color.
 *
 * @since 2021-12-15
 */
class Bg_Color {
	public const NONE = '49';

	public const BLACK = '40';

	public const RED = '41';

	public const GREEN = '42';

	public const YELLOW = '43';

	public const BLUE = '44';

	public const MAGENTA = '45';

	public const CYAN = '46';

	public const LIGHT_GRAY = '47';

	public const DARK_GRAY = '100';

	public const LIGHT_RED = '101';

	public const LIGHT_GREEN = '102';

	public const LIGHT_YELLOW = '103';

	public const LIGHT_BLUE = '104';

	public const LIGHT_MAGENTA = '105';

	public const LIGHT_CYAN = '106';

	public const WHITE = '107';

	/**
	 * Gets array of available colors.
	 *
	 * @since 2021-12-15
	 *
	 * @return array Available colors.
	 */
	public static function enum() : array {
		return ( new \ReflectionClass( static::class ) )->getConstants();
	}

	/**
	 * Gets background color reset sequence.
	 *
	 * @since 2021-12-15
	 *
	 * @return string Background color reset sequence.
	 */
	public static function get_reset_sequence() : string {
		return Chalk::get_escape_sequence( static::NONE );
	}

	/**
	 * Gets a background color code.
	 *
	 * @since 2021-12-15
	 *
	 * @param string $color Color name.
	 *
	 * @return string        Background color code.
	 */
	public static function code( string $color ) : string {
		switch ( strtolower( $color ) ) {
			case 'black':
				return static::BLACK;
			case 'red':
				return static::RED;
			case 'green':
				return static::GREEN;
			case 'yellow':
				return static::YELLOW;
			case 'blue':
				return static::BLUE;
			case 'magenta':
				return static::MAGENTA;
			case 'cyan':
				return static::CYAN;
			case 'light-gray':
				return static::LIGHT_GRAY;
			case 'dark-gray':
				return static::DARK_GRAY;
			case 'light-red':
				return static::LIGHT_RED;
			case 'light-green':
				return static::LIGHT_GREEN;
			case 'light-yellow':
				return static::LIGHT_YELLOW;
			case 'light-blue':
				return static::LIGHT_BLUE;
			case 'light-magenta':
				return static::LIGHT_MAGENTA;
			case 'light-cyan':
				return static::LIGHT_CYAN;
			case 'white':
				return static::WHITE;
			default:
				return static::NONE;
		}
	}
}
