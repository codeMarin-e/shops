<?php
    namespace Marinar\Shops\Database\Seeders;

    use App\Models\Shop;
    use Illuminate\Database\Seeder;
    use Marinar\Shops\MarinarShops;
    use Spatie\Permission\Models\Permission;

    class MarinarShopsRemoveSeeder extends Seeder {

        use \Marinar\Marinar\Traits\MarinarSeedersTrait;

        public static function configure() {
            static::$packageName = 'marinar_shops';
            static::$packageDir = MarinarShops::getPackageMainDir();
        }

        public function run() {
            if(!in_array(env('APP_ENV'), ['dev', 'local'])) return;

            $this->autoRemove();

            $this->refComponents->info("Done!");
        }

        public function clearMe() {
            $this->refComponents->task("Clear DB", function() {
                foreach(Shop::get() as $shop) {
                    $shop->delete();
                }
                Permission::whereIn('name', [
                    'shops.view',
                    'shop.create',
                    'shop.update',
                    'shop.delete',
                ])
                ->where('guard_name', 'admin')
                ->delete();
                app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
                return true;
            });
        }
    }
