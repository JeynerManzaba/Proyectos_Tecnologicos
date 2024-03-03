-- CREATE, ALTER, DROP, RENAME

-- Crear la base de datos
DROP DATABASE IF EXISTS ProyectoGDB_Quinto;
GO

CREATE DATABASE ProyectoGDB_Quinto;
GO

-- Apuntar a la Base de Datos
USE ProyectoGDB_Quinto;
GO 
-- Creación de tablas
DROP TABLE IF EXISTS Roles;
CREATE TABLE Roles (
    ID_Rol INT IDENTITY(1,1) PRIMARY KEY,
    Descripcion VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS Habilidades;
CREATE TABLE Habilidades (
    ID_Habilidad INT IDENTITY(1,1) PRIMARY KEY,
    Descripcion VARCHAR(255) NOT NULL,
    Nivel_Dificultad INT NOT NULL
);

DROP TABLE IF EXISTS Empleados;
CREATE TABLE Empleados (
    ID_Empleado INT IDENTITY(1,1) PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Correo_Electronico VARCHAR(255) NOT NULL,
    Rol_ID INT NOT NULL,
    FOREIGN KEY (Rol_ID) REFERENCES Roles(ID_Rol)
);

DROP TABLE IF EXISTS Clientes;
CREATE TABLE Clientes (
    ID_Cliente INT IDENTITY(1,1) PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Cedula VARCHAR(10) NOT NULL,
    Telefono VARCHAR(10) NOT NULL,
    Correo_Electronico VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS Proyectos;
CREATE TABLE Proyectos (
    ID_Proyecto INT IDENTITY(1,1) PRIMARY KEY,
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
    ID_Tarea INT IDENTITY(1,1) PRIMARY KEY,
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

-- Crear la tabla Requisitos_Cliente
CREATE TABLE Requisitos_Cliente (
    ID_Requisito INT IDENTITY(1,1) PRIMARY KEY,
    Descripcion TEXT NOT NULL,
    Tipo VARCHAR(20) CHECK (Tipo IN ('Funcional', 'No Funcional')) NOT NULL,
    ID_Proyecto INT NOT NULL,
    FOREIGN KEY (ID_Proyecto) REFERENCES Proyectos(ID_Proyecto)
);

-- Procedimientos almacenados

-- Crear un rol
CREATE PROCEDURE CrearRol
    @p_Descripcion VARCHAR(100)
AS
BEGIN
    INSERT INTO Roles (Descripcion) VALUES (@p_Descripcion);
END;

-- Actualizar un rol
CREATE PROCEDURE ActualizarRol
    @p_ID_Rol INT,
    @p_Descripcion VARCHAR(100)
AS
BEGIN
    UPDATE Roles SET Descripcion = @p_Descripcion WHERE ID_Rol = @p_ID_Rol;
END;

-- Eliminar un rol
CREATE PROCEDURE EliminarRol
    @p_ID_Rol INT
AS
BEGIN
    DELETE FROM Roles WHERE ID_Rol = @p_ID_Rol;
END;

-- Crear una habilidad
CREATE PROCEDURE CrearHabilidad
    @p_Descripcion VARCHAR(255),
    @p_Nivel_Dificultad INT
AS
BEGIN
    INSERT INTO Habilidades (Descripcion, Nivel_Dificultad)
    VALUES (@p_Descripcion, @p_Nivel_Dificultad);
END;

-- Actualizar una habilidad
CREATE PROCEDURE ActualizarHabilidad
    @p_ID_Habilidad INT,
    @p_Descripcion VARCHAR(255),
    @p_Nivel_Dificultad INT
AS
BEGIN
    UPDATE Habilidades
    SET
        Descripcion = @p_Descripcion,
        Nivel_Dificultad = @p_Nivel_Dificultad
    WHERE ID_Habilidad = @p_ID_Habilidad;
END;

-- Eliminar una habilidad
CREATE PROCEDURE EliminarHabilidad
    @p_ID_Habilidad INT
AS
BEGIN
    DELETE FROM Habilidades WHERE ID_Habilidad = @p_ID_Habilidad;
END;

-- Crear un empleado
CREATE PROCEDURE CrearEmpleado
    @p_Nombre VARCHAR(255),
    @p_Correo_Electronico VARCHAR(255),
    @p_Rol_ID INT
AS
BEGIN
    INSERT INTO Empleados (Nombre, Correo_Electronico, Rol_ID)
    VALUES (@p_Nombre, @p_Correo_Electronico, @p_Rol_ID);
END;

-- Actualizar un empleado
CREATE PROCEDURE ActualizarEmpleado
    @p_ID_Empleado INT,
    @p_Nombre VARCHAR(255),
    @p_Correo_Electronico VARCHAR(255),
    @p_Rol_ID INT
AS
BEGIN
    UPDATE Empleados
    SET
        Nombre = @p_Nombre,
        Correo_Electronico = @p_Correo_Electronico,
        Rol_ID = @p_Rol_ID
    WHERE ID_Empleado = @p_ID_Empleado;
END;

-- Eliminar un empleado
CREATE PROCEDURE EliminarEmpleado
    @p_ID_Empleado INT
AS
BEGIN
    DELETE FROM Empleados WHERE ID_Empleado = @p_ID_Empleado;
END;

-- Crear un cliente
CREATE PROCEDURE CrearCliente
    @p_Nombre VARCHAR(255),
    @p_Cedula VARCHAR(10),
    @p_Telefono VARCHAR(10),
    @p_Correo_Electronico VARCHAR(255)
AS
BEGIN
    INSERT INTO Clientes (Nombre, Cedula, Telefono, Correo_Electronico)
    VALUES (@p_Nombre, @p_Cedula, @p_Telefono, @p_Correo_Electronico);
END;

-- Actualizar un cliente
CREATE PROCEDURE ActualizarCliente
    @p_ID_Cliente INT,
    @p_Nombre VARCHAR(255),
    @p_Cedula VARCHAR(10),
    @p_Telefono VARCHAR(10),
    @p_Correo_Electronico VARCHAR(255)
AS
BEGIN
    UPDATE Clientes
    SET
        Nombre = @p_Nombre,
        Cedula = @p_Cedula,
        Telefono = @p_Telefono,
        Correo_Electronico = @p_Correo_Electronico
    WHERE ID_Cliente = @p_ID_Cliente;
END;

-- Eliminar un cliente
CREATE PROCEDURE EliminarCliente
    @p_ID_Cliente INT
AS
BEGIN
    DELETE FROM Clientes WHERE ID_Cliente = @p_ID_Cliente;
END;

-- Crear un requisito
CREATE PROCEDURE CrearRequisitoCliente
    @p_Descripcion TEXT,
    @p_Tipo VARCHAR(20),
    @p_ID_Proyecto INT
AS
BEGIN
    INSERT INTO Requisitos_Cliente (Descripcion, Tipo, ID_Proyecto)
    VALUES (@p_Descripcion, @p_Tipo, @p_ID_Proyecto);
END;

-- Actualizar un requisito
CREATE PROCEDURE ActualizarRequisitoCliente
    @p_ID_Requisito INT,
    @p_Descripcion TEXT,
    @p_Tipo VARCHAR(20),
    @p_ID_Proyecto INT
AS
BEGIN
    UPDATE Requisitos_Cliente
    SET
        Descripcion = @p_Descripcion,
        Tipo = @p_Tipo,
        ID_Proyecto = @p_ID_Proyecto
    WHERE ID_Requisito = @p_ID_Requisito;
END;

-- Eliminar un requisito
CREATE PROCEDURE EliminarRequisitoCliente
    @p_ID_Requisito INT
AS
BEGIN
    DELETE FROM Requisitos_Cliente WHERE ID_Requisito = @p_ID_Requisito;
END;

-- Crear un proyecto
CREATE PROCEDURE CrearProyecto
    @p_Nombre VARCHAR(255),
    @p_Descripcion TEXT,
    @p_Fecha_Inicio DATE,
    @p_Fecha_Fin DATE,
    @p_Estado VARCHAR(50),
    @p_ID_Cliente INT
AS
BEGIN
    INSERT INTO Proyectos (Nombre, Descripcion, Fecha_Inicio, Fecha_Fin, Estado, ID_Cliente)
    VALUES (@p_Nombre, @p_Descripcion, @p_Fecha_Inicio, @p_Fecha_Fin, @p_Estado, @p_ID_Cliente);
END;

-- Actualizar un proyecto
CREATE PROCEDURE ActualizarProyecto
    @p_ID_Proyecto INT,
    @p_Nombre VARCHAR(255),
    @p_Descripcion TEXT,
    @p_Fecha_Inicio DATE,
    @p_Fecha_Fin DATE,
    @p_Estado VARCHAR(50),
    @p_ID_Cliente INT
AS
BEGIN
    UPDATE Proyectos
    SET
        Nombre = @p_Nombre, Descripcion = @p_Descripcion, Fecha_Inicio = @p_Fecha_Inicio, Fecha_Fin = @p_Fecha_Fin, Estado = @p_Estado, ID_Cliente = @p_ID_Cliente
    WHERE ID_Proyecto = @p_ID_Proyecto;
END;

-- Eliminar un proyecto
CREATE PROCEDURE EliminarProyecto
    @p_ID_Proyecto INT
AS
BEGIN
    DELETE FROM Proyectos WHERE ID_Proyecto = @p_ID_Proyecto;
END;

-- Crear una tarea
CREATE PROCEDURE CrearTarea
    @p_Descripcion TEXT,
    @p_Estado VARCHAR(50),
    @p_Fecha_Inicio DATE,
    @p_Fecha_Fin DATE,
    @p_ID_Empleado INT,
    @p_ID_Proyecto INT
AS
BEGIN
    INSERT INTO Tareas (Descripcion, Estado, Fecha_Inicio, Fecha_Fin, ID_Empleado, ID_Proyecto)
    VALUES (@p_Descripcion, @p_Estado, @p_Fecha_Inicio, @p_Fecha_Fin, @p_ID_Empleado, @p_ID_Proyecto);
END;

-- Actualizar una tarea
CREATE PROCEDURE ActualizarTarea
    @p_ID_Tarea INT,
    @p_Descripcion TEXT,
    @p_Estado VARCHAR(50),
    @p_Fecha_Inicio DATE,
    @p_Fecha_Fin DATE,
    @p_ID_Empleado INT,
    @p_ID_Proyecto INT
AS
BEGIN
    UPDATE Tareas
    SET Descripcion = @p_Descripcion,
        Estado = @p_Estado,
        Fecha_Inicio = @p_Fecha_Inicio,
        Fecha_Fin = @p_Fecha_Fin,
        ID_Empleado = @p_ID_Empleado,
        ID_Proyecto = @p_ID_Proyecto
    WHERE ID_Tarea = @p_ID_Tarea;
END;

-- Eliminar una tarea
CREATE PROCEDURE EliminarTarea
    @p_ID_Tarea INT
AS
BEGIN
    DELETE FROM Tareas WHERE ID_Tarea = @p_ID_Tarea;
END;

-- Vistas

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
-- Vista de Empleados y sus Habilidades
CREATE VIEW Vista_Detalles_Empleado AS
SELECT 
    E.ID_Empleado,
    E.Nombre AS Nombre_Empleado,
    E.Correo_Electronico,
    R.Descripcion AS Rol,
    STRING_AGG(H.Descripcion, ', ') AS Habilidades
FROM Empleados E
INNER JOIN Roles R ON E.Rol_ID = R.ID_Rol
LEFT JOIN Empleado_Habilidad EH ON E.ID_Empleado = EH.ID_Empleado
LEFT JOIN Habilidades H ON EH.ID_Habilidad = H.ID_Habilidad
GROUP BY 
    E.ID_Empleado,
    E.Nombre, 
    E.Correo_Electronico,
    R.Descripcion;
