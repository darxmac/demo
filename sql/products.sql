create table products
(
    id       char(36)     not null
        primary key,
    name     varchar(255) not null,
    modified datetime     not null,
    created  datetime     not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO demo.products (id, name, modified, created) VALUES ('b49bd77d-c26d-4d26-9afa-a3fafce78756', 'Product 2', '2025-06-16 18:34:52', '2025-06-16 18:34:55');
INSERT INTO demo.products (id, name, modified, created) VALUES ('cdf3edf7-31d0-44db-a10f-a67f8d0d6cac', 'Product 1', '2025-06-16 18:32:53', '2025-06-16 18:32:54');
