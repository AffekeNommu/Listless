# Listless
The previous list is so much different from this I am starting a new repository.

Complete rewrite using php, jquery, bootstrap, popper, toastr and datatables.
Could have gone with a framework like codeigniter but chose to do a claytons framework for fun.

It has 2 files:
* index.php - the view
* functions.php - the model/controller

There are 2 tables in a database
* list - where all items go
* category - current categories for the dropdown

It can happily start with an empty database and not display errors.
Categories can be added and removed.
Items can be displayed, checked off and removed from display.
Item remove undo has a 15 minute max.

