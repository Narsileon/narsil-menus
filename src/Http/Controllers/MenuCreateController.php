<?php

namespace Narsil\Menus\Http\Controllers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Forms\Constants\FormsConfig;
use Narsil\Forms\Http\Resources\FormResource;
use Narsil\Menus\Http\Forms\MenuForm;
use Narsil\Menus\Models\Menu;
use Narsil\Policies\Policies\AbstractPolicy;
use Narsil\Tables\Http\Controllers\Controller;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class ResourceCreateController extends Controller
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

        $resource = new MenuForm(new Menu());

        return Inertia::render('narsil/tables::Resources/Create/Index', compact(
            'resource',
        ));
    }

    #endregion
}
