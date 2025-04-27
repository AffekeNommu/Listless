# Listless

This version has no need for a database. It stores the data in a pair of JSON files.
It also can cope with multiple users.
On first use or if you want to change lists you need to set the list ID. Each user could have a differnet ID or IDs.

It has 2 files:
* index.php - the view
* functions.php - the model/controller
The functions php is called with a value and there is a case that picks the correct function inside it. Technically a controller and we can call the functions the model.

There are 2 tables in JSON files:
* list - where all items go
* category - current categories for the dropdown

These files have the name of catfile-<id>.json and listfile-<id>.json
The ID is set in a cookie which has an expiry of 2 weeks. You can give the same ID to get back to your files if it expires.

It can happily start empty and not display errors.
Categories can be added and removed.
Items can be displayed, checked off and removed from display.
There is an edit toggle and an auto clear toggle.

The JSON files are small but you might need to clean up unused lists eventually.

I have this running in an Azure app service on PHP with no modifications.


Enjoy!
