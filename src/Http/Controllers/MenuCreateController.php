<?php

namespace Narsil\Menus\Http\Controllers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Menus\Http\Forms\MenuFormResource;
use Narsil\Menus\Models\Menu;
use Narsil\Policies\Policies\AbstractPolicy;
use Narsil\Tables\Http\Controllers\Controller;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class MenuCreateController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): Response
    {
        $this->authorize(AbstractPolicy::CREATE, Menu::class);

        $resource = new MenuFormResource(new Menu());

        return Inertia::render('narsil/tables::Resources/Create/Index', compact(
            'resource',
        ));
    }

    #endregion
}
