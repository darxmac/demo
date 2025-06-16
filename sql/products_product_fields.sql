create table products_product_fields
(
    id               char(36)     not null
        primary key,
    product_id       char(36)     not null,
    product_field_id char(36)     not null,
    value            varchar(255) null,
    modified         datetime     not null,
    created          datetime     not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO demo.products_product_fields (id, product_id, product_field_id, value, modified, created) VALUES ('0fd3c86e-4c54-459d-a1c0-b274e9d0c6da', 'cdf3edf7-31d0-44db-a10f-a67f8d0d6cac', '355a9c0c-64e3-4d39-acba-6e68218d1e81', 'original value 2', '2025-06-16 18:35:53', '2025-06-16 18:35:56');
INSERT INTO demo.products_product_fields (id, product_id, product_field_id, value, modified, created) VALUES ('ce1a06ac-5fba-428b-a595-d73962733555', 'b49bd77d-c26d-4d26-9afa-a3fafce78756', '355a9c0c-64e3-4d39-acba-6e68218d1e81', 'original value 1', '2025-06-16 18:35:21', '2025-06-16 18:35:25');
