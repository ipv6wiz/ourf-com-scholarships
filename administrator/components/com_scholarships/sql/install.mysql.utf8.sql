DROP TABLE IF EXISTS `#__scholarships`;

CREATE TABLE `#__scholarships` (
                                     `id`       INT     NOT NULL AUTO_INCREMENT,
                                     `scholarship_year` VARCHAR(4) NOT NULL,
                                     `scholarship_recipient` VARCHAR(50) NOT NULL,
                                     `scholarship_fk_scholarship_status` INT DEFAULT 1,
                                     `scholarship_fk_scholarship_college` INT DEFAULT 1,
                                     `scholarship_fk_scholarship_department` INT DEFAULT 1,
                                     `scholarship_topic` TEXT,
                                     `scholarship_employment` TEXT,
                                     `scholarship_abstract_pdf` VARCHAR(100),
                                     `scholarship_abstract_title` VARCHAR(100),
                                     `scholarship_profile_pdf` VARCHAR(100),
                                     `scholarship_sponsor_member` TINYINT NOT NULL DEFAULT 0,
                                     `state` TINYINT NOT NULL DEFAULT 1,
                                     `ordering` INT DEFAULT 10,
                                     `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                     `language` char(7) NOT NULL DEFAULT '',
                                     `created_by` int unsigned NOT NULL DEFAULT 1,
                                     `created_by_alias` varchar(255) NOT NULL DEFAULT '',
                                     `modified` datetime NULL,
                                     `modified_by` int unsigned NOT NULL DEFAULT 1,
                                     `version` int unsigned NOT NULL DEFAULT 1,
                                     `catid` int unsigned NOT NULL DEFAULT 1,
                                     `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
                                     `scholarship_fk_color` int unsigned not null,
                                     `scholarship_year_graduated` varchar(4),
                                     `scholarship_fk_opt_item_gender` int unsigned default 1,
                                     `scholarship_fk_opt_item_imp_org` int unsigned default 1,
                                     `scholarship_student_photo_url` varchar(255),
                                     `scholarship_student_home_town` varchar(150),
                                     `scholarship_student_cell_phone` varchar(50),
                                     `scholarship_student_email` varchar(100),
                                     `scholarship_fk_opt_item_emp_type` int unsigned default 1,
                                     PRIMARY KEY (`id`),
                                     KEY `idx_state` (`state`),
                                     KEY `idx_scholarships_catid` (`catid`),
                                     KEY `idx_language` (`language`)
)
    ENGINE =MyISAM
    AUTO_INCREMENT =0
    DEFAULT CHARSET =utf8;

DROP TABLE IF EXISTS `#__scholarship_colleges`;

CREATE TABLE `#__scholarship_colleges` (
                                             `id` INT NOT NULL AUTO_INCREMENT,
                                             `scholarship_college_name` VARCHAR(200) NOT NULL,
                                             `state` tinyint NOT NULL DEFAULT 1,
                                             `ordering` INT DEFAULT 10,
                                             `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                             `language` char(7) NOT NULL DEFAULT '',
                                             `created_by` int unsigned NOT NULL DEFAULT 1,
                                             `created_by_alias` varchar(255) NOT NULL DEFAULT '',
                                             `modified` datetime NULL,
                                             `modified_by` int unsigned NOT NULL DEFAULT 1,
                                             `version` int unsigned NOT NULL DEFAULT 1,
                                             `catid` int unsigned NOT NULL DEFAULT 1,
                                             `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
                                             PRIMARY KEY (`id`),
                                             KEY `idx_state` (`state`),
                                             KEY `idx_colleges_catid` (`catid`),
                                             KEY `idx_language` (`language`)
)
    ENGINE =MyISAM
    AUTO_INCREMENT =0
    DEFAULT CHARSET =utf8;

INSERT INTO `#__scholarship_colleges` (`scholarship_college_name`)
values ('Medan Area University'),
       ('Mulawarman University'),
       ('North Sumatra University'),
       ('Palangka Raya University'),
       ('Panca Bhakti University'),
       ('State University of Medan'),
       ('STIK Pante Kulu'),
       ('Syiah Kuala University'),
       ('Tanjungpura University'),
       ('UIN Ar-Raniry');

DROP TABLE IF EXISTS `#__scholarship_departments`;

