// جدول کاربران
Table users {
    id int [pk, increment] // شناسه منحصر به فرد برای هر کاربر
    name varchar // نام کاربر
    email varchar [unique, not null] // ایمیل کاربر، باید منحصر به فرد و غیر خالی باشد
    email_verified_at timestamp // زمان تأیید ایمیل
    password varchar // رمز عبور کاربر
    is_active boolean [default: true] // نشان‌دهنده فعال بودن کاربر
    remember_token varchar // توکن برای به خاطر سپردن کاربر
    created_at timestamp // زمان ایجاد کاربر
    updated_at timestamp // زمان آخرین به‌روزرسانی کاربر
}

// جدول مشتریان
Table customers {
    id int [pk, increment] // شناسه منحصر به فرد برای هر مشتری
    user_id int [ref: > users.id] // ارجاع به جدول کاربران
    name varchar // نام مشتری
    email varchar [unique, not null] // ایمیل مشتری، باید منحصر به فرد و غیر خالی باشد
    phone varchar // شماره تلفن مشتری
    address varchar // آدرس مشتری
    is_active boolean [default: true] // نشان‌دهنده فعال بودن مشتری
    created_at timestamp // زمان ایجاد مشتری
    updated_at timestamp // زمان آخرین به‌روزرسانی مشتری
}

// جدول دسته‌بندی محصولات
Table product_categories {
    id int [pk, increment] // شناسه منحصر به فرد برای هر دسته‌بندی
    category_name varchar // نام دسته‌بندی
    description text // توضیحات دسته‌بندی
    parent_category_id int [ref: > product_categories.id] // ارجاع به دسته‌بندی والد
    created_at timestamp // زمان ایجاد دسته‌بندی
    updated_at timestamp // زمان آخرین به‌روزرسانی دسته‌بندی
}

// جدول محصولات
Table products {
    id int [pk, increment] // شناسه منحصر به فرد برای هر محصول
    name varchar // نام محصول
    description text // توضیحات محصول
    price decimal(10, 2) // قیمت محصول
    stock int // موجودی قابل دسترس برای محصول
    category_id int [ref: > product_categories.id] // ارجاع به دسته‌بندی محصول
    image_url varchar // URL تصویر محصول
    is_active boolean [default: true] // نشان‌دهنده فعال بودن محصول
    expiration_date date // تاریخ انقضای محصول
    created_at timestamp // زمان ایجاد محصول
    updated_at timestamp // زمان آخرین به‌روزرسانی محصول
}

// جدول تخفیف‌ها
Table discounts {
    id int [pk, increment] // شناسه منحصر به فرد برای هر تخفیف
    product_id int [ref: > products.id] // ارجاع به محصول
    discount_percentage decimal(5, 2) // درصد تخفیف
    start_date datetime // تاریخ شروع تخفیف
    end_date datetime // تاریخ پایان تخفیف
    discount_code varchar [unique] // کد تخفیف منحصر به فرد
}

// جدول روش‌های پرداخت
Table payment_methods {
    id int [pk, increment] // شناسه منحصر به فرد برای هر روش پرداخت
    method_name varchar [unique] // نام روش پرداخت
    created_at timestamp // زمان ایجاد روش پرداخت
    updated_at timestamp // زمان آخرین به‌روزرسانی روش پرداخت
}

// جدول سفارشات
Table orders {
    id int [pk, increment] // شناسه منحصر به فرد برای هر سفارش
    customer_id int [ref: > customers.id] // ارجاع به مشتری
    order_date datetime [default: "now()"] // تاریخ ثبت سفارش
    total_amount decimal(10, 2) // مبلغ کل سفارش
    status enum('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') [default: 'Pending'] // وضعیت سفارش
    payment_status enum('Pending', 'Completed', 'Failed') [default: 'Pending'] // وضعیت پرداخت
    shipping_address varchar // آدرس ارسال سفارش
    payment_method_id int [ref: > payment_methods.id] // ارجاع به روش پرداخت
    created_at timestamp // زمان ایجاد سفارش
    updated_at timestamp // زمان آخرین به‌روزرسانی سفارش
}

// جدول اقلام سفارش
Table order_items {
    id int [pk, increment] // شناسه منحصر به فرد برای هر قلم سفارش
    order_id int [ref: > orders.id] // ارجاع به سفارش
    product_id int [ref: > products.id] // ارجاع به محصول
    quantity int // تعداد محصول در سفارش
    price decimal(10, 2) // قیمت محصول در زمان سفارش
    created_at timestamp // زمان ایجاد قلم سفارش
    updated_at timestamp // زمان آخرین به‌روزرسانی قلم سفارش
}

// جدول نظرات
Table reviews {
    id int [pk, increment] // شناسه منحصر به فرد برای هر نظر
    product_id int [ref: > products.id] // ارجاع به محصول
    customer_id int [ref: > customers.id] // ارجاع به مشتری
    rating int // امتیاز داده شده توسط مشتری
    comment text // نظر مشتری
    created_at timestamp // زمان ایجاد نظر
    updated_at timestamp // زمان آخرین به‌روزرسانی نظر
}

// جدول تاریخچه وضعیت سفارش
Table order_status_history {
    id int [pk, increment] // شناسه منحصر به فرد برای هر ورودی تاریخچه وضعیت
    order_id int [ref: > orders.id] // ارجاع به سفارش
    old_status enum('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') // وضعیت قبلی سفارش
    new_status enum('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') // وضعیت جدید سفارش
    change_date datetime [default: "now()"] // تاریخ تغییر وضعیت
}

