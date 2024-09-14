module
   composer require nwidart/laravel-modules
      php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
         php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="config"
            php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="stubs"

               "extra": {
       "laravel": {
           "dont-discover": []
       },
       "merge-plugin": {
           "include": [
               "Modules/*/composer.json"
           ]
       }
   }
   composer require laravel/sanctum
      php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

php artisan make:filament-user





       // مدل مرتبط با ریسورس
    protected static ?string $model = Post::class;

    // آیکون نمایش داده شده در منوی ناوبری
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    // نام نمایش داده شده در منوی ناوبری
    protected static ?string $navigationLabel = 'مقالات';

    // گروه ناوبری که ریسورس در آن قرار می‌گیرد
    protected static ?string $navigationGroup = 'وبلاگ';

    // اسلاگ (مسیر URL) ریسورس
    protected static ?string $slug = 'posts';

    // ویژگی‌ای که به عنوان عنوان رکورد در فرم‌ها و جداول استفاده می‌شود
    protected static ?string $recordTitleAttribute = 'title';

    // نام جمع مدل
    protected static ?string $pluralModelLabel = 'مقالات';

    // نام مفرد مدل
    protected static ?string $modelLabel = 'مقاله';

    // آیا ریسورس باید در منوی ناوبری نمایش داده شود
    protected static bool $shouldRegisterNavigation = true;

    // ترتیب نمایش ریسورس در منوی ناوبری
    protected static ?int $navigationSort = 1;

    // رنگ آیکون ناوبری
    protected static ?string $navigationColor = 'primary';

    // آیا ریسورس باید در جستجوی جهانی نمایش داده شود
    protected static bool $shouldRegisterGlobalSearch = true;

    // ویژگی‌هایی که در جستجوی جهانی استفاده می‌شوند
    protected static array $globalSearchAttributes = ['title', 'content'];

    // آیا ریسورس باید در جستجوی منوی ناوبری نمایش داده شود
    protected static bool $shouldRegisterNavigationSearch = true;
