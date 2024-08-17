<?php

namespace Narsil\Menus\Models;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Narsil\Localization\Casts\TransAttribute;
use Narsil\Menus\Enums\MenuEnum;
use Narsil\Menus\Enums\VisibilityEnum;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class Menu extends Model
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->casts = [
            self::ACTIVE => 'boolean',
            self::NAME => TransAttribute::class,
        ];

        $this->with = [
            self::RELATIONSHIP_NODES,
        ];

        parent::__construct($attributes, self::TABLE);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    final public const ACTIVE = 'active';
    /**
     * @var string
     */
    final public const ID = 'id';
    /**
     * @var string
     */
    final public const NAME = 'name';
    /**
     * @var string
     */
    final public const TYPE = 'type';

    /**
     * @var string
     */
    final public const RELATIONSHIP_NODES = 'nodes';
    /**
     * @var string
     */
    final public const RELATIONSHIP_VISIBLE_NODES = 'visible_nodes';

    /**
     * @var string
     */
    final public const TABLE = 'menus';

    #endregion

    #region RELATIONSHIPS

    /**
     * @return HasMany
     */
    final public function nodes(): HasMany
    {
        return $this->hasMany(
            MenuHasNode::class,
            MenuHasNode::MENU_ID,
            self::ID
        );
    }

    /**
     * @return HasMany
     */
    final public function visible_nodes(): HasMany
    {
        return $this->hasMany(
            MenuHasNode::class,
            MenuHasNode::MENU_ID,
            self::ID
        )->whereHas(MenuHasNode::RELATIONSHIP_TARGET, function ($menuNodeQuery)
        {
            $menuNodeQuery
                ->where(function (Builder $subquery)
                {
                    if (Auth::check())
                    {
                        $subquery->where(MenuNode::VISIBILITY, VisibilityEnum::AUTH->value);
                    }
                    else
                    {
                        $subquery->where(MenuNode::VISIBILITY, VisibilityEnum::GUEST->value);
                    }

                    $subquery->orWhere(MenuNode::VISIBILITY, VisibilityEnum::USER->value);
                });
        });
    }

    #endregion

    #region SCOPES

    /**
     * @param Builder $query
     *
     * @return void
     */
    final public function scopeOptions(Builder $query): void
    {
        $query
            ->select([
                self::ID,
                self::NAME,
            ])
            ->where(self::ACTIVE, true);
    }

    /**
     * @param Builder $query
     * @param MenuEnum $type
     *
     * @return void
     */
    final public function scopeType(Builder $query, string $type): void
    {
        $query->where(self::TYPE, $type);;
    }

    #endregion
}
