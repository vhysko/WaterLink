ALTER TABLE users
ADD COLUMN full_name VARCHAR(255) NOT NULL AFTER id,
ADD COLUMN phone VARCHAR(20) NOT NULL AFTER email,
ADD COLUMN address VARCHAR(255) NOT NULL AFTER phone,
ADD COLUMN location VARCHAR(255) NOT NULL AFTER address;