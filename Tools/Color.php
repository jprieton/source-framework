<?php

namespace SourceFramework\Tools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Color conversion class class
 *
 * @package     SourceFramework
 * @subpackage  Tools
 *
 * @author      Javier Prieto <jprieton@gmail.com>
 * @copyright	  Copyright (c) 2017, Javier Prieto
 * @since       1.0.0
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
class Color {

  /**
   * HTML color names
   * @var array
   */
  private $color_names = array(
      'aliceblue'            => array( 240, 248, 255 ),
      'antiquewhite'         => array( 250, 235, 215 ),
      'aqua'                 => array( 0, 255, 255 ),
      'aquamarine'           => array( 127, 255, 212 ),
      'azure'                => array( 240, 255, 255 ),
      'beige'                => array( 245, 245, 220 ),
      'bisque'               => array( 255, 228, 196 ),
      'black'                => array( 0, 0, 0 ),
      'blanchedalmond'       => array( 255, 235, 205 ),
      'blue'                 => array( 0, 0, 255 ),
      'blueviolet'           => array( 138, 43, 226 ),
      'brown'                => array( 165, 42, 42 ),
      'burlywood'            => array( 222, 184, 135 ),
      'cadetblue'            => array( 95, 158, 160 ),
      'chartreuse'           => array( 127, 255, 0 ),
      'chocolate'            => array( 210, 105, 30 ),
      'coral'                => array( 255, 127, 80 ),
      'cornflowerblue'       => array( 100, 149, 237 ),
      'cornsilk'             => array( 255, 248, 220 ),
      'crimson'              => array( 220, 20, 60 ),
      'cyan'                 => array( 0, 255, 255 ),
      'darkblue'             => array( 0, 0, 139 ),
      'darkcyan'             => array( 0, 139, 139 ),
      'darkgoldenrod'        => array( 184, 134, 11 ),
      'darkgray'             => array( 169, 169, 169 ),
      'darkgreen'            => array( 0, 100, 0 ),
      'darkgrey'             => array( 169, 169, 169 ),
      'darkkhaki'            => array( 189, 183, 107 ),
      'darkmagenta'          => array( 139, 0, 139 ),
      'darkolivegreen'       => array( 85, 107, 47 ),
      'darkorange'           => array( 255, 140, 0 ),
      'darkorchid'           => array( 153, 50, 204 ),
      'darkred'              => array( 139, 0, 0 ),
      'darksalmon'           => array( 233, 150, 122 ),
      'darkseagreen'         => array( 143, 188, 143 ),
      'darkslateblue'        => array( 72, 61, 139 ),
      'darkslategray'        => array( 47, 79, 79 ),
      'darkslategrey'        => array( 47, 79, 79 ),
      'darkturquoise'        => array( 0, 206, 209 ),
      'darkviolet'           => array( 148, 0, 211 ),
      'deeppink'             => array( 255, 20, 147 ),
      'deepskyblue'          => array( 0, 191, 255 ),
      'dimgray'              => array( 105, 105, 105 ),
      'dimgrey'              => array( 105, 105, 105 ),
      'dodgerblue'           => array( 30, 144, 255 ),
      'firebrick'            => array( 178, 34, 34 ),
      'floralwhite'          => array( 255, 250, 240 ),
      'forestgreen'          => array( 34, 139, 34 ),
      'fuchsia'              => array( 255, 0, 255 ),
      'gainsboro'            => array( 220, 220, 220 ),
      'ghostwhite'           => array( 248, 248, 255 ),
      'gold'                 => array( 255, 215, 0 ),
      'goldenrod'            => array( 218, 165, 32 ),
      'gray'                 => array( 128, 128, 128 ),
      'green'                => array( 0, 128, 0 ),
      'greenyellow'          => array( 173, 255, 47 ),
      'grey'                 => array( 128, 128, 128 ),
      'honeydew'             => array( 240, 255, 240 ),
      'hotpink'              => array( 255, 105, 180 ),
      'indianred'            => array( 205, 92, 92 ),
      'indigo'               => array( 75, 0, 130 ),
      'ivory'                => array( 255, 255, 240 ),
      'khaki'                => array( 240, 230, 140 ),
      'lavender'             => array( 230, 230, 250 ),
      'lavenderblush'        => array( 255, 240, 245 ),
      'lawngreen'            => array( 124, 252, 0 ),
      'lemonchiffon'         => array( 255, 250, 205 ),
      'lightblue'            => array( 173, 216, 230 ),
      'lightcoral'           => array( 240, 128, 128 ),
      'lightcyan'            => array( 224, 255, 255 ),
      'lightgoldenrodyellow' => array( 250, 250, 210 ),
      'lightgray'            => array( 211, 211, 211 ),
      'lightgreen'           => array( 144, 238, 144 ),
      'lightgrey'            => array( 211, 211, 211 ),
      'lightpink'            => array( 255, 182, 193 ),
      'lightsalmon'          => array( 255, 160, 122 ),
      'lightseagreen'        => array( 32, 178, 170 ),
      'lightskyblue'         => array( 135, 206, 250 ),
      'lightslategray'       => array( 119, 136, 153 ),
      'lightslategrey'       => array( 119, 136, 153 ),
      'lightsteelblue'       => array( 176, 196, 222 ),
      'lightyellow'          => array( 255, 255, 224 ),
      'lime'                 => array( 0, 255, 0 ),
      'limegreen'            => array( 50, 205, 50 ),
      'linen'                => array( 250, 240, 230 ),
      'magenta'              => array( 255, 0, 255 ),
      'maroon'               => array( 128, 0, 0 ),
      'mediumaquamarine'     => array( 102, 205, 170 ),
      'mediumblue'           => array( 0, 0, 205 ),
      'mediumorchid'         => array( 186, 85, 211 ),
      'mediumpurple'         => array( 147, 112, 219 ),
      'mediumseagreen'       => array( 60, 179, 113 ),
      'mediumslateblue'      => array( 123, 104, 238 ),
      'mediumspringgreen'    => array( 0, 250, 154 ),
      'mediumturquoise'      => array( 72, 209, 204 ),
      'mediumvioletred'      => array( 199, 21, 133 ),
      'midnightblue'         => array( 25, 25, 112 ),
      'mintcream'            => array( 245, 255, 250 ),
      'mistyrose'            => array( 255, 228, 225 ),
      'moccasin'             => array( 255, 228, 181 ),
      'navajowhite'          => array( 255, 222, 173 ),
      'navy'                 => array( 0, 0, 128 ),
      'oldlace'              => array( 253, 245, 230 ),
      'olive'                => array( 128, 128, 0 ),
      'olivedrab'            => array( 107, 142, 35 ),
      'orange'               => array( 255, 165, 0 ),
      'orangered'            => array( 255, 69, 0 ),
      'orchid'               => array( 218, 112, 214 ),
      'palegoldenrod'        => array( 238, 232, 170 ),
      'palegreen'            => array( 152, 251, 152 ),
      'paleturquoise'        => array( 175, 238, 238 ),
      'palevioletred'        => array( 219, 112, 147 ),
      'papayawhip'           => array( 255, 239, 213 ),
      'peachpuff'            => array( 255, 218, 185 ),
      'peru'                 => array( 205, 133, 63 ),
      'pink'                 => array( 255, 192, 203 ),
      'plum'                 => array( 221, 160, 221 ),
      'powderblue'           => array( 176, 224, 230 ),
      'purple'               => array( 128, 0, 128 ),
      'rebeccapurple'        => array( 102, 51, 153 ),
      'red'                  => array( 255, 0, 0 ),
      'rosybrown'            => array( 188, 143, 143 ),
      'royalblue'            => array( 65, 105, 225 ),
      'saddlebrown'          => array( 139, 69, 19 ),
      'salmon'               => array( 250, 128, 114 ),
      'sandybrown'           => array( 244, 164, 96 ),
      'seagreen'             => array( 46, 139, 87 ),
      'seashell'             => array( 255, 245, 238 ),
      'sienna'               => array( 160, 82, 45 ),
      'silver'               => array( 192, 192, 192 ),
      'skyblue'              => array( 135, 206, 235 ),
      'slateblue'            => array( 106, 90, 205 ),
      'slategray'            => array( 112, 128, 144 ),
      'slategrey'            => array( 112, 128, 144 ),
      'snow'                 => array( 255, 250, 250 ),
      'springgreen'          => array( 0, 255, 127 ),
      'steelblue'            => array( 70, 130, 180 ),
      'tan'                  => array( 210, 180, 140 ),
      'teal'                 => array( 0, 128, 128 ),
      'thistle'              => array( 216, 191, 216 ),
      'tomato'               => array( 255, 99, 71 ),
      'turquoise'            => array( 64, 224, 208 ),
      'violet'               => array( 238, 130, 238 ),
      'wheat'                => array( 245, 222, 179 ),
      'white'                => array( 255, 255, 255 ),
      'whitesmoke'           => array( 245, 245, 245 ),
      'yellow'               => array( 255, 255, 0 ),
      'yellowgreen'          => array( 154, 205, 50 ),
  );

