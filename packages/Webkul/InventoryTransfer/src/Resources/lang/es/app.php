<?php

return [
    'inventory-transfers' => [
        'index' => [
            'title'               => 'Transferencias de Inventario',
            'create-btn'          => 'Crear Transferencia de Inventario',

            'datagrid' => [
                'id'                     => 'ID',
                'reference-number'       => 'Número de Referencia',
                'assigned-to'            => 'Asignado a',
                'status'                 => 'Estado',
                'from-warehouse'         => 'Desde Almacén',
                'to-warehouse'           => 'Hacia Almacén',
                'expected-transfer-date' => 'Fecha de Transferencia Esperada',
                'created-at'             => 'Creado el',
                'view'                   => 'Ver',
                'delete'                 => 'Eliminar',
                'confirm-message'        => '¿Estás seguro de que deseas eliminar esta orden de transferencia de inventario?',
            ],

            'create' => [
                'title'            => 'Crear Transferencia de Inventario',
                'from-warehouse'   => 'Desde Almacén',
                'to-warehouse'     => 'Hacia Almacén',
                'reference-number' => 'Número de Referencia',
                'save-btn'         => 'Guardar',
            ],
        ],

        'view' => [
            'title'       => 'Transferencia de Inventario #:id',
            'created-on'  => 'Creado el: :date',
            'print'       => 'Imprimir',
            'all'         => 'Todos',
            'files'       => 'Archivos',
            'notes'       => 'Notas',
            'change-logs' => 'Historial de Cambios',
            'items-tab'   => 'Artículos',

            'actions' => [
                'cancel' => [
                    'title'    => 'Cancelar',
                    'reason'   => 'Razón de Cancelación',
                    'save-btn' => 'Cancelar Transferencia de Inventario',
                ],

                'pick-inventory' => [
                    'title'        => 'Seleccionar Inventario',
                    'save-btn'     => 'Guardar',
                    'products'     => 'Productos',
                    'pick-qty'     => 'Cantidad Seleccionada',
                    'qty'          => 'Cantidad',
                    'requested'    => 'Cantidad Solicitada',
                    'from'         => 'desde :location',
                    'sku'          => 'SKU',
                    'add-location' => 'Agregar Ubicación',
                ],

                'load-inventory' => [
                    'title'       => 'Cargar Inventario',
                    'description' => 'Descripción',
                    'save-btn'    => 'Guardar',
                ],

                'send-inventory' => [
                    'title'    => 'Enviar Inventario',
                    'save-btn' => 'Guardar',
                ],

                'receive-inventory' => [
                    'title'        => 'Recibir Inventario',
                    'save-btn'     => 'Guardar',
                    'products'     => 'Productos',
                    'receive-qty'  => 'Cantidad Recibida',
                    'qty'          => 'Cantidad',
                    'on-order'     => 'En Orden',
                    'in'           => 'en',
                    'sku'          => 'SKU',
                    'add-location' => 'Agregar Ubicación',
                ],
            ],

            'attributes' => [
                'general' => [
                    'title'        => 'Información General',
                    'update-title' => 'Actualizar Información General',
                    'edit-btn'     => 'Editar',
                    'save-btn'     => 'Guardar',
                    'cancel-btn'   => 'Cancelar',
                ],

                'delivery' => [
                    'title'        => 'Información de Entrega',
                    'update-title' => 'Actualizar Información de Entrega',
                    'edit-btn'     => 'Editar',
                    'save-btn'     => 'Guardar',
                    'cancel-btn'   => 'Cancelar',
                ],
            ],

            'items' => [
                'add-products-btn'    => 'Agregar Productos',
                'add-new-btn'         => 'Agregar Nuevo Producto',
                'add-btn'             => 'Agregar',
                'add-products'        => 'Agregar Productos',
                'create-btn'          => 'Crear Producto',
                'search-by'           => 'Buscar productos',
                'title'               => 'Artículos',
                'empty'               => 'No se encontraron artículos.',
                'products'            => 'Productos',
                'id'                  => 'ID',
                'name'                => 'Nombre',
                'sku'                 => 'SKU',
                'from-location'       => 'Desde :location',
                'add-location'        => 'Agregar Ubicación',
                'qty'                 => 'Cantidad',
                'inventories'         => 'Inventarios',
                'requested-qty'       => 'Cantidad Solicitada',
                'picked-qty'          => 'Cantidad Seleccionada',
                'received-qty'        => 'Cantidad Recibida',
                'location-qty'        => ':location - :qty Cantidad',
                'on-hand-qty'         => 'Disponible',
                'action'              => 'Acción',
                'delete'              => 'Eliminar',
                'item-confirm-delete' => '¿Estás seguro de que deseas eliminar este artículo?',
                'empty-title'         => 'No se encontraron productos.',
                'empty-info'          => 'Puedes agregar productos haciendo clic en el botón "Agregar Productos".',
                'search-empty-info'   => 'No se encontraron productos para la consulta de búsqueda.',
            ],
        ],

        'status' => [
            'pending'            => 'Pendiente',
            'picked'             => 'Seleccionado',
            'partially-picked'   => 'Parcialmente Seleccionado',
            'loaded'             => 'Cargado',
            'in-transit'         => 'En Tránsito',
            'received'           => 'Recibido',
            'partially-received' => 'Parcialmente Recibido',
            'canceled'           => 'Cancelado',
        ],

        'pdf' => [
            'title'                  => 'Transferencia de Inventario',
            'contact-number'         => 'Número de Contacto',
            'contact'                => 'Contacto',
            'reference-number'       => 'Número de Referencia',
            'transfer-date'          => 'Fecha de Transferencia',
            'transfer-id'            => 'ID de Transferencia',
            'product-name'           => 'Nombre del Producto',
            'qty'                    => 'Cantidad',
            'qty-value'              => ':location - :qty Cantidad',
            'sku'                    => 'SKU',
            'shipping-handling'      => 'Manejo de Envío',
            'delivery-method'        => 'Método de Entrega',
            'expected-transfer-date' => 'Fecha de Transferencia Esperada',
            'deliver-to'             => 'Entregar a',
            'delivery-details'       => 'Detalles de Entrega',
            'tracking-number'        => 'Número de Seguimiento',
            'requested-qty'          => 'Cantidad Solicitada',
            'picked-qty'             => 'Cantidad Seleccionada',
            'received-qty'           => 'Cantidad Recibida',
            'pick-from'              => 'Seleccionar Desde',
            'deliver-to'             => 'Entregar a',
        ],

        'create-success'             => 'Transferencia de Inventario creada con éxito.',
        'update-success'             => 'Transferencia de Inventario actualizada con éxito.',
        'delete-success'             => 'Transferencia de Inventario eliminada con éxito.',
        'delete-failed'              => 'La Transferencia de Inventario no se puede eliminar.',
        'no-items-error'             => 'Por favor, agrega artículos a la transferencia de inventario primero.',
        'no-items-pick-error'        => 'Por favor, selecciona artículos para la transferencia de inventario primero.',
        'no-warehouse-error'         => 'Por favor, agrega información de entrega a la transferencia de inventario primero.',
        'invalid-pick-qty-error'     => 'Cantidad seleccionada no válida para los artículos.',
        'invalid-receive-qty-error'  => 'Cantidad recibida no válida para los artículos.',
        'same-location-error'        => 'La ubicación de selección y recepción no puede ser la misma.',
        'already-canceled-error'     => 'La Transferencia de Inventario ya está cancelada.',
        'already-picked-error-error' => 'La Transferencia de Inventario ya está seleccionada.',
    ],

    'settings' => [
        'workflows' => [
            'inventory-transfers' => [
                'attach-pdf'                          => 'Adjuntar PDF',
                'status'                              => 'Estado',
                'cancel-description'                  => 'Razón de Cancelación',
                'created-at'                          => 'Creado el',
                'update-inventory-transfer'           => 'Actualizar Transferencia de Inventario',
                'send-email-to-assignee'              => 'Enviar Correo al Asignado',
                'send-email-to-creator'               => 'Enviar Correo al Creador',
                'send-email-to-source-warehouse'      => 'Enviar Correo al Almacén de Origen',
                'send-email-to-destination-warehouse' => 'Enviar Correo al Almacén de Destino',
            ],
        ],
    ],

    'seeders' => [
        'attributes' => [
            'inventory-transfers' => [
                'increment-id'           => 'ID Incremental',
                'reference-number'       => 'Número de Referencia',
                'status'                 => 'Estado',
                'shipping-method'        => 'Método de Envío',
                'tracking-number'        => 'Número de Seguimiento',
                'expected-transfer-date' => 'Fecha de Transferencia Esperada',
                'from-warehouse'         => 'Desde Almacén',
                'to-warehouse'           => 'Hacia Almacén',
                'total-items-count'      => 'Cantidad Total de Artículos',
                'total-qty-requested'    => 'Cantidad Total Solicitada',
                'total-qty-received'     => 'Cantidad Total Recibida',
                'created-by'             => 'Creado Por',
                'assigned-to'            => 'Asignado a',
            ],
        ],
    ],

    'acl' => [
        'inventory-transfers' => [
            'title'  => 'Transferencias de Inventario',
            'create' => 'Crear',
            'edit'   => 'Editar',
            'view'   => 'Ver',
            'delete' => 'Eliminar',
        ],
    ],
];
