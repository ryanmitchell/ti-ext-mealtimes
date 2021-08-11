## Extend Mealtimes to become Meal Schedules

Extends mealtimes to allow for menu scheduling and different menus on different days.

This is free and doesn't require a license, but you can [donate to Ryan](https://github.com/sponsors/ryanmitchell), the developer behind it, to show your appreciation.

### After Installation
If you want the menu items to be hidden when unavailable, then modify the `mapIntoObjects()` function in `extensions/igniter/local/components/Menu.php` by adding the following before `$list->setCollection();`

 
```
$collection = $collection->filter(function ($menuItem) {
	return !$menuItem->mealtimeIsNotAvailable;
});
```

If you are grouping by categories and want categories with no items to be removed from the menu list, then amend `components/menu/grouped.blade.php` by adding  `@if (count($menuList)) `before `<div class="menu-group-item">` and `@endif` after the closing `</div>` of the same element