  /**
   *
   * @param string $hex Hexadecimal representacion of color (#RGB, #RRGGBB, RGB or RRGGBB);
   * @param string $output
   */
  public function hex_to_rgb( $hex, $output = 'property' ) {
    if ( strstr( $hex, '#' ) ) {
      $hex = str_replace( '#', '', $hex, 1 );
    }

    if ( strlen( $hex ) == 3 ) {
      $rgb = array_map( function($hex) {
        return hexdec( $hex . $hex );
      }, str_split( $hex, 1 ) );
    } elseif ( strlen( $hex ) == 6 ) {
      $rgb = array_map( 'hexdec', str_split( $hex, 2 ) );
    } else {
      return false;
    }

    if ( 'property' == $output ) {
      $rgb = 'rgb(' . implode( ',', $rgb ) . ')';
    }

    return $rgb;
  }

  /**
   *
   * @param string $hex Hexadecimal representacion of color (#RGB, #RRGGBB, RGB or RRGGBB);
   * @param float $opacity
   * @param string $output
   */
  public function hex_to_rgba( $hex, $opacity = 1, $output = 'property' ) {
    if ( strstr( $hex, '#' ) ) {
      $hex = str_replace( '#', '', $hex, 1 );
    }

    if ( in_array( strlen( $hex ), array( 3, 6 ) ) ) {
      $rgba   = $this->hex_to_rgb( $hex, 'array' );
      $rgba[] = ($opacity >= 0 && $opacity <= 1) ? $opacity : 1;

      if ( 'property' == $output ) {
        $rgba = 'rgba(' . implode( ',', $rgba ) . ')';
      }

      return $rgba;
    } else {
      return false;
    }
  }

