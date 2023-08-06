<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;
use Inertia\{Inertia, Response};
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TodoItemRequest;
use Illuminate\Support\Facades\Redirect;

class TodoItemController extends Controller
{
    public function index(Request $request)
    {
        $items = TodoItem::where('created_by', auth()->id())->orderBy('title')->paginate(10);

        if ($request->wantsJson()) {
            return $items;
        }

        return Inertia::render('TodoItem/Index', [
            'items' => $items,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('TodoItem/Create');
    }

    public function store(TodoItemRequest $request): RedirectResponse
    {
        TodoItem::create($request->validated());

        return Redirect::route('todo.index');
    }

    public function edit(Request $request, $id): Response
    {
        $item = TodoItem::where('created_by', auth()->id())->find($id);

        return Inertia::render('TodoItem/Edit', [
            'item' => $item,
        ]);
    }

    public function update(TodoItemRequest $request, $id): RedirectResponse
    {
        $item = TodoItem::where('created_by', auth()->id())->findOrFail($id);
        $item->update($request->validated());

        return Redirect::route('todo.index');
    }

    public function destroy(Request $request, $id): RedirectResponse
    {
        $item = TodoItem::where('created_by', auth()->id())->findOrFail($id);
        $item->delete();

        return Redirect::route('todo.index');
    }
}
