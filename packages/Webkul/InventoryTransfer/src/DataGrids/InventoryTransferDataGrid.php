<?php

namespace Webkul\InventoryTransfer\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\InventoryTransfer\Enums\InventoryTransferStatus;
use Webkul\InventoryTransfer\Models\InventoryTransfer;
use Webkul\User\Repositories\UserRepository;
use Webkul\Warehouse\Repositories\WarehouseRepository;

class InventoryTransferDataGrid extends DataGrid
{
    /**
     * Prepare query builder.
     *
     * @return void
     */
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('inventory_transfers')
            ->leftJoin('users', 'inventory_transfers.assigned_to_user_id', '=', 'users.id')
            ->leftJoin('warehouses as from_warehouses', 'inventory_transfers.from_warehouse_id', '=', 'from_warehouses.id')
            ->leftJoin('warehouses as to_warehouses', 'inventory_transfers.to_warehouse_id', '=', 'to_warehouses.id')
            ->select(
                'inventory_transfers.id',
                'inventory_transfers.reference_number',
                'inventory_transfers.increment_id',
                'inventory_transfers.status',
                'inventory_transfers.expected_transfer_date',
                'inventory_transfers.created_at',
            )
            ->addSelect(
                'users.id as assigned_to_user_id',
                'users.name as assigned_to_user_name',
            )
            ->addSelect(
                'from_warehouses.id as from_warehouse_id',
                'from_warehouses.name as from_warehouse_name',
            )
            ->addSelect(
                'to_warehouses.id as to_warehouse_id',
                'to_warehouses.name as to_warehouse_name',
            )
            ->where(function ($query) {
                if ($userIds = bouncer()->getAuthorizedUserIds()) {
                    $query->whereIn('inventory_transfers.created_by_user_id', $userIds)
                        ->orWhereIn('inventory_transfers.assigned_to_user_id', $userIds);
                }
            });

        $this->addFilter('id', 'inventory_transfers.id');
        $this->addFilter('from_warehouse_name', 'from_warehouses.name');
        $this->addFilter('to_warehouse_name', 'to_warehouses.name');
        $this->addFilter('created_at', 'inventory_transfers.created_at');

        return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'increment_id',
            'label'      => trans('inventory_transfer::app.inventory-transfers.index.datagrid.id'),
            'type'       => 'integer',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'reference_number',
            'label'      => trans('inventory_transfer::app.inventory-transfers.index.datagrid.reference-number'),
            'type'       => 'integer',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'              => 'assigned_to_user_name',
            'label'              => trans('inventory_transfer::app.inventory-transfers.index.datagrid.assigned-to'),
            'type'               => 'string',
            'searchable'         => false,
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => UserRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'name',
                ],
            ],
            'closure'         => function ($row) {
                if (! $row->assigned_to_user_name) {
                    return '--';
                }

                return $row->assigned_to_user_name;
            },
        ]);

        $this->addColumn([
            'index'              => 'status',
            'label'              => trans('inventory_transfer::app.inventory-transfers.index.datagrid.status'),
            'type'               => 'string',
            'searchable'         => false,
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'dropdown',
            'filterable_options' => collect(InventoryTransferStatus::cases())->map(function ($status) {
                return [
                    'value'   => $status->value,
                    'label'   => $status->label(),
                ];
            })->toArray(),
            'closure'    => function ($row) {
                $inventoryTransfer = (new InventoryTransfer)->fill(['status' => $row->status]);

                return $inventoryTransfer->status->label();
            },
        ]);

        $this->addColumn([
            'index'              => 'from_warehouse_name',
            'label'              => trans('inventory_transfer::app.inventory-transfers.index.datagrid.from-warehouse'),
            'type'               => 'string',
            'searchable'         => false,
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => WarehouseRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'name',
                ],
            ],
            'closure'            => function ($row) {
                if (! $row->from_warehouse_id) {
                    return '--';
                }

                $route = route('admin.settings.warehouses.view', $row->from_warehouse_id);

                return "<a class=\"text-brandColor transition-all hover:underline\" href='".$route."' target='_blank'>".$row->from_warehouse_name.'</a>';
            },
        ]);

        $this->addColumn([
            'index'              => 'to_warehouse_name',
            'label'              => trans('inventory_transfer::app.inventory-transfers.index.datagrid.to-warehouse'),
            'type'               => 'string',
            'searchable'         => false,
            'sortable'           => true,
            'filterable'         => true,
            'filterable_type'    => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => WarehouseRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'name',
                ],
            ],
            'closure'            => function ($row) {
                if (! $row->to_warehouse_id) {
                    return '--';
                }

                $route = route('admin.settings.warehouses.view', $row->to_warehouse_id);

                return "<a class=\"text-brandColor transition-all hover:underline\" href='".$route."' target='_blank'>".$row->to_warehouse_name.'</a>';
            },
        ]);

        $this->addColumn([
            'index'           => 'expected_transfer_date',
            'label'           => trans('inventory_transfer::app.inventory-transfers.index.datagrid.expected-transfer-date'),
            'type'            => 'date',
            'searchable'      => false,
            'sortable'        => true,
            'filterable'      => true,
            'filterable_type' => 'date_range',
            'closure'         => function ($row) {
                if (! $row->expected_transfer_date) {
                    return '--';
                }

                return $row->expected_transfer_date;
            },
        ]);

        $this->addColumn([
            'index'           => 'created_at',
            'label'           => trans('inventory_transfer::app.inventory-transfers.index.datagrid.created-at'),
            'type'            => 'date',
            'searchable'      => false,
            'sortable'        => true,
            'filterable'      => true,
            'filterable_type' => 'date_range',
            'closure'         => function ($row) {
                if (! $row->created_at) {
                    return '--';
                }

                return $row->created_at;
            },
        ]);
    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        if (bouncer()->hasPermission('inventory_transfers.view')) {
            $this->addAction([
                'icon'   => 'icon-eye',
                'title'  => trans('inventory_transfer::app.inventory-transfers.index.datagrid.view'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.inventory_transfers.view', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('inventory_transfers.delete')) {
            $this->addAction([
                'icon'   => 'icon-delete',
                'title'  => trans('inventory_transfer::app.inventory-transfers.index.datagrid.delete'),
                'method' => 'delete',
                'url'    => fn ($row) => route('admin.inventory_transfers.delete', $row->id),
            ]);
        }
    }
}
