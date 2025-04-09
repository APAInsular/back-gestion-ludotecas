<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuStoreRequest;
use App\Http\Requests\MenuUpdateRequest;
use App\Http\Resources\MenuCollection;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    public function index(Request $request): MenuCollection
    {
        $menus = Menu::all();

        return new MenuCollection($menus);
    }

    public function store(MenuStoreRequest $request): MenuResource
    {
        $menu = Menu::create($request->validated());

        return new MenuResource($menu);
    }

    public function show(Request $request, Menu $menu): MenuResource
    {
        return new MenuResource($menu);
    }

    public function update(MenuUpdateRequest $request, Menu $menu): MenuResource
    {
        $menu->update($request->validated());

        return new MenuResource($menu);
    }

    public function destroy(Request $request, Menu $menu): Response
    {
        $menu->delete();

        return response()->noContent();
    }
}
