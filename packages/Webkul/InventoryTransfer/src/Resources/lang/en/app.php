<?php

return [
    'inventory-transfers' => [
        'index' => [
            'title'               => 'Inventory Transfers',
            'create-btn'          => 'Create Inventory Transfer',

            'datagrid' => [
                'id'                     => 'ID',
                'reference-number'       => 'Reference Number',
                'assigned-to'            => 'Assigned To',
                'status'                 => 'Status',
                'from-warehouse'         => 'From Warehouse',
                'to-warehouse'           => 'To Warehouse',
                'expected-transfer-date' => 'Expected Transfer Date',
                'created-at'             => 'Created At',
                'view'                   => 'View',
                'delete'                 => 'Delete',
                'confirm-message'        => 'Are you sure you want to delete this inventory transfer order?',
            ],

            'create' => [
                'title'            => 'Create Inventory Transfer',
                'from-warehouse'   => 'From Warehouse',
                'to-warehouse'     => 'To Warehouse',
                'reference-number' => 'Reference Number',
                'save-btn'         => 'Save',
            ],
        ],

        'view' => [
            'title'       => 'Inventory Transfer #:id',
            'created-on'  => 'Created On: :date',
            'print'       => 'Print',
            'all'         => 'All',
            'files'       => 'Files',
            'notes'       => 'Notes',
            'change-logs' => 'Changelogs',
            'items-tab'   => 'Items',

            'actions' => [
                'cancel' => [
                    'title'    => 'Cancel',
                    'reason'   => 'Cancel Reason',
                    'save-btn' => 'Cancel Inventory Transfer',
                ],

                'pick-inventory' => [
                    'title'        => 'Pick Inventory',
                    'save-btn'     => 'Save',
                    'products'     => 'Products',
                    'pick-qty'     => 'Pick Qty',
                    'qty'          => 'Qty',
                    'requested'    => 'Requested Qty',
                    'from'         => 'from :location',
                    'sku'          => 'SKU',
                    'add-location' => 'Add Location',
                ],

                'load-inventory' => [
                    'title'       => 'Load Inventory',
                    'description' => 'Description',
                    'save-btn'    => 'Save',
                ],

                'send-inventory' => [
                    'title'    => 'Send Inventory',
                    'save-btn' => 'Save',
                ],

                'receive-inventory' => [
                    'title'        => 'Receive Inventory',
                    'save-btn'     => 'Save',
                    'products'     => 'Products',
                    'receive-qty'  => 'Receive Qty',
                    'qty'          => 'Qty',
                    'on-order'     => 'On Order',
                    'in'           => 'in',
                    'sku'          => 'SKU',
                    'add-location' => 'Add Location',
                ],
            ],

            'attributes' => [
                'general' => [
                    'title'        => 'General Information',
                    'update-title' => 'Update General Information',
                    'edit-btn'     => 'Edit',
                    'save-btn'     => 'Save',
                    'cancel-btn'   => 'Cancel',
                ],

                'delivery' => [
                    'title'        => 'Delivery Information',
                    'update-title' => 'Update Delivery Information',
                    'edit-btn'     => 'Edit',
                    'save-btn'     => 'Save',
                    'cancel-btn'   => 'Cancel',
                ],
            ],

            'items' => [
                'add-products-btn'    => 'Add Products',
                'add-new-btn'         => 'Add New Product',
                'add-btn'             => 'Add',
                'add-products'        => 'Add Products',
                'create-btn'          => 'Create Product',
                'search-by'           => 'Search products',
                'title'               => 'Items',
                'empty'               => 'No items found.',
                'products'            => 'Products',
                'id'                  => 'ID',
                'name'                => 'Name',
                'sku'                 => 'SKU',
                'from-location'       => 'From :location',
                'add-location'        => 'Add Location',
                'qty'                 => 'Qty',
                'inventories'         => 'Inventories',
                'requested-qty'       => 'Requested Qty',
                'picked-qty'          => 'Picked Qty',
                'received-qty'        => 'Received Qty',
                'location-qty'        => ':location - :qty Qty',
                'on-hand-qty'         => 'On Hand',
                'action'              => 'Action',
                'delete'              => 'Delete',
                'item-confirm-delete' => 'Are you sure you want to delete this item?',
                'empty-title'         => 'No products found.',
                'empty-info'          => 'You can add products by clicking on the "Add Products" button.',
                'search-empty-info'   => 'No products found for the search query.',
            ],
        ],

        'status' => [
            'pending'            => 'Pending',
            'picked'             => 'Picked',
            'partially-picked'   => 'Partially Picked',
            'loaded'             => 'Loaded',
            'in-transit'         => 'In Transit',
            'received'           => 'Received',
            'partially-received' => 'Partially Received',
            'canceled'           => 'Canceled',
        ],

        'pdf' => [
            'title'                  => 'Inventory Transfer',
            'contact-number'         => 'Contact Number',
            'contact'                => 'Contact',
            'reference-number'       => 'Reference Number',
            'transfer-date'          => 'Transfer Date',
            'transfer-id'            => 'Transfer ID',
            'product-name'           => 'Product Name',
            'qty'                    => 'Quantity',
            'qty-value'              => ':location - :qty Qty',
            'sku'                    => 'SKU',
            'shipping-handling'      => 'Shipping Handling',
            'delivery-method'        => 'Delivery Method',
            'expected-transfer-date' => 'Expected Transfer Date',
            'deliver-to'             => 'Deliver To',
            'delivery-details'       => 'Deliver Details',
            'tracking-number'        => 'Tracking Number',
            'requested-qty'          => 'Requested Qty',
            'picked-qty'             => 'Picked Qty',
            'received-qty'           => 'Received Qty',
            'pick-from'              => 'Pick From',
            'deliver-to'             => 'Deliver To',
        ],

        'create-success'             => 'Inventory Transfer created successfully.',
        'update-success'             => 'Inventory Transfer updated successfully.',
        'delete-success'             => 'Inventory Transfer deleted successfully.',
        'delete-failed'              => 'Inventory Transfer can not be deleted.',
        'no-items-error'             => 'Please add items to the inventory transfer first.',
        'no-items-pick-error'        => 'Please pick items to the inventory transfer first.',
        'no-warehouse-error'         => 'Please add delivery information to the inventory transfer first.',
        'invalid-pick-qty-error'     => 'Invalid pick qty for the items.',
        'invalid-receive-qty-error'  => 'Invalid receive qty for the items.',
        'same-location-error'        => 'Pick and receive location can not be same.',
        'already-canceled-error'     => 'Inventory Transfer is already canceled.',
        'already-picked-error-error' => 'Inventory Transfer is already picked.',
    ],

    'settings' => [
        'workflows' => [
            'inventory-transfers' => [
                'attach-pdf'                          => 'Attach PDF',
                'status'                              => 'Status',
                'cancel-description'                  => 'Cancel Reason',
                'created-at'                          => 'Created At',
                'update-inventory-transfer'           => 'Update Inventory Transfer',
                'send-email-to-assignee'              => 'Send Email To Assignee',
                'send-email-to-creator'               => 'Send Email To Creator',
                'send-email-to-source-warehouse'      => 'Send Email To Source Warehouse',
                'send-email-to-destination-warehouse' => 'Send Email To Destination Warehouse',
            ],
        ],
    ],

    'seeders' => [
        'attributes' => [
            'inventory-transfers' => [
                'increment-id'           => 'Increment ID',
                'reference-number'       => 'Reference Number',
                'status'                 => 'Status',
                'shipping-method'        => 'Shipping Method',
                'tracking-number'        => 'Tracking Number',
                'expected-transfer-date' => 'Expected Transfer Date',
                'from-warehouse'         => 'From Warehouse',
                'to-warehouse'           => 'To Warehouse',
                'total-items-count'      => 'Total Items Count',
                'total-qty-requested'    => 'Total Qty Requested',
                'total-qty-received'     => 'Total Qty Received',
                'created-by'             => 'Created By',
                'assigned-to'            => 'Assigned To',
            ],
        ],
    ],

    'acl' => [
        'inventory-transfers' => [
            'title'  => 'Inventory Transfers',
            'create' => 'Create',
            'edit'   => 'Edit',
            'view'   => 'View',
            'delete' => 'Delete',
        ],
    ],
];
