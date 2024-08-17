<?php

namespace Narsil\Menus\Policies;

#region USE

use Narsil\Menus\Models\MenuNode;
use Narsil\Policies\Policies\AbstractPolicy;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class MenuNodePolicy extends AbstractPolicy
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(MenuNode::class);
    }

    #endregion
}
