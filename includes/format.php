<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Obfuscate a string to prevent spam-bots from sniffing it.
 *
 * @since   1.0.0
 *
 * @param   string              $text
 * @return  string
 */
function obfuscate( $text ) {
  $safe = '';
  foreach ( str_split( $text ) as $letter ) {
    if ( ord( $letter ) > 128 ) {
      return $letter;
    }
    // To properly obfuscate the value, we will randomly convert each letter to
    // its entity or hexadecimal representation, keeping a bot from sniffing
    // the randomly obfuscated letters out of the string on the responses.
    switch ( rand( 1, 3 ) ) {
      case 1:
        $safe .= '&#' . ord( $letter ) . ';';
        break;
      case 2:
        $safe .= '&#x' . dechex( ord( $letter ) ) . ';';
        break;
      case 3:
        $safe .= $letter;
    }
  }
  return $safe;
}

/**
 * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
 *
 * @since   1.0.0
 *
 * @param   string              $email
 * @return  string
 */
function obfuscate_email( $email ) {
  return str_replace( '@', '&#64;', obfuscate( $email ) );
}
