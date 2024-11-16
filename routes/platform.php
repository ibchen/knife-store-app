<?php

declare(strict_types=1);

use App\Orchid\Screens\Address\AddressEditScreen;
use App\Orchid\Screens\Address\AddressListScreen;
use App\Orchid\Screens\Customer\CustomerEditScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Order\OrderEditScreen;
use App\Orchid\Screens\Order\OrderListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Product\ProductEditScreen;
use App\Orchid\Screens\Product\ProductListScreen;
use App\Orchid\Screens\ProductCategory\ProductCategoryEditScreen;
use App\Orchid\Screens\ProductCategory\ProductCategoryListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Customer\CustomerListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать маршруты для панели управления.
| Эти маршруты используют middleware "dashboard" для обеспечения безопасности.
| Добавляйте свои маршруты для экранов и других элементов платформы Orchid.
|
*/

// Главная страница панели
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Профиль пользователя
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Управление пользователями
Route::group(['prefix' => 'users'], function () {
    Route::screen('{user}/edit', UserEditScreen::class)
        ->name('platform.systems.users.edit')
        ->breadcrumbs(fn(Trail $trail, $user) => $trail
            ->parent('platform.systems.users')
            ->push($user->name, route('platform.systems.users.edit', $user)));

    Route::screen('create', UserEditScreen::class)
        ->name('platform.systems.users.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create')));

    Route::screen('', UserListScreen::class)
        ->name('platform.systems.users')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users')));
});

// Управление ролями
Route::group(['prefix' => 'roles'], function () {
    Route::screen('{role}/edit', RoleEditScreen::class)
        ->name('platform.systems.roles.edit')
        ->breadcrumbs(fn(Trail $trail, $role) => $trail
            ->parent('platform.systems.roles')
            ->push($role->name, route('platform.systems.roles.edit', $role)));

    Route::screen('create', RoleEditScreen::class)
        ->name('platform.systems.roles.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create')));

    Route::screen('', RoleListScreen::class)
        ->name('platform.systems.roles')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles')));
});

// Управление клиентами
Route::group(['prefix' => 'customers'], function () {
    Route::screen('', CustomerListScreen::class)
        ->name('platform.systems.customers')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Customers'), route('platform.systems.customers')));

    Route::screen('create', CustomerEditScreen::class)
        ->name('platform.systems.customers.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.customers')
            ->push(__('Create Customer'), route('platform.systems.customers.create')));

    Route::screen('{customer}/edit', CustomerEditScreen::class)
        ->name('platform.systems.customers.edit')
        ->breadcrumbs(fn(Trail $trail, $customer) => $trail
            ->parent('platform.systems.customers')
            ->push(__('Edit Customer'), route('platform.systems.customers.edit', $customer)));
});

// Управление продуктами
Route::group(['prefix' => 'products'], function () {
    Route::screen('', ProductListScreen::class)
        ->name('platform.systems.products');

    Route::screen('create', ProductEditScreen::class)
        ->name('platform.systems.products.create');

    Route::screen('{product}/edit', ProductEditScreen::class)
        ->name('platform.systems.products.edit');
});

// Управление категориями продуктов
Route::group(['prefix' => 'categories'], function () {
    Route::screen('', ProductCategoryListScreen::class)
        ->name('platform.systems.categories');

    Route::screen('create', ProductCategoryEditScreen::class)
        ->name('platform.systems.categories.create');

    Route::screen('{category}/edit', ProductCategoryEditScreen::class)
        ->name('platform.systems.categories.edit');
});

// Управление адресами
Route::group(['prefix' => 'addresses'], function () {
    Route::screen('', AddressListScreen::class)
        ->name('platform.systems.addresses');

    Route::screen('create', AddressEditScreen::class)
        ->name('platform.systems.addresses.create');

    Route::screen('{address}/edit', AddressEditScreen::class)
        ->name('platform.systems.addresses.edit');
});

// Управление заказами
Route::group(['prefix' => 'orders'], function () {
    Route::screen('', OrderListScreen::class)
        ->name('platform.systems.orders');

    Route::screen('create', OrderEditScreen::class)
        ->name('platform.systems.orders.create');

    Route::screen('edit/{order?}', OrderEditScreen::class)
        ->name('platform.systems.orders.edit');
});

// Примеры использования Orchid
Route::group(['prefix' => 'examples'], function () {
    Route::screen('', ExampleScreen::class)
        ->name('platform.example');

    Route::screen('form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
    Route::screen('form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
    Route::screen('form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
    Route::screen('form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

    Route::screen('layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
    Route::screen('grid', ExampleGridScreen::class)->name('platform.example.grid');
    Route::screen('charts', ExampleChartsScreen::class)->name('platform.example.charts');
    Route::screen('cards', ExampleCardsScreen::class)->name('platform.example.cards');
});
