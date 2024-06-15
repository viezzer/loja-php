-- Desabilitar verificação de chaves estrangeiras temporariamente
SET session_replication_role = 'replica';

-- Dropar tabelas na ordem correta para evitar erros de dependência
DROP TABLE IF EXISTS order_items cascade;
DROP TABLE IF EXISTS orders cascade;
DROP TABLE IF EXISTS stocks cascade;
DROP TABLE IF EXISTS products cascade;
DROP TABLE IF EXISTS suppliers cascade;
DROP TABLE IF EXISTS addresses cascade;
DROP TABLE IF EXISTS users cascade;

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

INSERT INTO users (login, password, name, role) 
VALUES 
    ('admin','21232f297a57a5a743894a0e4a801fc3','Admin', 'admin'),
    ('joao_silva','21232f297a57a5a743894a0e4a801fc3','João Silva', 'client'),
    ('maria_oliveira','21232f297a57a5a743894a0e4a801fc3','Maria Oliveira', 'client'),
    ('carlos_santos','21232f297a57a5a743894a0e4a801fc3','Carlos Santos', 'client'),
    ('ana_pereira','21232f297a57a5a743894a0e4a801fc3','Ana Pereira', 'client'),
    ('paulo_fernandes','21232f297a57a5a743894a0e4a801fc3','Paulo Fernandes', 'client'),
    ('fernanda_souza','21232f297a57a5a743894a0e4a801fc3','Fernanda Souza', 'client'),
    ('luiz_costa','21232f297a57a5a743894a0e4a801fc3','Luiz Costa', 'client'),
    ('mariana_silveira','21232f297a57a5a743894a0e4a801fc3','Mariana Silveira', 'client'),
    ('andre_almeida','21232f297a57a5a743894a0e4a801fc3','André Almeida', 'client'),
    ('beatriz_gomes','21232f297a57a5a743894a0e4a801fc3','Beatriz Gomes', 'client'),
    ('bruno_rocha','21232f297a57a5a743894a0e4a801fc3','Bruno Rocha', 'client'),
    ('camila_freitas','21232f297a57a5a743894a0e4a801fc3','Camila Freitas', 'client'),
    ('daniel_ribeiro','21232f297a57a5a743894a0e4a801fc3','Daniel Ribeiro', 'client'),
    ('elisabete_mendes','21232f297a57a5a743894a0e4a801fc3','Elisabete Mendes', 'client'),
    ('felipe_cardoso','21232f297a57a5a743894a0e4a801fc3','Felipe Cardoso', 'client'),
    ('gabriela_barbosa','21232f297a57a5a743894a0e4a801fc3','Gabriela Barbosa', 'client'),
    ('henrique_martins','21232f297a57a5a743894a0e4a801fc3','Henrique Martins', 'client'),
    ('isabel_guimaraes','21232f297a57a5a743894a0e4a801fc3','Isabel Guimarães', 'client'),
    ('roberto_ramos','21232f297a57a5a743894a0e4a801fc3','Roberto Ramos', 'client');


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
    ('Rua Coronel Flores', '1213', 'Loja 1', 'Centenário', '95012-000', 'Caxias do Sul', 'RS'),
    ('Rua Visconde de Pelotas', '1314', 'Apto 202', 'Madureira', '95030-000', 'Caxias do Sul', 'RS'),
    ('Rua Moreira César', '1415', 'Casa 5', 'Bela Vista', '95040-000', 'Caxias do Sul', 'RS'),
    ('Avenida Itália', '1516', 'Loja 3', 'São José', '95050-000', 'Caxias do Sul', 'RS'),
    ('Rua Tronca', '1617', 'Sala 4', 'Rio Branco', '95060-000', 'Caxias do Sul', 'RS'),
    ('Rua Feijó Júnior', '1718', 'Apto 301', 'Nossa Senhora de Lourdes', '95070-000', 'Caxias do Sul', 'RS'),
    ('Rua Marquês do Herval', '1819', 'Casa 6', 'Cinquentenário', '95080-000', 'Caxias do Sul', 'RS'),
    ('Avenida Rossetti', '1920', 'Loja 2', 'Sagrada Família', '95090-000', 'Caxias do Sul', 'RS'),
    ('Rua Teixeira Mendes', '2021', 'Sala 5', 'Jardim América', '95100-000', 'Caxias do Sul', 'RS'),
    ('Rua Machado de Assis', '2122', 'Apto 401', 'São Luiz', '95110-000', 'Caxias do Sul', 'RS'),
    ('Rua São João', '2223', 'Casa 7', 'Cristo Redentor', '95120-000', 'Caxias do Sul', 'RS'),
    ('Avenida Rio Branco', '2324', 'Loja 4', 'Santa Catarina', '95130-000', 'Caxias do Sul', 'RS'),
    ('Rua Flores da Cunha', '2425', 'Sala 6', 'Santa Tereza', '95140-000', 'Caxias do Sul', 'RS'),
    ('Rua Alfredo Chaves', '2526', 'Apto 501', 'Medianeira', '95150-000', 'Caxias do Sul', 'RS'),
    ('Rua Pinheiro Machado', '2627', 'Casa 8', 'São Francisco', '95160-000', 'Caxias do Sul', 'RS'),
    ('Rua Pedro Tomasi', '2728', 'Loja 5', 'Salgado Filho', '95170-000', 'Caxias do Sul', 'RS');

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
    ('Distribuidora de Produtos de Limpeza E', 'Especializada em produtos de limpeza para empresas', '(54) 5555-6666', 'limpezaE@caxias.com', 5),
    ('Fornecedor de Papelaria F', 'Tudo para seu escritório e escola', '(54) 7777-8888', 'papelariaF@caxias.com', 6),
    ('Distribuidora de Bebidas G', 'Bebidas para festas e eventos', '(54) 9999-0000', 'bebidasG@caxias.com', 7),
    ('Fornecedor de Informática H', 'Equipamentos e acessórios de informática', '(54) 2222-3333', 'informaticaH@caxias.com', 8),
    ('Loja de Ferramentas I', 'Ferramentas para construção e jardinagem', '(54) 4444-5555', 'ferramentasI@caxias.com', 9),
    ('Distribuidora de Cosméticos J', 'Cosméticos e produtos de beleza', '(54) 6666-7777', 'cosmeticosJ@caxias.com', 10),
    ('Fornecedor de Móveis K', 'Móveis para casa e escritório', '(54) 8888-9999', 'moveisK@caxias.com', 11),
    ('Loja de Roupas L', 'Roupas femininas e masculinas', '(54) 0000-1111', 'roupasL@caxias.com', 12),
    ('Distribuidora de Produtos de Limpeza M', 'Produtos de limpeza para residência', '(54) 3333-2222', 'limpezaM@caxias.com', 13),
    ('Fornecedor de Eletrodomésticos N', 'Eletrodomésticos para sua casa', '(54) 5555-4444', 'eletrodomesticosN@caxias.com', 14),
    ('Loja de Calçados O', 'Calçados para todas as idades', '(54) 7777-6666', 'calcadosO@caxias.com', 15),
    ('Distribuidora de Ferragens P', 'Ferragens e parafusos', '(54) 9999-8888', 'ferragensP@caxias.com', 16),
    ('Fornecedor de Produtos de Higiene Q', 'Produtos de higiene pessoal', '(54) 2222-1111', 'higieneQ@caxias.com', 17),
    ('Loja de Equipamentos Esportivos R', 'Equipamentos para esportes e fitness', '(54) 4444-3333', 'esportivosR@caxias.com', 18),
    ('Distribuidora de Produtos Naturais S', 'Produtos naturais e orgânicos', '(54) 6666-5555', 'naturaisS@caxias.com', 19),
    ('Fornecedor de Brinquedos T', 'Brinquedos e jogos para crianças', '(54) 8888-7777', 'brinquedosT@caxias.com', 20);

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
    ('Detergente Multiuso', 'Detergente concentrado para limpeza', NULL, 5),
    ('Caderno Universitário', 'Caderno universitário com 200 folhas', NULL, 6),
    ('Refrigerante 2L', 'Refrigerante sabor cola em garrafa de 2 litros', NULL, 7),
    ('Mouse Óptico USB', 'Mouse óptico com conexão USB', NULL, 8),
    ('Martelo de Borracha', 'Martelo de borracha para marcenaria', NULL, 9),
    ('Shampoo Anticaspa', 'Shampoo para tratamento de caspa', NULL, 10),
    ('Mesa de Escritório', 'Mesa de escritório com 4 gavetas', NULL, 11),
    ('Vestido de Festa', 'Vestido longo para festas e eventos', NULL, 12),
    ('Sabão em Pó', 'Sabão em pó para roupas', NULL, 13),
    ('Geladeira Duplex', 'Geladeira duplex com freezer', NULL, 14),
    ('Tênis Esportivo', 'Tênis esportivo para corrida', NULL, 15),
    ('Parafuso 10mm', 'Parafuso de aço de 10mm', NULL, 16),
    ('Pasta de Dente', 'Pasta de dente com flúor', NULL, 17),
    ('Bicicleta Mountain Bike', 'Bicicleta para trilhas e montanhas', NULL, 18),
    ('Chá Verde Orgânico', 'Chá verde orgânico em saquinhos', NULL, 19),
    ('Boneca de Pano', 'Boneca de pano artesanal', NULL, 20);

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
    (200, 9.99, 5),
    (150, 12.99, 6),
    (300, 5.99, 7),
    (80, 29.99, 8),
    (60, 19.99, 9),
    (500, 15.99, 10),
    (30, 399.99, 11),
    (200, 99.99, 12),
    (250, 10.99, 13),
    (20, 2999.99, 14),
    (100, 149.99, 15),
    (400, 0.99, 16),
    (600, 4.99, 17),
    (40, 699.99, 18),
    (180, 14.99, 19),
    (75, 39.99, 20);

CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    number SERIAL,
    order_date DATE NOT NULL,
    delivery_date DATE,
    status VARCHAR(20) NOT NULL CHECK (status IN ('NOVO', 'ENTREGUE', 'CANCELADO')),
    client_id INTEGER NOT NULL,
    CONSTRAINT fk_client_order FOREIGN KEY (client_id) REFERENCES users(id)
);

INSERT INTO orders (order_date, delivery_date, status, client_id)
VALUES 
    ('2024-05-01', '2024-05-05', 'NOVO', 1),
    ('2024-05-02', '2024-05-06', 'NOVO', 2),
    ('2024-05-03', '2024-05-07', 'ENTREGUE', 3),
    ('2024-05-04', '2024-05-08', 'CANCELADO', 4),
    ('2024-05-05', '2024-05-09', 'NOVO', 5);


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