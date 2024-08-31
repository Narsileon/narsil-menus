<?php

namespace Narsil\Menus\Http\Menus;

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class AbstractMenu
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public static function getBackendMenu(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getFooterMenu(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getHeaderMenu(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getMenuNodes(): array
    {
        return [];
    }

    #endregion
}
