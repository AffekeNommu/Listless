# Listless

Our family runs on lists. This is the latest incarnation of the list we all use.
It can happily handle many using at once and saves the ticks on click events.
Intended to be used on a phone.

The previous list https://github.com/AffekeNommu/Listy-McListface is so much different from this I am starting a new repository.
Complete rewrite using php, jquery, bootstrap, popper, toastr and datatables.
Could have gone with a framework like codeigniter but chose to do a claytons framework for _fun_.

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
You could also run a cleanup on the database by an event in MySql or scheduled SP in MSSql.
Something like:
```
delete FROM test.list where display=0 and timestamp < DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -1 day);
```
would work well to keep data in check. I would do this myself but my cloud provider has events disabled on MySql.

Namaste
