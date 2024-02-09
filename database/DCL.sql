-- GRANT, REVOKE

-- Apuntar a la Base de Datos
USE proyectogdb_mapache;

-- Conceder privilegios específicos
GRANT SELECT ON proyectogdb_mapache.* TO Consultor;
GRANT SELECT, INSERT ON proyectogdb_mapache.* TO Funcionario;
GRANT ALL PRIVILEGES ON proyectogdb_mapache.* TO DBA;

SELECT * FROM mysql.user;



