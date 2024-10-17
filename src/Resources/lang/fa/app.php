<?php 

return [
    'inventory-transfers' => [
        'index' => [
            'title'               => 'انتقال موجودی',
            'create-btn'          => 'ایجاد انتقال موجودی',

            'datagrid' => [
                'id'                     => 'شناسه',
                'reference-number'       => 'شماره مرجع',
                'assigned-to'            => 'تخصیص داده شده به',
                'status'                 => 'وضعیت',
                'from-warehouse'         => 'از انبار',
                'to-warehouse'           => 'به انبار',
                'expected-transfer-date' => 'تاریخ انتظار انتقال',
                'created-at'             => 'ایجاد شده در',
                'view'                   => 'مشاهده',
                'delete'                 => 'حذف',
                'confirm-message'        => 'آیا مطمئن هستید که می‌خواهید این سفارش انتقال موجودی را حذف کنید؟',
            ],

            'create' => [
                'title'            => 'ایجاد انتقال موجودی',
                'from-warehouse'   => 'از انبار',
                'to-warehouse'     => 'به انبار',
                'reference-number' => 'شماره مرجع',
                'save-btn'         => 'ذخیره',
            ],
        ],

        'view' => [
            'title'       => 'انتقال موجودی #:id',
            'created-on'  => 'ایجاد شده در: :date',
            'print'       => 'چاپ',
            'all'         => 'همه',
            'files'       => 'فایل‌ها',
            'notes'       => 'یادداشت‌ها',
            'change-logs' => 'لاگ‌های تغییرات',
            'items-tab'   => 'موارد',

            'actions' => [
                'cancel' => [
                    'title'    => 'لغو',
                    'reason'   => 'دلیل لغو',
                    'save-btn' => 'لغو انتقال موجودی',
                ],

                'pick-inventory' => [
                    'title'        => 'انتخاب موجودی',
                    'save-btn'     => 'ذخیره',
                    'products'     => 'محصولات',
                    'pick-qty'     => 'تعداد انتخابی',
                    'qty'          => 'تعداد',
                    'requested'    => 'تعداد درخواست شده',
                    'from'         => 'از :location',
                    'sku'          => 'کد کالا',
                    'add-location' => 'افزودن مکان',
                ],

                'load-inventory' => [
                    'title'       => 'بارگیری موجودی',
                    'description' => 'توضیحات',
                    'save-btn'    => 'ذخیره',
                ],

                'send-inventory' => [
                    'title'    => 'ارسال موجودی',
                    'save-btn' => 'ذخیره',
                ],

                'receive-inventory' => [
                    'title'        => 'دریافت موجودی',
                    'save-btn'     => 'ذخیره',
                    'products'     => 'محصولات',
                    'receive-qty'  => 'تعداد دریافتی',
                    'qty'          => 'تعداد',
                    'on-order'     => 'در سفارش',
                    'in'           => 'در',
                    'sku'          => 'کد کالا',
                    'add-location' => 'افزودن مکان',
                ],
            ],

            'attributes' => [
                'general' => [
                    'title'        => 'اطلاعات عمومی',
                    'update-title' => 'به‌روزرسانی اطلاعات عمومی',
                    'edit-btn'     => 'ویرایش',
                    'save-btn'     => 'ذخیره',
                    'cancel-btn'   => 'لغو',
                ],

                'delivery' => [
                    'title'        => 'اطلاعات تحویل',
                    'update-title' => 'به‌روزرسانی اطلاعات تحویل',
                    'edit-btn'     => 'ویرایش',
                    'save-btn'     => 'ذخیره',
                    'cancel-btn'   => 'لغو',
                ],
            ],

            'items' => [
                'add-products-btn'    => 'افزودن محصولات',
                'add-new-btn'         => 'افزودن محصول جدید',
                'add-btn'             => 'افزودن',
                'add-products'        => 'افزودن محصولات',
                'create-btn'          => 'ایجاد محصول',
                'search-by'           => 'جستجوی محصولات',
                'title'               => 'موارد',
                'empty'               => 'موردی یافت نشد.',
                'products'            => 'محصولات',
                'id'                  => 'شناسه',
                'name'                => 'نام',
                'sku'                 => 'کد کالا',
                'from-location'       => 'از :location',
                'add-location'        => 'افزودن مکان',
                'qty'                 => 'تعداد',
                'inventories'         => 'موجودی‌ها',
                'requested-qty'       => 'تعداد درخواست شده',
                'picked-qty'          => 'تعداد انتخاب شده',
                'received-qty'        => 'تعداد دریافت شده',
                'location-qty'        => ':location - :qty تعداد',
                'on-hand-qty'         => 'در دست',
                'action'              => 'عمل',
                'delete'              => 'حذف',
                'item-confirm-delete' => 'آیا مطمئن هستید که می‌خواهید این مورد را حذف کنید؟',
                'empty-title'         => 'محصولی یافت نشد.',
                'empty-info'          => 'می‌توانید با کلیک روی دکمه "افزودن محصولات" محصولات اضافه کنید.',
                'search-empty-info'   => 'محصولی برای جستجوی مورد نظر یافت نشد.',
            ],
        ],

        'status' => [
            'pending'            => 'در انتظار',
            'picked'             => 'انتخاب شده',
            'partially-picked'   => 'بخشی انتخاب شده',
            'loaded'             => 'بارگیری شده',
            'in-transit'         => 'در حال انتقال',
            'received'           => 'دریافت شده',
            'partially-received' => 'بخشی دریافت شده',
            'canceled'           => 'لغو شده',
        ],

        'pdf' => [
            'title'                  => 'انتقال موجودی',
            'contact-number'         => 'شماره تماس',
            'contact'                => 'تماس',
            'reference-number'       => 'شماره مرجع',
            'transfer-date'          => 'تاریخ انتقال',
            'transfer-id'            => 'شناسه انتقال',
            'product-name'           => 'نام محصول',
            'qty'                    => 'تعداد',
            'qty-value'              => ':location - :qty تعداد',
            'sku'                    => 'کد کالا',
            'shipping-handling'      => 'حمل و نقل',
            'delivery-method'        => 'روش تحویل',
            'expected-transfer-date' => 'تاریخ انتظار انتقال',
            'deliver-to'             => 'تحویل به',
            'delivery-details'       => 'جزئیات تحویل',
            'tracking-number'        => 'شماره پیگیری',
            'requested-qty'          => 'تعداد درخواست شده',
            'picked-qty'             => 'تعداد انتخاب شده',
            'received-qty'           => 'تعداد دریافت شده',
            'pick-from'              => 'انتخاب از',
            'deliver-to'             => 'تحویل به',
        ],

        'create-success'             => 'انتقال موجودی با موفقیت ایجاد شد.',
        'update-success'             => 'انتقال موجودی با موفقیت به‌روزرسانی شد.',
        'delete-success'             => 'انتقال موجودی با موفقیت حذف شد.',
        'delete-failed'              => 'انتقال موجودی نمی‌تواند حذف شود.',
        'no-items-error'             => 'لطفاً ابتدا مواردی به انتقال موجودی اضافه کنید.',
        'no-items-pick-error'        => 'لطفاً ابتدا مواردی به انتقال موجودی انتخاب کنید.',
        'no-warehouse-error'         => 'لطفاً ابتدا اطلاعات تحویل را به انتقال موجودی اضافه کنید.',
        'invalid-pick-qty-error'     => 'تعداد انتخابی نامعتبر برای موارد.',
        'invalid-receive-qty-error'  => 'تعداد دریافتی نامعتبر برای موارد.',
        'same-location-error'        => 'مکان انتخاب و دریافت نمی‌تواند یکسان باشد.',
        'already-canceled-error'     => 'انتقال موجودی قبلاً لغو شده است.',
        'already-picked-error-error' => 'انتقال موجودی قبلاً انتخاب شده است.',
    ],

    'settings' => [
        'workflows' => [
            'inventory-transfers' => [
                'attach-pdf'                          => 'ضمیمه PDF',
                'status'                              => 'وضعیت',
                'cancel-description'                  => 'دلیل لغو',
                'created-at'                          => 'ایجاد شده در',
                'update-inventory-transfer'           => 'به‌روزرسانی انتقال موجودی',
                'send-email-to-assignee'              => 'ارسال ایمیل به شخص تخصیص یافته',
                'send-email-to-creator'               => 'ارسال ایمیل به ایجادکننده',
                'send-email-to-source-warehouse'      => 'ارسال ایمیل به انبار مبدا',
                'send-email-to-destination-warehouse' => 'ارسال ایمیل به انبار مقصد',
            ],
        ],
    ],

    'seeders' => [
        'attributes' => [
            'inventory-transfers' => [
                'increment-id'           => 'شناسه افزایشی',
                'reference-number'       => 'شماره مرجع',
                'status'                 => 'وضعیت',
                'shipping-method'        => 'روش حمل و نقل',
                'tracking-number'        => 'شماره پیگیری',
                'expected-transfer-date' => 'تاریخ انتظار انتقال',
                'from-warehouse'         => 'از انبار',
                'to-warehouse'           => 'به انبار',
                'total-items-count'      => 'مجموع تعداد اقلام',
                'total-qty-requested'    => 'مجموع تعداد درخواست شده',
                'total-qty-received'     => 'مجموع تعداد دریافت شده',
                'created-by'             => 'ایجاد شده توسط',
                'assigned-to'            => 'تخصیص داده شده به',
            ],
        ],
    ],

    'acl' => [
        'inventory-transfers' => [
            'title'  => 'انتقال‌های موجودی',
            'create' => 'ایجاد',
            'edit'   => 'ویرایش',
            'view'   => 'مشاهده',
            'delete' => 'حذف',
        ],
    ],

];