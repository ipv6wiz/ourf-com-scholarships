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
values  ('North Sumatra University (USU)'),
        ('UNIMED'),
        ('Unsyiah Banda Aceh'),
        ('Medan Area University'),
        ('Univ. of Tanjungpura, W. Kalimantan'),
        ('STIK Pante Kulu'),
        ('Unsyiah'),
        ('UIN Ar-Raniry'),
        ('FKH Unsyiah');


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
values  ('Forestry'),
        ('Biology'),
        ('Veterinary');

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

INSERT INTO `#__scholarship_status` (`scholarship_status_option`) VALUES
                                                                        ('Still Studying'),
                                                                        ('Research proposal in progress'),
                                                                        ('Research in progress'),
                                                                        ('Research completed'),
                                                                        ('Graduated');

insert into `#__scholarships` (id, scholarship_year, scholarship_recipient, scholarship_fk_scholarship_status, scholarship_fk_scholarship_college, scholarship_fk_scholarship_department, scholarship_topic, scholarship_employment, scholarship_abstract_pdf, scholarship_abstract_title, scholarship_profile_pdf, scholarship_sponsor_member, state, ordering)
values  (1, '2006', 'Syarifah Lia Andriati', 5, 1, 1, 'Feeding Behavior of Sumatran Orangutan (Pongo abelii) and Local People Perception on Their Existence in Farmland (A Case Study in Subdistrict of Batang Serangan, Langkat District)', 'Work in BNI Medan as Corporate Social Responsibility (CSR)  officer', '/scholarship/abstracts/syarifah_abstract.pdf', 'Feeding Behavior of Sumatran Orangutan and People Perception on Their Existence in Farmland ', '', 0, 1, 10),
        (2, '2007', 'Gian Anas', 5, 1, 1, 'Comparison of seed growth speed between duku (Lansium domesticum)seeds that are digested by orangutan and duku seeds that are not digested by orangutan', 'Post graduate student in Andalas University, Padang, Indonesia', '', '', '', 0, 1, 10),
        (3, '2007', 'Sri Roma Yuliarta', 5, 1, 2, 'Daily activities of mother and infant of Sumatran orangutan (Pongo abelii) in Bukit Lawang, Gunung Leuser National Park, Langkat District', 'Work in Pan Eco YEL as Environmental Education Officer based in Bukit Lawang', '/scholarship/abstracts/roma_abstract.pdf', 'Daily Activities of Mother and Infant Orangutan', '', 0, 1, 10),
        (4, '2008', 'Mhd. Marliansyah', 5, 1, 1, 'Analysis of Sumatran orangutan food tree distribution using GIS', 'Work in PT Djarum Plantation in Kalimantan as sustainability staff', '', '', '', 0, 1, 10),
        (5, '2008', 'Sidahin Bangun', 5, 1, 2, 'Social behavior and interaction of mother and infant of Sumatran orangutan in Bukit Lawang, Gunung Leuser National Park', 'Work as field officer for PT RHOI (Restorasi Habitat Orangutan Indonesia) â BOSF in Kalimantan', '', '', '', 0, 1, 10),
        (6, '2008', 'Nurzaidah Putri Dalimunthe', 5, 1, 2, 'Density of Sumatran orangutan population in Bukit Lawang, Gunung Leuser National Park', 'Post graduate student in USU, Medan, Indonesia', '', '', '', 0, 1, 10),
        (7, '2008', 'Fifi Willyanti', 5, 1, 2, 'Behavior of Sumatran orangutan infant as a result of ecotourism activities in Bukit Lawang, Gunung Leuser National Park', 'Post graduate student in USU, Medan, Indonesia', '', '', '', 0, 1, 10),
        (8, '2008', 'Tetty Fransisca Panggabean', 5, 2, 2, 'Prevalence of Nematoda paracite  worm at Sumatran orangutans in Bukit Lawang, Gunung Leuser National Park', 'Work as Biology teacher', '', '', '', 0, 1, 10),
        (9, '2009', 'Lolly Esterida Banjarnahor', 3, 1, 1, 'Study of ex-situ orangutan conservation management in Medan and Siantar Zoos.', 'Work as Biology teacher', '', '', '', 0, 1, 10),
        (10, '2009', 'Ilhayatu Aini', 5, 1, 2, 'Feeding behavior of orangutan infant in Orangutan Viewing Centre, Bukit Lawang of Gunung Leuser National Park, Langkat, North Sumatra', 'Working as biology teacher in Sinabang, Aceh', '', '', '', 0, 1, 10),
        (11, '2009', 'Sari Ayu Mahgdalena', 5, 2, 2, 'The preferences of nesting tree of semi wild orangutans (Pongo abelii) in Bukit Lawang Ecotourism Forest, Gunung Leuser National Park.', 'Working as a lecturer at Education USA, Medan and in preparation to pursue a post graduate study', '', '', '', 0, 1, 10),
        (12, '2009', 'Jaka Framana', 4, 3, 3, 'The normal position of heart anatomy in Sumatran orangutan (Pongo Abelii) based on thorax Rontgen at Batu Mbelin Orangutan Quarantine, Medan, Indonesia', 'Veterinary Internship at Airlangga University, Surabaya', '', '', '', 0, 1, 10),
        (13, '2009', 'Cut Tri Janurli', 3, 3, 3, 'Correlation between feeding behaviour and nematoda gastrointestinal in sumatran orangutan (pongo abelii) in Bukit Lawang ecotourism forest, Gunung Leuser National Park, North Sumatra, Indonesia', 'Veterinary Internship at Pathology Lab of Veterinary Faculty of Syiah Kuala University', '', '', '', 0, 1, 10),
        (14, '2010', 'Iskandarrudin', 3, 4, 2, 'Inventory of orangutan food tree at Bukit  Lawang ecotourism forest, Gunung Leuser National Park, North Sumatra, Indonesia', 'Working as Park Ranger in Bukit Lawang of Gunung Leuser National Park (GLNP)', '', '', '', 0, 1, 10),
        (15, '2010', 'Fitra Dewi Warti Lubis', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (16, '2010', 'Akhirul Hijry', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (17, '2010', 'Christina Hutabarat', 5, 2, 2, 'The characteristic of semi wild orangutans in Bukit Lawang, Gunung Leuser National Park,  Langkat, North Sumatra', 'Working as a biology teacher in Medan', '', '', '', 0, 1, 10),
        (18, '2010', 'Rahmad Zubeir Harahap', 3, 1, 2, 'Feeding behavior of Sumatran Orangutan in research station in west Batang Toru forest, North Tapanuli, North Sumatra', '', '', '', '', 0, 1, 10),
        (19, '2010', 'Qaida Minati', 3, 3, 3, 'Interpretation of heart size of Sumatran Orangutan based on thorax Rontgen at Batu Mbelin Orangutan Quarantine, Medan, Indonesia', '', '', '', '', 0, 1, 10),
        (20, '2010', 'Ichsan Taufik Nasution', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (21, '2010', 'Maiyus Musrianti', 4, 3, 3, 'Hematology profile of sumatran orangutan in quarantine, Sibolangit, North Sumatra, Indonesia', 'Veterinary Internship in Cattle Slaughtering Centre, Medan', '', '', '', 0, 1, 10),
        (22, '2010', 'Awaluddin', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (23, '2010', 'Ali Murtala', 2, 3, 3, 'Correlation between feeding behaviour and gastrointestinal parasite (nematode parasite) in Sumatran Orangutan (pongo abelii) at Jantho nature reserve forest, Aceh Besar', '', '', '', '', 0, 1, 10),
        (24, '2011', 'M. Gojali Harahap', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (25, '2011', 'Henny L Tobing', 1, 2, 2, '', '', '', '', '', 0, 1, 10),
        (26, '2011', 'Hethy Novita Tamba', 1, 2, 2, '', '', '', '', '', 0, 1, 10),
        (27, '2011', 'Arfah Nasution', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (28, '2011', 'Juhardi Sembiring', 3, 1, 2, 'Individual behavior study of Sumatran Orangutan before Reintroduction Programme  at Batu Mbelin Orangutan Quarantine, Medan, Indonesia', 'Volunteer at OIC', '', '', '', 0, 1, 10),
        (29, '2011', 'Joharsyah Hutabarat', 4, 3, 3, 'Identification and Antibiotic Sensitivity Test for Enterobacteriaceae from fresh feces of Sumatran Orangutan at  Segar Orangutan Sumatera at Batu Mbelin Orangutan Quarantine, Medan, Indonesia', 'Veterinary internship', '', '', '', 0, 1, 10),
        (30, '2011', 'Raja Marthunus Selian', 4, 3, 3, 'Identification of Gastrointestinal Parasite in feces of semi wild orangutans at at Jantho nature reserve forest, Aceh Besar', '-Veterinary internship in "Laras Satwa" animal hospital, Jakarta', '', '', '', 0, 1, 10),
        (31, '2011', 'Meuthya SR', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (32, '2011', 'Dina Agustina', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (33, '2011', 'Aulia Fakhrurrozi', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (34, '2012', 'Aulia Fajria', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (35, '2012', 'Esty Nidianty', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (36, '2012', 'Ferry Aulia Hawari', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (37, '2012', 'Hernia Febrianti Sianipar', 2, 2, 2, 'Identification of orangutan nest composition in Besitang forest of Gunung Leuser National Park, North Sumatra', '', '', '', '', 0, 1, 10),
        (38, '2012', 'Indah Widiani', 1, 2, 2, '', '', '', '', '', 0, 1, 10),
        (39, '2012', 'Oni Sri Rahayu Sitorus', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (40, '2012', 'Cut Shavrina Devinta Fauzi', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (41, '2012', 'Oryona Romadhon', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (42, '2012', 'Vicky Diawan H', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (43, '2012', 'Yandi Syah Puitra', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (44, '2012', 'Ilham Fonna', 1, 3, 2, '', '', '', '', '', 0, 1, 10),
        (45, '2012', 'Irma Yanti', 1, 3, 2, '', '', '', '', '', 0, 1, 10),
        (46, '2012', 'Rinta Islami', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (47, '2012', 'Risa Aprillia', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (48, '2013', 'Gabriella Yohana', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (49, '2013', 'Bungaran MR Naibaho', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (50, '2013', 'Santy Darma Natalia P', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (51, '2013', 'Rika Santika Zuha', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (52, '2013', 'Inggin Trimendes', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (53, '2013', 'Darsimah Siahaan', 1, 2, 2, '', '', '', '', '', 0, 1, 10),
        (54, '2013', 'Diah Hestiasy Tanisyah', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (55, '2013', 'Een Maulidia Rahman', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (56, '2013', 'Octora Enda Sari Ginting', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (57, '2013', 'Resti Reimena', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (58, '2013', 'Mifhtahul Jannah', 1, 3, 3, '', '', '', '', '', 0, 1, 10),
        (59, '2013', 'Misdi', 1, 6, 1, '', '', '', '', '', 0, 1, 10),
        (60, '2013', 'Hendri Gunawan', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (61, '2013', 'Muhlis Saputra', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (62, '2014', 'Yan Herni', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (63, '2014', 'Nur Mahdiana', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (64, '2014', 'Reza Fahlevi Siregar', 1, 1, 2, '', '', '', '', '', 0, 1, 10),
        (65, '2014', 'Nira Wati', 1, 2, 2, '', '', '', '', '', 0, 1, 10),
        (66, '2014', 'Marina Oktaviani', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (67, '2014', 'Rifai Muda Harahap', 1, 1, 1, '', '', '', '', '', 0, 1, 10),
        (68, '2014', 'Akmal Qurazi', 1, 6, 1, '', '', '', '', '', 0, 1, 10),
        (69, '2014', 'Helvi Musdarlia', 1, 7, 2, '', '', '', '', '', 0, 1, 10),
        (70, '2014', 'Nabila', 1, 7, 2, '', '', '', '', '', 0, 1, 10),
        (71, '2014', 'Nanda Silvia', 1, 8, 2, '', '', '', '', '', 0, 1, 10),
        (72, '2014', 'Siti Patimah', 1, 6, 1, '', '', '', '', '', 0, 1, 10),
        (73, '2014', 'Rahmat Nazif', 1, 9, 3, '', '', '', '', '', 0, 1, 10),
        (74, '2014', 'Hanony Rafika Sari', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (75, '2014', 'Riduan', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (76, '2014', 'Petrus Yendri', 1, 5, 1, '', '', '', '', '', 0, 1, 10),
        (77, '2014', 'Sumihadi', 1, 5, 1, '', '', '', '', '', 0, 1, 10);
