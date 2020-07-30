## Extend Mealtimes to become Meal Schedules

Extends mealtimes to allow for menu scheduling and different menus on different days.

### After Installation
Change the following PHP file:

```
extensions/igniter/cart/classes/CartManager.php
```
!$menuItem->isAvailable() needs to become !$menuItem->isAvailable($this->location->orderDateTime())


If you are using the tastyigniter-orange theme you need to amend partials/localMenu/item.php as follows:

```
$mealtimeNotAvailable = ($mealtime AND !$mealtime->isAvailableNow());
```

becomes

```
$mealtimeNotAvailable = ($mealtime AND !$mealtime->isAvailableSchedule($location->orderDateTime()));
```

wrap the entire HTML output in

`if ($mealtimeNotAvailable == false){ }
`


i.e.
 
```
if ($mealtimeNotAvailable == false){

?>

....

<?php } ?>
```