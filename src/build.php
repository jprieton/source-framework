<?php

$phar_path = '../source-framework.phar';

if ( file_exists( $phar_path ) ) {
  unlink( $phar_path );
}

$phar = new Phar( $phar_path );
$phar->setStub( '<?php __HALT_COMPILER();' );

$folders = [ 'includes/core' ];

foreach ( $folders as $folder ) {
  if ( !file_exists( $folder ) || !is_dir( $folder ) ) {
    continue;
  }

  $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $folder ), RecursiveIteratorIterator::SELF_FIRST );

  foreach ( $files as $file ) {
    $file instanceof SplFileInfo;
    if ( 'php' == $file->getExtension() ) {
      $phar->addFromString( $file->getPathname(), php_strip_whitespace( $file->getPathname() ) );
    }
  }
}

$phar->compressFiles( Phar::GZ );
