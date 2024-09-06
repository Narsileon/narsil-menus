<?php

namespace Narsil\Legals\Http\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Narsil\Localization\Models\Language;
use Narsil\Menus\Models\MenuNode;
use Narsil\Storage\Models\Icon;
use Narsil\Tables\Constants\Types;
use Narsil\Tables\Http\Resources\ShowTableResource;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class ImprintShowTableResource extends ShowTableResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        $attributes = $this->resource->toArray();

        $attributes[MenuNode::RELATIONSHIP_ICON] = [
            Language::LABEL => $this->resource->{MenuNode::RELATIONSHIP_ICON}->{Icon::PATH},
        ];

        $attributes[MenuNode::ICON_ID] = null;

        return array_filter($attributes);
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
