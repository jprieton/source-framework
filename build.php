<?php

$phar_path = 'source-framework.phar';

if ( file_exists($phar_path) ) {
  unlink( $phar_path );
}

$phar = new Phar( $phar_path );
$phar->setStub( '<?php __HALT_COMPILER();' );

$folders = [ 'Abstracts', 'Init', 'Template', 'Settings', 'helpers', 'includes', 'admin', 'public' ];

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