// جدول تاریخچه قیمت محصولات
Table product_price_history {
    id int [pk, increment] // شناسه منحصر به فرد برای هر ورودی تاریخچه قیمت
    product_id int [ref: > products.id] // ارجاع به محصول
    old_price decimal(10, 2) // قیمت قدیمی محصول
    new_price decimal(10, 2) // قیمت جدید محصول
    change_date datetime [default: "now()"] // تاریخ تغییر قیمت
}

// جدول وضعیت‌های سفارش
Table order_statuses {
    id int [pk, increment] // شناسه منحصر به فرد برای هر وضعیت سفارش
    status_name varchar [unique] // نام وضعیت سفارش
    created_at timestamp // زمان ایجاد وضعیت
    updated_at timestamp // زمان آخرین به‌روزرسانی وضعیت
}

// جدول انبارها
Table warehouses {
    id int [pk, increment] // شناسه منحصر به فرد برای هر انبار
    name varchar [unique] // نام انبار
    location varchar // موقعیت انبار
    capacity int [default: 0] // ظرفیت انبار
    manager_name varchar // نام مدیر انبار
    contact_number varchar // شماره تماس مدیر
    email varchar // ایمیل مدیر
    created_at timestamp // زمان ایجاد انبار
    updated_at timestamp // زمان آخرین به‌روزرسانی انبار
}

// جدول موجودی
Table inventory {
    id int [pk, increment] // شناسه منحصر به فرد برای هر قلم موجودی
    product_id int [ref: > products.id] // ارجاع به محصول
    warehouse_id int [ref: > warehouses.id] // ارجاع به انبار
    quantity int [default: 0] // مقدار محصول در موجودی
    restock_threshold int [default: 10] // حداقل مقدار برای تجدید موجودی
    last_restocked timestamp // زمان آخرین تجدید موجودی
    reorder_point int [default: 5] // نقطه تجدید موجودی
    created_at timestamp // زمان ایجاد قلم موجودی
    updated_at timestamp // زمان آخرین به‌روزرسانی قلم موجودی
}

// جدول تراکنش‌های موجودی
Table inventory_transactions {
    id int [pk, increment] // شناسه منحصر به فرد برای هر تراکنش موجودی
    inventory_id int [ref: > inventory.id] // ارجاع به قلم موجودی
    transaction_type enum('addition', 'removal') // نوع تراکنش
    quantity int // مقدار درگیر در تراکنش
    transaction_date timestamp [default: "now()"] // تاریخ تراکنش
    notes text // توضیحات اضافی برای تراکنش
    created_at timestamp // زمان ایجاد تراکنش
    updated_at timestamp // زمان آخرین به‌روزرسانی تراکنش
}

// جدول تأمین‌کنندگان
Table suppliers {
    id int [pk, increment] // شناسه منحصر به فرد برای هر تأمین‌کننده
    name varchar [unique] // نام تأمین‌کننده
    contact_person varchar // نام شخص تماس
    contact_number varchar // شماره تماس تأمین‌کننده
    email varchar // ایمیل تأمین‌کننده
    address varchar // آدرس تأمین‌کننده
    created_at timestamp // زمان ایجاد تأمین‌کننده
    updated_at timestamp // زمان آخرین به‌روزرسانی تأمین‌کننده
}

// جدول سفارشات موجودی
Table inventory_orders {
    id int [pk, increment] // شناسه منحصر به فرد برای هر سفارش موجودی
    supplier_id int [ref: > suppliers.id] // ارجاع به تأمین‌کننده
    product_id int [ref: > products.id] // ارجاع به محصول
    quantity int // مقدار سفارش داده شده
    order_date timestamp [default: "now()"] // تاریخ سفارش
    expected_delivery_date timestamp // تاریخ تحویل مورد انتظار
    status enum('pending', 'received', 'cancelled', 'partially_received') [default: 'pending'] // وضعیت سفارش
    created_at timestamp // زمان ایجاد سفارش
    updated_at timestamp // زمان آخرین به‌روزرسانی سفارش
}

// جدول بازرسی‌های موجودی
Table inventory_audits {
    id int [pk, increment] // شناسه منحصر به فرد برای هر بازرسی موجودی
    inventory_id int [ref: > inventory.id] // ارجاع به قلم موجودی
    audit_date timestamp [default: "now()"] // تاریخ بازرسی
    quantity_before int // مقدار قبل از بازرسی
    quantity_after int // مقدار بعد از بازرسی
    discrepancies text // توضیحات در مورد اختلافات
    created_at timestamp // زمان ایجاد بازرسی
    updated_at timestamp // زمان آخرین به‌روزرسانی بازرسی
}

// بهبودها و رفع مشکلات
// 1. اضافه کردن فیلدهای جدید برای بهبود ارتباطات و مدیریت
// 2. استفاده از enum برای وضعیت سفارشات و تراکنش‌ها
// 3. ثبت تاریخ و زمان دقیق برای تراکنش‌ها و بازرسی‌ها
// 4. ایجاد سیاست‌های تجدید موجودی و ثبت دقیق موجودی
// 5. بهبود ثبت و پیگیری تأمین‌کنندگان و سفارشات
