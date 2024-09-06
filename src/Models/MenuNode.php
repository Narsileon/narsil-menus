<?php

namespace Narsil\Menus\Models;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Narsil\Localization\Casts\TransAttribute;
use Narsil\Storage\Models\Icon;
use Narsil\Menus\Enums\VisibilityEnum;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuNode extends Model
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

        $this->casts = [
            self::ACTIVE => 'boolean',
            self::LABEL => TransAttribute::class,
        ];

        $this->guarded = [
            self::ID,
        ];

        $this->hidden = [
            self::PREFIXABLE,
        ];

        $this->with = [
            self::RELATIONSHIP_ICON,
        ];

        parent::__construct($attributes);
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
    final public const BACKGROUND = 'background';
    /**
     * @var string
     */
    final public const DESCRIPTION = 'description';
    /**
     * @var string
     */
    final public const ICON_ID = 'icon_id';
    /**
     * @var string
     */
    final public const ID = 'id';
    /**
     * @var string
     */
    final public const LABEL = 'label';
    /**
     * @var string
     */
    final public const PREFIXABLE = 'prefixable';
    /**
     * @var string
     */
    final public const URL = 'url';
    /**
     * @var string
     */
    final public const VISIBILITY = 'visibility';

    /**
     * @var string
     */
    final public const RELATIONSHIP_ICON = 'icon';

    /**
     * @var string
     */
    final public const TABLE = 'menu_nodes';

    #endregion

    #region RELATIONSHIPS

    /**
     * @return HasOne
     */
    final public function icon(): HasOne
    {
        return $this->hasOne(
            Icon::class,
            Icon::ID,
            self::ICON_ID
        );
    }

    #endregion

    #region SCOPES

    /**
     * @param Builder $query
     * @param string $url
     *
     * @return void
     */
    final public function scopeBreadcrumb(Builder $query, string $url): void
    {
        $query->whereRaw('? REGEXP ' . self::URL, [$url]);
    }

    /**
     * @param Builder $query
     *
     * @return void
     */
    final public function scopePages(Builder $query): void
    {
        $query
            ->select([
                MenuNode::LABEL,
                MenuNode::URL
            ])
            ->where(self::VISIBILITY, '!=', VisibilityEnum::GUEST->value)
            ->where(self::URL, 'like', '/%')
            ->where(self::URL, '!=', '/logout');
    }

    #endregion
}
