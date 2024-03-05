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


DROP TABLE IF EXISTS MarcasAutos;
CREATE TABLE MarcasAutos (
    ID_Marca INT IDENTITY(1,1) PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS Autos;
CREATE TABLE Autos (
    ID_Auto INT IDENTITY(1,1) PRIMARY KEY,
    Modelo VARCHAR(255) NOT NULL,
    Año INT NOT NULL,
    Precio DECIMAL(18, 2) NOT NULL,
    ID_Marca INT NOT NULL,
    Stock INT NOT NULL,
    FOREIGN KEY (ID_Marca) REFERENCES MarcasAutos(ID_Marca) ON DELETE CASCADE
);

DROP TABLE IF EXISTS ComprasAutos;
CREATE TABLE ComprasAutos (
    ID_Compra INT IDENTITY(1,1) PRIMARY KEY,
    FechaCompra DATE NOT NULL,
    ID_Auto INT NOT NULL,
    ID_Cliente INT NOT NULL,
    CantidadComprada INT NOT NULL,
    PrecioTotal DECIMAL(18, 2) NOT NULL,
    FOREIGN KEY (ID_Auto) REFERENCES Autos(ID_Auto) ON DELETE CASCADE,
    FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID_Cliente) ON DELETE CASCADE
);

DROP TABLE IF EXISTS TiendasAutos;
CREATE TABLE TiendasAutos (
    ID_Tienda INT IDENTITY(1,1) PRIMARY KEY,
    Nombre VARCHAR(255) NOT NULL,
    Direccion VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS StockTiendas;
CREATE TABLE StockTiendas (
    ID_Tienda INT NOT NULL,
    ID_Auto INT NOT NULL,
    CantidadEnStock INT NOT NULL,
    PRIMARY KEY (ID_Tienda, ID_Auto),
    FOREIGN KEY (ID_Tienda) REFERENCES TiendasAutos(ID_Tienda) ON DELETE CASCADE,
    FOREIGN KEY (ID_Auto) REFERENCES Autos(ID_Auto) ON DELETE CASCADE
);

DROP TABLE IF EXISTS EmpleadosTiendas;
CREATE TABLE EmpleadosTiendas (
    ID_Empleado INT NOT NULL,
    ID_Tienda INT NOT NULL,
    PRIMARY KEY (ID_Empleado, ID_Tienda),
    FOREIGN KEY (ID_Empleado) REFERENCES Empleados(ID_Empleado) ON DELETE CASCADE,
    FOREIGN KEY (ID_Tienda) REFERENCES TiendasAutos(ID_Tienda) ON DELETE CASCADE
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

-- Crear una Tienda
CREATE PROCEDURE CrearTienda
    @p_Nombre VARCHAR(255),
    @p_Direccion VARCHAR(255)
AS
BEGIN
    INSERT INTO TiendasAutos (Nombre, Direccion) VALUES (@p_Nombre, @p_Direccion);
END;

-- Actualizar una Tienda
CREATE PROCEDURE ActualizarTienda
    @p_ID_Tienda INT,
    @p_Nombre VARCHAR(255),
    @p_Direccion VARCHAR(255)
AS
BEGIN
    UPDATE TiendasAutos SET Nombre = @p_Nombre, Direccion = @p_Direccion WHERE ID_Tienda = @p_ID_Tienda;
END;

-- Eliminar una Tienda
CREATE PROCEDURE EliminarTienda
    @p_ID_Tienda INT
AS
BEGIN
    DELETE FROM TiendasAutos WHERE ID_Tienda = @p_ID_Tienda;
END;

--Craer una marca
CREATE PROCEDURE CrearMarca
    @p_Nombre VARCHAR(255)
AS
BEGIN
    INSERT INTO MarcasAutos (Nombre)
    VALUES (@p_Nombre);
END;

--Actualizar una marca
CREATE PROCEDURE ActualizarMarcaAuto
    @p_ID_Marca INT,
    @p_Nombre VARCHAR(255)
AS
BEGIN
    UPDATE MarcasAutos
    SET Nombre = @p_Nombre
    WHERE ID_Marca = @p_ID_Marca;
END;

-- Eliminar una marca
CREATE PROCEDURE EliminarMarcaAuto
    @p_ID_Marca INT
AS
BEGIN
    DELETE FROM MarcasAutos
    WHERE ID_Marca = @p_ID_Marca;
END;


-- Crear un auto
CREATE PROCEDURE CrearAuto
    @p_Modelo VARCHAR(255),
    @p_Año INT,
    @p_Precio DECIMAL(18, 2),
    @p_ID_Marca INT,
    @p_Stock INT
AS
BEGIN
    INSERT INTO Autos (Modelo, Año, Precio, ID_Marca, Stock)
    VALUES (@p_Modelo, @p_Año, @p_Precio, @p_ID_Marca, @p_Stock);
END;

-- Actualizar un auto
CREATE PROCEDURE ActualizarAuto
    @p_ID_Auto INT,
    @p_Modelo VARCHAR(255),
    @p_Año INT,
    @p_Precio DECIMAL(18, 2),
    @p_ID_Marca INT,
    @p_Stock INT
AS
BEGIN
    UPDATE Autos
    SET Modelo = @p_Modelo, Año = @p_Año, Precio = @p_Precio, ID_Marca = @p_ID_Marca, Stock = @p_Stock
    WHERE ID_Auto = @p_ID_Auto;
END;

-- Eliminar un auto
CREATE PROCEDURE EliminarAuto
    @p_ID_Auto INT
AS
BEGIN
    DELETE FROM Autos WHERE ID_Auto = @p_ID_Auto;
END;


-- Vistas
-- Vista de Tareas Asignadas a un Empleado
CREATE VIEW Vista_Tareas_Empleados AS
SELECT T.ID_Tarea, T.Descripcion AS Descripcion_Tarea, T.Estado, T.Fecha_Inicio, T.Fecha_Fin, E.Nombre AS Responsable, P.Nombre AS Proyecto
FROM Tareas T
JOIN Empleados E ON T.ID_Empleado = E.ID_Empleado
JOIN Proyectos P ON T.ID_Proyecto = P.ID_Proyecto;


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
