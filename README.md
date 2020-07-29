## Extend Mealtimes to become Meal Schedules

Extends mealtimes to allow for menu scheduling and different menus on different days.

### After Installation
Change the following PHP file:

```
extensions/igniter/cart/classes/CartManager.php
```
!$menuItem->isAvailable() needs to become !$menuItem->isAvailable($this->location->orderDateTime())
