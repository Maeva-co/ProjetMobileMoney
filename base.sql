CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NULL,
    role TEXT NOT NULL CHECK(role IN ('admin', 'client')),
    number VARCHAR(15) NOT NULL UNIQUE,
    operator_type_id INTEGER NULL,
    FOREIGN KEY (operator_type_id) REFERENCES operator_types(id) ON DELETE SET NULL
);

CREATE TABLE operator_types (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    type VARCHAR(50) NOT NULL,
    commissions DECIMAL(10, 2) NOT NULL DEFAULT 0
);

CREATE TABLE transaction_types (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userId INTEGER NOT NULL,
    operator_type_id INTEGER NOT NULL,
    transaction_type_id INTEGER NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    frais DECIMAL(10, 2) DEFAULT 0,
    idUserReceiver INTEGER NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (operator_type_id) REFERENCES operator_types(id) ON DELETE CASCADE,
    FOREIGN KEY (transaction_type_id) REFERENCES transaction_types(id) ON DELETE CASCADE
);

CREATE TABLE solde_mouvement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userId INTEGER NOT NULL,
    type TEXT NOT NULL CHECK(type IN ('credit', 'debit')),
    amount DECIMAL(10, 2) NOT NULL,
    movement_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE config_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    minAmount DECIMAL(10, 2) NOT NULL,
    maxAmount DECIMAL(10, 2) NOT NULL,
    transaction_type_id INTEGER NOT NULL,
    operator_type_id INTEGER NOT NULL,
    frais DECIMAL(10, 2) NOT NULL,
    isActive BOOLEAN DEFAULT 1,
    FOREIGN KEY (transaction_type_id) REFERENCES transaction_types(id) ON DELETE CASCADE,
    FOREIGN KEY (operator_type_id) REFERENCES operator_types(id) ON DELETE CASCADE
);

CREATE TABLE config_frais_history (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    idConfigFrais INTEGER NOT NULL,
    minAmount DECIMAL(10, 2) NOT NULL,
    maxAmount DECIMAL(10, 2) NOT NULL,
    transaction_type_id INTEGER NOT NULL,
    operator_type_id INTEGER NOT NULL,
    frais DECIMAL(10, 2) NOT NULL,
    isActive BOOLEAN DEFAULT 1,
    change_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INTEGER NOT NULL,
    action TEXT NOT NULL CHECK(action IN ('CREATE', 'UPDATE', 'DELETE')),
    FOREIGN KEY (idConfigFrais) REFERENCES config_frais(id) ON DELETE CASCADE,
    FOREIGN KEY (transaction_type_id) REFERENCES transaction_types(id) ON DELETE CASCADE,
    FOREIGN KEY (operator_type_id) REFERENCES operator_types(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE gains(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transaction_id INTEGER NOT NULL,
    operator_type_id INTEGER NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (operator_type_id) REFERENCES operator_types(id) ON DELETE CASCADE,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE
);

INSERT INTO operator_types (name, type, commissions) VALUES 
('Yas', '034', 0.00);

INSERT INTO transaction_types (type) VALUES 
('Deposit'),
('Withdrawal'),
('Transfer');

INSERT INTO users (name, role, number, operator_type_id) VALUES 
('Administrator', 'admin', '0340000000', 1);

INSERT INTO config_frais (minAmount, maxAmount, transaction_type_id, operator_type_id, frais) VALUES
-- YAS (operator_type_id = 1) - Retrait (transaction_type_id = 2)
(100, 1000, 2, 1, 50),
(1001, 5000, 2, 1, 50),
(5001, 10000, 2, 1, 100),
(10001, 25000, 2, 1, 200),
(25001, 50000, 2, 1, 400),
(50001, 100000, 2, 1, 800),
(100001, 250000, 2, 1, 1500),
(250001, 500000, 2, 1, 1500),
(500001, 1000000, 2, 1, 2500),
(1000001, 2000000, 2, 1, 3000),

-- YAS (operator_type_id = 1) - Transfert (transaction_type_id = 3)
(100, 1000, 3, 1, 30),
(1001, 5000, 3, 1, 30),
(5001, 10000, 3, 1, 60),
(10001, 25000, 3, 1, 120),
(25001, 50000, 3, 1, 240),
(50001, 100000, 3, 1, 480),
(100001, 250000, 3, 1, 900),
(250001, 500000, 3, 1, 900),
(500001, 1000000, 3, 1, 1500),
(1000001, 2000000, 3, 1, 1800);

INSERT INTO config_frais_history (idConfigFrais, minAmount, maxAmount, transaction_type_id, operator_type_id, frais, isActive, created_by, action) VALUES
-- YAS - Retrait (ids 1-10)
(1, 100, 1000, 2, 1, 50, 1, 1, 'CREATE'),
(2, 1001, 5000, 2, 1, 50, 1, 1, 'CREATE'),
(3, 5001, 10000, 2, 1, 100, 1, 1, 'CREATE'),
(4, 10001, 25000, 2, 1, 200, 1, 1, 'CREATE'),
(5, 25001, 50000, 2, 1, 400, 1, 1, 'CREATE'),
(6, 50001, 100000, 2, 1, 800, 1, 1, 'CREATE'),
(7, 100001, 250000, 2, 1, 1500, 1, 1, 'CREATE'),
(8, 250001, 500000, 2, 1, 1500, 1, 1, 'CREATE'),
(9, 500001, 1000000, 2, 1, 2500, 1, 1, 'CREATE'),
(10, 1000001, 2000000, 2, 1, 3000, 1, 1, 'CREATE'),

-- YAS - Transfert (ids 31-40)
(31, 100, 1000, 3, 1, 30, 1, 1, 'CREATE'),
(32, 1001, 5000, 3, 1, 30, 1, 1, 'CREATE'),
(33, 5001, 10000, 3, 1, 60, 1, 1, 'CREATE'),
(34, 10001, 25000, 3, 1, 120, 1, 1, 'CREATE'),
(35, 25001, 50000, 3, 1, 240, 1, 1, 'CREATE'),
(36, 50001, 100000, 3, 1, 480, 1, 1, 'CREATE'),
(37, 100001, 250000, 3, 1, 900, 1, 1, 'CREATE'),
(38, 250001, 500000, 3, 1, 900, 1, 1, 'CREATE'),
(39, 500001, 1000000, 3, 1, 1500, 1, 1, 'CREATE'),
(40, 1000001, 2000000, 3, 1, 1800, 1, 1, 'CREATE');