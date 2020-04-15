CREATE TABLE fotoservico(
	id_fotoservico integer AUTO_INCREMENT PRIMARY KEY,
    id_servico integer not null,
    caminho varchar(220) not null,
    FOREIGN KEY fotoservico_servico(id_servico) REFERENCES servico(id_servico)
),

ALTER TABLE servico DROP COLUMN foto;

ALTER TABLE `servico` ADD `status` VARCHAR(220) NOT NULL DEFAULT 'pendente' AFTER `id_usuario`;

ALTER TABLE `servico` ADD `motivo` VARCHAR(220) NULL DEFAULT NULL AFTER `status`;