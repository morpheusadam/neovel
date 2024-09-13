----------------------------------------------------
 
----------------------------------------------------

----------------------------------------------------

ساختار پیشنهادی دیتابیس:
1. users: اطلاعات اصلی کاربران
2. roles: نقش‌های مختلف کاربران
3. permissions: مجوزهای مختلف
4. user_roles: ارتباط بین کاربران و نقش‌ها
5. role_permissions: ارتباط بین نقش‌ها و مجوزها
user_meta: اطلاعات متا کاربران

----

Table users {
    id INT [pk, increment]
    username VARCHAR(50) [not null, unique]
    password VARCHAR(255) [not null]
    email VARCHAR(100) [not null, unique]
    created_at TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table roles {
    id INT [pk, increment]
    role_name VARCHAR(50) [not null, unique]
    description TEXT
}

Table permissions {
    id INT [pk, increment]
    permission_name VARCHAR(50) [not null, unique]
    description TEXT
}

Table user_roles {
    user_id INT [ref: > users.id]
    role_id INT [ref: > roles.id]
    indexes {
        (user_id, role_id) [pk]
    }
}

Table role_permissions {
    role_id INT [ref: > roles.id]
    permission_id INT [ref: > permissions.id]
    indexes {
        (role_id, permission_id) [pk]
    }
}

Table user_meta {
    id INT [pk, increment]
    user_id INT [ref: > users.id]
    meta_key VARCHAR(50)
    meta_value TEXT
}

----------------------------------------------------
 
----------------------------------------------------

----------------------------------------------------



-- جدول کاربران
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول نقش‌ها
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

-- جدول مجوزها
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    permission_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

-- جدول ارتباط کاربران و نقش‌ها
CREATE TABLE user_roles (
    user_id INT,
    role_id INT,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- جدول ارتباط نقش‌ها و مجوزها
CREATE TABLE role_permissions (
    role_id INT,
    permission_id INT,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- جدول اطلاعات متا کاربران
CREATE TABLE user_meta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    meta_key VARCHAR(50),
    meta_value TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);



----------------------------------------------------
 
----------------------------------------------------

----------------------------------------------------


CREATE TABLE oauth_clients (
    client_id VARCHAR(100) PRIMARY KEY,
    client_secret VARCHAR(255) NOT NULL,
    redirect_uri VARCHAR(255) NOT NULL
);

-- جدول توکن‌های دسترسی
CREATE TABLE oauth_access_tokens (
    access_token VARCHAR(255) PRIMARY KEY,
    client_id VARCHAR(100),
    user_id INT,
    expires_at TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES oauth_clients(client_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- جدول توکن‌های تازه‌سازی
CREATE TABLE oauth_refresh_tokens (
    refresh_token VARCHAR(255) PRIMARY KEY,
    access_token VARCHAR(255),
    expires_at TIMESTAMP,
    FOREIGN KEY (access_token) REFERENCES oauth_access_tokens(access_token) ON DELETE CASCADE
);
