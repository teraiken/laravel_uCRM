<?php

namespace App\Http\Controllers;

use App\Models\InertiaTest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InertiaTestController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Inertia/Index', [
            'blogs' => InertiaTest::all()
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Inertia/Create');
    }

    /**
     * @param string $id
     * @return Response
     */
    public function show(string $id): Response
    {
        return Inertia::render('Inertia/Show',
        [
            'blog' => InertiaTest::findOrFail($id),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'max: 20'],
            'content' => ['required'],
        ]);

        $inertiaTest = new InertiaTest;
        $inertiaTest->title = $request->title;
        $inertiaTest->content = $request->content;
        $inertiaTest->save();

        return to_route('inertia.index')
            ->with([
                'message' => '登録しました。'
            ]);
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $blog = InertiaTest::findOrFail($id);
        $blog->delete();

        return to_route('inertia.index')
            ->with([
                'message' => '削除しました。'
            ]);
    }
}