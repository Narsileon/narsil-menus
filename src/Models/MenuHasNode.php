<?php

namespace Narsil\Menus\Models;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Tree\Models\NodeModel;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuHasNode extends NodeModel
{
    #region CONSTANTS

    /**
     * @var string
     */
    final public const MENU_ID = 'menu_id';

    /**
     * @var string
     */
    final public const RELATIONSHIP_MENU = 'menu';

    /**
     * @var string
     */
    final public const TABLE = 'menu_has_nodes';

    #endregion

    #region RELATIONSHIPS

    /**
     * @return BelongsTo
     */
    final public function menu(): BelongsTo
    {
        return $this->belongsTo(
            Menu::class,
            self::MENU_ID,
            Menu::ID
        );
    }

    /**
     * @return MorphTo
     */
    final public function target(): MorphTo
    {
        return $this->belongsTo(
            MenuNode::class,
            self::TARGET_ID,
            MenuNode::ID,
        );
    }

    #endregion
}
