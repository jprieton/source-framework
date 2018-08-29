<?php

$phar_path = __DIR__ . '/source-framework.phar';

if ( file_exists( $phar_path ) ) {
  unlink( $phar_path );
}

$phar = new Phar( $phar_path );
$phar->setStub( '<?php __HALT_COMPILER();' );

$folders = [
    'includes/admin',
    'includes/ajax',
    'includes/core',
    'includes/data',
    'includes/partials',
    'includes/shortcode',
    'includes/template',
    'includes/tools',
    'includes/vendor',
];

foreach ( $folders as $folder ) {
  $folder = __DIR__ . '/' . $folder;

  if ( !file_exists( $folder ) || !is_dir( $folder ) ) {
    continue;
  }

  $files = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $folder ), RecursiveIteratorIterator::SELF_FIRST );

  foreach ( $files as $file ) {
    $file instanceof SplFileInfo;

    // Tested in Ubuntu using CLI and Grunt, must be tested in Windows
    $filename = str_replace( __DIR__ . '/', '', $file->getPathname() );

    if ( 'php' == $file->getExtension() ) {
      $phar->addFromString( $filename, php_strip_whitespace( $filename ) );
    }
  }
}

$phar->compressFiles( Phar::GZ );
