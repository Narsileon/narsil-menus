<?php

namespace Narsil\Menus\Policies;

#region USE

use Narsil\Menus\Models\Menu;
use Narsil\Policies\Policies\AbstractPolicy;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class MenuPolicy extends AbstractPolicy
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Menu::class);
    }

    #endregion
}
