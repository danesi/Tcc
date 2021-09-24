create table nota_empregado
(
    id_nota_empregado int auto_increment primary key,
    id_empregado      int not null,
    id_usuario        int NOT null,
    nota              decimal(2,1) not null,
    constraint notaEmpregado_empregado foreign key (id_empregado) references empregado (id_usuario),
    constraint notaEmpregado_usuario foreign key (id_usuario) references usuario (id_usuario)
);

create table nota_servico
(
    id_nota_servico int auto_increment primary key,
    id_servico      int not null,
    id_usuario      int NOT null,
    nota            decimal(2,1) not null,
    constraint notaSservico_servico foreign key (id_servico) references servico (id_servico),
    constraint notaSmpregado_usuario foreign key (id_usuario) references usuario (id_usuario)
);


ALTER TABLE `usuario` ADD `deletado` int(1) DEFAULT 0;

create table chat
(
    id_chat int auto_increment primary key,
    id_remetente      int not null,
    id_destinatario      int NOT null,
    is_midia  TINYINT,
    caminho_midia varchar(500),
    mensagem varchar(500),
    data_envio datetime,
    visualizado TINYINT,
        constraint chat_remetente foreign key (id_remetente) references usuario (id_usuario),
    constraint chat_destinatario foreign key (id_destinatario) references  usuario (id_usuario)
);

ALTER TABLE `servico` ADD `deletado` int(1) DEFAULT 0;