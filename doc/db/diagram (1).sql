CREATE TABLE "users" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "name" varchar,
  "email" varchar UNIQUE,
  "email_verified_at" timestamp,
  "password" varchar,
  "is_active" varchar,
  "remember_token" varchar,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "password_reset_tokens" (
  "email" varchar PRIMARY KEY,
  "token" varchar,
  "created_at" timestamp
);

CREATE TABLE "sessions" (
  "id" varchar PRIMARY KEY,
  "user_id" int,
  "ip_address" varchar(45),
  "user_agent" text,
  "payload" longtext,
  "last_activity" int
);

CREATE TABLE "roles" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "role_name" varchar(60) UNIQUE,
  "description" varchar(255),
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "permissions" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "permission_name" varchar(60) UNIQUE,
  "description" varchar(255),
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "user_roles" (
  "user_id" int,
  "role_id" int,
  PRIMARY KEY ("user_id", "role_id")
);

CREATE TABLE "role_permissions" (
  "role_id" int,
  "permission_id" int,
  "created_at" timestamp,
  "updated_at" timestamp,
  PRIMARY KEY ("role_id", "permission_id")
);

CREATE TABLE "user_meta" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "user_id" int,
  "meta_key" varchar,
  "meta_value" text,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "categories" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "name" varchar(100) UNIQUE,
  "description" text,
  "parent_id" int,
  "slug" varchar(255) UNIQUE,
  "image_id" int,
  "is_visible" boolean DEFAULT true,
  "order_column" int DEFAULT 0,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "tags" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "name" varchar(50) UNIQUE,
  "slug" varchar(255) UNIQUE,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "posts" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "title" varchar,
  "slug" varchar UNIQUE,
  "content" text,
  "user_id" int,
  "category_id" int,
  "is_published" boolean DEFAULT false,
  "published_at" timestamp,
  "image_id" int,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "comments" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "post_id" int,
  "user_id" int,
  "content" text,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "post_tags" (
  "post_id" int,
  "tag_id" int,
  "created_at" timestamp,
  "updated_at" timestamp,
  PRIMARY KEY ("post_id", "tag_id")
);

CREATE TABLE "post_meta" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "post_id" int,
  "meta_key" varchar(50),
  "meta_value" text,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "pages" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "user_id" int,
  "title" varchar(255),
  "content" text,
  "slug" varchar(255) UNIQUE,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "cache" (
  "key" varchar PRIMARY KEY,
  "value" mediumtext,
  "expiration" int
);

CREATE TABLE "cache_locks" (
  "key" varchar PRIMARY KEY,
  "owner" varchar,
  "expiration" int
);

CREATE TABLE "jobs" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "queue" varchar,
  "payload" longtext,
  "attempts" tinyint,
  "reserved_at" int,
  "available_at" int,
  "created_at" int
);

CREATE TABLE "job_batches" (
  "id" varchar PRIMARY KEY,
  "name" varchar,
  "total_jobs" int,
  "pending_jobs" int,
  "failed_jobs" int,
  "failed_job_ids" longtext,
  "options" mediumtext,
  "cancelled_at" int,
  "created_at" int,
  "finished_at" int
);

