create table products_product_fields_translations
(
    id     char(36)     not null,
    locale varchar(5)   not null,
    value  varchar(255) not null,
    primary key (id, locale)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO demo.products_product_fields_translations (id, locale, value) VALUES ('0fd3c86e-4c54-459d-a1c0-b274e9d0c6da', 'da_DK', 'danish value 1');
INSERT INTO demo.products_product_fields_translations (id, locale, value) VALUES ('ce1a06ac-5fba-428b-a595-d73962733555', 'da_DK', 'danish value 2');
