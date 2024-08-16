<?php

namespace Narsil\Framework\Models\Navigations;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Narsil\Forms\Models\FormNodeOption;
use Narsil\Framework\Enums\MenuEnum;
use Narsil\Framework\Enums\VisibilityEnum;
use Narsil\Framework\Http\Resources\Menus\MenuFormResource;
use Narsil\Framework\Observers\MenuObserver;

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
    final public const RELATIONSHIP_TYPE_OPTION = 'type_option';
    /**
     * @var string
     */
    final public const RELATIONSHIP_VALIDATED_NODES = 'validated_nodes';

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
     * @return HasOne
     */
    final public function type_option(): HasOne
    {
        return $this->hasOne(
            FormNodeOption::class,
            FormNodeOption::ID,
            self::TYPE
        );
    }

    /**
     * @return HasMany
     */
    final public function validated_nodes(): HasMany
    {
        return $this->hasMany(
            MenuHasNode::class,
            MenuHasNode::MENU_ID,
            self::ID
        )->whereHas(MenuHasNode::RELATIONSHIP_MENU_NODE, function ($query)
        {
            $query
                ->whereHas(MenuNode::RELATIONSHIP_VISIBILITY_OPTION, function (Builder $query)
                {
                    if (Auth::check())
                    {
                        $query->where(FormNodeOption::VALUE, VisibilityEnum::AUTH->value);
                    }
                    else
                    {
                        $query->where(FormNodeOption::VALUE, VisibilityEnum::GUEST->value);
                    }

                    $query->orWhere(FormNodeOption::VALUE, VisibilityEnum::USER->value);
                })
                ->orDoesntHave(MenuNode::RELATIONSHIP_VISIBILITY_OPTION);
        })->orderBy(MenuHasNode::NODE_ID);
    }

    #endregion

    #region SCOPES

    /**
     * @param Builder $query
     * @param MenuEnum $type
     *
     * @return void
     */
    final public function scopeType(Builder $query, string $type): void
    {
        $query->whereHas(self::RELATIONSHIP_TYPE_OPTION, function (Builder $query) use ($type)
        {
            $query->where(FormNodeOption::VALUE, $type);
        })->get();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string $filter
     *
     * @return array<string,mixed>
     */
    final public static function options(string $filter = ''): array
    {
        return static::getOptions(self::TYPE, $filter, [
            self::ID,
            self::NAME,
        ]);
    }

    #endregion
}
