<?php

use App\Adm\Services\CategoryService;
use App\Adm\Services\MenuService;
use App\Adm\Services\PageService;
use App\Adm\Services\PostService;
use App\Adm\Services\TagService;
use App\Models\MenuItem;
use Spatie\Valuestore\Valuestore;

function siteSetting(): Valuestore
{
    return Valuestore::make(app_path('Settings/site_settings.json'));
}

function siteSettingsAll(): array
{
    return siteSetting()->all();
}

function siteLogoUrl(): string
{
    return !empty(siteSetting()->get('logo')) ?  '/storage/'.siteSetting()->get('logo') : asset('assets/images/logo.png');
}

function globalPaginationCount(): int
{
    $settingCount = siteSetting()->get('paginationCount');
    $configCount = config('adm', 'paginationCount');

    return !empty($settingCount) ? $settingCount : $configCount;
}

function admFormAction(string $hash): string
{
    return route('adm-form', $hash);
}

function pageLink($slug): string
{
    return route('page', $slug);
}

function homeLink(): string
{
    return route('home');
}

function pageDataBySlug($slug) {
    return resolve(PageService::class)->getOneBySlug($slug);
}

function parentsCategories() {
    return CategoryService::getAllParents();
}

function getAllTags() {
    return TagService::getAll();
}

function getPopularPosts(?int $paginationCount = 5, ?string $categorySlug = '') {
    return PostService::popularPosts($paginationCount, $categorySlug);
}

function AdmRandomImage(): string
{
    $rand = rand(1,21);
    return '/images/random/'.$rand.'.jpg';
}

function admMenuBySlug($slug) {
    $menu = MenuService::bySlug($slug);
    return !empty($menu->menu_items) ? MenuItem::tree($menu->id) : $menu->menu_items ?? [];
}

function admMenuByPosition($position) {
    $menu = MenuService::byPosition($position);
    return !empty($menu->menu_items) ? MenuItem::tree($menu->id) : $menu->menu_items ?? [];
}
