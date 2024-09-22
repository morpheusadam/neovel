CREATE TABLE [users] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [name] nvarchar(255),
  [email] nvarchar(255) UNIQUE,
  [email_verified_at] timestamp,
  [password] nvarchar(255),
  [is_active] nvarchar(255),
  [remember_token] nvarchar(255),
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [password_reset_tokens] (
  [email] nvarchar(255) PRIMARY KEY,
  [token] nvarchar(255),
  [created_at] timestamp
)
GO

CREATE TABLE [sessions] (
  [id] nvarchar(255) PRIMARY KEY,
  [user_id] int,
  [ip_address] varchar(45),
  [user_agent] text,
  [payload] longtext,
  [last_activity] int
)
GO

CREATE TABLE [roles] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [role_name] varchar(60) UNIQUE,
  [description] varchar(255),
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [permissions] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [permission_name] varchar(60) UNIQUE,
  [description] varchar(255),
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [user_roles] (
  [user_id] int,
  [role_id] int,
  PRIMARY KEY ([user_id], [role_id])
)
GO

CREATE TABLE [role_permissions] (
  [role_id] int,
  [permission_id] int,
  [created_at] timestamp,
  [updated_at] timestamp,
  PRIMARY KEY ([role_id], [permission_id])
)
GO

CREATE TABLE [user_meta] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [user_id] int,
  [meta_key] nvarchar(255),
  [meta_value] text,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [categories] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [name] varchar(100) UNIQUE,
  [description] text,
  [parent_id] int,
  [slug] varchar(255) UNIQUE,
  [image_id] int,
  [is_visible] boolean DEFAULT (true),
  [order_column] int DEFAULT (0),
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [tags] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [name] varchar(50) UNIQUE,
  [slug] varchar(255) UNIQUE,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [posts] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [title] nvarchar(255),
  [slug] nvarchar(255) UNIQUE,
  [content] text,
  [user_id] int,
  [category_id] int,
  [is_published] boolean DEFAULT (false),
  [published_at] timestamp,
  [image_id] int,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [comments] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [post_id] int,
  [user_id] int,
  [content] text,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [post_tags] (
  [post_id] int,
  [tag_id] int,
  [created_at] timestamp,
  [updated_at] timestamp,
  PRIMARY KEY ([post_id], [tag_id])
)
GO

CREATE TABLE [post_meta] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [post_id] int,
  [meta_key] varchar(50),
  [meta_value] text,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [pages] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [user_id] int,
  [title] varchar(255),
  [content] text,
  [slug] varchar(255) UNIQUE,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [cache] (
  [key] nvarchar(255) PRIMARY KEY,
  [value] mediumtext,
  [expiration] int
)
GO

CREATE TABLE [cache_locks] (
  [key] nvarchar(255) PRIMARY KEY,
  [owner] nvarchar(255),
  [expiration] int
)
GO

CREATE TABLE [jobs] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [queue] nvarchar(255),
  [payload] longtext,
  [attempts] tinyint,
  [reserved_at] int,
  [available_at] int,
  [created_at] int
)
GO

CREATE TABLE [job_batches] (
  [id] nvarchar(255) PRIMARY KEY,
  [name] nvarchar(255),
  [total_jobs] int,
  [pending_jobs] int,
  [failed_jobs] int,
  [failed_job_ids] longtext,
  [options] mediumtext,
  [cancelled_at] int,
  [created_at] int,
  [finished_at] int
)
GO

CREATE TABLE [failed_jobs] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [uuid] nvarchar(255) UNIQUE,
  [connection] text,
  [queue] text,
  [payload] longtext,
  [exception] longtext,
  [failed_at] timestamp DEFAULT (CURRENT_TIMESTAMP)
)
GO

