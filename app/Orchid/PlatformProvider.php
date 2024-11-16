<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

/**
 * Класс PlatformProvider
 *
 * Регистрация меню и прав доступа для панели управления Orchid.
 */
class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Инициализация сервисов приложения.
     *
     * @param Dashboard $dashboard
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // Здесь можно добавить дополнительные настройки или загрузчики.
    }

    /**
     * Регистрация элементов меню.
     *
     * @return Menu[] Массив элементов меню.
     */
    public function menu(): array
    {
        return [
            // Управление клиентами
            Menu::make(__('Customers'))
                ->icon('bs.person-badge')
                ->route('platform.systems.customers')
                ->title(__('Customer Management')),

            // Управление адресами
            Menu::make(__('Addresses'))
                ->icon('bs.house')
                ->route('platform.systems.addresses')
                ->title(__('Address Management')),

            // Управление категориями продуктов
            Menu::make(__('Categories'))
                ->icon('bs.tags')
                ->route('platform.systems.categories')
                ->title(__('Category Management')),

            // Управление продуктами
            Menu::make(__('Products'))
                ->icon('bs.box-seam')
                ->route('platform.systems.products')
                ->title(__('Product Management')),

            // Управление заказами
            Menu::make(__('Orders'))
                ->icon('bs.bag')
                ->route('platform.systems.orders')
                ->title(__('Order Management')),
        ];
    }

    /**
     * Регистрация прав доступа для приложения.
     *
     * @return ItemPermission[] Массив прав доступа.
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
