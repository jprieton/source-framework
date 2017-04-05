<?php

$phar = new Phar( 'wc-sitef-gateway.phar' );
$phar->setStub( '<?php __HALT_COMPILER();' );
$phar->buildFromDirectory( __DIR__, '/\.php$/' );
$phar->delete( 'build-phar.php' );
$phar->delete( 'uninstall.php' );
$phar->delete( 'source-framework.php' );
$phar->compressFiles( Phar::GZ );
