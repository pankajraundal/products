# How to use productswithqr module.

Enable module using command "drush en productswithqr"

## What it does by its own
    - It will creat content type products
    - It will create custom block for qr code.
    - Qr code Custom block will get auto placed on each products detail page. 
    
## What manual stuff need to do:
    - Module has package to generate qr code, for which composer json has been already added.
    - This composer json contains package for qr code with version.
    - Once module install composer install should needs to run from root.
    - This will add package into the vendor directory.
