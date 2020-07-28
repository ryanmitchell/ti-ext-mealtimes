## Extend Mealtimes to become Meal Schedules

Extends mealtimes to allow for menu scheduling and different menus on different days.

### After Installation
If you are using the tastyigniter-orange theme you need to amend _partials/localMenu/item.php as follows:

$mealtimeNotAvailable = ($mealtime AND !$mealtime->isAvailableNow());

becomes

$mealtimeNotAvailable = ($mealtime AND !$mealtime->isAvailableSchedule($location->orderDateTime()));

wrap the entire HTML output in

if ($mealtimeNotAvailable == false){

}

i.e. 

if ($mealtimeNotAvailable == false){

?>

....

<?php } ?>