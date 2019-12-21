# Listless

Our family runs on lists. This is the latest incarnation of the list we all use.
It can happily handle many using at once and saves the ticks on click events.
Intended to be used on a phone.

The previous list https://github.com/AffekeNommu/Listy-McListface is so much different from this I am starting a new repository.
Complete rewrite using php, jquery, bootstrap, popper, toastr, material icons and datatables.
I have gone with hosted libraries and styles to keep it simple on the site.
Could have gone with a framework like codeigniter but chose to do a claytons framework for _fun_.

It has 2 files:
* index.php - the view
* functions.php - the model/controller
The functions php is called with a value and there is a case that picks the correct function inside it. Technically a controller and we can call the functions the model.

There are 2 tables in a database
* list - where all items go
* category - current categories for the dropdown

It can happily start with an empty database and not display errors.
Categories can be added and removed.
Items can be displayed, checked off and removed from display.
Item remove undo has a 15 minute max.

The create statements for the tables are:

```
CREATE TABLE `category` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  PRIMARY KEY (`idx`),
  UNIQUE KEY `idx_UNIQUE` (`idx`),
  UNIQUE KEY `category_UNIQUE` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `list` (
  `idlist` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `display` tinyint(4) DEFAULT '1',
  `checked` tinyint(4) DEFAULT '0',
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlist`),
  UNIQUE KEY `idlist_UNIQUE` (`idlist`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```
I have given them incrementing int as keys to see how many of each are created.
The category in category has a unique constraint so that you do not add twice.
I have the removeticked function actioning a cleanup for all stale items because my cloud provider has events disabled on MySql.
Alternatively you could do this as an event in MySql or scheduled SP in MSSql.
Something like:
```
delete FROM test.list where display=0 and timestamp < DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -1 day);
```
would also work well to keep data in check. 


Namaste
