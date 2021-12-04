<?php
/**
 * A tool to style terminal output.
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
 * @link               https://github.com/clevercanyon/clevercanyon-php-chalk
 */
namespace Clever_Canyon\Chalk;

/**
 * Chalk.
 *
 * @since 1.0.0
 */
class Chalk {
	/**
	 * The terminal color escape sequence with color replace tag.
	 *
	 * @since 1.0.0
	 */
	public const ESCAPE_SEQUENCE = "\033[STYLEm";

	/**
	 * Styles string.
	 *
	 * @since 1.0.0
	 *
	 * @param  string    $string String.
	 * @param  int|Style $style  Styles.
	 *
	 * @return string            Styled string.
	 */
	public static function style( string $string, $style ) : string {
		$escape_sequence = $style instanceof Style ? $style->get_escape_sequence() : static::get_escape_sequence( $style );
		$reset_sequence  = $style instanceof Style ? Style::get_reset_sequence() : static::get_reset_sequence( $style );

		return $escape_sequence . $string . $reset_sequence;
	}

	/**
	 * Parses the given string and inserts the color tags replacing the placeholders.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $string String.
	 * @param  array  $styles Styles.
	 *
	 * @return string         Parsed string.
	 */
	public static function parse( string $string, array $styles ) : string {
		if ( false === strpos( $string, '{' ) ) {
			return static::style( $string, reset( $styles ) );
		}

		$_i = 0; // Initialize iterator.
		// Loop through each tag in the string.

		while ( false !== $_open_tag = strpos( $string, '{' ) ) {
			$_style = array_key_exists( $_i, $styles ) ? $styles[ $_i ] : end( $styles );

			$_escape_sequence = $_style instanceof Style ? $_style->get_escape_sequence() : static::get_escape_sequence( $_style );
			$_reset_sequence  = $_style instanceof Style ? Style::get_reset_sequence() : static::get_reset_sequence( $_style );

			$string = substr_replace( $string, $_escape_sequence, $_open_tag, 1 );

			if ( false === $_close_tag = strpos( $string, '}' ) ) {
				$_close_tag = strlen( $string );
			}
			if ( substr( $string, $_close_tag - strlen( $_reset_sequence ), strlen( $_reset_sequence ) ) !== $_reset_sequence ) {
				$string = substr_replace( $string, $_reset_sequence, $_close_tag, 1 );
			}
			$_i++; // Increment iterator.
		}
		return $string;
	}

	/**
	 * Returns a terminal escape sequence with the given style.
	 *
	 * @since 1.0.0
	 *
	 * @param  int $style Style.
	 *
	 * @return string     Escape sequence.
	 */
	public static function get_escape_sequence( int $style ) : string {
		return str_replace( 'STYLE', (string) $style, static::ESCAPE_SEQUENCE );
	}

	/**
	 * Returns the reset sequence for the given style.
	 *
	 * @since 1.0.0
	 *
	 * @param  int|null $style Style.
	 *
	 * @return string          Escape sequence.
	 */
	public static function get_reset_sequence( $style = null ) : string {
		$reset_sequence = Style::get_reset_sequence();

		if ( ! is_null( $style ) ) {
			switch ( true ) {
				case in_array( (string) $style, Fg_Color::enum(), true ):
					$reset_sequence = Fg_Color::get_reset_sequence();
					break;
				case in_array( (string) $style, Bg_Color::enum(), true ):
					$reset_sequence = Bg_Color::get_reset_sequence();
					break;
			}
		}
		return $reset_sequence;
	}

	/**
	 * Allows the convenient use of methods like {@link Chalk::blue()}.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $color     Color.
	 * @param  array  $arguments Arguments.
	 *
	 * @return string            Styled string.
	 *
	 * @internal The color is caSe-insensitive, and this only works for colors.
	 */
	public static function __callStatic( $color, $arguments ) : string {
		$color_constant = strtoupper( $color );
		$reflection     = new \ReflectionClass( Fg_Color::class );

		if ( ! $reflection->hasConstant( $color_constant ) ) {
			trigger_error( 'Fatal error: Call to undefined method ' . static::class . '::' . $color . '()', E_USER_ERROR ); // phpcs:ignore -- error ok.
		}
		if ( empty( $arguments ) ) {
			trigger_error( 'Warning: Missing argument 1 for ' . static::class . '::' . $color . '()', E_USER_WARNING ); // phpcs:ignore -- error ok.
		}
		return static::style( $arguments[0], $reflection->getConstant( $color_constant ) );
	}
}
