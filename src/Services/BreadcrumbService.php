<?php

namespace Narsil\Menus\Services;

#region USE

use Narsil\Menus\Models\MenuNode;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class BreadcrumbService
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public static function getBreadcrumb(): array
    {
        $breadcrumbNodes = MenuNode::breadcrumb(url()->current())->get();

        $breadcrumb = [];

        foreach ($breadcrumbNodes as $breadcrumbNode)
        {
            $breadcrumb[$breadcrumbNode->{MenuNode::URL}] = $breadcrumbNode->{MenuNode::LABEL};
        }

        return $breadcrumb;
    }

    #endregion
}
