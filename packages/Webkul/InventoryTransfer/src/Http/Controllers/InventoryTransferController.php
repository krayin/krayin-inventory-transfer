<?php

namespace Webkul\InventoryTransfer\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Prettus\Repository\Criteria\RequestCriteria;
use Webkul\Activity\Repositories\ActivityRepository;
use Webkul\Admin\Http\Requests\AttributeForm;
use Webkul\Admin\Http\Resources\ActivityResource;
use Webkul\Core\Traits\PDFHandler;
use Webkul\InventoryTransfer\DataGrids\InventoryTransferDataGrid;
use Webkul\InventoryTransfer\Enums\InventoryTransferStatus;
use Webkul\InventoryTransfer\Http\Resources\InventoryTransferResource;
use Webkul\InventoryTransfer\Repositories\InventoryTransferItemRepository;
use Webkul\InventoryTransfer\Repositories\InventoryTransferRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Warehouse\Repositories\WarehouseRepository;

class InventoryTransferController extends Controller
{
    use PDFHandler;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected WarehouseRepository $warehouseRepository,
        protected ProductRepository $productRepository,
        protected InventoryTransferRepository $inventoryTransferRepository,
        protected InventoryTransferItemRepository $inventoryTransferItemRepository,
        protected ActivityRepository $activityRepository
    ) {
        request()->request->add(['entity_type' => 'inventory_transfers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(InventoryTransferDataGrid::class)->toJson();
        }

        $warehouses = $this->warehouseRepository->all();

        return view('inventory_transfer::inventory-transfers.index', compact('warehouses'));
    }

    /**
     * Returns product inventories grouped by warehouse.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        return response()->json([
            'data' => new InventoryTransferResource($inventoryTransfer),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'from_warehouse_id' => 'required',
            'to_warehouse_id'   => 'required',
            'reference_number'  => 'required|unique:inventory_transfers,reference_number',
        ]);

        Event::dispatch('inventory_transfers.create.before');

        $inventoryTransfer = $this->inventoryTransferRepository->create(array_merge(request()->all(), [
            'created_by_user_id' => auth()->user()->id,
        ]));

        Event::dispatch('inventory_transfers.create.after', $inventoryTransfer);

        return response()->json([
            'message'  => trans('inventory_transfer::app.inventory-transfers.create-success'),
            'redirect' => route('admin.inventory_transfers.view', $inventoryTransfer->id),
        ]);
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        if (
            $userIds = bouncer()->getAuthorizedUserIds()
            && ! in_array($inventoryTransfer->assigned_to_user_id, $userIds)
            && ! in_array($inventoryTransfer->created_by_user_id, $userIds)
        ) {
            return redirect()->route('admin.inventory_transfers.index');
        }

        return view('inventory_transfer::inventory-transfers.view', compact('inventoryTransfer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Webkul\Attribute\Http\Requests\AttributeForm  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeForm $request, $id)
    {
        $this->validate(request(), [
            'items'                  => 'required_if:status,qty_picked,qty_received|array',
            'items.*'                => 'required_if:status,qty_picked,qty_received|array',
            'items.*'                => 'required_if:status,qty_picked,qty_received|array',
            'items.*.*'              => 'required_if:status,qty_picked,qty_received|array',
            'items.*.*.qty_picked'   => 'required_if:status,qty_picked,qty_received|numeric|min:0',
            'items.*.*.qty_received' => 'required_if:status,qty_received|numeric|min:0',
        ]);

        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        try {
            $validatedData = $this->validateStatusUpdateRequest($inventoryTransfer, request()->all());

            if (request()->has('status')) {
                Event::dispatch('inventory_transfers.status.update.before', $id);
            }

            Event::dispatch('inventory_transfers.update.before', $id);

            $inventoryTransfer = $this->inventoryTransferRepository->update($validatedData, $id);

            $this->inventoryTransferRepository->collectTotals($inventoryTransfer);

            if (request()->has('status')) {
                Event::dispatch('inventory_transfers.status.update.after', $inventoryTransfer);
            }

            Event::dispatch('inventory_transfers.update.after', $inventoryTransfer);
        } catch (\Exception $exception) {
            if (request()->ajax()) {
                return response()->json([
                    'message' => $exception->getMessage(),
                ], 400);
            }

            session()->flash('error', $exception->getMessage());

            return redirect()->route('admin.inventory_transfers.view', $id);
        }

        if (request()->ajax()) {
            return response()->json([
                'data'    => new InventoryTransferResource($inventoryTransfer),
                'message' => trans('inventory_transfer::app.inventory-transfers.update-success'),
            ]);
        }

        session()->flash('success', trans('inventory_transfer::app.inventory-transfers.update-success'));

        return redirect()->route('admin.inventory_transfers.view', $id);
    }

    /**
     * Sanitize the given input data specifically status
     */
    protected function validateStatusUpdateRequest($inventoryTransfer, $data)
    {
        if (empty($data['status'])) {
            return $data;
        }

        if ($inventoryTransfer->status == $inventoryTransfer->status::CANCELED) {
            throw new \Exception(trans('inventory_transfer::app.inventory-transfers.already-canceled-error'));
        }

        if (
            $data['status'] != $inventoryTransfer->status::PENDING
            && ! $inventoryTransfer->items->count()
        ) {
            throw new \Exception(trans('inventory_transfer::app.inventory-transfers.no-items-error'));
        }

        if (
            in_array($data['status'], [
                InventoryTransferStatus::INVENTORY_PARTIALLY_PICKED->value,
                InventoryTransferStatus::INVENTORY_PICKED->value,
            ])
        ) {
            $totalQtyPicked = collect($data['items'])
                ->flatMap(function ($item) {
                    return collect($item)->pluck('qty_picked');
                })
                ->sum(function ($qtyPicked) {
                    return (int) $qtyPicked;
                });

            $totalQtyPicked += $inventoryTransfer->total_qty_picked;

            if ($totalQtyPicked > $inventoryTransfer->total_qty_requested) {
                throw new \Exception(trans('inventory_transfer::app.inventory-transfers.invalid-pick-qty-error'));
            }

            if ($totalQtyPicked == $inventoryTransfer->total_qty_requested) {
                $data['status'] = InventoryTransferStatus::INVENTORY_PICKED->value;
            } else {
                $data['status'] = InventoryTransferStatus::INVENTORY_PARTIALLY_PICKED->value;
            }
        } elseif (
            in_array($data['status'], [
                InventoryTransferStatus::INVENTORY_PARTIALLY_RECEIVED->value,
                InventoryTransferStatus::INVENTORY_RECEIVED->value,
            ])
        ) {
            $receivingLocationIds = collect($data['items'])
                ->flatMap(function ($item) {
                    return collect($item)->pluck('location_id');
                });

            $pickedLocationIds = $inventoryTransfer->items
                ->flatMap(function ($item) {
                    return collect($item->inventories->where('qty_picked', '<>', 0))->pluck('warehouse_location_id');
                });

            if ($receivingLocationIds->intersect($pickedLocationIds)->count()) {
                throw new \Exception(trans('inventory_transfer::app.inventory-transfers.same-location-error'));
            }

            $totalQtyReceived = collect($data['items'])
                ->flatMap(function ($item) {
                    return collect($item)->pluck('qty_received');
                })
                ->sum(function ($qtyReceived) {
                    return (int) $qtyReceived;
                });

            $totalQtyReceived += $inventoryTransfer->total_qty_received;

            if ($totalQtyReceived > $inventoryTransfer->total_qty_requested) {
                throw new \Exception(trans('inventory_transfer::app.inventory-transfers.invalid-receive-qty-error'));
            }

            if ($totalQtyReceived == $inventoryTransfer->total_qty_requested) {
                $data['status'] = InventoryTransferStatus::INVENTORY_RECEIVED->value;
            } else {
                $data['status'] = InventoryTransferStatus::INVENTORY_PARTIALLY_RECEIVED->value;
            }
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        try {
            Event::dispatch('inventory_transfers.delete.before', $id);

            $this->inventoryTransferRepository->delete($id);

            Event::dispatch('inventory_transfers.delete.after', $id);

            return response()->json([
                'message' => trans('inventory_transfer::app.inventory-transfers.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => trans('inventory_transfer::app.inventory-transfers.delete-failed'),
            ], 400);
        }

        return response()->json([
            'message' => trans('inventory_transfer::app.inventory-transfers.delete-failed'),
        ], 400);
    }

    /**
     * Print and download the for the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(int $id)
    {
        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        return $this->downloadPDF(
            view('inventory_transfer::inventory-transfers.pdf', compact('inventoryTransfer'))->render(),
            'inventory-transfer-'.$inventoryTransfer->created_at->format('d-m-Y')
        );
    }

    /**
     * Search results
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $inventoryTransfers = $this->inventoryTransferRepository
            ->pushCriteria(app(RequestCriteria::class))
            ->get();

        return InventoryTransferResource::collection($inventoryTransfers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeProducts($id)
    {
        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        if ($inventoryTransfer->status == $inventoryTransfer->status::CANCELED) {
            return response()->json([
                'message' => trans('inventory_transfer::app.inventory-transfers.already-canceled-error'),
            ], 400);
        }

        if ($inventoryTransfer->status != $inventoryTransfer->status::PENDING) {
            return response()->json([
                'message' => trans('inventory_transfer::app.inventory-transfers.already-picked-error'),
            ], 400);
        }

        Event::dispatch('inventory_transfers.update.before', $id);

        foreach (request()->input('products') as $productData) {
            if (empty($productData['inventories'])) {
                continue;
            }

            Event::dispatch('inventory_transfers.items.create.before', $productData);

            $product = $this->productRepository->find($productData['id']);

            $inventoryTransferItem = $this->inventoryTransferItemRepository->create([
                'product_id'            => $productData['id'],
                'sku'                   => $product->sku,
                'name'                  => $product->name,
                'inventories'           => $productData['inventories'],
                'inventory_transfer_id' => $inventoryTransfer->id,
            ]);

            $inventoryTransferItem = $this->inventoryTransferItemRepository->collectTotals($inventoryTransferItem);

            Event::dispatch('inventory_transfers.items.create.after', $inventoryTransferItem);
        }

        $this->inventoryTransferRepository->collectTotals($inventoryTransfer);

        Event::dispatch('inventory_transfers.update.after', $inventoryTransfer);

        return response()->json([
            'message' => trans('inventory_transfer::app.inventory-transfers.update-success'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeItems($id)
    {
        $inventoryTransfer = $this->inventoryTransferRepository->findOrFail($id);

        if ($inventoryTransfer->status == $inventoryTransfer->status::CANCELED) {
            return response()->json([
                'message' => trans('inventory_transfer::app.inventory-transfers.already-canceled-error'),
            ], 400);
        }

        if ($inventoryTransfer->status != $inventoryTransfer->status::PENDING) {
            return response()->json([
                'message' => trans('inventory_transfer::app.inventory-transfers.already-picked-error'),
            ], 400);
        }

        Event::dispatch('inventory_transfers.update.before', $id);

        foreach (request()->input('items') as $itemId) {
            Event::dispatch('inventory_transfers.items.delete.before', $itemId);

            $this->inventoryTransferItemRepository->deleteWhere([
                'id' => $itemId,
            ]);

            Event::dispatch('inventory_transfers.items.delete.after', $itemId);
        }

        $this->inventoryTransferRepository->collectTotals($inventoryTransfer);

        Event::dispatch('inventory_transfers.update.after', $inventoryTransfer);

        return response()->json([
            'message' => trans('inventory_transfer::app.inventory-transfers.update-success'),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activities($id)
    {
        $activities = $this->activityRepository
            ->leftJoin('inventory_transfer_activities', 'activities.id', '=', 'inventory_transfer_activities.activity_id')
            ->where('inventory_transfer_activities.inventory_transfer_id', $id)
            ->get()
            ->sortByDesc('id')
            ->sortByDesc('created_at');

        return ActivityResource::collection($activities);
    }
}
