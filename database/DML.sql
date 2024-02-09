-- SELECT, INSER, UPDATE, DELETE.
-- Insercion de datos de prueba

INSERT INTO Roles (Descripcion) VALUES
('Desarrollador'),
('Diseñador'),
('Gerente de Proyecto');

INSERT INTO Habilidades (Descripcion, Nivel_Dificultad) VALUES
('Programación en Java', 3),
('Diseño UX/UI', 2),
('Gestión de Proyectos', 4);

INSERT INTO Empleados (Nombre, Correo_Electronico, Rol_ID) VALUES
('Jeyner Manzaba', 'jomanzaba@espe.edu.ec', 3),
('Mario Pazmiño', 'mpazmiño@espe.edu.ec', 1),
('Nataly Pacheco', 'nmpacheco1@espe.edu.ec', 2);

INSERT INTO Clientes (Nombre, Cedula, Telefono, Correo_Electronico) VALUES
('Espe SD', '1234567890', '0990206287', 'info@empresa.com'),
('Aldean supermercados', '0987654321', '0990206287', 'contacto@cliente.com'),
('La feria', '5678901234', '0321456987', 'info@institucion1.org');

INSERT INTO Proyectos (Nombre, Descripcion, Fecha_Inicio, Fecha_Fin, Estado, ID_Cliente) VALUES
('Proyecto Web', 'Desarrollo de un sitio web corporativo', '2023-01-15', '2023-06-30', 'En Progreso', 1),
('Sistema de Inventario', 'Desarrollo de un sistema de inventario', '2023-02-01', '2023-07-31', 'Planificado', 2),
('App Móvil', 'Desarrollo de una aplicación móvil', '2023-03-10', '2023-09-15', 'En Proceso de Evaluación', 3);

INSERT INTO Tareas (Descripcion, Estado, Fecha_Inicio, Fecha_Fin, ID_Empleado, ID_Proyecto) VALUES
('Diseño de interfaz de usuario', 'En Progreso', '2023-01-20', '2023-02-15', 3, 1),
('Programación de backend', 'Planificado', '2023-02-10', '2023-03-30', 1, 2),
('Evaluación de requisitos', 'En Proceso de Evaluación', '2023-03-20', '2023-04-15', 2, 3);

INSERT INTO Empleado_Habilidad (ID_Empleado, ID_Habilidad) VALUES
(1, 2),
(2, 3),
(3, 1);

INSERT INTO Requisitos_Cliente (Descripcion, Tipo, ID_Proyecto) VALUES
('Registro de usuarios', 'Funcional', 1),
('Seguridad y monitoreo de datos', 'No Funcional', 2),
('Compatibilidad con dispositivos', 'Funcional', 3);