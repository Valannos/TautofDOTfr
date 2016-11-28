tautofDOTfr
===========

A small Symfony project to manage a car adverts website. 
Currently, user can login or registrer himself and look for adverts from make or model name (color criteria selection in progress) registered in database. Users can also edit their own adverts.

ADMIN_ROLE has been defined in firewalls (security.yml) and can, for the moment, remove user from database. 

Adding an advert is possible but need to be improve (add photos, select make/model from database…).

Installation
============

- Clone this project
- get dependencies : composer install 
- Create a database and import tables from file "tautofDOTfr.sql"
- Change database parameters in parameters.yml 
  
