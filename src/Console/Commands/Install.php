<?php

namespace Webkul\InventoryTransfer\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'krayin-inventory-transfer:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will install and configure Krayin Inventory Transfer.';

    /**
     * Install and configure bagisto rest api.
     */
    public function handle()
    {
        $this->info('📦 Step 1: Running database migrations...');
        try {
            $this->call('migrate');
        } catch (\Exception $e) {
            $this->error('❌ Database migration failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('🌱 Step 2: Seeding the database...');
        try {
            $this->call('db:seed', [
                '--class' => 'Webkul\\InventoryTransfer\\Database\\Seeders\\DatabaseSeeder',
            ]);
        } catch (\Exception $e) {
            $this->error('❌ Database seeding failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('📂 Step 3: Publishing static assets...');
        try {
            $this->call('vendor:publish', [
                '--provider' => 'Webkul\\InventoryTransfer\\Providers\\InventoryTransferServiceProvider',
            ]);
        } catch (\Exception $e) {
            $this->error('❌ Static assets publishing failed: ' . $e->getMessage());
            return 1;
        }

        $this->info('🎉 Installation complete!');
        return 0;
    }
}
