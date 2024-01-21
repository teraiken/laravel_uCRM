<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Models\Purchase;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $perPage = 50;
        $orders = Order::groupBy('id')
            ->selectRaw('id, sum(subtotal) as total, customer_name, status, created_at')
            ->paginate($perPage);
        
        return Inertia::render('Purchases/Index', [
            'orders' => $orders
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        $items = Item::select('id', 'name', 'price')->isSelling(ItemStatus::Available)->get();

        return Inertia::render('Purchases/Create', [
            'items' => $items
        ]);
    }

    /**
     * @param StorePurchaseRequest $request
     * @return RedirectResponse
     */
    public function store(StorePurchaseRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status
            ]);
    
            foreach($request->items as $item) {
                $purchase->items()->attach($item['id'], [
                    'quantity' => $item['quantity']
                ]);
            }
        });

        return to_route('dashboard');
    }

    /**
     * @param Purchase $purchase
     * @return Response
     */
    public function show(Purchase $purchase): Response
    {
        $items = Order::where('id', $purchase->id)->orderBy('item_id')->get();

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, sum(subtotal) as total, customer_name, status, created_at')
            ->get();

        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * @param Purchase $purchase
     * @return Response
     */
    public function edit(Purchase $purchase): Response
    {
        $purchase = Purchase::find($purchase->id);
        $allItems = Item::select('id', 'name', 'price')->get();
        $items = [];

        foreach ($allItems as $allItem) {
            $quantity = 0;

            foreach($purchase->items as $item) {
                if ($allItem->id === $item->id) {
                    $quantity = $item->pivot->quantity;
                }
            }

            array_push($items, [
                'id' => $allItem->id,
                'name' => $allItem->name,  
                'price' => $allItem->price,  
                'quantity' => $quantity,  
            ]);
        }

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_id, customer_name, status, created_at')
            ->get();
        
        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * @param UpdatePurchaseRequest $request
     * @param Purchase $purchase
     * @return RedirectResponse
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase): RedirectResponse
    {
        DB::transaction(function () use ($request, $purchase) {
            $purchase->status = $request->status;
            $purchase->save();
            
            $items = [];

            foreach($request->items as $item) {
                $items = $items + [
                    $item['id'] => [
                        'quantity' => $item['quantity']
                    ]
                ];
            }

            $purchase->items()->sync($items);
        });

        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
