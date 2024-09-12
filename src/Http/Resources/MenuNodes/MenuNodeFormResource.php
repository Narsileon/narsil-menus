<?php

namespace Narsil\Menus\Http\Resources\MenuNodes;

#region USE

use Narsil\Forms\Builder\AbstractFormNode;
use Narsil\Forms\Builder\Elements\FormCard;
use Narsil\Forms\Builder\Inputs\FormSelect;
use Narsil\Forms\Builder\Inputs\FormString;
use Narsil\Forms\Builder\Inputs\FormTrans;
use Narsil\Forms\Http\Resources\AbstractFormResource;
use Narsil\Forms\Models\FormNodeOption;
use Narsil\Menus\Enums\VisibilityEnum;
use Narsil\Menus\Models\MenuNode;
use Narsil\Storage\Models\Icon;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuNodeFormResource extends AbstractFormResource
{
    #region CONSTRUCTOR

    /**
     * @param mixed $resource
     *
     * @return void
     */
    public function __construct(mixed $resource)
    {
        parent::__construct($resource, 'Menu node', 'menu-node');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<AbstractFormNode>
     */
    protected function getSchema(): array
    {
        return [
            (new FormCard('default'))
                ->label('Settings')
                ->children([
                    (new FormTrans(MenuNode::LABEL))
                        ->required(),
                    (new FormString(MenuNode::URL)),
                    (new FormSelect(MenuNode::VISIBILITY))
                        ->options([[
                            FormNodeOption::LABEL => 'Auths',
                            FormNodeOption::VALUE => VisibilityEnum::AUTH->value,
                        ], [
                            FormNodeOption::LABEL => 'Guests',
                            FormNodeOption::VALUE => VisibilityEnum::GUEST->value,
                        ], [
                            FormNodeOption::LABEL => 'Users',
                            FormNodeOption::VALUE => VisibilityEnum::USER->value,
                        ]])
                        ->required(),
                ]),
            (new FormCard('decoration'))
                ->label('Decoration')
                ->children([
                    (new FormSelect(MenuNode::ICON_ID))
                        ->fetch('/icons/fetch')
                        ->labelKey(Icon::PATH)
                        ->valueKey(Icon::ID),
                    (new FormString(MenuNode::BACKGROUND)),
                ]),
        ];
    }

    #endregion
}
