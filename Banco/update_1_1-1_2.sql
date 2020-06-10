create table nota_empregado
(
    id_nota_empregado int auto_increment
        primary key,
    id_usuario        int not null,
    nota              int not null,
    constraint nota_empregado_empregado
        foreign key (id_usuario) references empregado (id_usuario)
);

create table nota_servico
(
    id_nota_servico int auto_increment
        primary key,
    id_servico      int not null,
    nota            int not null,
    constraint nota_servico_servico
        foreign key (id_servico) references servico (id_servico)
);