CREATE TABLE [filament_exceptions_table] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [type] varchar(255),
  [code] nvarchar(255),
  [message] longtext,
  [file] varchar(255),
  [line] int,
  [trace] text,
  [method] nvarchar(255),
  [path] varchar(255),
  [query] text,
  [body] text,
  [cookies] text,
  [headers] text,
  [ip] nvarchar(255),
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [breezy_sessions] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [authenticatable_type] nvarchar(255),
  [authenticatable_id] int,
  [panel_id] nvarchar(255),
  [guard] nvarchar(255),
  [ip_address] varchar(45),
  [user_agent] text,
  [expires_at] timestamp,
  [two_factor_secret] text,
  [two_factor_recovery_codes] text,
  [two_factor_confirmed_at] timestamp,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [activity_log] (
  [id] bigint PRIMARY KEY IDENTITY(1, 1),
  [log_name] nvarchar(255),
  [description] text,
  [subject_type] nvarchar(255),
  [subject_id] bigint,
  [causer_type] nvarchar(255),
  [causer_id] bigint,
  [properties] json,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [media] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [disk] nvarchar(255) DEFAULT 'public',
  [directory] nvarchar(255) DEFAULT 'media',
  [visibility] nvarchar(255) DEFAULT 'public',
  [name] nvarchar(255),
  [path] nvarchar(255),
  [width] int,
  [height] int,
  [size] int,
  [type] nvarchar(255) DEFAULT 'image',
  [ext] nvarchar(255),
  [alt] nvarchar(255),
  [title] nvarchar(255),
  [description] text,
  [caption] text,
  [exif] text,
  [curations] longtext,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [queue_monitors] (
  [id] int PRIMARY KEY IDENTITY(1, 1),
  [job_id] nvarchar(255),
  [name] nvarchar(255),
  [queue] nvarchar(255),
  [started_at] timestamp,
  [finished_at] timestamp,
  [failed] boolean DEFAULT (false),
  [attempt] int DEFAULT (0),
  [progress] int,
  [exception_message] text,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE TABLE [notifications] (
  [id] uuid PRIMARY KEY,
  [type] nvarchar(255),
  [notifiable_type] nvarchar(255),
  [notifiable_id] bigint,
  [data] json,
  [read_at] timestamp,
  [created_at] timestamp,
  [updated_at] timestamp
)
GO

CREATE INDEX [roles_index_0] ON [roles] ("role_name")
GO

CREATE INDEX [permissions_index_1] ON [permissions] ("permission_name")
GO

CREATE UNIQUE INDEX [user_meta_index_2] ON [user_meta] ("user_id", "meta_key")
GO

CREATE INDEX [user_meta_index_3] ON [user_meta] ("meta_key")
GO

CREATE INDEX [jobs_index_4] ON [jobs] ("queue")
GO

CREATE INDEX [activity_log_index_5] ON [activity_log] ("log_name")
GO

CREATE INDEX [activity_log_index_6] ON [activity_log] ("subject_type", "subject_id")
GO

CREATE INDEX [activity_log_index_7] ON [activity_log] ("causer_type", "causer_id")
GO

CREATE INDEX [queue_monitors_index_8] ON [queue_monitors] ("job_id")
GO

CREATE INDEX [queue_monitors_index_9] ON [queue_monitors] ("started_at")
GO

CREATE INDEX [queue_monitors_index_10] ON [queue_monitors] ("failed")
GO

CREATE INDEX [notifications_index_11] ON [notifications] ("notifiable_type", "notifiable_id")
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Primary key of the categories table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Name of the category, must be unique',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'name';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Description of the category',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'description';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Parent category ID, references categories.id',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'parent_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'URL-friendly version of the category name, must be unique',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'slug';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing media table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'image_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Visibility of the category',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'is_visible';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Order of the category for display purposes',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'categories',
@level2type = N'Column', @level2name = 'order_column';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Primary key of the tags table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'tags',
@level2type = N'Column', @level2name = 'id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Name of the tag, must be unique and up to 50 characters',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'tags',
@level2type = N'Column', @level2name = 'name';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'URL-friendly version of the tag name, must be unique and up to 255 characters',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'tags',
@level2type = N'Column', @level2name = 'slug';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'URL-friendly version of the post title, must be unique',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'slug';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Content of the post',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'content';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing users table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'user_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing categories table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'category_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Publication status of the post',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'is_published';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Publication date of the post',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'published_at';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing media table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'posts',
@level2type = N'Column', @level2name = 'image_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Primary key of the comments table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'comments',
@level2type = N'Column', @level2name = 'id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing posts table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'comments',
@level2type = N'Column', @level2name = 'post_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing users table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'comments',
@level2type = N'Column', @level2name = 'user_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Content of the comment',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'comments',
@level2type = N'Column', @level2name = 'content';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing posts table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'post_tags',
@level2type = N'Column', @level2name = 'post_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing tags table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'post_tags',
@level2type = N'Column', @level2name = 'tag_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Primary key of the post_meta table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'post_meta',
@level2type = N'Column', @level2name = 'id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing posts table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'post_meta',
@level2type = N'Column', @level2name = 'post_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Key for the meta information, up to 50 characters',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'post_meta',
@level2type = N'Column', @level2name = 'meta_key';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Value for the meta information, can be null',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'post_meta',
@level2type = N'Column', @level2name = 'meta_value';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Primary key of the pages table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'pages',
@level2type = N'Column', @level2name = 'id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Foreign key referencing users table',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'pages',
@level2type = N'Column', @level2name = 'user_id';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Title of the page, up to 255 characters',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'pages',
@level2type = N'Column', @level2name = 'title';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'Content of the page',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'pages',
@level2type = N'Column', @level2name = 'content';
GO

EXEC sp_addextendedproperty
@name = N'Column_Description',
@value = 'URL-friendly version of the page title, must be unique and up to 255 characters',
@level0type = N'Schema', @level0name = 'dbo',
@level1type = N'Table',  @level1name = 'pages',
@level2type = N'Column', @level2name = 'slug';
GO

ALTER TABLE [sessions] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [user_roles] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [user_roles] ADD FOREIGN KEY ([role_id]) REFERENCES [roles] ([id])
GO

ALTER TABLE [role_permissions] ADD FOREIGN KEY ([role_id]) REFERENCES [roles] ([id])
GO

ALTER TABLE [role_permissions] ADD FOREIGN KEY ([permission_id]) REFERENCES [permissions] ([id])
GO

ALTER TABLE [user_meta] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [categories] ADD FOREIGN KEY ([parent_id]) REFERENCES [categories] ([id])
GO

ALTER TABLE [categories] ADD FOREIGN KEY ([image_id]) REFERENCES [media] ([id])
GO

ALTER TABLE [posts] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [posts] ADD FOREIGN KEY ([image_id]) REFERENCES [media] ([id])
GO

ALTER TABLE [comments] ADD FOREIGN KEY ([post_id]) REFERENCES [posts] ([id])
GO

ALTER TABLE [comments] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO

ALTER TABLE [post_tags] ADD FOREIGN KEY ([post_id]) REFERENCES [posts] ([id])
GO

ALTER TABLE [post_tags] ADD FOREIGN KEY ([tag_id]) REFERENCES [tags] ([id])
GO

ALTER TABLE [post_meta] ADD FOREIGN KEY ([post_id]) REFERENCES [posts] ([id])
GO

ALTER TABLE [pages] ADD FOREIGN KEY ([user_id]) REFERENCES [users] ([id])
GO
