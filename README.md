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


Change some php files

/extensions/igniter/cart/CartManager.php
-> !$menuItem->isAvailable() needs to become !$menuItem->isAvailable($this->location->orderDateTime())

/extensions/igniter/models/Menus_model.php
change isAvailable to 
    public function isAvailable($orderDateTime)
    {
	    
        if (!$mealtime = $this->mealtime)
            return TRUE;
            
        if (!$mealtime->mealtime_status)
            return TRUE;
            
        return $mealtime->isAvailableNow($orderDateTime);
    }


app/admin/models/Mealtimes_model.php
change isAvailableNow to 
    public function isAvailableNow($date = null)
    {
	    
	    if ($date === null) $date = Carbon::now();
	    
        $isBetween = $date->betweenIncluded(
            Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date),
            Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)
        );
                        
        if (!$isBetween) return false;
                
        foreach ($this->availability as $a){
	        if ($a['day'] == ($date->format('w') + 6)%7){

		        return $date->betweenIncluded(
		            Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d ').$a['open']),
		            Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d ').$a['close'])
		        );
		        
	        }
        }
        
        return true;
        
    }
