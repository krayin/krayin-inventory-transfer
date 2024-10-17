<?php

return [
    'inventory-transfers' => [
        'index' => [
            'title'               => 'تحويلات المخزون',
            'create-btn'          => 'إنشاء تحويل مخزون',

            'datagrid' => [
                'id'                     => 'المعرف',
                'reference-number'       => 'رقم المرجع',
                'assigned-to'            => 'مخصص لـ',
                'status'                 => 'الحالة',
                'from-warehouse'         => 'من المستودع',
                'to-warehouse'           => 'إلى المستودع',
                'expected-transfer-date' => 'تاريخ التحويل المتوقع',
                'created-at'             => 'تم الإنشاء في',
                'view'                   => 'عرض',
                'delete'                 => 'حذف',
                'confirm-message'        => 'هل أنت متأكد أنك تريد حذف أمر تحويل المخزون هذا؟',
            ],

            'create' => [
                'title'            => 'إنشاء تحويل مخزون',
                'from-warehouse'   => 'من المستودع',
                'to-warehouse'     => 'إلى المستودع',
                'reference-number' => 'رقم المرجع',
                'save-btn'         => 'حفظ',
            ],
        ],

        'view' => [
            'title'       => 'تحويل المخزون #:id',
            'created-on'  => 'تم الإنشاء في: :date',
            'print'       => 'طباعة',
            'all'         => 'الكل',
            'files'       => 'الملفات',
            'notes'       => 'ملاحظات',
            'change-logs' => 'سجلات التغيير',
            'items-tab'   => 'العناصر',

            'actions' => [
                'cancel' => [
                    'title'    => 'إلغاء',
                    'reason'   => 'سبب الإلغاء',
                    'save-btn' => 'إلغاء تحويل المخزون',
                ],

                'pick-inventory' => [
                    'title'        => 'اختيار المخزون',
                    'save-btn'     => 'حفظ',
                    'products'     => 'المنتجات',
                    'pick-qty'     => 'الكمية المختارة',
                    'qty'          => 'الكمية',
                    'requested'    => 'الكمية المطلوبة',
                    'from'         => 'من :location',
                    'sku'          => 'SKU',
                    'add-location' => 'إضافة موقع',
                ],

                'load-inventory' => [
                    'title'       => 'تحميل المخزون',
                    'description' => 'الوصف',
                    'save-btn'    => 'حفظ',
                ],

                'send-inventory' => [
                    'title'    => 'إرسال المخزون',
                    'save-btn' => 'حفظ',
                ],

                'receive-inventory' => [
                    'title'        => 'استلام المخزون',
                    'save-btn'     => 'حفظ',
                    'products'     => 'المنتجات',
                    'receive-qty'  => 'الكمية المستلمة',
                    'qty'          => 'الكمية',
                    'on-order'     => 'في الطلب',
                    'in'           => 'في',
                    'sku'          => 'SKU',
                    'add-location' => 'إضافة موقع',
                ],
            ],

            'attributes' => [
                'general' => [
                    'title'        => 'معلومات عامة',
                    'update-title' => 'تحديث المعلومات العامة',
                    'edit-btn'     => 'تحرير',
                    'save-btn'     => 'حفظ',
                    'cancel-btn'   => 'إلغاء',
                ],

                'delivery' => [
                    'title'        => 'معلومات التوصيل',
                    'update-title' => 'تحديث معلومات التوصيل',
                    'edit-btn'     => 'تحرير',
                    'save-btn'     => 'حفظ',
                    'cancel-btn'   => 'إلغاء',
                ],
            ],

            'items' => [
                'add-products-btn'    => 'إضافة منتجات',
                'add-new-btn'         => 'إضافة منتج جديد',
                'add-btn'             => 'إضافة',
                'add-products'        => 'إضافة منتجات',
                'create-btn'          => 'إنشاء منتج',
                'search-by'           => 'البحث عن المنتجات',
                'title'               => 'العناصر',
                'empty'               => 'لم يتم العثور على عناصر.',
                'products'            => 'المنتجات',
                'id'                  => 'المعرف',
                'name'                => 'الاسم',
                'sku'                 => 'SKU',
                'from-location'       => 'من :location',
                'add-location'        => 'إضافة موقع',
                'qty'                 => 'الكمية',
                'inventories'         => 'المخزون',
                'requested-qty'       => 'الكمية المطلوبة',
                'picked-qty'          => 'الكمية المختارة',
                'received-qty'        => 'الكمية المستلمة',
                'location-qty'        => ':location - :qty كمية',
                'on-hand-qty'         => 'في المخزون',
                'action'              => 'الإجراء',
                'delete'              => 'حذف',
                'item-confirm-delete' => 'هل أنت متأكد أنك تريد حذف هذا العنصر؟',
                'empty-title'         => 'لم يتم العثور على منتجات.',
                'empty-info'          => 'يمكنك إضافة منتجات بالنقر على زر "إضافة منتجات".',
                'search-empty-info'   => 'لم يتم العثور على منتجات للبحث المطلوب.',
            ],
        ],

        'status' => [
            'pending'            => 'قيد الانتظار',
            'picked'             => 'تم الاختيار',
            'partially-picked'   => 'تم الاختيار جزئيًا',
            'loaded'             => 'تم التحميل',
            'in-transit'         => 'في الطريق',
            'received'           => 'تم الاستلام',
            'partially-received' => 'تم الاستلام جزئيًا',
            'canceled'           => 'ملغاة',
        ],

        'pdf' => [
            'title'                  => 'تحويل المخزون',
            'contact-number'         => 'رقم الاتصال',
            'contact'                => 'الاتصال',
            'reference-number'       => 'رقم المرجع',
            'transfer-date'          => 'تاريخ التحويل',
            'transfer-id'            => 'معرف التحويل',
            'product-name'           => 'اسم المنتج',
            'qty'                    => 'الكمية',
            'qty-value'              => ':location - :qty كمية',
            'sku'                    => 'SKU',
            'shipping-handling'      => 'الشحن والمناولة',
            'delivery-method'        => 'طريقة التوصيل',
            'expected-transfer-date' => 'تاريخ التحويل المتوقع',
            'deliver-to'             => 'التوصيل إلى',
            'delivery-details'       => 'تفاصيل التوصيل',
            'tracking-number'        => 'رقم التتبع',
            'requested-qty'          => 'الكمية المطلوبة',
            'picked-qty'             => 'الكمية المختارة',
            'received-qty'           => 'الكمية المستلمة',
            'pick-from'              => 'اختيار من',
            'deliver-to'             => 'التوصيل إلى',
        ],

        'create-success'             => 'تم إنشاء تحويل المخزون بنجاح.',
        'update-success'             => 'تم تحديث تحويل المخزون بنجاح.',
        'delete-success'             => 'تم حذف تحويل المخزون بنجاح.',
        'delete-failed'              => 'لا يمكن حذف تحويل المخزون.',
        'no-items-error'             => 'يرجى إضافة عناصر إلى تحويل المخزون أولاً.',
        'no-items-pick-error'        => 'يرجى اختيار عناصر إلى تحويل المخزون أولاً.',
        'no-warehouse-error'         => 'يرجى إضافة معلومات التوصيل إلى تحويل المخزون أولاً.',
        'invalid-pick-qty-error'     => 'كمية الاختيار غير صالحة للعناصر.',
        'invalid-receive-qty-error'  => 'كمية الاستلام غير صالحة للعناصر.',
        'same-location-error'        => 'لا يمكن أن يكون موقع الاختيار والاستلام متماثلاً.',
        'already-canceled-error'     => 'تحويل المخزون ملغى بالفعل.',
        'already-picked-error-error' => 'تم اختيار تحويل المخزون بالفعل.',
    ],

    'settings' => [
        'workflows' => [
            'inventory-transfers' => [
                'attach-pdf'                          => 'إرفاق ملف PDF',
                'status'                              => 'الحالة',
                'cancel-description'                  => 'سبب الإلغاء',
                'created-at'                          => 'تاريخ الإنشاء',
                'update-inventory-transfer'           => 'تحديث نقل المخزون',
                'send-email-to-assignee'              => 'إرسال بريد إلكتروني إلى المسؤول',
                'send-email-to-creator'               => 'إرسال بريد إلكتروني إلى المنشئ',
                'send-email-to-source-warehouse'      => 'إرسال بريد إلكتروني إلى مستودع المصدر',
                'send-email-to-destination-warehouse' => 'إرسال بريد إلكتروني إلى مستودع الوجهة',
            ],
        ],
    ],

    'seeders' => [
        'attributes' => [
            'inventory-transfers' => [
                'increment-id'           => 'معرف الزيادة',
                'reference-number'       => 'رقم المرجع',
                'status'                 => 'الحالة',
                'shipping-method'        => 'طريقة الشحن',
                'tracking-number'        => 'رقم التتبع',
                'expected-transfer-date' => 'تاريخ النقل المتوقع',
                'from-warehouse'         => 'من المستودع',
                'to-warehouse'           => 'إلى المستودع',
                'total-items-count'      => 'إجمالي عدد العناصر',
                'total-qty-requested'    => 'إجمالي الكمية المطلوبة',
                'total-qty-received'     => 'إجمالي الكمية المستلمة',
                'created-by'             => 'أنشأ بواسطة',
                'assigned-to'            => 'مخصص لـ',
            ],
        ],
    ],

    'acl' => [
        'inventory-transfers' => [
            'title'  => 'نقل المخزون',
            'create' => 'إنشاء',
            'edit'   => 'تعديل',
            'view'   => 'عرض',
            'delete' => 'حذف',
        ],
    ],
];
