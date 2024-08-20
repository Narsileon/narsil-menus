<?php

namespace Narsil\Menus\Models;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Tree\Models\NodeModel;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuHasNode extends NodeModel
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = [
            self::ID,
        ];

        parent::__construct($attributes);
    }

    #endregion

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

    #endregion
}
