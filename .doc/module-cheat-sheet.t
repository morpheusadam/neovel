php artisan module:make-controller API/V1/AuthController Auth
php artisan module:make-migration create_auth_table Auth


mkdir -p Modules/Auth/resources/lang/en
mkdir -p Modules/Auth/resources/lang/fa

sudo touch -p Modules/Auth/resources/lang/en/messages.php
sudo touch -p Modules/Auth/resources/lang/fa/messages.php


php artisan module:migrate-refresh --seed CMS



module:make
module:make
module:use
module:unuse
module:list
module:show-model
module:migrate
module:migrate-rollback
module:migrate-refresh
module:migrate-reset Blog
module:seed
module:publish-migration
module:publish-config
module:publish-translation
module:lang
module:enable
module:disable
module:update
Generator commands
module:make-command
module:make-migration
module:make-seed
module:make-controller
module:make-model
module:make-provider
module:make-middleware
module:make-mail
module:make-notification
module:make-listener
module:make-request
module:make-event
module:make-job
module:route-provider
module:make-factory
module:make-policy
module:make-rule
module:make-resource
module:make-test
module:make-view


