<?php
$dbFile = __DIR__ . '/threadpixel.sqlite';
if (file_exists($dbFile)) {
    unlink($dbFile); // Reset DB for fresh setup
}

$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = "
CREATE TABLE users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  role TEXT DEFAULT 'customer',
  business_name TEXT DEFAULT NULL,
  country TEXT DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE services (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  description TEXT,
  starting_price REAL DEFAULT 0.00,
  suitable_applications TEXT,
  is_active INTEGER DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE portfolio_categories (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL
);

CREATE TABLE portfolio (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  category_id INTEGER DEFAULT NULL,
  title TEXT NOT NULL,
  description TEXT,
  original_artwork_path TEXT DEFAULT NULL,
  digitized_preview_path TEXT DEFAULT NULL,
  actual_embroidery_path TEXT DEFAULT NULL,
  stitch_count INTEGER DEFAULT NULL,
  dimensions TEXT DEFAULT NULL,
  machine_formats TEXT DEFAULT NULL,
  is_featured INTEGER DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES portfolio_categories(id)
);

CREATE TABLE quotes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  quote_number TEXT NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  service_id INTEGER DEFAULT NULL,
  design_size TEXT DEFAULT NULL,
  garment_type TEXT DEFAULT NULL,
  machine_format TEXT DEFAULT NULL,
  quantity INTEGER DEFAULT 1,
  required_date DATE DEFAULT NULL,
  is_rush INTEGER DEFAULT 0,
  additional_instructions TEXT,
  status TEXT DEFAULT 'Pending',
  quoted_price REAL DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (service_id) REFERENCES services(id)
);

CREATE TABLE quote_files (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  quote_id INTEGER NOT NULL,
  file_path TEXT NOT NULL,
  file_name TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE orders (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  order_number TEXT NOT NULL UNIQUE,
  quote_id INTEGER UNIQUE NOT NULL,
  user_id INTEGER NOT NULL,
  status TEXT DEFAULT 'Awaiting Payment',
  total_price REAL NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (quote_id) REFERENCES quotes(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_files (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  order_id INTEGER NOT NULL,
  file_type TEXT DEFAULT 'final_design',
  file_path TEXT NOT NULL,
  file_name TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id)
);

CREATE TABLE messages (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  sender_id INTEGER NOT NULL,
  receiver_id INTEGER NOT NULL,
  quote_id INTEGER DEFAULT NULL,
  order_id INTEGER DEFAULT NULL,
  content TEXT NOT NULL,
  is_read INTEGER DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id),
  FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE faqs (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  category TEXT DEFAULT 'General',
  question TEXT NOT NULL,
  answer TEXT NOT NULL,
  is_active INTEGER DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE chatbot_knowledge (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  category TEXT DEFAULT 'General',
  keywords TEXT NOT NULL,
  question TEXT NOT NULL,
  answer TEXT NOT NULL,
  is_active INTEGER DEFAULT 1
);

CREATE TABLE testimonials (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  client_name TEXT NOT NULL,
  business_name TEXT DEFAULT NULL,
  content TEXT NOT NULL,
  rating INTEGER DEFAULT 5,
  is_active INTEGER DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  setting_key TEXT NOT NULL UNIQUE,
  setting_value TEXT
);
";

$pdo->exec($schema);

// Seed basic data
$pass = password_hash('admin123', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO users (name, email, password, role) VALUES ('Admin User', 'admin@threadpixel.com', '{$pass}', 'admin')");

$pdo->exec("INSERT INTO services (name, description, starting_price, suitable_applications) VALUES 
('Logo Digitizing', 'Convert logos and artwork into professional machine embroidery files.', 10.00, 'Polos, T-Shirts, Bags'),
('Cap Digitizing', 'Digitizing specifically optimized for caps and hats.', 12.00, 'Snapbacks, Dad Hats, Beanies'),
('3D Puff Digitizing', 'Create raised embroidery designs for caps and apparel.', 15.00, 'Caps, Jackets')");

$pdo->exec("INSERT INTO faqs (category, question, answer) VALUES 
('General', 'What is embroidery digitizing?', 'It is the process of converting artwork into a digital file format that an embroidery machine can read and stitch.'),
('Formats', 'What file formats do you provide?', 'We provide DST, PES, EXP, JEF, VP3, and other common formats. You can select your format when requesting a quote.')");

echo "SQLite Database created and seeded successfully!";
