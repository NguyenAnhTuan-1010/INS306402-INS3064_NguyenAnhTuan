drop table if exists patients;
drop table if exists doctors;
drop table if exists medicines;
drop table if exists appointments;
drop table if exists prescriptions;
drop table if exists prescription_medicines;


create table patients (
    id int default auto_increment primary key,
    first_name varchar(36) not null,
    last_name varchar(36) not null,
    age int not null,
    sex boolean,
    phone_number varchar(12) not null
);

create table doctors (
    id int default auto_increment primary key,
    first_name varchar(36) not null,
    last_name varchar(36) not null,
    age int not null,
    phone_number varchar(12) not null,
    faculty enum("surgeon", "diagnose")
);

create table medicines (
    id int default auto_increment primary key,
    medicine_name varchar(20) not null,
    medicine_type varchar(10) unique not null,
    quantity int not null
);


create table prescriptions (
    id int default auto_increment primary key,
    
);

create table appointments (
    id int default auto_increment primary key,
    DoctorID int not null,
    PatientID int not null,
    PrescriptionID int not null, 

    foreign key prescriptions(DoctorID) references doctors(id) on delete cascade,
    foreign key prescriptions(PatientID) references patients(id) on delete cascade,
    foreign key appointments(PrescriptionID) references prescriptions(id) on delete cascade
);

create table prescription_medicines(
    id int default auto_increment primary key,
    PrescriptionID int not null,
    MedicineID int not null,
    dosage varchar(80) not null,
    frequency varchar(80) not null,

    foreign key prescription_medicines(PrescriptionID) references prescriptions(id) on delete cascade,
    foreign key prescription_medicines(MedicineID) references medicines(id) on delete cascade
);