Part 1: Theory Warmup
1. Join Behaviors for Unmatched Records
LEFT JOIN: When no match exists in the right table, the query retains the record from the left table and populates the missing columns with NULL values.

INNER JOIN: This clause strictly filters for rows that have matching values in both tables based on the relationship between the Primary Key and Foreign Key.

2. WHERE vs. HAVING
The WHERE clause serves as a row-level filter, applied before any data grouping occurs.

In contrast, the HAVING clause acts as a group-level filter. It is used in conjunction with GROUP BY and aggregate functions (such as COUNT, SUM, etc.) to filter data after the computer has already categorized the records into groups.

3. PDO vs. MySQLi

PDO (PHP Data Object): A database access layer that provides a unified interface for interacting with various database systems.

MySQLi (MySQL Improved): A PHP extension specifically optimized for MySQL and MariaDB databases.

Key Advantages of PDO:

Database Flexibility: Unlike MySQLi, PDO supports multiple database drivers.

Consistent API: PDO offers a uniform interface regardless of the backend, making it superior for building portable and scalable frameworks or libraries.

Feature,PDO,MySQLi
Database support,Multiple DBs,MySQL only
Prepared statements,Named + positional,Positional only
API style,Consistent,MySQL-oriented
Flexibility,High,Medium
Error handling,Exception-based,Medium

4. Security of Prepared Statements
Prepared statements prevent SQL Injection by ensuring user input is never executed as SQL code. While string concatenation allows a user to "rewrite" the SQL template, a prepared statement treats input strictly as data ("filling in the blanks").

They protect the database because the SQL structure is fixed first, and user input is bound later. However, they do not protect against logical errors or authorization flaws.

5. SQL Execution Logic
In a query involving WHERE, GROUP BY, and HAVING:

Selection: The engine identifies the source table (students) and the required fields.

Row Filtering: The WHERE clause filters the raw data (e.g., gender = "female").

Grouping: Data is partitioned into distinct groups based on the subject field.

Ordering: Within those groups, results are sorted (typically alphabetically by default or as specified by ORDER BY).

Group Filtering: Finally, the HAVING clause filters the results at the group level (e.g., only displaying groups with 5 or more records).

Part 2: SQL Lab - The Data Detective

Task 1: Product Catalog with Categories
SELECT 
    p.*, 
    c.category_name 
FROM products p 
LEFT JOIN categories c ON p.category_id = c.id;

Task 2: Revenue Analysis by Category

SELECT 
    ot.id, 
    p.name, 
    c.category_name, 
    o.order_date, 
    ot.quantity, 
    (p.price * ot.quantity) AS revenue 
FROM order_items ot 
LEFT JOIN products p ON ot.product_id = p.id 
LEFT JOIN orders o ON ot.order_id = o.id 
LEFT JOIN categories c ON p.category_id = c.id 
GROUP BY c.category_name;

Task 3: VIP Customers

SELECT 
    u.name, 
    u.email, 
    o.id, 
    (ot.quantity * ot.unit_price) AS total_spent
FROM users u
INNER JOIN orders o ON u.id = o.user_id 
LEFT JOIN order_items ot ON o.id = ot.order_id 
GROUP BY u.email 
HAVING COUNT(o.id) >= 3;