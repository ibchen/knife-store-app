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
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//Route::screen('idea', Idea::class, 'platform.screens.idea');

// Platform > System > Customers
Route::screen('customers', CustomerListScreen::class)
    ->name('platform.systems.customers')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Customers'), route('platform.systems.customers')));

// Platform > System > Customers > Create
Route::screen('customers/create', CustomerEditScreen::class)
    ->name('platform.systems.customers.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.customers')
        ->push(__('Create Customer'), route('platform.systems.customers.create')));

// Platform > System > Customers > Edit
Route::screen('customers/{customer}/edit', CustomerEditScreen::class)
    ->name('platform.systems.customers.edit')
    ->breadcrumbs(fn (Trail $trail, $customer) => $trail
        ->parent('platform.systems.customers')
        ->push(__('Edit Customer'), route('platform.systems.customers.edit', $customer)));

// Platform > System > Products > Edit
Route::screen('products/{product}/edit', ProductEditScreen::class)
    ->name('platform.systems.products.edit');

// Platform > System > Products > Create
Route::screen('products/create', ProductEditScreen::class)
    ->name('platform.systems.products.create');

// Platform > System > Products
Route::screen('products', ProductListScreen::class)
    ->name('platform.systems.products');

// Platform > System > Categories
Route::screen('categories/{category}/edit', ProductCategoryEditScreen::class)
    ->name('platform.systems.categories.edit');

// Platform > System > Categories > Create
Route::screen('categories/create', ProductCategoryEditScreen::class)
    ->name('platform.systems.categories.create');

// Platform > System > Categories
Route::screen('categories', ProductCategoryListScreen::class)
    ->name('platform.systems.categories');

// Platform > System > Addresses
Route::screen('addresses/{address}/edit', AddressEditScreen::class)
    ->name('platform.systems.addresses.edit');

// Platform > System > Addresses > Create
Route::screen('addresses/create', AddressEditScreen::class)
    ->name('platform.systems.addresses.create');

// Platform > System > Addresses
Route::screen('addresses', AddressListScreen::class)
    ->name('platform.systems.addresses');