CREATE TABLE `#__scholarship_departments`(
                                               `id` INT NOT NULL AUTO_INCREMENT,
                                               `scholarship_department_name` VARCHAR(200) NOT NULL,
                                               `state` tinyint NOT NULL DEFAULT 1,
                                               `ordering` INT DEFAULT 10,
                                               `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                               `language` char(7) NOT NULL DEFAULT '',
                                               `created_by` int unsigned NOT NULL DEFAULT 1,
                                               `created_by_alias` varchar(255) NOT NULL DEFAULT '',
                                               `modified` datetime NULL,
                                               `modified_by` int unsigned NOT NULL DEFAULT 1,
                                               `version` int unsigned NOT NULL DEFAULT 1,
                                               `catid` int unsigned NOT NULL DEFAULT 1,
                                               `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
                                               PRIMARY KEY (`id`),
                                               KEY `idx_state` (`state`),
                                               KEY `idx_depts_catid` (`catid`),
                                               KEY `idx_language` (`language`)
)
    ENGINE =MyISAM
    AUTO_INCREMENT =0
    DEFAULT CHARSET =utf8;

INSERT INTO `#__scholarship_departments` (`scholarship_department_name`)
values  ('Biology'),
        ('Elementary Education'),
        ('Forestry'),
        ('Geography Education'),
        ('International Studies'),
        ('Law'),
        ('Science & Technology'),
        ('Sociology Education'),
        ('Sociology of Politics and Social Sciences'),
        ('Veterinary Science');



DROP TABLE IF EXISTS `#__scholarship_status`;

CREATE TABLE `#__scholarship_status` (
                                           `id` INT NOT NULL AUTO_INCREMENT,
                                           `scholarship_status_option` VARCHAR(30) NOT NULL,
                                           `state` tinyint NOT NULL DEFAULT 1,
                                           `ordering` INT DEFAULT 10,
                                           `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                           `language` char(7) NOT NULL DEFAULT '',
                                           `created_by` int unsigned NOT NULL DEFAULT 1,
                                           `created_by_alias` varchar(255) NOT NULL DEFAULT '',
                                           `modified` datetime NULL,
                                           `modified_by` int unsigned NOT NULL DEFAULT 1,
                                           `version` int unsigned NOT NULL DEFAULT 1,
                                           PRIMARY KEY (`id`)
)
    ENGINE =MyISAM
    AUTO_INCREMENT =0
    DEFAULT CHARSET =utf8;

INSERT INTO `#__scholarship_status` (`scholarship_status_option`)
VALUES ('Still Studying'),
       ('Research in progress'),
       ('Graduated'),
       ('Research TBC');

DROP TABLE IF EXISTS `#__scholarship_year_colors`;
CREATE TABLE `#__scholarship_year_colors` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `fk_colors` INT NOT NULL ,
    `year` VARCHAR(4) NOT NULL,
    PRIMARY KEY (`id`),
    constraint scholarships_year_colors_id_uindex
        unique (id),
    constraint scholarships_year_colors_year_uindex
        unique (year)
)
    engine =MyISAM
    auto_increment =0
    default char set =utf8;

insert into `#__scholarship_year_colors` (id, fk_colors, year)
values  (1, 2, '2006'),
    (2, 3, '2007'),
    (3, 4, '2008'),
    (4, 5, '2009'),
    (5, 6, '2010'),
    (6, 7, '2011'),
    (7, 1, '2012'),
    (8, 2, '2013'),
    (9, 3, '2014'),
    (10, 4, '2015'),
    (11, 5, '2016'),
    (12, 6, '2017'),
    (13, 7, '2018'),
    (14, 1, '2019'),
    (15, 2, '2020'),
    (16, 3, '2021');

DROP TABLE IF EXISTS `#__scholarship_colors`;
CREATE TABLE `#__scholarship_colors` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `color` varchar(7) not null,
    `class` varchar(50) not null,
    `name` varchar(50) not null,
    PRIMARY KEY (`id`),
    constraint dev4_scholarship_colors_id_uindex
        unique (id)
)
    engine =MyISAM
    auto_increment =0
    default char set =utf8;

