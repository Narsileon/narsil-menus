<?php

namespace Narsil\Legals\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JsonSerializable;
use Narsil\Menus\Models\MenuNode;
use Narsil\Localization\Models\Language;
use Narsil\Storage\Models\Icon;
use Narsil\Tables\Constants\Types;
use Narsil\Tables\Http\Resources\DataTableCollection;
use Narsil\Tables\Structures\ModelColumn;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class MenuNodeDataTableCollection extends DataTableCollection
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonSerializable
     */
    public function toArray(Request $request): JsonSerializable
    {
        return $this->collection->map(function ($item)
        {
            $attributes = $item->toArray();

            $attributes[MenuNode::RELATIONSHIP_ICON] = [
                Language::LABEL => $item->{MenuNode::RELATIONSHIP_ICON}->{Icon::PATH},
            ];

            $attributes[MenuNode::ICON_ID] = null;

            return array_filter($attributes);
        });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Collection<ModelColumn>
     */
    protected function getColumns(): Collection
    {
        $columns = parent::getColumns();

        $iconId = $columns->get(MenuNode::ICON_ID);

        $iconId->setAccessorKey(MenuNode::RELATIONSHIP_ICON . '.' . Icon::PATH);
        $iconId->setType(Types::STRING);

        $columns->put(MenuNode::ICON_ID, $iconId);

        return $columns;
    }

    #endregion
}
