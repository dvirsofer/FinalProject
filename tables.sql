  CREATE TABLE mbtm_workers.users_type(
    id INT NOT NULL AUTO_INCREMENT,
	user_type varchar(100) not null,
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
    );
 
 
 
 CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT,
    type_id INT not null,
    user_name VARCHAR(40) NOT NULL,
    user_password VARCHAR(40) NOT NULL,
    email VARCHAR(150) NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
	CONSTRAINT fk_type_id FOREIGN KEY (type_id)
	REFERENCES users_type(id)
);

create table mbtm_workers.settlement(
    id INT NOT NULL AUTO_INCREMENT,
    symbol int ,
    settlement_name varchar(100) ,
    settlement_name_in_english varchar(100) ,
    napa_name varchar(100) ,
    council_name varchar(100) ,
    latitude float,
    longitude float,
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)

    );


    create table mbtm_workers.tamat(
    id INT NOT NULL AUTO_INCREMENT,
    department_name varchar(100) ,
    department_number int ,
    address varchar(150) ,
    settlement_name varchar(100) ,
    contact_name varchar(100),
    position varchar(100),
    contact_phone varchar(100),
    department_main_phone int,
    department_secundery_phone int,
    department_fax_number int,
    email varchar(100),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)

    );


    create table mbtm_workers.ministry_of_interior(
    id INT NOT NULL AUTO_INCREMENT,
    department_name varchar(100) ,
    department_number int ,
    address varchar(150) ,
    settlement_name varchar(100) ,
    contact_name varchar(100),
    position varchar(100),
    contact_phone varchar(100),
    department_main_phone int,
    department_secundery_phone int,
    department_fax_number int,
    email varchar(100),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)

    );






  CREATE TABLE mbtm_workers.customer(
    id INT NOT NULL AUTO_INCREMENT,
	customer_name varchar(100) not null,
    name_in_english varchar(100) not null,
    company_number varchar(40) not null,
    settlement_id int,
    responsible_id int,
    tamat_symbol int ,
    ministry_of_economics int ,
    ministry_of_interior int ,
    note varchar(200),
    opening_date date,
    bookkeeping_number int,
    workers_amount_update_date date,
    main_customer bool,
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    CONSTRAINT fk_settlement_id FOREIGN KEY (settlement_id)
	REFERENCES settlement(id),
    CONSTRAINT fk_responsible_id FOREIGN KEY (responsible_id)
	REFERENCES users(id),
    CONSTRAINT fk_tamat_symbol_id FOREIGN KEY (ministry_of_economics)
	REFERENCES tamat(id),
    CONSTRAINT fk_ministry_of_interior_id FOREIGN KEY (ministry_of_interior)
	REFERENCES ministry_of_interior(id)

    );


        CREATE TABLE mbtm_workers.contacts(
    id INT NOT NULL AUTO_INCREMENT,
    customer_id int not null,
	contact_name varchar(100),
    positon varchar (100),
    phone_number int,
    email varchar(100),
    fax int,
    fax_to_email  varchar(100),
    comment varchar(200),
    distribution bool,
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    CONSTRAINT fk_customer_id FOREIGN KEY (customer_id)
	REFERENCES customer(id)
    );


          CREATE TABLE mbtm_workers.visas(
    id INT NOT NULL AUTO_INCREMENT,
    customer_id int not null,
	year int,
    amount_of_visas int,
    comments varchar (200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    CONSTRAINT fk_customer_id_2 FOREIGN KEY (customer_id)
	REFERENCES customer(id)
    );


      CREATE TABLE mbtm_workers.forgen_workes(
    id INT NOT NULL AUTO_INCREMENT,
    worker_id int,
    last_name varchar(150),
    first_name varchar(150),
    gender varchar (7),
    entrance_date date,
    form_of_eravel varchar(50),
    birth_country varchar(100),
    birthday_date date,
    responsible_id int,
    phone_number varchar(20),
    number_of_month_from_entrance int,
    sitizen varchar(200),
    inventation_number varchar(100),
	note varchar(200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
     CONSTRAINT fk_responsible_id_2 FOREIGN KEY (responsible_id)
	REFERENCES users(id)
    );



      CREATE TABLE mbtm_workers.passport(
    id INT NOT NULL AUTO_INCREMENT,
    worker_id int,
	passport_number varchar(50),
    validation_date date,
	note varchar(200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
     CONSTRAINT fk_worker_id FOREIGN KEY (worker_id)
	REFERENCES forgen_workes(id)
    );



    CREATE TABLE mbtm_workers.invitation(
    id INT NOT NULL AUTO_INCREMENT,
   customer_id int,
   invitation_create_date date,
   status varchar(100),
   change_status_date date,
   contract_open_date date,
   expected_arrival_date date,
   approved_arrival_date date,
   check_deposit bool,
   	forgen_workes_id int,
   paid bool,
   paid_via varchar(100),
	note varchar(200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),

     CONSTRAINT fk_customer_id_3 FOREIGN KEY (customer_id)
	REFERENCES customer(id),
    CONSTRAINT fk_forgen_workes_id FOREIGN KEY (forgen_workes_id)
	REFERENCES forgen_workes(id)
    );


            CREATE TABLE mbtm_workers.history(
    id INT NOT NULL AUTO_INCREMENT,
	forgen_workes_id int,
    employer_id int,
    from_date date,
    to_date date,
    working_field varchar (200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),

     CONSTRAINT fk_employer_id FOREIGN KEY (employer_id)
	REFERENCES customer(id),
    CONSTRAINT fk_forgen_workes_id_5 FOREIGN KEY (forgen_workes_id)
	REFERENCES forgen_workes(id)
    );


            CREATE TABLE mbtm_workers.transportation (
    id INT NOT NULL AUTO_INCREMENT,
	forgen_workes_id int,
    from_employer_id int,
    to_employer_id int,
   start_date date,
    end_date date,
    approval bool,
    note varchar(200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),

     CONSTRAINT fk_from_employer_id FOREIGN KEY (from_employer_id)
	REFERENCES customer(id),
      CONSTRAINT fk_to_employer_id FOREIGN KEY (to_employer_id)
	REFERENCES customer(id),
    CONSTRAINT fk_forgen_workes_id_6 FOREIGN KEY (forgen_workes_id)
	REFERENCES forgen_workes(id)
    );


  CREATE TABLE mbtm_workers.insurance (
    id INT NOT NULL AUTO_INCREMENT,
	forgen_workes_id int,
    employer_id int,
    insurance_compony varchar(100),
    insurance_number varchar (20),
    start_insurance date,
    end_insurance date,
    card_id varchar(100),
    insurance_type varchar(100),
    note varchar(200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
          CONSTRAINT fk_employer_id_8 FOREIGN KEY (employer_id)
	REFERENCES customer(id),

    CONSTRAINT fk_forgen_workes_id_7 FOREIGN KEY (forgen_workes_id)
	REFERENCES forgen_workes(id)
    );


             CREATE TABLE mbtm_workers.supplier(
    id INT NOT NULL AUTO_INCREMENT,
    supplier_id int not null,
	contact_name varchar(100),
    company_code varchar (100),
    phone_number int,
    email varchar(100),
    fax int,
    fax_to_email  varchar(100),
    note varchar(200),
    read_premition int,
    write_premition int,
	create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id)

    );