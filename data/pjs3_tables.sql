create table annee
(
    annee int not null
        primary key
);

create table obesite
(
    Sexe          varchar(50)    not null,
    codePAys      varchar(50)    not null,
    annee         int            not null,
    IndiceObesite decimal(15, 2) null,
    primary key (Sexe, codePAys, annee)
);

create table obesite_totale
(
    codePAys    varchar(50)    not null,
    annee       int            not null,
    indiceTotal decimal(15, 2) null,
    primary key (codePAys, annee)
);

create table pays
(
    codePAys varchar(50) not null
        primary key,
    NomPays  varchar(50) null
);

create table sexe
(
    Sexe varchar(50) not null
        primary key
);