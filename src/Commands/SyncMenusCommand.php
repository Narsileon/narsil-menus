<?php

namespace Narsil\Menus\Commands;

#region USE

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Narsil\Menus\Constants\MenusConfig;
use Narsil\Menus\Enums\MenuEnum;
use Narsil\Menus\Models\Menu;
use Narsil\Menus\Models\MenuHasNode;
use Narsil\Menus\Models\MenuNode;
use Narsil\Storage\Models\Icon;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class SyncMenusCommand extends Command
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->signature = 'narsil:sync-menus {--fresh}';
        $this->description = 'Syncs the menu tables with the menu files';

        parent::__construct();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Collection Collection of Menu keyed by path.
     */
    private Collection $icons;
    /**
     * @var Collection Collection of Menu keyed by type.
     */
    private Collection $menus;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function handle(): void
    {
        if ($this->option('fresh'))
        {
            MenuNode::query()->delete();
            Menu::query()->delete();
        }

        $this->icons = Icon::all()->keyBy(Icon::PATH);
        $this->menus = Menu::all()->keyBy(Menu::TYPE);

        $this->createMenus();

        $this->info('Menu tables have been successfully synced with the menu files.');
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function createMenus(): void
    {
        foreach (MenuEnum::cases() as $case)
        {
            $menu = $this->menus->get($case->value);

            if (!$menu)
            {
                $menu = Menu::create([
                    Menu::NAME => $case->value,
                    Menu::TYPE => $case->value,
                ]);
            }

            $this->createMenuNodes($menu);
        }
    }

    /**
     * @param Menu $menu
     *
     * @return void
     */
    protected function createMenuNodes(Menu $menu): void
    {
        $menuClassNames = Config::get(MenusConfig::MENUS, []);

        foreach ($menuClassNames as $menuClassName)
        {
            $nodes = match ($menu->{Menu::TYPE})
            {
                MenuEnum::BACKEND->value => $menuClassName::getBackendMenu(),
                MenuEnum::FOOTER->value => $menuClassName::getFooterMenu(),
                MenuEnum::HEADER->value => $menuClassName::getHeaderMenu(),
            };

            foreach ($nodes as $node)
            {
                $icon = $this->icons->get(Arr::get($node, MenuNode::RELATIONSHIP_ICON));

                if ($icon)
                {
                    Arr::set($node, MenuNode::ICON_ID, $icon->{Icon::ID});
                }

                $menuNode = MenuNode::firstOrCreate([
                    MenuNode::VISIBILITY => Arr::get($node, MenuNode::VISIBILITY),
                    MenuNode::URL => Arr::get($node, MenuNode::URL),
                ], [$node]);

                $menuHasNode = MenuHasNode::firstOrNew([
                    MenuHasNode::MENU_ID => $menu->{Menu::ID},
                    MenuHasNode::TARGET_ID => $menuNode->{MenuNode::ID},
                ]);

                $menuHasNode->target()->attach($menuNode);

                $menuHasNode->save();
            }
        }
    }

    #endregion
}