insert into `#__scholarship_colors` (id, color, class, name)
values  (1, '#cfe2ff', 'table-primary', 'Primary'),
    (2, '#e2e3e5', 'table-secondary', 'Secondary'),
    (3, '#d1e7dd', 'table-success', 'Success'),
    (4, '#f8d7da', 'table-danger', 'Danger'),
    (5, '#fff3cd', 'table-warning', 'Warning'),
    (6, '#cff4fc', 'table-info', 'Info'),
    (7, '#f8f9fa', 'table-light', 'Light');


drop table if exists `#__scholarship_option_types`;

create table `#__scholarship_option_types`
(
    `id`            int unsigned auto_increment,
    `opt_type_name` varchar(30)    not null,
    `ordering`       int default 10 null,
    `state`         int default 1  not null,
    primary key (`id`)
);

insert into `#__scholarship_option_types` (`id`, `opt_type_name`, `ordering`, `state`)
values  (1, 'Employment Type', 10, 1),
        (2, 'Gender', 10, 1);

drop table if exists `#__scholarship_option_items`;

create table `#__scholarship_option_items`
(
    `id`                   int unsigned auto_increment,
    `opt_item_key`         varchar(30)    not null,
    `opt_item_value`       varchar(30)    not null,
    `ordering`              int default 10 null,
    `state`                int default 1  null,
    `opt_item_fk_opt_type` int unsigned   not null,
    primary key (`id`)
);

insert into `#__scholarship_option_items` (`id`, `opt_item_key`, `opt_item_value`, `ordering`, `state`, `opt_item_fk_opt_type`)
values  (1, 'Unemployed/Unknown', '1', 10, 1, 1),
        (2, 'NGO', '2', 20, 1, 1),
        (3, 'Government', '3', 30, 1, 1),
        (4, 'Academia - Graduate Student', '4', 40, 1, 1),
        (5, 'Academia - Teacher', '5', 50, 1, 1),
        (6, 'Private Sector - Agriculture', '6', 60, 1, 1),
        (7, 'Private Sector - Finance', '7', 70, 1, 1),
        (8, 'Private Sector - Health Care', '8', 80, 1, 1),
        (9, 'Private Sector - Other', '9', 90, 1, 1),
        (10, 'Unknown', '1', 10, 1, 2),
        (11, 'Female', '2', 20, 1, 2),
        (12, 'Male', '3', 30, 1, 2),
        (13, 'Non-Binary', '4', 40, 1, 2);

