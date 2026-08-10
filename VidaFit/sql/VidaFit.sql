SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS VidaFit_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE VidaFit_db;

CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT,
    nombre_rol VARCHAR(50) NOT NULL,

    CONSTRAINT pk_roles  PRIMARY KEY (id_rol),

    CONSTRAINT uk_roles_nombre UNIQUE (nombre_rol)
);

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT,
    nombre_completo VARCHAR(150) NOT NULL,
    username   VARCHAR(80)  NOT NULL UNIQUE,
    correo VARCHAR(150) NOT NULL,
    contrasenna VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_usuarios PRIMARY KEY (id_usuario),

    CONSTRAINT uk_usuarios_correo UNIQUE (correo),

    CONSTRAINT fk_usuarios_roles FOREIGN KEY (id_rol) REFERENCES roles (id_rol)
);

CREATE TABLE expedientes (
    id_expediente INT AUTO_INCREMENT,
    id_paciente INT NOT NULL,
    historial_medico  VARCHAR(350) NOT NULL,
    condiciones_medicas VARCHAR(150) NOT NULL,
    alergias  VARCHAR(150) NOT NULL,
    discapacidades  VARCHAR(150) NOT NULL,
    observaciones  VARCHAR(150) NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_expedientes PRIMARY KEY (id_expediente),

    CONSTRAINT uk_expedientes_paciente UNIQUE (id_paciente),

    CONSTRAINT fk_expedientes_pacientes FOREIGN KEY (id_paciente) REFERENCES usuarios (id_usuario)
);

CREATE TABLE planes_nutricionales (
    id_plan INT AUTO_INCREMENT,
    id_profesional INT NOT NULL,
    id_paciente INT NOT NULL,
    calorias_diarias INT,
    recomendaciones  VARCHAR(150) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE,

    CONSTRAINT pk_planes_nutricionales PRIMARY KEY (id_plan),

    CONSTRAINT fk_planes_profesional FOREIGN KEY (id_profesional) REFERENCES usuarios (id_usuario),

    CONSTRAINT fk_planes_paciente FOREIGN KEY (id_paciente) REFERENCES usuarios (id_usuario)
);

CREATE TABLE plan_comidas (
    id_comida INT AUTO_INCREMENT,
    id_plan INT NOT NULL,
    nombre_comida VARCHAR(100) NOT NULL,
    imagen  VARCHAR(150),
    horario TIME,
    descripcion_alimentos TEXT NOT NULL,

    CONSTRAINT pk_plan_comidas PRIMARY KEY (id_comida),

    CONSTRAINT fk_comidas_plan  FOREIGN KEY (id_plan) REFERENCES planes_nutricionales (id_plan) ON DELETE CASCADE
);

CREATE TABLE rutinas (
    id_rutina INT AUTO_INCREMENT,
    id_profesional INT NOT NULL,
    id_paciente INT NOT NULL,
    frecuencia_semanal INT NOT NULL,
    duracion_total INT,

    CONSTRAINT pk_rutinas PRIMARY KEY (id_rutina),

    CONSTRAINT fk_rutinas_profesional FOREIGN KEY (id_profesional) REFERENCES usuarios (id_usuario),

    CONSTRAINT fk_rutinas_paciente   FOREIGN KEY (id_paciente) REFERENCES usuarios (id_usuario)

);

CREATE TABLE ejercicios (
    id_ejercicio INT AUTO_INCREMENT,
    nombre_ejercicio VARCHAR(100) NOT NULL,
    descripcion TEXT,
    video  VARCHAR(150),

    CONSTRAINT pk_ejercicios PRIMARY KEY (id_ejercicio)

);

CREATE TABLE detalle_rutina (
    id_detalle INT AUTO_INCREMENT,
    id_rutina INT NOT NULL,
    id_ejercicio INT NOT NULL,
    series INT NOT NULL,
    repeticiones INT NOT NULL,

    CONSTRAINT pk_detalle_rutina PRIMARY KEY (id_detalle),

    CONSTRAINT fk_detalle_rutina FOREIGN KEY (id_rutina)REFERENCES rutinas (id_rutina)ON DELETE CASCADE,

    CONSTRAINT fk_detalle_ejercicio FOREIGN KEY (id_ejercicio) REFERENCES ejercicios (id_ejercicio),

    CONSTRAINT uk_rutina_ejercicio UNIQUE (id_rutina, id_ejercicio)

);

CREATE TABLE registro_progreso (
    id_progreso INT AUTO_INCREMENT,
    id_paciente INT NOT NULL,
    peso_kg DECIMAL(5,2),
    altura_m DECIMAL(3,2),
    imc DECIMAL(5,2),
    peso_ideal DECIMAL(5,2),
    estado_nutricional VARCHAR(50),
    medidas_corporales VARCHAR(150),
    observaciones_paciente VARCHAR(50),
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_registro_progreso PRIMARY KEY (id_progreso),

    CONSTRAINT fk_progreso_paciente FOREIGN KEY (id_paciente) REFERENCES usuarios (id_usuario)

);
COMMIT;

--Se asignan los roles por defecto.
INSERT INTO roles (nombre_rol) VALUES ('Paciente');
INSERT INTO roles (nombre_rol) VALUES ('Profesional');


