<?php

if ( file_exists( 'source-framework.phar' ) ) {
  unlink( 'source-framework.phar' );
}

$phar = new Phar( 'source-framework.phar' );
$phar->setStub( '<?php __HALT_COMPILER();' );

$folders = [ 'Abstracts', 'Init', 'Template', 'core', 'helpers', 'includes', 'admin', 'public' ];

foreach ( $folders as $folder ) {
  $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $folder ), RecursiveIteratorIterator::SELF_FIRST );

  foreach ( $files as $file ) {
    if ( preg_match( '/\.php$/', $file ) ) {
      $file instanceof SplFileInfo;
      $phar->addFromString( $file->getPathname(), php_strip_whitespace( $file->getPathname() ) );
    }
  }
}
$phar->compressFiles( Phar::GZ );
