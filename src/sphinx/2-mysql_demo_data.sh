#!/bin/sh
# Example of mysql user created for Sphinx only:
FILE="sql_import.sql"
wget "https://raw.github.com/alombarte/utilities/master/sql/spain_comunidades_autonomas.sql" --no-check-certificate
wget "https://raw.github.com/alombarte/utilities/master/sql/spain_municipios_INE.sql" --no-check-certificate
wget "https://raw.github.com/alombarte/utilities/master/sql/spain_provincias.sql" --no-check-certificate

echo "DROP DATABASE IF EXISTS sphinx_demo; \
CREATE database sphinx_demo; \
GRANT SELECT ON sphinx_demo.* to 'sphinx'@'127.0.0.1' identified by 'sspphhiinnxx001122'; \
USE sphinx_demo;" > $FILE
cat spain_* >> $FILE

mysql -u root -p < $FILE
rm $FILE spain_*