# Krayin Inventory Transfer Extension

Optimize your inventory management within Krayin CRM with the Inventory Transfer Extension. This powerful tool allows administrators to effortlessly manage inventory relocation across different bins or warehouses, ensuring precise control and real-time tracking of stock levels. Whether you need to transfer items between bins within the same warehouse or relocate stock across different warehouses, this extension makes the process seamless and efficient.

## Key Features

1. **Bin to Bin Transfer**:
   - Easily transfer inventory items between different bins within the same warehouse.
   - Track the movement of items in real-time to maintain accurate inventory records.

2. **Warehouse to Warehouse Transfer**:
   - Facilitate smooth and efficient transfer of inventory between different warehouse locations.
   - Monitor stock levels across warehouses to ensure optimal distribution and avoid stockouts or overstocking.

## Requirements

- **Krayin**: v2.0.0

## Installation

To install the Krayin Inventory Transfer Extension, follow these detailed steps:

1. **Extract and Merge Files**:
   - Unzip the extension package.
   - Merge the `packages` folder from the extension into the root directory of your Krayin CRM project.

2. **Update Composer Autoload**:
   - Open the `composer.json` file in your project root.
   - Under the `'psr-4'` section, add the following line to ensure proper autoloading of the extension:

   ```json
   "Webkul\\InventoryTransfer\\": "packages/Webkul/InventoryTransfer/src"
   ```

3. **Register the Service Provider**:
   - In the `config/app.php` file, locate the `'providers'` array.
   - Add the following line to register the Inventory Transfer Service Provider:

   ```php
   Webkul\InventoryTransfer\Providers\InventoryTransferServiceProvider::class,
   ```

4. **Register the Module Service Provider**:
   - In the `config/concord.php` file, locate the `'modules'` array.
   - Add the following line to register the Inventory Transfer Service Provider:

   ```php
   Webkul\InventoryTransfer\Providers\ModuleServiceProvider::class,

5. **Configure Vite Assets**:
   - Open the `config/krayin-vite.php` file.
   - Under the `'viters'` section, add the following configuration for the Inventory Transfer extension:

   ```php
   'inventory_transfer' => [
       'hot_file'                 => 'inventory-transfer-vite.hot',
       'build_directory'          => 'inventory-transfer/build',
       'package_assets_directory' => 'src/Resources/assets',
   ],
   ```

6. **Update Composer Autoload**:
   - Run the following command to refresh the Composer autoload files:

   ```bash
   composer dump-autoload
   ```

7. **Run Database Migrations**:
   - Execute the following command to migrate the necessary tables into your database:

   ```bash
   php artisan migrate
   ```

8. **Seed the Database**:
   - Seed the necessary data by running:

   ```bash
   php artisan db:seed --class=\Webkul\\InventoryTransfer\\Database\\Seeders\\DatabaseSeeder
   ```

9. **Publish Static Assets**:
   - Finally, publish the extension's static assets to the public directory with the following command:

   ```bash
   php artisan vendor:publish --provider=\Webkul\\InventoryTransfer\\Providers\\InventoryTransferServiceProvider
   ```