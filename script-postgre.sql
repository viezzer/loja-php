-- Desabilitar verificação de chaves estrangeiras temporariamente
SET session_replication_role = 'replica';

-- Dropar tabelas na ordem correta para evitar erros de dependência
DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS stocks;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS suppliers;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS users;

-- Habilitar verificação de chaves estrangeiras novamente
SET session_replication_role = 'origin';

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    login VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    cartao_credito VARCHAR(255),
    role VARCHAR(10) NOT NULL CHECK (role IN ('admin', 'client'))
);

INSERT INTO users(login, password, name, role) 
VALUES 
    ('admin','21232f297a57a5a743894a0e4a801fc3','Admin', 'admin'),
    ('client','21232f297a57a5a743894a0e4a801fc3','cliente1', 'client'),
    ('client2','21232f297a57a5a743894a0e4a801fc3','cliente2', 'client'),
    ('client3','21232f297a57a5a743894a0e4a801fc3','cliente3', 'client'),
    ('client4','21232f297a57a5a743894a0e4a801fc3','cliente4', 'client');

CREATE TABLE addresses (
    id SERIAL PRIMARY KEY,
    street VARCHAR(255) NOT NULL, 
    number VARCHAR(255) NOT NULL,
    complement VARCHAR(255),
    neighborhood VARCHAR(255) NOT NULL, 
    zip_code VARCHAR(255) NOT NULL, 
    city VARCHAR(255) NOT NULL, 
    state VARCHAR(255) NOT NULL 
);

INSERT INTO addresses (street, number, complement, neighborhood, zip_code, city, state) 
VALUES 
    ('Rua Garibaldi', '123', 'Apto 101', 'Centro', '95010-000', 'Caxias do Sul', 'RS'),
    ('Avenida Júlio de Castilhos', '456', NULL, 'Pio X', '95020-000', 'Caxias do Sul', 'RS'),
    ('Rua Bento Gonçalves', '789', 'Sala 2', 'São Pelegrino', '95010-010', 'Caxias do Sul', 'RS'),
    ('Rua Sinimbu', '1011', 'Casa 3', 'Exposição', '95084-000', 'Caxias do Sul', 'RS'),
    ('Rua Coronel Flores', '1213', 'Loja 1', 'Centenário', '95012-000', 'Caxias do Sul', 'RS');

CREATE TABLE suppliers (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    phone VARCHAR(255),
    email VARCHAR(30) NOT NULL UNIQUE,
    address_id INTEGER NOT NULL,
    CONSTRAINT fk_address_supplier FOREIGN KEY (address_id) REFERENCES addresses(id)
);

INSERT INTO suppliers (name, description, phone, email, address_id)
VALUES 
    ('Loja de Eletrônicos A', 'Especializada em eletrônicos para casa', '(54) 1234-5678', 'eletronicosA@caxias.com', 1),
    ('Distribuidora de Alimentos B', 'Fornecedora de alimentos para restaurantes', '(54) 9876-5432', 'alimentosB@caxias.com', 2),
    ('Indústria de Confecções C', 'Fabricante de roupas de moda masculina', '(54) 1111-2222', 'confecoesC@caxias.com', 3),
    ('Loja de Materiais de Construção D', 'Ampla variedade em materiais de construção', '(54) 3333-4444', 'construcaoD@caxias.com', 4),
    ('Distribuidora de Produtos de Limpeza E', 'Especializada em produtos de limpeza para empresas', '(54) 5555-6666', 'limpezaE@caxias.com', 5);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    image BYTEA,
    supplier_id INTEGER NOT NULL,
    CONSTRAINT fk_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
);

INSERT INTO products (name, description, image, supplier_id)
VALUES 
    ('Smart TV 4K 50 polegadas', 'Smart TV com resolução 4K e 50 polegadas', NULL, 1),
    ('Cesta Básica Familiar', 'Cesta básica com alimentos essenciais', NULL, 2),
    ('Camisa Social Masculina', 'Camisa social para homens elegantes', NULL, 3),
    ('Tinta Acrílica Branca', 'Lata de tinta acrílica branca para pintura', NULL, 4),
    ('Detergente Multiuso', 'Detergente concentrado para limpeza', NULL, 5);

CREATE TABLE stocks (
    id SERIAL PRIMARY KEY,
    quantity INTEGER NOT NULL,
    price NUMERIC (10,2) NOT NULL,
    product_id INTEGER UNIQUE NOT NULL, 
    CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO stocks (quantity, price, product_id)
VALUES 
    (10, 2999.99, 1),
    (50, 199.99, 2),
    (100, 79.99, 3),
    (20, 39.99, 4),
    (200, 9.99, 5);

CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    number SERIAL NOT NULL,
    order_date DATE NOT NULL,
    delivery_date DATE,
    status VARCHAR(20) NOT NULL CHECK (status IN ('NOVO', 'ENTREGUE', 'CANCELADO')),
    client_id INTEGER NOT NULL,
    CONSTRAINT fk_client_order FOREIGN KEY (client_id) REFERENCES users(id)
);

INSERT INTO orders (number, order_date, delivery_date, status, client_id)
VALUES 
    (1001, '2024-05-01', '2024-05-05', 'NOVO', 1),
    (1002, '2024-05-02', '2024-05-06', 'NOVO', 2),
    (1003, '2024-05-03', '2024-05-07', 'ENTREGUE', 3),
    (1004, '2024-05-04', '2024-05-08', 'CANCELADO', 4),
    (1005, '2024-05-05', '2024-05-09', 'NOVO', 5);


CREATE TABLE order_items (
    id SERIAL PRIMARY KEY,
    quantity INTEGER NOT NULL,
    price NUMERIC (10, 2) NOT NULL,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    CONSTRAINT fk_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_product_order_item FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO order_items (quantity, price, order_id, product_id)
VALUES 
    (1, 2999.99, 1, 1),
    (2, 199.99, 2, 2),
    (3, 79.99, 3, 3),
    (4, 39.99, 4, 4),
    (5, 9.99, 5, 5);