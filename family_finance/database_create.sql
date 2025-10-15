--
-- 1. Tabela dla rodzin/wspólnych budżetów
--
CREATE TABLE families (
    id INT(11) NOT NULL AUTO_INCREMENT,
    family_name VARCHAR(100) NOT NULL,
    region VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

--
-- 2. Tabela dla użytkowników
--
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    family_id INT(11) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('member', 'admin') NOT NULL DEFAULT 'member', -- Rola w rodzinie
    account_type ENUM('standard', 'premium') NOT NULL DEFAULT 'standard', -- Typ konta
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (family_id) REFERENCES families(id)
);

--
-- 3. Tabela dla kategorii globalnych (z podkategoriami)
--
CREATE TABLE categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    parent_id INT(11) DEFAULT NULL, -- Umożliwia tworzenie podkategorii
    name VARCHAR(100) NOT NULL UNIQUE, -- Unikalność nazwy na poziomie globalnym
    type ENUM('expense', 'income') NOT NULL,
    is_global TINYINT(1) DEFAULT 1,
    PRIMARY KEY (id),
    FOREIGN KEY (parent_id) REFERENCES categories(id)
);

--
-- 4. Tabela dla roboczych kategorii lokalnych
--
CREATE TABLE local_categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    family_id INT(11) NOT NULL,
    parent_id INT(11) DEFAULT NULL,
    name VARCHAR(100) NOT NULL,
    status ENUM('draft', 'proposed', 'approved') NOT NULL DEFAULT 'draft',
    PRIMARY KEY (id),
    FOREIGN KEY (family_id) REFERENCES families(id),
    FOREIGN KEY (parent_id) REFERENCES local_categories(id),
    -- Ograniczenie, aby nazwa kategorii była unikalna w obrębie jednej rodziny
    UNIQUE KEY unique_local_category (family_id, name)
);

--
-- 5. Tabela dla transakcji (wydatków i przychodów)
--
CREATE TABLE transactions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    family_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    category_id INT(11) DEFAULT NULL, -- Może być NULL, jeśli użyto local_category_id
    local_category_id INT(11) DEFAULT NULL, -- Może być NULL, jeśli użyto category_id
    type ENUM('expense', 'income') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(10) NOT NULL,
    payment_method ENUM('cash', 'card', 'crypto') NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    transaction_date DATETIME NOT NULL,
    is_recurring TINYINT(1) DEFAULT 0,
    PRIMARY KEY (id),
    FOREIGN KEY (family_id) REFERENCES families(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (local_category_id) REFERENCES local_categories(id),
    -- Ograniczenie (CHECK) zapewniające, że dokładnie jedna z kategorii jest użyta
    CHECK (category_id IS NOT NULL OR local_category_id IS NOT NULL)
);

--
-- 6. Tabela dla definicji transakcji cyklicznych
--
CREATE TABLE recurring_transactions (
    id INT(11) NOT NULL AUTO_INCREMENT,
    transaction_template_id INT(11) NOT NULL,
    frequency ENUM('daily', 'weekly', 'monthly', 'yearly') NOT NULL,
    next_due_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (transaction_template_id) REFERENCES transactions(id)
);

--
-- 7. Tabela dla limitów budżetowych
--
CREATE TABLE budgets (
    id INT(11) NOT NULL AUTO_INCREMENT,
    family_id INT(11) NOT NULL,
    category_id INT(11) NOT NULL,
    limit_amount DECIMAL(10, 2) NOT NULL,
    period_type ENUM('monthly', 'yearly') NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (family_id) REFERENCES families(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

--
-- 8. Tabela dla kursów walut (w tym kryptowalut)
--
CREATE TABLE exchange_rates (
    id INT(11) NOT NULL AUTO_INCREMENT,
    base_currency VARCHAR(10) NOT NULL,
    target_currency VARCHAR(10) NOT NULL,
    rate DECIMAL(18, 8) NOT NULL,
    last_updated DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unique_rate (base_currency, target_currency)
);

--
-- 9. Tabela dla formularza kontaktowego, sugestii i błędów
--
CREATE TABLE feedbacks (
    id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) DEFAULT NULL,
    type ENUM('bug', 'suggestion', 'category_proposal', 'support') NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    related_local_category_id INT(11) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('new', 'in_progress', 'resolved') DEFAULT 'new',
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (related_local_category_id) REFERENCES local_categories(id)
);