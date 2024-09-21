<?php

return [
    'empty' => [
        'title' => "هیچ رسانه یا پوشه‌ای یافت نشد",
    ],
    'folders' => [
        'title' => 'مدیریت رسانه',
        'single' => 'پوشه',
        'columns' => [
            'name' => 'نام',
            'collection' => 'مجموعه',
            'description' => 'توضیحات',
            'is_public' => 'عمومی است',
            'has_user_access' => 'دسترسی کاربر دارد',
            'users' => 'کاربران',
            'icon' => 'آیکون',
            'color' => 'رنگ',
            'is_protected' => 'محافظت شده است',
            'password' => 'رمز عبور',
            'password_confirmation' => 'تأیید رمز عبور',
        ],
        'group' => 'محتوا',
    ],
    'media' => [
        'title' => 'رسانه',
        'single' => 'رسانه',
        'columns' => [
            'image' => 'تصویر',
            'model' => 'مدل',
            'collection_name' => 'نام مجموعه',
            'size' => 'اندازه',
            'order_column' => 'ستون ترتیب',
        ],
        'actions' => [
            'sub_folder'=> [
              'label' => "ایجاد پوشه فرعی"
            ],
            'create' => [
                'label' => 'افزودن رسانه',
                'form' => [
                    'file' => 'فایل',
                    'title' => 'عنوان',
                    'description' => 'توضیحات',
                ],
            ],
            'delete' => [
                'label' => 'حذف پوشه',
            ],
            'edit' => [
                'label' => 'ویرایش پوشه',
            ],
        ],
        'notifications' => [
            'create-media' => 'رسانه با موفقیت ایجاد شد',
            'delete-folder' => 'پوشه با موفقیت حذف شد',
            'edit-folder' => 'پوشه با موفقیت ویرایش شد',
        ],
        'meta' => [
            'model' => 'مدل',
            'file-name' => 'نام فایل',
            'type' => 'نوع',
            'size' => 'اندازه',
            'disk' => 'دیسک',
            'url' => 'آدرس',
            'delete-media' => 'حذف رسانه',
        ],
    ],
];