  /**
   *
   * @param string $hex Hexadecimal representacion of color (#RGB, #RRGGBB, RGB or RRGGBB);
   * @param string $output
   * @param bool $rounded
   */
  public function hex_to_hsl( $hex, $output = 'property', $rounded = true ) {
    $rgb = $this->hex_to_rgb( $hex, 'array' );
    $hsl = $this->rgb_to_hsl( $rgb, $output, $rounded );
    return $hsl;
  }

  /**
   * Convert color HSL to RGB
   *
   * @since   1.0.0
   *
   * @param   string         $hsl
   * @param   string         $output
   * @param   bool           $rounded
   * @return  string|array
   */
  public function hsl_to_rgb( $hsl, $output = 'property', $rounded = true ) {
    list($h, $s, $l) = (array) $hsl;

    $s /= 100;
    $l /= 100;

    $c = (1 - abs( (2 * $l) - 1 ) ) * $s;

    $hh = $h / 60;

    $x = $c * (1 - abs( fmod( $hh, 2 ) - 1 ));
    $r = $g = $b = 0;
    if ( $hh >= 0 && $hh < 1 ) {
      $r = $c;
      $g = $x;
    } else if ( $hh >= 1 && $hh < 2 ) {
      $r = $x;
      $g = $c;
    } else if ( $hh >= 2 && $hh < 3 ) {
      $g = $c;
      $b = $x;
    } else if ( $hh >= 3 && $hh < 4 ) {
      $g = $x;
      $b = $c;
    } else if ( $hh >= 4 && $hh < 5 ) {
      $r = $x;
      $b = $c;
    } else {
      $r = $c;
      $b = $x;
    }

    $m = $l - $c / 2;
    $r += $m;
    $g += $m;
    $b += $m;
    $r *= 255.0;
    $g *= 255.0;
    $b *= 255.0;

    if ( $rounded ) {
      $r = round( $r );
      $g = round( $g );
      $b = round( $b );
    }

    $rgb = array( $r, $g, $b );

    if ( 'property' == $output ) {
      $rgb = 'rgb(' . implode( ',', $rgb ) . ')';
    }

    return $rgb;
  }

