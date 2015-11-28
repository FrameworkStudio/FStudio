/************ Update: Tables ***************/

/******************** Add Table: bitacora ************************/

/* Build Table Structure */
CREATE TABLE bitacora
(
	id BIGINT NOT NULL,
	usuario_id BIGINT NOT NULL,
	accion VARCHAR(80) NOT NULL,
	tabla VARCHAR(80) NOT NULL,
	registro BIGINT NULL,
	observacion VARCHAR(1024) NULL,
	fecha TIMESTAMP DEFAULT now() NOT NULL
);


/******************** Add Table: credencial ************************/

/* Build Table Structure */
CREATE TABLE credencial
(
	id BIGINT NOT NULL,
	nombre VARCHAR(80) NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	updated_at TIMESTAMP NULL,
	deleted_at TIMESTAMP NULL
);

/* Add Primary Key */
ALTER TABLE credencial ADD CONSTRAINT pkcredencial
	PRIMARY KEY (id);

/******************** Add Table: dato_usuario ************************/

/* Build Table Structure */
CREATE TABLE dato_usuario
(
	id BIGINT NOT NULL,
	usuario_id BIGINT NOT NULL,
	cedula VARCHAR(20) NOT NULL,
	nombre VARCHAR(80) NOT NULL,
	apellidos VARCHAR(80) NOT NULL,
	movil VARCHAR(12) NOT NULL,
	correo VARCHAR(120) NOT NULL,
	imagen VARCHAR(36) NULL,
	sexo BOOL NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	updated_at TIMESTAMP NULL,
	deleted_at TIMESTAMP NULL
);

/* Add Primary Key */
ALTER TABLE dato_usuario ADD CONSTRAINT pkdato_usuario
	PRIMARY KEY (id);



/******************** Add Table: password_recovery ************************/

/* Build Table Structure */
CREATE TABLE password_recovery
(
	id BIGINT NOT NULL,
	usuario_id BIGINT NOT NULL,
	hash VARCHAR(32) NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL
);

/* Add Primary Key */
ALTER TABLE password_recovery ADD CONSTRAINT pkpassword_recovery
	PRIMARY KEY (id);

/******************** Add Table: recordar_me ************************/

/* Build Table Structure */
CREATE TABLE recordar_me
(
	id BIGINT  NOT NULL,
	usuario_id BIGINT NOT NULL,
	ip_address VARCHAR(50) NOT NULL,
	hash_cookie VARCHAR(32) NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL
);

/* Add Primary Key */
ALTER TABLE recordar_me ADD CONSTRAINT pkrecordar_me
	PRIMARY KEY (id);

/******************** Add Table: usuario ************************/

/* Build Table Structure */
CREATE TABLE usuario
(
	id BIGINT NOT NULL,
	user_name VARCHAR(80) NOT NULL,
	password VARCHAR(32) NOT NULL,
	actived BOOL NOT NULL,
	last_login_at TIMESTAMP NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL,
	updated_at TIMESTAMP NULL,
	deleted_at TIMESTAMP NULL
);

/* Add Primary Key */
ALTER TABLE usuario ADD CONSTRAINT pkusuario
	PRIMARY KEY (id);

/******************** Add Table: usuario_credencial ************************/

/* Build Table Structure */
CREATE TABLE usuario_credencial
(
	id BIGINT NOT NULL,
	usuario_id BIGINT NOT NULL,
	credencial_id BIGINT NOT NULL,
	created_at TIMESTAMP DEFAULT now() NOT NULL
);

/* Add Primary Key */
ALTER TABLE usuario_credencial ADD CONSTRAINT pkusuario_credencial
	PRIMARY KEY (id);

