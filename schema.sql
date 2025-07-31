-- -- schema.sql

-- CREATE DATABASE IF NOT EXISTS fifteen_puzzle CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE fifteen_puzzle;

-- -- Users table
-- CREATE TABLE users (
--   user_id      INT AUTO_INCREMENT PRIMARY KEY,
--   username     VARCHAR(50)    NOT NULL UNIQUE,
--   password_hash VARCHAR(255)  NOT NULL,
--   role         ENUM('player','admin') NOT NULL DEFAULT 'player'
-- );

-- -- Game statistics table
-- CREATE TABLE game_stats (
--   stat_id     INT AUTO_INCREMENT PRIMARY KEY,
--   user_id     INT             NULL,
--   moves       INT             NOT NULL,
--   time_taken  INT             NOT NULL,    -- seconds
--   date_played TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
--   FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
-- );

-- schema.sql (Postgres‐compatible)

-- Users table
CREATE TABLE IF NOT EXISTS users (
  user_id SERIAL PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(10) NOT NULL DEFAULT 'player'
    CHECK (role IN ('player','admin'))
);

-- Game statistics table
CREATE TABLE IF NOT EXISTS game_stats (
  stat_id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(user_id) ON DELETE SET NULL,
  moves INT NOT NULL,
  time_taken INT NOT NULL,   -- seconds
  date_played TIMESTAMP NOT NULL DEFAULT now()
);
