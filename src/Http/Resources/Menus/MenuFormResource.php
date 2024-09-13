<?php

namespace Narsil\Menus\Http\Resources\Menus;

#region USE

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
                            (new FormTree('tree')),
                        ]),
                ]),
        ];
    }

    #endregion
}
