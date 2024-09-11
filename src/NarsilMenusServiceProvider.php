<?php

namespace Narsil\Menus;

#region USE

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Narsil\Menus\Commands\SyncMenusCommand;
use Narsil\Menus\Models\Menu;
use Narsil\Menus\Models\MenuNode;
use Narsil\Menus\Policies\MenuNodePolicy;
use Narsil\Menus\Policies\MenuPolicy;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
final class NarsilMenusServiceProvider extends ServiceProvider
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->bootCommands();
        $this->bootMigrations();
        $this->bootPolicies();
        $this->bootPublishes();
        $this->bootRoutes();
        $this->bootTranslations();
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return void
     */
    private function bootCommands(): void
    {
        $this->commands([
            SyncMenusCommand::class,
        ]);
    }

    /**
     * @return void
     */
    private function bootMigrations(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database/migrations',
        ]);
    }

    /**
     * @return void
     */
    private function bootPolicies(): void
    {
        Gate::policy(Menu::class, MenuPolicy::class);
        Gate::policy(MenuNode::class, MenuNodePolicy::class);
    }

    /**
     * @return void
     */
    private function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/Config' => config_path(),
        ], 'config');
    }

    /**
     * @return void
     */
    private function bootRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/backend.php');
    }

    /**
     * @return void
     */
    private function bootTranslations(): void
    {
        $this->loadJsonTranslationsFrom(__DIR__ . '/../lang', 'menus');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'menus');
    }

    #endregion
}
