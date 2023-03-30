<?php
//    $dbDir = [ dirname(__DIR__), 'Database', 'migrations' ];
//    $dbDir = implode( DIRECTORY_SEPARATOR, $dbDir );
	return [
		'install' => [
            'php artisan db:seed --class="\Marinar\Shops\Database\Seeders\MarinarShopsInstallSeeder"',
		],
		'remove' => [
            'php artisan db:seed --class="\Marinar\Shops\Database\Seeders\MarinarShopsRemoveSeeder"',
        ]
	];
