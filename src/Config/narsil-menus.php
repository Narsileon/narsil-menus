<?php

#region USE

use Narsil\Menus\Enums\MenuEnum;
use Narsil\Menus\Enums\VisibilityEnum;
use Narsil\Menus\Models\MenuNode;

#endregion

return [
    /*
    |--------------------------------------------------------------------------
    | Backend Menu
    |--------------------------------------------------------------------------
    |
    | List of menus nodes.
    |
    */

    MenuEnum::BACKEND->value => [[
        MenuNode::LABEL => 'Menus',
        MenuNode::URL => '/backend/menus',
        MenuNode::VISIBILITY => VisibilityEnum::AUTH->value,
        MenuNode::RELATIONSHIP_ICON => 'lucide/list-collapse',
    ], [
        MenuNode::LABEL => 'Menu nodes',
        MenuNode::URL => '/backend/menu-nodes',
        MenuNode::VISIBILITY => VisibilityEnum::AUTH->value,
        MenuNode::RELATIONSHIP_ICON => 'lucide/link',
    ]],

    /*
    |--------------------------------------------------------------------------
    | Footer Menu
    |--------------------------------------------------------------------------
    |
    | List of menus nodes.
    |
    */

    MenuEnum::FOOTER->value => [],

    /*
    |--------------------------------------------------------------------------
    | Header Menu
    |--------------------------------------------------------------------------
    |
    | List of menus nodes.
    |
    */

    MenuEnum::HEADER->value => [],
];
