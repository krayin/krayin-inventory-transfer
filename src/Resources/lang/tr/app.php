<?php

return [
    'inventory-transfers' => [
        'index' => [
            'title'               => 'Stok Transferleri',
            'create-btn'          => 'Stok Transferi Oluştur',

            'datagrid' => [
                'id'                     => 'ID',
                'reference-number'       => 'Referans Numarası',
                'assigned-to'            => 'Atanan Kişi',
                'status'                 => 'Durum',
                'from-warehouse'         => 'Gönderen Depo',
                'to-warehouse'           => 'Alan Depo',
                'expected-transfer-date' => 'Beklenen Transfer Tarihi',
                'created-at'             => 'Oluşturulma Tarihi',
                'view'                   => 'Görünüm',
                'delete'                 => 'Sil',
                'confirm-message'        => 'Bu stok transfer emrini silmek istediğinizden emin misiniz?',
            ],

            'create' => [
                'title'            => 'Stok Transferi Oluştur',
                'from-warehouse'   => 'Gönderen Depo',
                'to-warehouse'     => 'Alan Depo',
                'reference-number' => 'Referans Numarası',
                'save-btn'         => 'Kaydet',
            ],
        ],

        'view' => [
            'title'       => 'Stok Transferi #:id',
            'created-on'  => 'Oluşturulma Tarihi: :date',
            'print'       => 'Yazdır',
            'all'         => 'Tümü',
            'files'       => 'Dosyalar',
            'notes'       => 'Notlar',
            'change-logs' => 'Değişiklik Günlükleri',
            'items-tab'   => 'Ürünler',

            'actions' => [
                'cancel' => [
                    'title'    => 'İptal',
                    'reason'   => 'İptal Nedeni',
                    'save-btn' => 'Stok Transferini İptal Et',
                ],

                'pick-inventory' => [
                    'title'        => 'Stok Seçimi',
                    'save-btn'     => 'Kaydet',
                    'products'     => 'Ürünler',
                    'pick-qty'     => 'Seçilen Miktar',
                    'qty'          => 'Miktar',
                    'requested'    => 'Talep Edilen Miktar',
                    'from'         => ':location\'dan',
                    'sku'          => 'SKU',
                    'add-location' => 'Lokasyon Ekle',
                ],

                'load-inventory' => [
                    'title'       => 'Stok Yükle',
                    'description' => 'Açıklama',
                    'save-btn'    => 'Kaydet',
                ],

                'send-inventory' => [
                    'title'    => 'Stok Gönder',
                    'save-btn' => 'Kaydet',
                ],

                'receive-inventory' => [
                    'title'        => 'Stok Al',
                    'save-btn'     => 'Kaydet',
                    'products'     => 'Ürünler',
                    'receive-qty'  => 'Alınan Miktar',
                    'qty'          => 'Miktar',
                    'on-order'     => 'Siparişte',
                    'in'           => 'içinde',
                    'sku'          => 'SKU',
                    'add-location' => 'Lokasyon Ekle',
                ],
            ],

            'attributes' => [
                'general' => [
                    'title'        => 'Genel Bilgiler',
                    'update-title' => 'Genel Bilgileri Güncelle',
                    'edit-btn'     => 'Düzenle',
                    'save-btn'     => 'Kaydet',
                    'cancel-btn'   => 'İptal',
                ],

                'delivery' => [
                    'title'        => 'Teslimat Bilgileri',
                    'update-title' => 'Teslimat Bilgilerini Güncelle',
                    'edit-btn'     => 'Düzenle',
                    'save-btn'     => 'Kaydet',
                    'cancel-btn'   => 'İptal',
                ],
            ],

            'items' => [
                'add-products-btn'    => 'Ürün Ekle',
                'add-new-btn'         => 'Yeni Ürün Ekle',
                'add-btn'             => 'Ekle',
                'add-products'        => 'Ürünleri Ekle',
                'create-btn'          => 'Ürün Oluştur',
                'search-by'           => 'Ürünleri Ara',
                'title'               => 'Ürünler',
                'empty'               => 'Hiçbir ürün bulunamadı.',
                'products'            => 'Ürünler',
                'id'                  => 'ID',
                'name'                => 'Ad',
                'sku'                 => 'SKU',
                'from-location'       => ':location\'dan',
                'add-location'        => 'Lokasyon Ekle',
                'qty'                 => 'Miktar',
                'inventories'         => 'Envanterler',
                'requested-qty'       => 'Talep Edilen Miktar',
                'picked-qty'          => 'Seçilen Miktar',
                'received-qty'        => 'Alınan Miktar',
                'location-qty'        => ':location - :qty Miktar',
                'on-hand-qty'         => 'Elde',
                'action'              => 'İşlem',
                'delete'              => 'Sil',
                'item-confirm-delete' => 'Bu ürünü silmek istediğinizden emin misiniz?',
                'empty-title'         => 'Hiç ürün bulunamadı.',
                'empty-info'          => 'Ürün eklemek için "Ürün Ekle" butonuna tıklayabilirsiniz.',
                'search-empty-info'   => 'Arama sorgusu için hiçbir ürün bulunamadı.',
            ],
        ],

        'status' => [
            'pending'            => 'Beklemede',
            'picked'             => 'Seçildi',
            'partially-picked'   => 'Kısmen Seçildi',
            'loaded'             => 'Yüklendi',
            'in-transit'         => 'Yolda',
            'received'           => 'Alındı',
            'partially-received' => 'Kısmen Alındı',
            'canceled'           => 'İptal Edildi',
        ],

        'pdf' => [
            'title'                  => 'Stok Transferi',
            'contact-number'         => 'İletişim Numarası',
            'contact'                => 'İletişim',
            'reference-number'       => 'Referans Numarası',
            'transfer-date'          => 'Transfer Tarihi',
            'transfer-id'            => 'Transfer ID',
            'product-name'           => 'Ürün Adı',
            'qty'                    => 'Miktar',
            'qty-value'              => ':location - :qty Miktar',
            'sku'                    => 'SKU',
            'shipping-handling'      => 'Nakliye İşlemleri',
            'delivery-method'        => 'Teslimat Yöntemi',
            'expected-transfer-date' => 'Beklenen Transfer Tarihi',
            'deliver-to'             => 'Teslim Edilecek',
            'delivery-details'       => 'Teslimat Detayları',
            'tracking-number'        => 'Takip Numarası',
            'requested-qty'          => 'Talep Edilen Miktar',
            'picked-qty'             => 'Seçilen Miktar',
            'received-qty'           => 'Alınan Miktar',
            'pick-from'              => 'Seçim Yapılacak',
            'deliver-to'             => 'Teslim Edilecek',
        ],

        'create-success'             => 'Stok Transferi başarıyla oluşturuldu.',
        'update-success'             => 'Stok Transferi başarıyla güncellendi.',
        'delete-success'             => 'Stok Transferi başarıyla silindi.',
        'delete-failed'              => 'Stok Transferi silinemedi.',
        'no-items-error'             => 'Lütfen önce stok transferine ürün ekleyin.',
        'no-items-pick-error'        => 'Lütfen önce stok transferine ürün seçin.',
        'no-warehouse-error'         => 'Lütfen önce stok transferine teslimat bilgilerini ekleyin.',
        'invalid-pick-qty-error'     => 'Ürünler için geçersiz seçim miktarı.',
        'invalid-receive-qty-error'  => 'Ürünler için geçersiz alma miktarı.',
        'same-location-error'        => 'Seçim ve alma lokasyonu aynı olamaz.',
        'already-canceled-error'     => 'Stok Transferi zaten iptal edildi.',
        'already-picked-error-error' => 'Stok Transferi zaten seçildi.',
    ],

    'settings' => [
        'workflows' => [
            'inventory-transfers' => [
                'attach-pdf'                          => 'PDF Ekle',
                'status'                              => 'Durum',
                'cancel-description'                  => 'İptal Nedeni',
                'created-at'                          => 'Oluşturulma Tarihi',
                'update-inventory-transfer'           => 'Stok Transferini Güncelle',
                'send-email-to-assignee'              => 'Atanan Kişiye E-posta Gönder',
                'send-email-to-creator'               => 'Oluşturan Kişiye E-posta Gönder',
                'send-email-to-source-warehouse'      => 'Kaynak Depoya E-posta Gönder',
                'send-email-to-destination-warehouse' => 'Hedef Depoya E-posta Gönder',
            ],
        ],
    ],

    'seeders' => [
        'attributes' => [
            'inventory-transfers' => [
                'increment-id'           => 'Artan ID',
                'reference-number'       => 'Referans Numarası',
                'status'                 => 'Durum',
                'shipping-method'        => 'Gönderim Yöntemi',
                'tracking-number'        => 'Takip Numarası',
                'expected-transfer-date' => 'Beklenen Transfer Tarihi',
                'from-warehouse'         => 'Gönderen Depo',
                'to-warehouse'           => 'Alan Depo',
                'total-items-count'      => 'Toplam Ürün Sayısı',
                'total-qty-requested'    => 'Talep Edilen Toplam Miktar',
                'total-qty-received'     => 'Alınan Toplam Miktar',
                'created-by'             => 'Oluşturan',
                'assigned-to'            => 'Atanan',
            ],
        ],
    ],

    'acl' => [
        'inventory-transfers' => [
            'title'  => 'Stok Transferleri',
            'create' => 'Oluştur',
            'edit'   => 'Düzenle',
            'view'   => 'Görünüm',
            'delete' => 'Sil',
        ],
    ],
];
