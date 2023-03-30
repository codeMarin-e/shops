<?php
    namespace Marinar\Shops\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Marinar\Shops\MarinarShops;

    class MarinarShopsInstallSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public static function configure() {
            static::$packageName = 'marinar_shops';
            static::$packageDir = MarinarShops::getPackageMainDir();
        }

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

            $this->autoInstall();

            $this->refComponents->info("Done!");
        }

    }
