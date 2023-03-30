<?php
    namespace Marinar\Shops;

    use Marinar\Shops\Database\Seeders\MarinarShopsInstallSeeder;

    class MarinarShops {

        public static function getPackageMainDir() {
            return __DIR__;
        }

        public static function injects() {
            return MarinarShopsInstallSeeder::class;
        }
    }
