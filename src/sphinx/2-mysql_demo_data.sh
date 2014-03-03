#!/bin/sh
# Example of mysql user created for Sphinx only:
FILE="sql_import.sql"
wget "https://raw.github.com/alombarte/utilities/master/sql/spain_comunidades_autonomas.sql" --no-check-certificate
wget "https://raw.github.com/alombarte/utilities/master/sql/spain_municipios_INE.sql" --no-check-certificate
wget "https://raw.github.com/alombarte/utilities/master/sql/spain_provincias.sql" --no-check-certificate

echo "CREATE database sphinx_demo;\nCREATE USER 'sphinx'@'127.0.0.1' IDENTIFIED BY 'sspphhiinnxx001122';\nGRANT SELECT ON *.* TO 'sphinx'@'127.0.0.1';\n" > $FILE
cat spain_* >> $FILE

mysql -u root -p sphinx_demo < $FILE
rm $FILE spain_*