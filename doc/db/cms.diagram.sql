Table users {
  id int [pk, increment]
  name varchar
  email varchar [unique]
  email_verified_at timestamp [null]
  password varchar
  is_active varchar [null]
  remember_token varchar
  created_at timestamp
  updated_at timestamp
}

Table password_reset_tokens {
  email varchar [pk]
  token varchar
  created_at timestamp [null]
}

Table sessions {
  id varchar [pk]
  user_id int [ref: > users.id, null]
  ip_address varchar(45) [null]
  user_agent text [null]
  payload longtext
  last_activity int
}

Table roles {
  id int [pk, increment]
  role_name varchar(60) [unique]
  description varchar(255) [null]
  created_at timestamp
  updated_at timestamp
  indexes {
    role_name
  }
}


Table permissions {
  id int [pk, increment]
  permission_name varchar(60) [unique]
  description varchar(255) [null]
  created_at timestamp
  updated_at timestamp
  indexes {
    permission_name
  }
}

Table user_roles {
  user_id int [ref: > users.id, pk]
  role_id int [ref: > roles.id, pk]
}

Table role_permissions {
  role_id int [ref: > roles.id, pk]
  permission_id int [ref: > permissions.id, pk]
  created_at timestamp
  updated_at timestamp
}

Table user_meta {
  id int [pk, increment]
  user_id int [ref: > users.id]
  meta_key varchar
  meta_value text [null]
  created_at timestamp
  updated_at timestamp
  indexes {
    (user_id, meta_key) [unique]
    meta_key
  }
}
Table categories {
  id int [pk, increment, note: 'Primary key of the categories table']
  name varchar(100) [unique, note: 'Name of the category, must be unique']
  description text [null, note: 'Description of the category']
  parent_id int [ref: > categories.id, null, note: 'Parent category ID, references categories.id']
  slug varchar(255) [unique, note: 'URL-friendly version of the category name, must be unique']
  image_id int [ref: > media.id, null, note: 'Foreign key referencing media table']
  is_visible boolean [default: true, note: 'Visibility of the category']
  order_column int [default: 0, note: 'Order of the category for display purposes']
  created_at timestamp
  updated_at timestamp
}

Table tags {
  id int [pk, increment, note: 'Primary key of the tags table']
  name varchar(50) [unique, note: 'Name of the tag, must be unique and up to 50 characters']
  slug varchar(255) [unique, note: 'URL-friendly version of the tag name, must be unique and up to 255 characters']
  created_at timestamp
  updated_at timestamp
}

Table posts {
  id int [pk, increment]
  title varchar
  slug varchar [unique, note: 'URL-friendly version of the post title, must be unique']
  content text [null, note: 'Content of the post']
  user_id int [ref: > users.id, note: 'Foreign key referencing users table']
  category_id int [null, note: 'Foreign key referencing categories table']
  is_published boolean [default: false, note: 'Publication status of the post']
  published_at timestamp [null, note: 'Publication date of the post']
  image_id int [ref: > media.id, null, note: 'Foreign key referencing media table']
  created_at timestamp
  updated_at timestamp
}

Table comments {
  id int [pk, increment, note: 'Primary key of the comments table']
  post_id int [ref: > posts.id, note: 'Foreign key referencing posts table']
  user_id int [ref: > users.id, note: 'Foreign key referencing users table']
  content text [note: 'Content of the comment']
  created_at timestamp
  updated_at timestamp
}

Table post_tags {
  post_id int [ref: > posts.id, pk, note: 'Foreign key referencing posts table']
  tag_id int [ref: > tags.id, pk, note: 'Foreign key referencing tags table']
  created_at timestamp
  updated_at timestamp
}

Table post_meta {
  id int [pk, increment, note: 'Primary key of the post_meta table']
  post_id int [ref: > posts.id, note: 'Foreign key referencing posts table']
  meta_key varchar(50) [note: 'Key for the meta information, up to 50 characters']
  meta_value text [null, note: 'Value for the meta information, can be null']
  created_at timestamp
  updated_at timestamp
}

Table pages {
  id int [pk, increment, note: 'Primary key of the pages table']
  user_id int [ref: > users.id, note: 'Foreign key referencing users table']
  title varchar(255) [note: 'Title of the page, up to 255 characters']
  content text [note: 'Content of the page']
  slug varchar(255) [unique, note: 'URL-friendly version of the page title, must be unique and up to 255 characters']
  created_at timestamp
  updated_at timestamp
}
Table cache {
  key varchar [pk]
  value mediumtext
  expiration int
}

Table cache_locks {
  key varchar [pk]
  owner varchar
  expiration int
}

Table jobs {
  id int [pk, increment]
  queue varchar
  payload longtext
  attempts tinyint
  reserved_at int [null]
  available_at int
  created_at int
  indexes {
    queue
  }
}

Table job_batches {
  id varchar [pk]
  name varchar
  total_jobs int
  pending_jobs int
  failed_jobs int
  failed_job_ids longtext
  options mediumtext [null]
  cancelled_at int [null]
  created_at int
  finished_at int [null]
}

Table failed_jobs {
  id int [pk, increment]
  uuid varchar [unique]
  connection text
  queue text
  payload longtext
  exception longtext
  failed_at timestamp [default: `CURRENT_TIMESTAMP`]
}

Table filament_exceptions_table {
  id int [pk, increment]
  type varchar(255)
  code varchar
  message longtext
  file varchar(255)
  line int
  trace text
  method varchar
  path varchar(255)
  query text
  body text
  cookies text
  headers text
  ip varchar
  created_at timestamp
  updated_at timestamp
}

Table breezy_sessions {
  id int [pk, increment]
  authenticatable_type varchar
  authenticatable_id int
  panel_id varchar [null]
  guard varchar [null]
  ip_address varchar(45) [null]
  user_agent text [null]
  expires_at timestamp [null]
  two_factor_secret text [null]
  two_factor_recovery_codes text [null]
  two_factor_confirmed_at timestamp [null]
  created_at timestamp
  updated_at timestamp
}

Table activity_log {
  id bigint [pk, increment]
  log_name varchar [null]
  description text
  subject_type varchar [null]
  subject_id bigint [null]
  causer_type varchar [null]
  causer_id bigint [null]
  properties json [null]
  created_at timestamp
  updated_at timestamp
  indexes {
    log_name
    (subject_type, subject_id)
    (causer_type, causer_id)
  }
}

Table media {
  id int [pk, increment]
  disk varchar [default: 'public']
  directory varchar [default: 'media']
  visibility varchar [default: 'public']
  name varchar
  path varchar
  width int [null]
  height int [null]
  size int [null]
  type varchar [default: 'image']
  ext varchar
  alt varchar [null]
  title varchar [null]
  description text [null]
  caption text [null]
  exif text [null]
  curations longtext [null]
  created_at timestamp
  updated_at timestamp
}

Table queue_monitors {
  id int [pk, increment]
  job_id varchar
  name varchar [null]
  queue varchar [null]
  started_at timestamp [null]
  finished_at timestamp [null]
  failed boolean [default: false]
  attempt int [default: 0]
  progress int [null]
  exception_message text [null]
  created_at timestamp
  updated_at timestamp
  indexes {
    job_id
    started_at
    failed
  }
}

Table notifications {
  id uuid [pk]
  type varchar
  notifiable_type varchar
  notifiable_id bigint
  data json
  read_at timestamp [null]
  created_at timestamp
  updated_at timestamp
  indexes {
    (notifiable_type, notifiable_id)
  }
}
