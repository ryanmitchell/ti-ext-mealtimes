## Extend Mealtimes to become Meal Schedules

Extends mealtimes to allow for menu scheduling and different menus on different days.

### After Installation
If you are using the tastyigniter-orange theme you need to amend the `createMenuItemObject()` function in `extensions/igniter/local/components/Menu.php` as follows:

```
$object->mealtimeIsNotAvailable = !$menuItem->isAvailable(Location::instance()->orderDateTime());
```

becomes

```
$mealtimeNotAvailable = false;
$location = Location::instance();
$mealtimes->each(function($mealtime) use (&$mealtimeNotAvailable, $location){
    if (!$mealtime->isAvailableSchedule($location->orderDateTime())){
        $mealtimeNotAvailable = true;
    }
});
$object->mealtimeIsNotAvailable = $mealtimeNotAvailable;
```

**Note:** this will mean any menu items without a mealtime will still be available.

If you want the menu option to be hidden when unavailable, then modify the `mapIntoObjects()` function in the same file by adding the following before `$list->setCollection();`

 
```
$collection = $collection->filter(function ($menuItem) {
	return !$menuItem->mealtimeIsNotAvailable;
});
```

If you are grouping by categories and want categories with no items to be removed from the menu list, then amend `components/menu/grouped.blade.php` by adding  `@if (count($menuList)) `before `<div class="menu-group-item">` and `@endif` after the closing `</div>` of the same element