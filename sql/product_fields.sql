create table product_fields
(
    id           char(36)                    not null
        primary key,
    name         varchar(64)                 not null,
    type         varchar(255) default 'text' not null,
    is_localized tinyint(1)   default 0      not null,
    modified     datetime                    not null,
    created      datetime                    not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO demo.product_fields (id, name, type, is_localized, modified, created) VALUES ('0949c27b-e494-434d-966d-fc9114f1e97a', 'Field 2', 'url', 0, '2025-06-16 18:34:28', '2025-06-16 18:34:30');
INSERT INTO demo.product_fields (id, name, type, is_localized, modified, created) VALUES ('355a9c0c-64e3-4d39-acba-6e68218d1e81', 'Field 1', 'text', 0, '2025-06-16 18:34:06', '2025-06-16 18:34:09');
