<?php

namespace Narsil\Framework\Models\Navigations;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Framework\Interfaces\INodeTrait;
use Narsil\Framework\Traits\NodeTrait;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuHasNode extends Model
{
    use NodeTrait;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = [];

        $this->with = [
            self::RELATIONSHIP_MENU_NODE,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    final public const ID = 'id';
    /**
     * @var string
     */
    final public const MENU_ID = 'menu_id';
    /**
     * @var string
     */
    final public const MENU_NODE_ID = 'menu_node_id';
    /**
     * @var string
     */
    final public const NODE_ID = 'node_id';

    /**
     * @var string
     */
    final public const RELATIONSHIP_MENU = 'menu';
    /**
     * @var string
     */
    final public const RELATIONSHIP_MENU_NODE = 'menu_node';

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
     * @return BelongsTo
     */
    final public function menu_node(): BelongsTo
    {
        return $this->belongsTo(
            MenuNode::class,
            self::MENU_NODE_ID,
            MenuNode::ID,
        );
    }

    #endregion
}