  /**
   * Convert color HSL to HEX
   *
   * @since   1.0.0
   *
   * @param   string         $rgb
   * @param   string         $output
   * @return  string|array
   */
  public function hsl_to_hex( $rgb, $output = 'property' ) {
    $rgb = $this->hsl_to_rgb( $rgb, 'array' );
    $hex = $this->rgb_to_hex( $rgb, $output );
    return $hex;
  }

  /**
   * Convert color RGB to HEX
   *
   * @since   1.0.0
   *
   * @param   string         $rgb
   * @param   string         $output
   * @return  string|array
   */
  public function rgb_to_hex( $rgb, $output = 'property' ) {
    $rgb = array_map( function($dec) {
      return str_pad( dechex( $dec ), 2, '0', STR_PAD_LEFT );
    }, $rgb );

    if ( 'property' == $output ) {
      $hex = '#' . implode( '', $rgb );
    }

    return $hex;
  }

  /**
   * Convert color RGB to HSL
   *
   * @since   1.0.0
   *
   * @param   string         $rgb
   * @param   string         $output
   * @param   bool           $rounded
   * @return  string|array
   */
  public function rgb_to_hsl( $rgb, $output = 'property', $rounded = true ) {
    list($r, $g, $b) = (array) $rgb;
    $r = ( $r / 255 ); //RGB from 0 to 255
    $g = ( $g / 255 );
    $b = ( $b / 255 );

    $min = min( $r, $g, $b ); //Min. value of RGB
    $max = max( $r, $g, $b ); //Max. value of RGB
    $d   = $max - $min; //Delta RGB value

    $l = ( $max + $min ) / 2;

    if ( $d == 0 ) { //This is a gray, no chroma...
      $h = 0; //HSL results from 0 to 1
      $s = 0;
    } else { //Chromatic data...
      if ( $l < 0.5 ) $s = $d / ( $max + $min );
      else $s = $d / ( 2 - $max - $min );

      $dr = ( ( ( $max - $r ) / 6 ) + ( $d / 2 ) ) / $d;
      $dg = ( ( ( $max - $g ) / 6 ) + ( $d / 2 ) ) / $d;
      $db = ( ( ( $max - $b ) / 6 ) + ( $d / 2 ) ) / $d;

      if ( $r == $max ) $h = $db - $dg;
      else if ( $g == $max ) $h = ( 1 / 3 ) + $dr - $db;
      else if ( $b == $max ) $h = ( 2 / 3 ) + $dg - $dr;

      if ( $h < 0 ) $h += 1;
      if ( $h > 1 ) $h -= 1;
    }

    $h *= 360;
    $s *= 100;
    $l *= 100;

    if ( $rounded ) {
      $h = round( $h );
      $s = round( $s );
      $l = round( $l );
    }

    if ( 'property' == $output ) {
      $hsl = "hsl({$h},{$s}%,{$l}%)";
    } else {
      $hsl = array( $h, $s, $l );
    }

    return $hsl;
  }

