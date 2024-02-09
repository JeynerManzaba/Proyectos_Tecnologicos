-- CREATE, ALTER, DROP, RENAME

-- Crear la base de datos
DROP DATABASE IF EXISTS proyectogdb_mapache;
CREATE DATABASE proyectogdb_mapache;

-- Apuntar a la Base de Datos
USE proyectogdb_mapache;

-- Crear usuarios
CREATE USER 'Consultor'@'%' IDENTIFIED BY 'C0nsu1t0r!_2024';
CREATE USER 'Funcionario'@'%' IDENTIFIED BY 'Funct10n@r10!_2O2A';
CREATE USER 'DBA'@'%' IDENTIFIED BY 'D8A$up3rP@ss_2O2A!';

-- Creación de tablas
DROP TABLE IF EXISTS Roles;
CREATE TABLE Roles (
    ID_Rol INT AUTO_INCREMENT PRIMARY KEY,
    Descripcion VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS Habilidades;
CREATE TABLE Habilidades (
    ID_Habilidad INT AUTO_INCREMENT PRIMARY KEY,
    Descripcion VARCHAR(255) NOT NULL,
    Nivel_Dificultad INT NOT NULL
);

DROP TABLE IF EXISTS Empleados;
CREATE TABLE Empleados (
    ID_Empleado INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Correo_Electronico VARCHAR(255) NOT NULL,
    Rol_ID INT NOT NULL,
    FOREIGN KEY (Rol_ID) REFERENCES Roles(ID_Rol)
);

DROP TABLE IF EXISTS Clientes;
CREATE TABLE Clientes (
    ID_Cliente INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Cedula VARCHAR(10) NOT NULL,
    Telefono VARCHAR(10) NOT NULL,
    Correo_Electronico VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS Proyectos;
CREATE TABLE Proyectos (
    ID_Proyecto INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Descripcion TEXT NOT NULL,
    Fecha_Inicio DATE NOT NULL,
    Fecha_Fin DATE NOT NULL,
    Estado VARCHAR(50) NOT NULL,
    ID_Cliente INT NOT NULL,
    FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID_Cliente)
);

DROP TABLE IF EXISTS Tareas;
CREATE TABLE Tareas (
    ID_Tarea INT AUTO_INCREMENT PRIMARY KEY,
    Descripcion TEXT NOT NULL,
    Estado VARCHAR(50)NOT NULL,
    Fecha_Inicio DATE NOT NULL,
    Fecha_Fin DATE NOT NULL,
    ID_Empleado INT NOT NULL,
    ID_Proyecto INT NOT NULL,
    FOREIGN KEY (ID_Empleado) REFERENCES Empleados(ID_Empleado),
    FOREIGN KEY (ID_Proyecto) REFERENCES Proyectos(ID_Proyecto)
);

DROP TABLE IF EXISTS Empleado_Habilidad;
CREATE TABLE Empleado_Habilidad (
    ID_Empleado INT NOT NULL,
    ID_Habilidad INT NOT NULL,
    PRIMARY KEY (ID_Empleado, ID_Habilidad),
    FOREIGN KEY (ID_Empleado) REFERENCES Empleados(ID_Empleado) ON DELETE CASCADE,
    FOREIGN KEY (ID_Habilidad) REFERENCES Habilidades(ID_Habilidad) ON DELETE CASCADE
);

DROP TABLE IF EXISTS Requisitos_Cliente;
CREATE TABLE Requisitos_Cliente (
    ID_Requisito INT AUTO_INCREMENT PRIMARY KEY,
    Descripcion TEXT NOT NULL,
    Tipo ENUM('Funcional', 'No Funcional') NOT NULL,
    ID_Proyecto INT NOT NULL,
    FOREIGN KEY (ID_Proyecto) REFERENCES Proyectos(ID_Proyecto)
);


-- Procemientos almacenados

-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
--                                         Roles
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

-- sp: crear rol
Drop Procedure CrearRol;
-- sp: crear rol
DELIMITER //

CREATE PROCEDURE CrearRol(
    IN p_Descripcion VARCHAR(100)
)
BEGIN
    DECLARE rollback_action BOOLEAN DEFAULT 0;

    -- Configurar manejador de errores
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        SET rollback_action = 1;

    -- Iniciar transacción
    START TRANSACTION;

    BEGIN
        -- Lógica del procedimiento
        INSERT INTO Roles (Descripcion) VALUES (p_Descripcion);
    END;

    -- Comprobar si se produjo un error
    IF rollback_action THEN
        -- Revertir transacción en caso de error
        ROLLBACK;
        -- Registrar el error en la tabla de errores
        INSERT INTO Errores (Usuario, Sentencia_Incorrecta, IP, Fecha_Hora, Motivo_Error)
        VALUES ('UsuarioReportes', 'CREATE ROLE', 'IP_Donde_Fue_Disparada', NOW(), 'Error al crear el rol');
        -- Lanzar una excepción personalizada
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error al crear el rol. Consulta la tabla de errores para más detalles.';
    ELSE
        -- Confirmar transacción si no hay errores
        COMMIT;
    END IF;
END //

DELIMITER ;


-- sp: actualizar rol
DELIMITER //
CREATE PROCEDURE ActualizarRol(
    IN p_ID_Rol INT,
    IN p_Descripcion VARCHAR(100)
)
BEGIN
    UPDATE Roles SET Descripcion = p_Descripcion WHERE ID_Rol = p_ID_Rol;
END //
DELIMITER ;

-- sp: eliminar rol
Drop PROCEDURE EliminarRol;
-- Modifica tu procedimiento almacenado EliminarRol
DELIMITER //
CREATE PROCEDURE EliminarRol(
    IN p_ID_Rol INT
)
SQL SECURITY DEFINER -- Define el usuario que ejecuta el procedimiento como el creador (root)
BEGIN
    DECLARE rollback_action BOOLEAN DEFAULT 0;
    -- Configurar manejador de errores
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
        SET rollback_action = 1;
    -- Iniciar transacción
    START TRANSACTION;
    -- Lógica del procedimiento
    BEGIN
        -- Lógica del procedimiento
        DELETE FROM Roles WHERE ID_Rol = p_ID_Rol;
    END;
    -- Comprobar si se produjo un error
    IF rollback_action THEN
        -- Revertir transacción en caso de error
        ROLLBACK;
        -- Insertar en la tabla de errores usando el usuario root (definer)
        INSERT INTO Errores (Usuario, Sentencia_Incorrecta, IP, Fecha_Hora, Motivo_Error)
        VALUES ('UsuarioReportes', 'DELETE ROLE', 'IP_Donde_Fue_Disparada', NOW(), 'Error al eliminar el rol');
        -- Lanzar una excepción personalizada
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error al eliminar el rol. Consulta la tabla de errores para más detalles.';
    ELSE
        -- Confirmar transacción si no hay errores
        COMMIT;
    END IF;
END//
DELIMITER ;


-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
--                                     Habilidades
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- SP: Crear una Habilidad
DELIMITER //
CREATE PROCEDURE CrearHabilidad(
    IN p_Descripcion VARCHAR(255),
    IN p_Nivel_Dificultad INT
)
BEGIN
    INSERT INTO Habilidades (Descripcion, Nivel_Dificultad)
    VALUES (p_Descripcion, p_Nivel_Dificultad);
END //
DELIMITER ;

-- SP: Actualizar una Habilidad
DELIMITER //
CREATE PROCEDURE ActualizarHabilidad(
    IN p_ID_Habilidad INT,
    IN p_Descripcion VARCHAR(255),
    IN p_Nivel_Dificultad INT
)
BEGIN
    UPDATE Habilidades
    SET
        Descripcion = p_Descripcion,
        Nivel_Dificultad = p_Nivel_Dificultad
    WHERE ID_Habilidad = p_ID_Habilidad;
END //
DELIMITER ;

-- SP: Eliminar una Habilidad
DELIMITER //
CREATE PROCEDURE EliminarHabilidad(IN p_ID_Habilidad INT)
BEGIN
    DELETE FROM Habilidades WHERE ID_Habilidad = p_ID_Habilidad;
END //
DELIMITER ;

-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- Empleados
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

-- Sp: Crear un Empleado
DELIMITER //
CREATE PROCEDURE CrearEmpleado(
    IN p_Nombre VARCHAR(255),
    IN p_Correo_Electronico VARCHAR(255),
    IN p_Rol_ID INT
)
BEGIN
    INSERT INTO Empleados (Nombre, Correo_Electronico, Rol_ID)
    VALUES (p_Nombre, p_Correo_Electronico, p_Rol_ID);
END //
DELIMITER ;

-- Sp: Actualizar un Empleado
DELIMITER //
CREATE PROCEDURE ActualizarEmpleado(
    IN p_ID_Empleado INT,
    IN p_Nombre VARCHAR(255),
    IN p_Correo_Electronico VARCHAR(255),
    IN p_Rol_ID INT
)
BEGIN
    UPDATE Empleados
    SET
        Nombre = p_Nombre,
        Correo_Electronico = p_Correo_Electronico,
        Rol_ID = p_Rol_ID
    WHERE ID_Empleado = p_ID_Empleado;
END //
DELIMITER ;

-- Sp: Eliminar empleado
DELIMITER //
CREATE PROCEDURE EliminarEmpleado(IN p_ID_Empleado INT)
BEGIN
    DELETE FROM Empleados WHERE ID_Empleado = p_ID_Empleado;
END //
DELIMITER ;

-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- Clientes
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- SP: crear cliente.
DELIMITER //
CREATE PROCEDURE CrearCliente(
    IN p_Nombre VARCHAR(255),
    IN p_Cedula VARCHAR(10),
    IN p_Telefono VARCHAR(10),
    IN p_Correo_Electronico VARCHAR(255)
)
BEGIN
    INSERT INTO Clientes (Nombre, Cedula, Telefono, Correo_Electronico)
    VALUES (p_Nombre, p_Cedula, p_Telefono, p_Correo_Electronico);
END //
DELIMITER ;

-- SP: Actualizar cliente
DELIMITER //
CREATE PROCEDURE ActualizarCliente(
    IN p_ID_Cliente INT,
    IN p_Nombre VARCHAR(255),
    IN p_Cedula VARCHAR(10),
    IN p_Telefono VARCHAR(10),
    IN p_Correo_Electronico VARCHAR(255)
)
BEGIN
    UPDATE Clientes
    SET
        Nombre = p_Nombre,
        Cedula = p_Cedula,
        Telefono = p_Telefono,
        Correo_Electronico = p_Correo_Electronico
    WHERE ID_Cliente = p_ID_Cliente;
END //
DELIMITER ;

-- SP: Eliminar cliente
DELIMITER //
CREATE PROCEDURE EliminarCliente(IN p_ID_Cliente INT)
BEGIN
    DELETE FROM Clientes WHERE ID_Cliente = p_ID_Cliente;
END //
DELIMITER ;

-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- Requisitos
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- sp: Crear un requisito
DELIMITER //
CREATE PROCEDURE CrearRequisitoCliente(
    IN p_Descripcion TEXT,
    IN p_Tipo ENUM('Funcional', 'No Funcional'),
    IN p_ID_Proyecto INT
)
BEGIN
    INSERT INTO Requisitos_Cliente (Descripcion, Tipo, ID_Proyecto)
    VALUES (p_Descripcion, p_Tipo, p_ID_Proyecto);
END //
DELIMITER ;

-- sp: Actualizar un requisito
DELIMITER //
CREATE PROCEDURE ActualizarRequisitoCliente(
    IN p_ID_Requisito INT,
    IN p_Descripcion TEXT,
    IN p_Tipo ENUM('Funcional', 'No Funcional'),
    IN p_ID_Proyecto INT
)
BEGIN
    UPDATE Requisitos_Cliente
    SET
        Descripcion = p_Descripcion,
        Tipo = p_Tipo,
        ID_Proyecto = p_ID_Proyecto
    WHERE ID_Requisito = p_ID_Requisito;
END //
DELIMITER ;

-- sp: Eliminastes un requisito
DELIMITER //
CREATE PROCEDURE EliminarRequisitoCliente(IN p_ID_Requisito INT)
BEGIN
    DELETE FROM Requisitos_Cliente WHERE ID_Requisito = p_ID_Requisito;
END //
DELIMITER ;

-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- Proyectos
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- sp: Crear un proyecto
DELIMITER //
CREATE PROCEDURE CrearProyecto(
    IN p_Nombre VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_Fecha_Inicio DATE,
    IN p_Fecha_Fin DATE,
    IN p_Estado VARCHAR(50),
    IN p_ID_Cliente INT
)
BEGIN
    INSERT INTO Proyectos (Nombre, Descripcion, Fecha_Inicio, Fecha_Fin, Estado, ID_Cliente)
    VALUES (p_Nombre, p_Descripcion, p_Fecha_Inicio, p_Fecha_Fin, p_Estado, p_ID_Cliente);
END //
DELIMITER ;

-- sp: Actualizar un proyecto
DELIMITER //
CREATE PROCEDURE ActualizarProyecto(
    IN p_ID_Proyecto INT,
    IN p_Nombre VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_Fecha_Inicio DATE,
    IN p_Fecha_Fin DATE,
    IN p_Estado VARCHAR(50),
    IN p_ID_Cliente INT
)
BEGIN
    UPDATE Proyectos
    SET
        Nombre = p_Nombre, Descripcion = p_Descripcion, Fecha_Inicio = p_Fecha_Inicio, Fecha_Fin = p_Fecha_Fin, Estado = p_Estado, ID_Cliente = p_ID_Cliente
    WHERE ID_Proyecto = p_ID_Proyecto;
END //
DELIMITER ;

-- sp: Eliminar un proyecto
DELIMITER //
CREATE PROCEDURE EliminarProyecto(IN p_ID_Proyecto INT)
BEGIN
    DELETE FROM Proyectos WHERE ID_Proyecto = p_ID_Proyecto;
END //
DELIMITER ;

-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- Tareas
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

-- sp: Crear una tarea
DELIMITER //
CREATE PROCEDURE CrearTarea(
    IN p_Descripcion TEXT,
    IN p_Estado VARCHAR(50),
    IN p_Fecha_Inicio DATE,
    IN p_Fecha_Fin DATE,
    IN p_ID_Empleado INT,
    IN p_ID_Proyecto INT
)
BEGIN
    INSERT INTO Tareas (Descripcion, Estado, Fecha_Inicio, Fecha_Fin, ID_Empleado, ID_Proyecto)
    VALUES (p_Descripcion, p_Estado, p_Fecha_Inicio, p_Fecha_Fin, p_ID_Empleado, p_ID_Proyecto);
END //
DELIMITER ;

-- sp: Actualizar una tarea
DELIMITER //
CREATE PROCEDURE ActualizarTarea(
    IN p_ID_Tarea INT,
    IN p_Descripcion TEXT,
    IN p_Estado VARCHAR(50),
    IN p_Fecha_Inicio DATE,
    IN p_Fecha_Fin DATE,
    IN p_ID_Empleado INT,
    IN p_ID_Proyecto INT
)
BEGIN
    UPDATE Tareas
    SET Descripcion = p_Descripcion,
        Estado = p_Estado,
        Fecha_Inicio = p_Fecha_Inicio,
        Fecha_Fin = p_Fecha_Fin,
        ID_Empleado = p_ID_Empleado,
        ID_Proyecto = p_ID_Proyecto
    WHERE ID_Tarea = p_ID_Tarea;
END//
DELIMITER ;

-- sp: Eliminar una tarea
DELIMITER //
CREATE PROCEDURE EliminarTarea(IN p_ID_Tarea INT)
BEGIN
    DELETE FROM Tareas WHERE ID_Tarea = p_ID_Tarea;
END//
DELIMITER ;


-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
-- Vistas
-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

-- Vista de Tareas Asignadas a un Empleado
CREATE VIEW Vista_Tareas_Empleados AS
SELECT T.ID_Tarea, T.Descripcion AS Descripcion_Tarea, T.Estado, T.Fecha_Inicio, T.Fecha_Fin, E.Nombre AS Responsable, P.Nombre AS Proyecto
FROM Tareas T
JOIN Empleados E ON T.ID_Empleado = E.ID_Empleado
JOIN Proyectos P ON T.ID_Proyecto = P.ID_Proyecto;

-- Vista de Proyectos y Requisitos del Cliente
CREATE VIEW Vista_Detalles_Proyectos AS
SELECT P.ID_Proyecto, P.Nombre AS Nombre_Proyecto, P.Estado, C.Nombre AS Nombre_Cliente, RC.Tipo AS Tipo_Requisito, RC.Descripcion AS Requisito_Cliente
FROM Proyectos P
INNER JOIN Clientes C ON P.ID_Cliente = C.ID_Cliente
LEFT JOIN Requisitos_Cliente RC ON P.ID_Proyecto = RC.ID_Proyecto;

-- Vista de Empleados y sus Habilidades
CREATE VIEW Vista_Detalles_Empleado AS
SELECT E.ID_Empleado, E.Nombre AS Nombre_Empleado, E.Correo_Electronico, R.Descripcion AS Rol, GROUP_CONCAT(H.Descripcion SEPARATOR ', ') AS Habilidades
FROM Empleados E
INNER JOIN Roles R ON E.Rol_ID = R.ID_Rol
LEFT JOIN Empleado_Habilidad EH ON E.ID_Empleado = EH.ID_Empleado
LEFT JOIN Habilidades H ON EH.ID_Habilidad = H.ID_Habilidad
GROUP BY E.ID_Empleado;



