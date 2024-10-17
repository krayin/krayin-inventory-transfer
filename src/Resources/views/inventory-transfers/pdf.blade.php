<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ app()->getLocale() }}"
    dir=""
>
    <head>
        <!-- meta tags -->
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        @php
            $fontPath = [];
            
            $fontFamily = [
                'regular' => 'Arial, sans-serif',
                'bold'    => 'Arial, sans-serif',
            ];

            if (in_array(app()->getLocale(), ['ar', 'he', 'fa', 'tr', 'ru', 'uk'])) {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            } elseif (app()->getLocale() == 'zh_CN') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSC-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSC-Bold.ttf'),
                ];
                
                $fontFamily = [
                    'regular' => 'Noto Sans SC',
                    'bold'    => 'Noto Sans SC Bold',
                ];
            } elseif (app()->getLocale() == 'ja') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansJP-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansJP-Bold.ttf'),
                ];
                
                $fontFamily = [
                    'regular' => 'Noto Sans JP',
                    'bold'    => 'Noto Sans JP Bold',
                ];
            } elseif (app()->getLocale() == 'hi_IN') {
                $fontPath = [
                    'regular' => asset('fonts/Hind-Regular.ttf'),
                    'bold'    => asset('fonts/Hind-Bold.ttf'),
                ];
                
                $fontFamily = [
                    'regular' => 'Hind',
                    'bold'    => 'Hind Bold',
                ];
            } elseif (app()->getLocale() == 'bn') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansBengali-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansBengali-Bold.ttf'),
                ];
                
                $fontFamily = [
                    'regular' => 'Noto Sans Bengali',
                    'bold'    => 'Noto Sans Bengali Bold',
                ];
            } elseif (app()->getLocale() == 'sin') {
                $fontPath = [
                    'regular' => asset('fonts/NotoSansSinhala-Regular.ttf'),
                    'bold'    => asset('fonts/NotoSansSinhala-Bold.ttf'),
                ];
                
                $fontFamily = [
                    'regular' => 'Noto Sans Sinhala',
                    'bold'    => 'Noto Sans Sinhala Bold',
                ];
            }
        @endphp

        <!-- lang supports inclusion -->
        <style type="text/css">
            @if (! empty($fontPath['regular']))
                @font-face {
                    src: url({{ $fontPath['regular'] }}) format('truetype');
                    font-family: {{ $fontFamily['regular'] }};
                }
            @endif
            
            @if (! empty($fontPath['bold']))
                @font-face {
                    src: url({{ $fontPath['bold'] }}) format('truetype');
                    font-family: {{ $fontFamily['bold'] }};
                    font-style: bold;
                }
            @endif
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: {{ $fontFamily['regular'] }};
            }

            body {
                font-size: 10px;
                color: #091341;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            b, th {
                font-family: "{{ $fontFamily['bold'] }}";
            }

            .page-content {
                padding: 12px;
            }

            .page-header {
                border-bottom: 1px solid #F1F5F9;
                text-align: center;
                font-size: 24px;
                text-transform: uppercase;
                color: #0E90D9;
                padding: 24px 0;
                margin: 0;
            }

            .logo-container {
                position: absolute;
                top: 20px;
                left: 20px;
            }

            .logo-container.rtl {
                left: auto;
                right: 20px;
            }

            .logo-container img {
                max-width: 100%;
                height: auto;
            }

            .page-header b {
                display: inline-block;
                vertical-align: middle;
            }

            .small-text {
                font-size: 7px;
            }

            table {
                width: 100%;
                border-spacing: 1px 0;
                border-collapse: separate;
                margin-bottom: 16px;
            }
            
            table thead th {
                background-color: #F1F5F9;
                color: #0E90D9;
                padding: 6px 18px;
                text-align: left;
            }

            table.rtl thead tr th {
                text-align: right;
            }

            table tbody td {
                padding: 9px 18px;
                border-bottom: 1px solid #F1F5F9;
                text-align: left;
                vertical-align: top;
            }

            table.rtl tbody tr td {
                text-align: right;
            }

            .summary {
                width: 100%;
                display: inline-block;
            }

            .summary table {
                float: right;
                width: 250px;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #F1F5F9;
                white-space: nowrap;
            }

            .summary table.rtl {
                width: 280px;
            }

            .summary table.rtl {
                margin-right: 480px;
            }

            .summary table td {
                padding: 5px 10px;
            }

            .summary table td:nth-child(2) {
                text-align: center;
            }

            .summary table td:nth-child(3) {
                text-align: right;
            }
        </style>
    </head>

    <body dir="">
        <div class="logo-container">
            @if (core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo'))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(Storage::url(core()->getConfigData('sales.invoice_settings.pdf_print_outs.logo')))) }}"/>
            @else
                <img src="data:image/png;base64,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"/>
            @endif
        </div>
        
        <div class="page">
            <!-- Header -->
            <div class="page-header">
                <b>@lang('inventory_transfer::app.inventory-transfers.pdf.title')</b>
            </div>

            <div class="page-content">
                <!-- Inventory Transfer Information -->
                <table class="">
                    <tbody>
                        <tr>
                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                <div>
                                    <b>
                                        @lang('inventory_transfer::app.inventory-transfers.pdf.transfer-id'):
                                    </b>

                                    <span>
                                        #{{ $inventoryTransfer->increment_id ?? $inventoryTransfer->id }}
                                    </span>
                                </div>

                                @if ($inventoryTransfer->reference_number)
                                    <div style="margin-top: 4px">
                                        <b>
                                            @lang('inventory_transfer::app.inventory-transfers.pdf.reference-number'):
                                        </b>

                                        <span>
                                            #{{ $inventoryTransfer->reference_number }}
                                        </span>
                                    </div>
                                @endif

                                <div style="margin-top: 4px">
                                    <b>
                                        @lang('inventory_transfer::app.inventory-transfers.pdf.transfer-date'):
                                    </b>

                                    <span>
                                        {{ core()->formatDate($inventoryTransfer->created_at, 'd-m-Y') }}
                                    </span>
                                </div>
                            </td>

                            <td style="width: 50%; padding: 2px 18px;border:none;">
                                @if ($inventoryTransfer->from_warehouse != $inventoryTransfer->to_warehouse)
                                    @if ($inventoryTransfer->shipping_method)
                                        <div>
                                            <b>
                                                @lang('inventory_transfer::app.inventory-transfers.pdf.delivery-method'):
                                            </b>

                                            <span>
                                                {{ $inventoryTransfer->shipping_method }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if ($inventoryTransfer->tracking_number)
                                        <div style="margin-top: 4px">
                                            <b>
                                                @lang('inventory_transfer::app.inventory-transfers.pdf.tracking-number'):
                                            </b>

                                            <span>
                                                {{ $inventoryTransfer->tracking_number }}
                                            </span>
                                        </div>
                                    @endif
                                @endif

                                @if ($inventoryTransfer->expected_transfer_date)
                                    <div style="margin-top: 4px">
                                        <b>
                                            @lang('inventory_transfer::app.inventory-transfers.pdf.expected-transfer-date'):
                                        </b>

                                        <span>
                                            {{ core()->formatDate($inventoryTransfer->expected_transfer_date, 'd-m-Y') }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Delivery Details -->
                @if ($inventoryTransfer->from_warehouse != $inventoryTransfer->to_warehouse)
                    <table class="">
                        <thead>
                            <tr>
                                <th style="width: 50%">
                                    <b>
                                        @lang('inventory_transfer::app.inventory-transfers.pdf.pick-from')
                                    </b>
                                </th>

                                <th style="width: 50%">
                                    <b>
                                        @lang('inventory_transfer::app.inventory-transfers.pdf.deliver-to')
                                    </b>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @if ($inventoryTransfer->from_warehouse->contact_address)
                                    <td style="width: 50%">
                                        <div>
                                            {{ $inventoryTransfer->from_warehouse->contact_name }}
                                        </div>

                                        <div>
                                            {{ $inventoryTransfer->from_warehouse->contact_address['address'] }}
                                        </div>

                                        <div>
                                            {{ $inventoryTransfer->from_warehouse->contact_address['postcode'] . ' ' . $inventoryTransfer->from_warehouse->contact_address['city'] }}
                                        </div>

                                        <div>
                                            {{ $inventoryTransfer->from_warehouse->contact_address['state'] . ', ' . core()->country_name($inventoryTransfer->from_warehouse->contact_address['country']) }}
                                        </div>

                                        <div>
                                            @lang('inventory_transfer::app.inventory-transfers.pdf.contact'):

                                            @php $contactNumbers = []; @endphp

                                            @foreach ($inventoryTransfer->from_warehouse->contact_numbers as $contactNumber)
                                                @php
                                                    $contactNumbers[] = $contactNumber['value'] . ' (' . $contactNumber['label'] . ')';
                                                @endphp
                                            @endforeach

                                            {{ implode(', ', $contactNumbers) }}
                                        </div>
                                    </td>
                                @endif
                                
                                @if ($inventoryTransfer->to_warehouse->contact_address)
                                    <td style="width: 50%">
                                        <div>
                                            {{ $inventoryTransfer->to_warehouse->contact_name }}
                                        </div>

                                        <div>
                                            {{ $inventoryTransfer->to_warehouse->contact_address['address'] }}
                                        </div>

                                        <div>
                                            {{ $inventoryTransfer->to_warehouse->contact_address['postcode'] . ' ' . $inventoryTransfer->to_warehouse->contact_address['city'] }}
                                        </div>

                                        <div>
                                            {{ $inventoryTransfer->to_warehouse->contact_address['state'] . ', ' . core()->country_name($inventoryTransfer->to_warehouse->contact_address['country']) }}
                                        </div>

                                        <div>
                                            @lang('inventory_transfer::app.inventory-transfers.pdf.contact'):

                                            @php $contactNumbers = []; @endphp

                                            @foreach ($inventoryTransfer->to_warehouse->contact_numbers as $contactNumber)
                                                @php
                                                    $contactNumbers[] = $contactNumber['value'] . ' (' . $contactNumber['label'] . ')';
                                                @endphp
                                            @endforeach

                                            {{ implode(', ', $contactNumbers) }}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                @endif

                <!-- Items -->
                <div class="items">
                    <table class="">
                        <thead>
                            <tr>
                                <th>
                                    @lang('inventory_transfer::app.inventory-transfers.pdf.sku')
                                </th>

                                <th>
                                    @lang('inventory_transfer::app.inventory-transfers.pdf.product-name')
                                </th>

                                <th>
                                    @lang('inventory_transfer::app.inventory-transfers.pdf.requested-qty')
                                </th>

                                <th>
                                    @lang('inventory_transfer::app.inventory-transfers.pdf.picked-qty')
                                </th>

                                <th>
                                    @lang('inventory_transfer::app.inventory-transfers.pdf.received-qty')
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($inventoryTransfer->items as $item)
                                <tr>
                                    <td>
                                        {{ $item->sku }}
                                    </td>

                                    <td>
                                        {{ $item->name }}
                                    </td>

                                    <td>
                                        @if ($item->qty_requested > 0)
                                            @foreach ($item->inventories as $inventory)
                                                @if ($inventory->qty_requested < 1)
                                                    @continue
                                                @endif

                                                @lang('inventory_transfer::app.inventory-transfers.pdf.qty-value', [
                                                    'location' => $inventory->location->name,
                                                    'qty'      => $inventory->qty_requested,
                                                ])

                                                <br>
                                            @endforeach
                                        @else
                                            {{ $item->qty_requested }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->qty_picked > 0)
                                            @foreach ($item->inventories as $inventory)
                                                @if ($inventory->qty_picked < 1)
                                                    @continue
                                                @endif

                                                @lang('inventory_transfer::app.inventory-transfers.pdf.qty-value', [
                                                    'location' => $inventory->location->name,
                                                    'qty'      => $inventory->qty_picked,
                                                ])

                                                <br>
                                            @endforeach
                                        @else
                                            {{ $item->qty_picked }}
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->qty_received > 0)
                                            @foreach ($item->inventories as $inventory)
                                                @if ($inventory->qty_received < 1)
                                                    @continue
                                                @endif

                                                @lang('inventory_transfer::app.inventory-transfers.pdf.qty-value', [
                                                    'location' => $inventory->location->name,
                                                    'qty'      => $inventory->qty_received,
                                                ])

                                                <br>
                                            @endforeach
                                        @else
                                            {{ $item->qty_received }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
