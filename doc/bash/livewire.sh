#!/bin/bash
create_directories() {
    local dir=$1
    mkdir -p "resources/views/livewire/$dir"
}

# Function to create Livewire components
create_livewire_component() {
    local component=$1
    php artisan make:livewire "$component"
}

# Function to create directories if they don't exist
create_directories() {
    local dir=$1
    mkdir -p "resources/views/livewire/$dir"
}

# Define directories and files
directories=(
    "morpheus/admin/banner:create edit index"
    "morpheus/admin/brand:create edit index"
    "morpheus/admin/category:create edit index"
    "morpheus/admin/comment:edit index"
    "morpheus/admin/coupon:create edit index"
    "morpheus/admin:index"
    "morpheus/admin/laravel-filemanager:crop demo index move resize tree use"
    "morpheus/admin/layouts:changePassword file-manager footer head header master notification sidebar"
    "morpheus/admin/mail/html:button footer header layout message panel subcopy table"
    "morpheus/admin/mail/html/themes:default"
    "morpheus/admin/mail/text:button footer header layout message panel subcopy table"
    "morpheus/admin/message:index message show"
    "morpheus/admin/notification:index show"
    "morpheus/admin/notifications:email"
    "morpheus/admin/order:edit index pdf show"
    "morpheus/admin/pagination:bootstrap-4 bootstrap-5 default semantic-ui simple-bootstrap-4 simple-bootstrap-5 simple-default simple-tailwind tailwind"
    "morpheus/admin/post:create edit index"
    "morpheus/admin/postcategory:create edit index"
    "morpheus/admin/posttag:create edit index"
    "morpheus/admin/product:create edit index"
    "morpheus/admin/review:edit index"
    "morpheus/admin/setting:setting"
    "morpheus/admin/shipping:create edit index"
    "morpheus/admin/users:create edit index profile"
    "morpheus/auth:login o-login register verify"
    "morpheus/auth/passwords:confirm email old-reset reset"
    "morpheus/errors:401 402 403 404 419 429 500 503 layout minimal"
    "morpheus/user:home"
    "morpheus/user/layouts:_filter _listProducts footer head header master newsletter notification"
    "morpheus/user/pages:about-us blog-detail blog cart checkout comment contact login order-track product-grids product-lists product_detail register wishlist"
    "morpheus/user/profile/comment:edit index"
    "morpheus/user/profile:index setting"
    "morpheus/user/profile/layouts:file-manager footer head header master notification sidebar userPasswordChange"
    "morpheus/user/profile/order:index pdf show"
    "morpheus/user/profile/review:edit index show"
    "morpheus/user/profile/users:create edit index profile"
    "neo:"
    "spoonboy:"
)

# Create Livewire components
for entry in "${directories[@]}"; do
    dir="${entry%%:*}"
    files="${entry#*:}"
    IFS=' ' read -r -a file_array <<< "$files"
    create_directories "$dir"
    for file in "${file_array[@]}"; do
        component="${dir//\//.}.$file"
        create_livewire_component "$component"
    done
done

echo "Livewire components created successfully."
