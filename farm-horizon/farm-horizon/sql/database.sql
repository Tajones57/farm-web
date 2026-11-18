-- Import this in phpMyAdmin (Import tab) or paste in the SQL tab
CREATE DATABASE IF NOT EXISTS farm_horizon CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE farm_horizon;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NULL,
  email_or_phone VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  unit VARCHAR(30) NOT NULL DEFAULT '',
  image VARCHAR(120) NOT NULL,
  detail_image VARCHAR(120) NULL,
  description TEXT NOT NULL,
  rating DECIMAL(2,1) NOT NULL DEFAULT 8.9
);

CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  UNIQUE KEY uniq_user_product (user_id, product_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE favorites (
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  PRIMARY KEY (user_id, product_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'Placed',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, category, price, unit, image, detail_image, description, rating) VALUES
('Apple','Fruits',20,'','apple.jpg','apple-large.jpg','Enjoy the fresh and delicious taste of our premium apples. Crisp, juicy, and naturally sweet, each apple is carefully selected to ensure great quality and freshness. Perfect for a healthy snack, breakfast, desserts, or refreshing fruit salads. Fresh, nutritious, and delicious a perfect choice for every day!',8.9),
('Banana','Fruits',50,'per kilo','banana.jpg','banana.jpg','Sweet, creamy bananas picked at their peak. A great source of energy for breakfast, smoothies, or a quick snack on the go.',8.7),
('Mango','Fruits',30,'each','mango.jpg','mango.jpg','Ripe, juicy mangoes with a rich tropical sweetness. Perfect fresh, in shakes, or as a dessert topping.',9.1),
('Tomato','Vegetable',35,'per kilo','tomato.jpg','tomato.jpg','Firm, bright red tomatoes full of flavor. Great for salads, sauces, soups, and everyday cooking.',8.5),
('Potato','Vegetable',80,'per kilo','potato.jpg','potato.jpg','Farm-fresh potatoes that are perfect for frying, boiling, roasting, or mashing. A kitchen staple for every meal.',8.6),
('Cow milk','Vegetable',200,'','milk.jpg','milk.jpg','Fresh cow milk, rich and creamy, straight from the farm. Ideal for drinking, coffee, baking, and cooking.',8.8);
