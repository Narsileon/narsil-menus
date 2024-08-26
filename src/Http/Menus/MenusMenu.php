<?php

namespace Narsil\Menus\Http\Menus;

#region USE

use Narsil\Menus\Enums\VisibilityEnum;
use Narsil\Menus\Http\Menus\AbstractMenu;
use Narsil\Menus\Models\MenuNode;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenusMenu extends AbstractMenu
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public static function getBackendMenu(): array
    {
        return [[
            MenuNode::LABEL => 'Menus',
            MenuNode::URL => '/backend/menus',
            MenuNode::VISIBILITY => VisibilityEnum::AUTH->value,
            MenuNode::RELATIONSHIP_ICON => 'lucide/list-collapse',
        ], [
            MenuNode::LABEL => 'Menu nodes',
            MenuNode::URL => '/backend/menu-nodes',
            MenuNode::VISIBILITY => VisibilityEnum::AUTH->value,
            MenuNode::RELATIONSHIP_ICON => 'lucide/link',
        ]];
    }

    #endregion
}