insert into `#__scholarships` (id, scholarship_year, scholarship_recipient, scholarship_fk_scholarship_status, scholarship_fk_scholarship_college, scholarship_fk_scholarship_department, scholarship_topic, scholarship_employment, scholarship_abstract_pdf, scholarship_abstract_title, scholarship_profile_pdf, scholarship_sponsor_member, state, ordering, created, `language`, created_by, created_by_alias, modified, modified_by, version, catid, alias, scholarship_fk_color, scholarship_year_graduated, scholarship_fk_opt_item_gender, scholarship_fk_opt_item_imp_org, scholarship_student_photo_url, scholarship_student_home_town, scholarship_student_cell_phone, scholarship_student_email, scholarship_fk_opt_item_emp_type)
values  (1, '2006', 'Syarifah Lia Andriati', 3, 3, 3, '', '', '', '', '', 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '2022-02-20-05-31-23', 2, null, 1, null, null, null, null, null, 1),
    (2, '2007', 'Sri Roma Yuliarta', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 2, null, 1, null, null, null, null, null, 1),
    (3, '2007', 'Gian Anas', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 2, null, 1, null, null, null, null, null, 1),
    (4, '2008', 'Tetty Fransisca Panggabean', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 3, null, 1, null, null, null, null, null, 1),
    (5, '2008', 'Fifi Willyanti', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 3, null, 1, null, null, null, null, null, 1),
    (6, '2008', 'Nurzaidah Putri Dalimunthe', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 3, null, 1, null, null, null, null, null, 1),
    (7, '2008', 'Sidahin Bangun', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 3, null, 1, null, null, null, null, null, 1),
    (8, '2008', 'Mhd. Marliansyah', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 3, null, 1, null, null, null, null, null, 1),
    (9, '2009', 'Cut Tri Janurli', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 4, null, 1, null, null, null, null, null, 1),
    (10, '2009', 'Jaka Framana', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 4, null, 1, null, null, null, null, null, 1),
    (11, '2009', 'Sari Ayu Mahgdalena', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 4, null, 1, null, null, null, null, null, 1),
    (12, '2009', 'Ilhayatu Aini', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 4, null, 1, null, null, null, null, null, 1),
    (13, '2009', 'Lolly Esterida Banjarnahor', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 4, null, 1, null, null, null, null, null, 1),
    (14, '2010', 'Ali Murtala', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (15, '2010', 'Awaluddin', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (16, '2010', 'Maiyus Musrianti', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (17, '2010', 'Ichsan Taufik Nasution', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (18, '2010', 'Qaida Minati', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (19, '2010', 'Rahmad Zubeir Harahap', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (20, '2010', 'Christina Hutabarat', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (21, '2010', 'Akhirul Hijry', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (22, '2010', 'Fitra Dewi Warti Lubis', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (23, '2010', 'Iskandarrudin', 3, 1, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 5, null, 1, null, null, null, null, null, 1),
    (24, '2011', 'Aulia Fakhrurrozi', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (25, '2011', 'Dina Agustina', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (26, '2011', 'Meuthya SR', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (27, '2011', 'Raja Marthunus Selian', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (28, '2011', 'Joharsyah Hutabarat', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (29, '2011', 'Juhardi Sembiring', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (30, '2011', 'Arfah Nasution', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (31, '2011', 'Hethy Novita Tamba', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (32, '2011', 'Henny L Tobing', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (33, '2011', 'M. Gojali Harahap', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 6, null, 1, null, null, null, null, null, 1),
    (34, '2012', 'Risa Aprillia', 3, 9, 2, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (35, '2012', 'Rinta Islami', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (36, '2012', 'Irma Yanti', 3, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (37, '2012', 'Ilham Fonna', 3, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (38, '2012', 'Yandi Syah Puitra', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (39, '2012', 'Vicky Diawan H', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (40, '2012', 'Oryona Romadhon', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (41, '2012', 'Cut Shavrina Devinta Fauzi', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (42, '2012', 'Oni Sri Rahayu Sitorus', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (43, '2012', 'Indah Widiani', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (44, '2012', 'Hernia Febrianti Sianipar', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (45, '2012', 'Ferry Aulia Hawari', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (46, '2012', 'Esty Nidianty', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (47, '2012', 'Aulia Fajria', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 7, null, 1, null, null, null, null, null, 1),
    (48, '2013', 'Muhlis Saputra', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (49, '2013', 'Hendri Gunawan', 3, 9, 6, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (50, '2013', 'Misdi', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (51, '2013', 'Mifhtahul Jannah', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (52, '2013', 'Resti Reimena', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (53, '2013', 'Octora Enda Sari Ginting', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (54, '2013', 'Een Maulidia Rahman', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (55, '2013', 'Diah Hestiasy Tanisyah', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (56, '2013', 'Darsimah Siahaan', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (57, '2013', 'Inggin Trimendes', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (58, '2013', 'Rika Santika Zuha', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (59, '2013', 'Santy Darma Natalia P', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (60, '2013', 'Bungaran MR Naibaho', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (61, '2013', 'Gabriella Yohana', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 8, null, 1, null, null, null, null, null, 1),
    (62, '2014', 'Sumihadi', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (63, '2014', 'Petrus Yendri', 4, 9, 4, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (64, '2014', 'Riduwan', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (65, '2014', 'Hanony Rafika Sari', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (66, '2014', 'Rahmat Nazif', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (67, '2014', 'Siti Patimah', 3, 7, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (68, '2014', 'Nanda Silvia', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (69, '2014', 'Nabila', 3, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (70, '2014', 'Helvi Musdarlia', 3, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (71, '2014', 'Akmal Qurazi', 3, 7, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (72, '2014', 'Rifai Muda Harahap', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (73, '2014', 'Marina Oktaviani', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (74, '2014', 'Nira Wati', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (75, '2014', 'Reza Fahlevi Siregar', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (76, '2014', 'Nur Mahdiana', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (77, '2014', 'Yan Herni', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 9, null, 1, null, null, null, null, null, 1),
    (78, '2015', 'Achmad Edi Saputra', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (79, '2015', 'Soni Irawan', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (80, '2015', 'Octha Fitriani', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (81, '2015', 'Apriana Ulda', 3, 9, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (82, '2015', 'Junardi', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (83, '2015', 'Susandro Frima', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (84, '2015', 'Kartini', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (85, '2015', 'M. Rindi Zulfahri', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (86, '2015', 'Marlinang Magdalena Sihite', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (87, '2015', 'Mastiur Tinambunan', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (88, '2015', 'Juang Siregar', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (89, '2015', 'Lisa Sya''baniar', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (90, '2015', 'Rency Amrilani', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (91, '2015', 'Rafi''i', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (92, '2015', 'Wardatul Hayuni', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (93, '2015', 'Rafika Dewi', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (94, '2015', 'Nurul Farija', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 10, null, 1, null, null, null, null, null, 1),
    (95, '2016', 'Nur Sholihin', 3, 9, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (96, '2016', 'Victor Samudera', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (97, '2016', 'Dedi Januri', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (98, '2016', 'Sari Ulandari', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (99, '2016', 'Supriadi', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (100, '2016', 'Erina Safitri', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (101, '2016', 'Satia Ras', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (102, '2016', 'Ummi Kalsum', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (103, '2016', 'Mahdiyyah Ardhina', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (104, '2016', 'Evi Karmila Naibaho', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (105, '2016', 'Marni Lidawati Limbong', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (106, '2016', 'Armansyah Maulana', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (107, '2016', 'Muhammad Andriansyah', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (108, '2016', 'Muhammad Fikri', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (109, '2016', 'Anna Fitriani', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (110, '2016', 'Teuku Achyar', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (111, '2016', 'Julizar', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (112, '2016', 'Dwikha Rahma Putri', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 11, null, 1, null, null, null, null, null, 1),
    (113, '2017', 'Muhamad Rizal', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (114, '2017', 'Taupan Juwana', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (115, '2017', 'Ninda Rizki', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (116, '2017', 'Taufiq Nurcholisudin', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (117, '2017', 'Cut Raudhatul Jannah', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (118, '2017', 'Agustina', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (119, '2017', 'Aswin Sahari', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (120, '2017', 'M Ariefatullah Syarifuddin', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (121, '2017', 'Fran Jaya', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (122, '2017', 'Indah Apria Situngkir', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (123, '2017', 'Elmida Hasibuan', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (124, '2017', 'Dameria Agustina Pohan', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (125, '2017', 'Rafikah', 4, 9, 8, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (126, '2017', 'Siti Nurbaiti', 3, 9, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (127, '2017', 'Mita Anggraini', 3, 9, 5, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (128, '2017', 'Ilham Pratama', 4, 9, 3, null, null, null, null, null, 1, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (129, '2017', 'Hanna Adelia Runtu', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (130, '2017', 'Ratiah', 3, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 12, null, 1, null, null, null, null, null, 1),
    (131, '2018', 'Reni Riasari', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (132, '2018', 'Surianto', 4, 9, 6, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (133, '2018', 'Gracia Ifri Sandy', 4, 9, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (134, '2018', 'Riyan Hari', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (135, '2018', 'Muhammad Iqbal', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (136, '2018', 'Tia Setiawati', 3, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (137, '2018', 'Inda Uli Hutagalung', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (138, '2018', 'Sella Novita', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (139, '2018', 'Hamidah Jaman', 3, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (140, '2018', 'Safrina', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (141, '2018', 'Ibrahim Syah', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (142, '2018', 'Nurlaily', 3, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (143, '2018', 'Miftahul Jannah', 3, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (144, '2018', 'Loly Amalia', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (145, '2018', 'Fazil', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (146, '2018', 'Zetli Decosta', 3, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (147, '2018', 'Prillicia Gumbang', 3, 4, 3, null, null, null, null, null, 1, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (148, '2018', 'Fitri Melyana', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (149, '2018', 'Ari Marlina', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (150, '2018', 'Mega Oktavia Gunawan', 4, 9, 3, null, null, null, null, null, 1, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 13, null, 1, null, null, null, null, null, 1),
    (151, '2019', 'Rino Anantha', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (152, '2019', 'Ibnu Agung Perdana', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (153, '2019', 'Lasmega Limbong', 4, 1, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (154, '2019', 'Muhdaril Ahda', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (155, '2019', 'Nabillah Saraswita', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (156, '2019', 'Ikhlasul Al Musayyin AS', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (157, '2019', 'Dodi Syahputra', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (158, '2019', 'Ferina', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (159, '2019', 'Susi Mulia Ulva', 3, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (160, '2019', 'Akbar Rivai', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (161, '2019', 'Nadia Berlianty', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (162, '2019', 'Radiana Sofyan', 3, 8, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (163, '2019', 'Fani Delina Sari Sinaga', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (164, '2019', 'Hasyim Asy'' Ari Mulawarman', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (165, '2019', 'Dhodi Presetia', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (166, '2019', 'Glen Wildodo', 4, 4, 3, null, null, null, null, null, 1, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (167, '2019', 'Gusti Irawan', 4, 5, 6, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (168, '2019', 'Ahmad Albab', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (169, '2019', 'Peri', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (170, '2019', 'Monica Sripayu', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (171, '2019', 'Gilang Ihsan Pratama', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (172, '2019', 'Fransiska Suhaimi', 4, 9, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 14, null, 1, null, null, null, null, null, 1),
    (173, '2020', 'Boy', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (174, '2020', 'Darmalia', 3, 7, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (175, '2020', 'Dara Pandan', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (176, '2020', 'Rhati Al Fazra', 4, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (177, '2020', 'Rosi Safriana', 4, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (178, '2020', 'Primanda Aulia', 4, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (179, '2020', 'Akbar Zulnun', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (180, '2020', 'Tania Ekonovia Sari', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (181, '2020', 'Ainun Zahira', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (182, '2020', 'Yusron Wahyudi', 3, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (183, '2020', 'Sukry Damanik', 4, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (184, '2020', 'Dinda Angggita', 4, 6, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (185, '2020', 'Muhammad Syainullah', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (186, '2020', 'Vera Frestia', 4, 9, 5, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (187, '2020', 'Sonia Utami', 4, 9, 9, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (188, '2020', 'Vicu Elyana Listy', 4, 9, 6, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (189, '2020', 'Rizal', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (190, '2020', 'Winda Lasari', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (191, '2020', 'Fajar Ricky Dwi Yulianto', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (192, '2020', 'Dimas Teja Kusuma', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 15, null, 1, null, null, null, null, null, 1),
    (193, '2021', 'Nurul Islamidini', 4, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (194, '2021', 'Indah Serly Pohan', 3, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (195, '2021', 'Aisyadhiya Yulsha', 4, 8, 10, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (196, '2021', 'Asyraf Furqon', 4, 8, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (197, '2021', 'Ulfa Maghfirah', 4, 10, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (198, '2021', 'Olivia Miftahul', 4, 8, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (199, '2021', 'Cut Riska Triana', 4, 1, 7, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (200, '2021', 'Rizky Arif', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (201, '2021', 'Nadiatul Aulia', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (202, '2021', 'Intan Novita', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (203, '2021', 'Siti Mardatillah', 4, 3, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (204, '2021', 'Anderson Sitorus', 4, 3, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (205, '2021', 'Oase Imanuelo', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (206, '2021', 'Dian Atma Sari', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (207, '2021', 'Viona Nadya Situmorang', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (208, '2021', 'Debora Sefti Exlesia', 4, 4, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (209, '2021', 'Muhamad Ismail', 4, 2, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (210, '2021', 'Selpia Lidia Hasugian', 4, 2, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (211, '2021', 'Riko Wibowo', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (212, '2021', 'Egi Iskandar', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (213, '2021', 'Agun Prayoga', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (214, '2021', 'Rita Kurniati', 4, 9, 3, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (215, '2021', 'Yeli Kurnia Sari', 4, 9, 5, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (216, '2021', 'Keti agusti', 4, 9, 1, null, null, null, null, null, 0, 1, 10, '2022-01-17 19:10:47', '*', 1, '', null, 1, 1, 1, '', 16, null, 1, null, null, null, null, null, 1),
    (217, '2022', 'Test Student #2', 1, 1, 1, '', '', '', '', '', 0, 0, 10, '2022-02-01 19:51:14', '', 1, '', null, 1, 1, 1, '2022-02-02-03-51-14', 4, null, 1, null, null, null, null, null, 1),
    (218, '2022', 'Test Student #3', 1, 2, 3, '', '', '', '', '', 0, 0, 10, '2022-02-01 21:27:02', '', 1, '', null, 1, 1, 1, '2022-02-02-05-27-02', 4, null, 1, null, null, null, null, null, 1);