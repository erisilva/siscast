SELECT 
table_name,
column_name,
CONCAT('ALTER TABLE `',
        table_name,
        '` CHANGE `',
        column_name,
        '` `',
        column_name,
        '` ',
        column_type,
        ' ',
        IF(is_nullable = 'YES', '' , 'NOT NULL '),
        IF(column_default IS NOT NULL, concat('DEFAULT ', IF(column_default = 'CURRENT_TIMESTAMP', column_default, CONCAT('\'',column_default,'\'') ), ' '), ''),
        IF(column_default IS NULL AND is_nullable = 'YES' AND column_key = '' AND column_type = 'timestamp','NULL ', ''),
        IF(column_default IS NULL AND is_nullable = 'YES' AND column_key = '','DEFAULT NULL ', ''),
        extra,
        ' COMMENT \'',
        column_comment,
        '\' ;') as script
FROM
    information_schema.columns
WHERE
    table_schema = 'sisfarma2016'
ORDER BY table_name , column_name
