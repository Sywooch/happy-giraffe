#!/bin/sh
chown :www-data -R site/console/runtime
chown :www-data -R site/frontend/runtime
chown :www-data -R site/backend/runtime
chown :www-data -R site/frontend/www-submodule/assets
chown :www-data -R site/frontend/www-submodule/jsd
chown :www-data -R site/backend/www/assets
chown root site/frontend/www-submodule/robots.txt
chown :www-data -R site/mobile/www/assets
chown :www-data -R site/mobile/runtime
chown root site/mobile/www/robots.txt
