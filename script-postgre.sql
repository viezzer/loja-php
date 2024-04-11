CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    login VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL
);

INSERT INTO users(login, password, name) VALUES ('admin','21232f297a57a5a743894a0e4a801fc3','Admin');

CREATE TABLE adresses (
    id SERIAL PRIMARY KEY,
    street VARCHAR(255) NOT NULL, 
    number VARCHAR(255) NOT NULL,
    complement VARCHAR(255),
    neighborhood VARCHAR(255) NOT NULL, 
    zip_code VARCHAR(255) NOT NULL, 
    city VARCHAR(255) NOT NULL, 
    state VARCHAR(255) NOT NULL 
);

INSERT INTO adresses (street, number, complement, neighborhood, zip_code, city, state) 
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
    CONSTRAINT fk_adress FOREIGN KEY (adress_id) REFERENCES adresses(id)
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
    CONSTRAINT fk_supplier FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
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
    CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO stocks (quantity, price, product_id)
VALUES 
    (10, 2999.99, 1),
    (50, 199.99, 2),
    (100, 79.99, 3),
    (20, 39.99, 4),
    (200, 9.99, 5);