CREATE TABLE "failed_jobs" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "uuid" varchar UNIQUE,
  "connection" text,
  "queue" text,
  "payload" longtext,
  "exception" longtext,
  "failed_at" timestamp DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE "filament_exceptions_table" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "type" varchar(255),
  "code" varchar,
  "message" longtext,
  "file" varchar(255),
  "line" int,
  "trace" text,
  "method" varchar,
  "path" varchar(255),
  "query" text,
  "body" text,
  "cookies" text,
  "headers" text,
  "ip" varchar,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "breezy_sessions" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "authenticatable_type" varchar,
  "authenticatable_id" int,
  "panel_id" varchar,
  "guard" varchar,
  "ip_address" varchar(45),
  "user_agent" text,
  "expires_at" timestamp,
  "two_factor_secret" text,
  "two_factor_recovery_codes" text,
  "two_factor_confirmed_at" timestamp,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "activity_log" (
  "id" bigint GENERATED AS IDENTITY PRIMARY KEY,
  "log_name" varchar,
  "description" text,
  "subject_type" varchar,
  "subject_id" bigint,
  "causer_type" varchar,
  "causer_id" bigint,
  "properties" json,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "media" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "disk" varchar DEFAULT 'public',
  "directory" varchar DEFAULT 'media',
  "visibility" varchar DEFAULT 'public',
  "name" varchar,
  "path" varchar,
  "width" int,
  "height" int,
  "size" int,
  "type" varchar DEFAULT 'image',
  "ext" varchar,
  "alt" varchar,
  "title" varchar,
  "description" text,
  "caption" text,
  "exif" text,
  "curations" longtext,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "queue_monitors" (
  "id" int GENERATED AS IDENTITY PRIMARY KEY,
  "job_id" varchar,
  "name" varchar,
  "queue" varchar,
  "started_at" timestamp,
  "finished_at" timestamp,
  "failed" boolean DEFAULT false,
  "attempt" int DEFAULT 0,
  "progress" int,
  "exception_message" text,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE TABLE "notifications" (
  "id" uuid PRIMARY KEY,
  "type" varchar,
  "notifiable_type" varchar,
  "notifiable_id" bigint,
  "data" json,
  "read_at" timestamp,
  "created_at" timestamp,
  "updated_at" timestamp
);

CREATE INDEX ON "roles" ("role_name");

CREATE INDEX ON "permissions" ("permission_name");

CREATE UNIQUE INDEX ON "user_meta" ("user_id", "meta_key");

CREATE INDEX ON "user_meta" ("meta_key");

CREATE INDEX ON "jobs" ("queue");

CREATE INDEX ON "activity_log" ("log_name");

CREATE INDEX ON "activity_log" ("subject_type", "subject_id");

CREATE INDEX ON "activity_log" ("causer_type", "causer_id");

CREATE INDEX ON "queue_monitors" ("job_id");

CREATE INDEX ON "queue_monitors" ("started_at");

CREATE INDEX ON "queue_monitors" ("failed");

CREATE INDEX ON "notifications" ("notifiable_type", "notifiable_id");

COMMENT ON COLUMN "categories"."id" IS 'Primary key of the categories table';

COMMENT ON COLUMN "categories"."name" IS 'Name of the category, must be unique';

COMMENT ON COLUMN "categories"."description" IS 'Description of the category';

COMMENT ON COLUMN "categories"."parent_id" IS 'Parent category ID, references categories.id';

COMMENT ON COLUMN "categories"."slug" IS 'URL-friendly version of the category name, must be unique';

COMMENT ON COLUMN "categories"."image_id" IS 'Foreign key referencing media table';

COMMENT ON COLUMN "categories"."is_visible" IS 'Visibility of the category';

COMMENT ON COLUMN "categories"."order_column" IS 'Order of the category for display purposes';

COMMENT ON COLUMN "tags"."id" IS 'Primary key of the tags table';

COMMENT ON COLUMN "tags"."name" IS 'Name of the tag, must be unique and up to 50 characters';

COMMENT ON COLUMN "tags"."slug" IS 'URL-friendly version of the tag name, must be unique and up to 255 characters';

COMMENT ON COLUMN "posts"."slug" IS 'URL-friendly version of the post title, must be unique';

COMMENT ON COLUMN "posts"."content" IS 'Content of the post';

COMMENT ON COLUMN "posts"."user_id" IS 'Foreign key referencing users table';

COMMENT ON COLUMN "posts"."category_id" IS 'Foreign key referencing categories table';

COMMENT ON COLUMN "posts"."is_published" IS 'Publication status of the post';

COMMENT ON COLUMN "posts"."published_at" IS 'Publication date of the post';

COMMENT ON COLUMN "posts"."image_id" IS 'Foreign key referencing media table';

COMMENT ON COLUMN "comments"."id" IS 'Primary key of the comments table';

COMMENT ON COLUMN "comments"."post_id" IS 'Foreign key referencing posts table';

COMMENT ON COLUMN "comments"."user_id" IS 'Foreign key referencing users table';

COMMENT ON COLUMN "comments"."content" IS 'Content of the comment';

COMMENT ON COLUMN "post_tags"."post_id" IS 'Foreign key referencing posts table';

COMMENT ON COLUMN "post_tags"."tag_id" IS 'Foreign key referencing tags table';

COMMENT ON COLUMN "post_meta"."id" IS 'Primary key of the post_meta table';

COMMENT ON COLUMN "post_meta"."post_id" IS 'Foreign key referencing posts table';

COMMENT ON COLUMN "post_meta"."meta_key" IS 'Key for the meta information, up to 50 characters';

COMMENT ON COLUMN "post_meta"."meta_value" IS 'Value for the meta information, can be null';

COMMENT ON COLUMN "pages"."id" IS 'Primary key of the pages table';

COMMENT ON COLUMN "pages"."user_id" IS 'Foreign key referencing users table';

COMMENT ON COLUMN "pages"."title" IS 'Title of the page, up to 255 characters';

COMMENT ON COLUMN "pages"."content" IS 'Content of the page';

COMMENT ON COLUMN "pages"."slug" IS 'URL-friendly version of the page title, must be unique and up to 255 characters';

ALTER TABLE "sessions" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");

ALTER TABLE "user_roles" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");

ALTER TABLE "user_roles" ADD FOREIGN KEY ("role_id") REFERENCES "roles" ("id");

ALTER TABLE "role_permissions" ADD FOREIGN KEY ("role_id") REFERENCES "roles" ("id");

ALTER TABLE "role_permissions" ADD FOREIGN KEY ("permission_id") REFERENCES "permissions" ("id");

ALTER TABLE "user_meta" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");

ALTER TABLE "categories" ADD FOREIGN KEY ("parent_id") REFERENCES "categories" ("id");

ALTER TABLE "categories" ADD FOREIGN KEY ("image_id") REFERENCES "media" ("id");

ALTER TABLE "posts" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");

ALTER TABLE "posts" ADD FOREIGN KEY ("image_id") REFERENCES "media" ("id");

ALTER TABLE "comments" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");

ALTER TABLE "comments" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");

ALTER TABLE "post_tags" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");

ALTER TABLE "post_tags" ADD FOREIGN KEY ("tag_id") REFERENCES "tags" ("id");

ALTER TABLE "post_meta" ADD FOREIGN KEY ("post_id") REFERENCES "posts" ("id");

ALTER TABLE "pages" ADD FOREIGN KEY ("user_id") REFERENCES "users" ("id");
