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
use Narsil\Menus\Models\MenuHasNode;
use Narsil\Policies\Policies\AbstractPolicy;
use Narsil\Tables\Http\Controllers\Controller;
use Narsil\Tables\Http\Resources\ModelCommentCollection;
use Narsil\Tables\Models\ModelComment;
use Narsil\Tree\Http\Resources\NestedNodeResource;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class ResourceEditController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Menu $menu
     *
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, Menu $menu): RedirectResponse|Response
    {
        $this->authorize(AbstractPolicy::UPDATE, Menu::class);

        $resource = new MenuForm($menu);

        $comments = $this->getComments(Menu::class, $menu->{Menu::ID});

        $menuHasNodes = $menu->{Menu::RELATIONSHIP_NODES}
            ->where(MenuHasNode::PARENT_ID, null);

        $tree = NestedNodeResource::collection($menuHasNodes);

        return Inertia::render('narsil/tables::Resources/Edit/Index', compact(
            'comments',
            'resource',
            'tree',
        ));
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param string $model
     * @param integer $id
     *
     * @return ModelCommentCollection
     */
    private function getComments(string $model, int $id): ModelCommentCollection
    {
        $comments = ModelComment::query()
            ->where(ModelComment::MODEL_TYPE, '=', $model)
            ->where(ModelComment::MODEL_ID, '=', $id)
            ->orderBy(ModelComment::UPDATED_AT, 'desc')
            ->get();

        return new ModelCommentCollection($comments);
    }

    /**
     * @param string $model
     *
     * @return string
     */
    private function getFormClass(string $model): string
    {
        $formClasses = Config::get(FormsConfig::FORMS, []);

        $formClass = $formClasses[$model] ?? FormResource::class;

        return $formClass;
    }

    #endregion
}
