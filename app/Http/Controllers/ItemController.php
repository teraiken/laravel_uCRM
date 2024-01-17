<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Items/Index', [
            'items' => Item::select('id', 'name', 'price', 'is_selling')->get()
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Items/Create');
    }

    /**
     * @param StoreItemRequest $request
     * @return RedirectResponse
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        Item::query()->create([
            'name' => $request->name,
            'memo' => $request->memo,
            'price' => $request->price
        ]);

        return to_route('items.index')
            ->with([
                'message' => '登録しました。',
                'status' => 'success'
            ]);
    }

    /**
     * @param Item $item
     * @return Response
     */
    public function show(Item $item): Response
    {
        return Inertia::render('Items/Show', [
            'item' => $item
        ]);
    }

    /**
     * @param Item $item
     * @return Response
     */
    public function edit(Item $item): Response
    {
        return Inertia::render('Items/Edit', [
            'item' => $item
        ]);
    }

    /**
     * @param UpdateItemRequest $request
     * @param Item $item
     * @return RedirectResponse
     */
    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $item->name = $request->name;
        $item->memo = $request->memo;
        $item->price = $request->price;
        $item->is_selling = $request->is_selling;
        $item->save();

        return to_route('items.index')
            ->with([
                'message' => '更新しました。',
                'status' => 'success'
            ]);
    }

    /**
     * @param Item $item
     * @return RedirectResponse
     */
    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return to_route('items.index')
            ->with([
                'message' => '削除しました。',
                'status' => 'danger'
            ]);
    }
}