  /**
   * Convert color name to HEX
   *
   * @since   1.0.0
   *
   * @param   string         $color
   * @param   string         $output
   * @return  string|array
   */
  public function name_to_hex( $color, $output = 'property' ) {
    if ( !empty( $this->color_names[$color] ) ) {
      $hex = $this->rgb_to_hex( $this->color_names[$color], 'array' );

      if ( 'property' == $output ) {
        $hex = '#' . implode( '', $hex );
      }

      return $hex;
    }
    return '';
  }

  /**
   * Convert color name to HSL
   *
   * @since   1.0.0
   *
   * @param   string         $color
   * @param   string         $output
   * @return  string|array
   */
  public function name_to_hsl( $color, $output = 'property' ) {
    if ( !empty( $this->color_names[$color] ) ) {
      $hsl = $this->rgb_to_hsl( $this->color_names[$color], 'array' );

      if ( 'property' == $output ) {
        $hsl = 'hsl(' . implode( ',', $hsl ) . ')';
      }

      return $hsl;
    }
    return '';
  }

  /**
   * Convert color name to HSLA
   *
   * @since   1.0.0
   *
   * @param   string         $color
   * @param   float          $opacity
   * @param   string         $output
   * @return  string|array
   */
  public function name_to_hsla( $color, $opacity = 1, $output = 'property' ) {
    if ( !empty( $this->color_names[$color] ) ) {
      $hsla   = $this->rgb_to_hsl( $this->color_names[$color], 'array' );
      $hsla[] = ($opacity >= 0 && $opacity <= 1) ? $opacity : 1;

      if ( 'property' == $output ) {
        $hsla = 'hsla(' . implode( ',', $hsla ) . ')';
      }

      return $hsla;
    }
    return false;
  }

  /**
   * Convert color name to RGB
   *
   * @since   1.0.0
   *
   * @param   string         $color
   * @param   string         $output
   * @return  string|array
   */
  public function name_to_rgb( $color, $output = 'property' ) {
    if ( !empty( $this->color_names[$color] ) ) {
      $rgb = $this->color_names[$color];

      if ( 'property' == $output ) {
        $rgb = 'rgb(' . implode( ',', $rgb ) . ')';
      }

      return $rgb;
    }
    return false;
  }

  /**
   * Convert color name to RGBA
   *
   * @since   1.0.0
   *
   * @param   string         $color
   * @param   float          $opacity
   * @param   string         $output
   * @return  string|array
   */
  public function name_to_rgba( $color, $opacity = 1, $output = 'property' ) {
    if ( !empty( $this->color_names[$color] ) ) {
      $rgba   = $this->color_names[$color];
      $rgba[] = ($opacity >= 0 && $opacity <= 1) ? $opacity : 1;

      if ( 'property' == $output ) {
        $rgba = 'rgba(' . implode( ',', $rgba ) . ')';
      }

      return $rgba;
    } else {
      return false;
    }
  }

  /**
   *
   * @param string $color
   * @param float $amount
   * @param string $method
   * @return string
   */
  public function darken( $color, $amount, $method = 'relative' ) {
    list($h, $s, $l) = $this->hex_to_hsl( $color, 'array', false );

    switch ( $method ) {
      case 'relative':
        $l -= $l * $amount / 100;
        break;

      default:
        $l -= $amount;
        break;
    }

    $hex = $this->hsl_to_hex( array( $h, $s, $l ), 'property' );
    return $hex;
  }

  /**
   *
   * @param string $color
   * @param float $amount
   * @param string $method
   * @return string
   */
  public function lighten( $color, $amount, $method = 'relative' ) {
    list($h, $s, $l) = $this->hex_to_hsl( $color, 'array', false );

    switch ( $method ) {
      case 'relative':
        $l += $l * $amount / 100;
        break;

      default:
        $l += $amount;
        break;
    }
    $hex = $this->hsl_to_hex( array( $h, $s, $l ), 'property' );
    return $hex;
  }

}
