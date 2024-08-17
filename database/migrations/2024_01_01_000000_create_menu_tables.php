<?php

#region USE

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Narsil\Menus\Models\Menu;
use Narsil\Menus\Models\MenuHasNode;
use Narsil\Menus\Models\MenuNode;

#endregion

return new class extends Migration
{
    #region MIGRATIONS

    /**
     * @return void
     */
    public function up(): void
    {
        $this->createMenusTable();
        $this->createMenuNodesTable();
        $this->createMenuHasNodesTable();

        Artisan::call('narsil:sync-menus');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(MenuHasNode::TABLE);
        Schema::dropIfExists(MenuNode::TABLE);
        Schema::dropIfExists(Menu::TABLE);
    }

    #endregion

    #region TABLES

    /**
     * @return void
     */
    private function createMenusTable(): void
    {
        if (Schema::hasTable(Menu::TABLE))
        {
            return;
        }

        Schema::create(Menu::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Menu::ID);
            $table
                ->boolean(Menu::ACTIVE)
                ->default(true);
            $table
                ->string(Menu::TYPE);
            $table
                ->trans(Menu::NAME);
            $table
                ->timestamps();

            $table
                ->unique([
                    Menu::TYPE,
                    Menu::NAME,
                ]);
        });
    }

    /**
     * @return void
     */
    private function createMenuHasNodesTable(): void
    {
        if (Schema::hasTable(MenuHasNode::TABLE))
        {
            return;
        }

        Schema::create(MenuHasNode::TABLE, function (Blueprint $table)
        {
            $table
                ->node(MenuHasNode::TABLE);
            $table
                ->foreignId(MenuHasNode::MENU_ID)
                ->constrained(Menu::TABLE, Menu::ID)
                ->cascadeOnDelete();
        });
    }

    /**
     * @return void
     */
    private function createMenuNodesTable(): void
    {
        if (Schema::hasTable(MenuNode::TABLE))
        {
            return;
        }

        Schema::create(MenuNode::TABLE, function (Blueprint $table)
        {
            $table
                ->id(Menu::ID);
            $table
                ->boolean(Menu::ACTIVE)
                ->default(true);
            $table
                ->string(MenuNode::VISIBILITY);
            $table
                ->string(MenuNode::URL)
                ->nullable();
            $table
                ->trans(MenuNode::LABEL);
            $table
                ->icon(MenuNode::ICON_ID);
            $table
                ->color(MenuNode::BACKGROUND);
        });
    }

    #endregion
};
