## Extend Mealtimes to become Meal Schedules

Extends mealtimes to allow for menu scheduling and different menus on different days.

### After Installation
Change the following PHP file:

```
extensions/igniter/cart/classes/CartManager.php
```
!$menuItem->isAvailable() needs to become !$menuItem->isAvailable($this->location->orderDateTime())


If you are using the tastyigniter-orange theme you need to amend extensions/igniter/local/components/Menu.php as follows:

```
$object->mealtimeIsNotAvailable = !$menuItem->isAvailable(Location::instance()->orderDateTime());
```

becomes

```
$mealtimeNotAvailable = true;
$location = Location::instance();
$mealtimes->each(function($mealtime) use (&$mealtimeNotAvailable, $location){
    if ($mealtime->isAvailableSchedule($location->orderDateTime())){
        $mealtimeNotAvailable = false;
    }
});
$object->mealtimeIsNotAvailable = $mealtimeNotAvailable;
```

**Note:** this will mean any menu items without a mealtime will also be unavailable.

If you want the menu option to be hidden when unavailable, then wrap the HTML output in extensions/igniter/local/components/menu/item.blade.php with

`@if ($menuItemObject->mealtimeIsNotAvailable == false)
 @endif
`

i.e.
 
```
@if ($menuItemObject->mealtimeIsNotAvailable == false)

....

@endif
```
