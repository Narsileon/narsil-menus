<?php

namespace Narsil\Framework\Models\Navigations;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Narsil\Forms\Models\FormNodeOption;
use Narsil\Framework\Enums\VisibilityEnum;
use Narsil\Storage\Models\Icon;

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
        $this->hidden = [
            self::PREFIXABLE,
        ];

        parent::__construct($attributes, self::TABLE);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    final public const BACKGROUND = 'background';
    /**
     * @var string
     */
    final public const ICON_ID = 'icon_id';
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
    final public const RELATIONSHIP_VISIBILITY_OPTION = 'visiblity_option';

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

    /**
     * @return HasOne
     */
    final public function visiblity_option(): HasOne
    {
        return $this->hasOne(
            FormNodeOption::class,
            FormNodeOption::ID,
            self::VISIBILITY
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

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    final public static function pages(): array
    {
        $pages = MenuNode::query()
            ->where(self::VISIBILITY, '!=', VisibilityEnum::GUEST->value)
            ->where(self::URL, 'LIKE', '/%')
            ->where(self::URL, '!=', '/logout')
            ->get()
            ->select([
                MenuNode::LABEL,
                MenuNode::URL
            ])->toArray();

        return $pages;
    }

    #endregion
}
