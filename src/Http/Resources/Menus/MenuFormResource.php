<?php

namespace Narsil\Menus\Http\Resources\Menus;

#region USE

use Illuminate\Http\Request;
use Narsil\Forms\Builder\AbstractFormNode;
use Narsil\Forms\Builder\Elements\FormCard;
use Narsil\Forms\Builder\Elements\FormTab;
use Narsil\Forms\Builder\Elements\FormTabs;
use Narsil\Forms\Builder\Inputs\FormSelect;
use Narsil\Forms\Builder\Inputs\FormString;
use Narsil\Forms\Builder\Inputs\FormTree;
use Narsil\Forms\Http\Resources\AbstractFormResource;
use Narsil\Forms\Models\FormNodeOption;
use Narsil\Menus\Enums\MenuEnum;
use Narsil\Menus\Models\Menu;
use Narsil\Menus\Models\MenuHasNode;
use Narsil\Tree\Http\Resources\NestedNodeResource;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuFormResource extends AbstractFormResource
{
    #region CONSTRUCTOR

    /**
     * @param mixed $resource
     *
     * @return void
     */
    public function __construct(mixed $resource)
    {
        parent::__construct($resource, 'Menu', 'menu');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {

        if (!$this->resource)
        {
            return [];
        }

        $attributes = parent::toArray($request);

        $nodes = $this->resource->{Menu::RELATIONSHIP_NODES}
            ->where(MenuHasNode::PARENT_ID, null);

        $attributes[Menu::RELATIONSHIP_NODES] = NestedNodeResource::collection($nodes);

        return $attributes;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<AbstractFormNode>
     */
    protected function getSchema(): array
    {
        return [
            (new FormTabs())
                ->children([
                    (new FormTab('main'))
                        ->label('Main')
                        ->children([
                            (new FormCard())
                                ->children([
                                    (new FormString(Menu::NAME)),
                                    (new FormSelect(Menu::TYPE))
                                        ->options([[
                                            FormNodeOption::LABEL => 'Backend',
                                            FormNodeOption::VALUE => MenuEnum::BACKEND->value,
                                        ], [
                                            FormNodeOption::LABEL => 'Footer',
                                            FormNodeOption::VALUE => MenuEnum::FOOTER->value,
                                        ], [
                                            FormNodeOption::LABEL => 'Header',
                                            FormNodeOption::VALUE => MenuEnum::HEADER->value,
                                        ]]),
                                ]),
                        ]),
                    (new FormTab('content'))
                        ->label('Content')
                        ->children([
                            (new FormTree('nodes'))
                                ->labelKey('target.label'),
                        ]),
                ]),
        ];
    }

    #endregion
}
