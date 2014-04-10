-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 09-01-2008 a las 16:03:07
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `sms`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `actual_planned_credit`
-- 

CREATE TABLE `actual_planned_credit` (
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente',
  `not_consumed_credit` float NOT NULL COMMENT 'Credito no consumido',
  `planned_credit` float NOT NULL COMMENT 'Credito reservado',
  `free_credit` float default NULL COMMENT 'Credito disponible',
  `credit_actu_date` datetime NOT NULL COMMENT 'Fecha de ultima actualizacion del registro',
  PRIMARY KEY  (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Credito no consumido, el reservado y el disponible del clien';

-- 
-- Volcar la base de datos para la tabla `actual_planned_credit`
-- 

INSERT INTO `actual_planned_credit` (`id_client`, `not_consumed_credit`, `planned_credit`, `free_credit`, `credit_actu_date`) VALUES 
(2, 0, 0, 0, '2008-01-02 16:17:06'),
(7, 0, 0, 0, '2008-01-09 10:06:00');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alert_price`
-- 

CREATE TABLE `alert_price` (
  `alert_type_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de alerta',
  `alert_price_country` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del pais',
  `alert_price` float unsigned default NULL COMMENT 'Precio sin IVA de la alerta',
  `alert_price_current_flag` tinyint(1) NOT NULL COMMENT 'Flag que indica el registro vigente para el tipo de alerta y pais',
  `alert_price_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del precio',
  `alert_price_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del precio',
  PRIMARY KEY  (`alert_type_cd`,`alert_price_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Precios de los diferentes tipos de alerta posibles';

-- 
-- Volcar la base de datos para la tabla `alert_price`
-- 

INSERT INTO `alert_price` (`alert_type_cd`, `alert_price_country`, `alert_price`, `alert_price_current_flag`, `alert_price_date_in`, `alert_price_date_out`) VALUES 
('E', 'SP', 0, 1, '2007-08-01 00:00:00', NULL),
('E', 'UK', 0, 1, '2007-08-01 00:00:00', NULL),
('M', 'SP', 1, 1, '2007-08-01 00:00:00', NULL),
('M', 'UK', 1, 1, '2007-08-01 00:00:00', NULL),
('S', 'SP', 2, 1, '2007-08-01 00:00:00', NULL),
('S', 'UK', 2, 1, '2007-08-01 00:00:00', NULL),
('V', 'SP', 1, 1, '2007-08-01 00:00:00', NULL),
('V', 'UK', 1, 1, '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alert_type`
-- 

CREATE TABLE `alert_type` (
  `alert_type_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de alerta',
  `alert_type_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `alert_type_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de alerta',
  `alert_type_dsc` varchar(100) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del tipo de alerta',
  `alert_type_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del tipo de alerta',
  `alert_type_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del tipo de alerta',
  PRIMARY KEY  (`alert_type_cd`,`alert_type_lang`),
  KEY `fk_constraint_alert_type.alert_type_lang_on_language` (`alert_type_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de alertas posibles para las prescripciones';

-- 
-- Volcar la base de datos para la tabla `alert_type`
-- 

INSERT INTO `alert_type` (`alert_type_cd`, `alert_type_lang`, `alert_type_nm`, `alert_type_dsc`, `alert_type_date_in`, `alert_type_date_out`) VALUES 
('E', 'SP', 'E-mail', 'Alertas por correo electronico.\r', '2007-08-01 00:00:00', NULL),
('E', 'UK', 'E-mail', 'Alerts sent by e-mail.\r', '2007-08-01 00:00:00', NULL),
('M', 'SP', 'Voz Movil', 'Alertas por voz al telefono movil.\r', '2007-08-01 00:00:00', NULL),
('M', 'UK', 'Voice Mobile', 'Alerts sent to mobile phone by voice.\r', '2007-08-01 00:00:00', NULL),
('S', 'SP', 'SMS', 'Alertas por SMS al telefono movil.\r', '2007-08-01 00:00:00', NULL),
('S', 'UK', 'SMS', 'Alerts sent to mobile phone by SMS.\r', '2007-08-01 00:00:00', NULL),
('V', 'SP', 'Voz Fijo', 'Alertas por voz al telefono fijo.\r', '2007-08-01 00:00:00', NULL),
('V', 'UK', 'Voice Landline', 'Alerts sent to landline phone by voice.\r', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `bill`
-- 

CREATE TABLE `bill` (
  `id_bill` int(10) unsigned NOT NULL auto_increment COMMENT 'Id de la factura',
  `bill_cd` char(22) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de la factura',
  `bill_value` float NOT NULL COMMENT 'Valor sin IVA de la factura',
  `bill_vat_id` smallint(5) unsigned NOT NULL COMMENT 'Id del IVA de la factura correspondiente al IVA del pais del cliente',
  `bill_vat_value` float NOT NULL COMMENT 'Valor del IVA de la factura',
  `bill_total_value` float NOT NULL COMMENT 'Valor total de la factura',
  `bill_pay_date` datetime default NULL COMMENT 'Fecha de pago de la factura',
  `bill_pay_mode_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Medio de pago utilizado para el pago de la factura',
  `bill_file_path` varchar(100) collate utf8_spanish_ci NOT NULL COMMENT 'Ruta al archivo de la factura',
  PRIMARY KEY  (`id_bill`),
  KEY `index_bill.bill_cd` (`bill_cd`),
  KEY `fk_constraint_bill.bill_vat_id_on_vat` (`bill_vat_id`),
  KEY `fk_constraint_bill.bill_pay_mode_cd_on_bill_pay_mode` (`bill_pay_mode_cd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Facturas de las compras de los clientes' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `bill`
-- 

INSERT INTO `bill` (`id_bill`, `bill_cd`, `bill_value`, `bill_vat_id`, `bill_vat_value`, `bill_total_value`, `bill_pay_date`, `bill_pay_mode_cd`, `bill_file_path`) VALUES 
(1, 'SP12346 20080108 01', 100, 1, 16, 116, '2008-01-09 14:00:02', 'M', 'facturas/SP12346 20080108 01.pdf');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `bill_pay_mode`
-- 

CREATE TABLE `bill_pay_mode` (
  `bill_pay_mode_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de la forma de pago',
  `bill_pay_mode_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `bill_pay_mode_nm` varchar(30) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre de la forma de pago',
  `bill_pay_mode_date_in` datetime NOT NULL COMMENT 'Fecha de creacion de la forma de pago',
  `bill_pay_mode_date_out` datetime default NULL COMMENT 'Fecha de finalizacion de la forma de pago',
  PRIMARY KEY  (`bill_pay_mode_cd`,`bill_pay_mode_lang`),
  KEY `fk_constraint_bill_pay_mode.bill_pay_mode_lang_on_language` (`bill_pay_mode_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Diferentes modos de pago de facturas';

-- 
-- Volcar la base de datos para la tabla `bill_pay_mode`
-- 

INSERT INTO `bill_pay_mode` (`bill_pay_mode_cd`, `bill_pay_mode_lang`, `bill_pay_mode_nm`, `bill_pay_mode_date_in`, `bill_pay_mode_date_out`) VALUES 
('B', 'SP', 'Transferencia bancaria\r', '2007-08-01 00:00:00', NULL),
('B', 'UK', 'Bank transfer\r', '2007-08-01 00:00:00', NULL),
('I', 'SP', 'Internet\r', '2007-08-01 00:00:00', NULL),
('I', 'UK', 'Internet\r', '2007-08-01 00:00:00', NULL),
('M', 'SP', 'Liquido\r', '2007-08-01 00:00:00', NULL),
('M', 'UK', 'Money', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `bill_status`
-- 

CREATE TABLE `bill_status` (
  `bill_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado de la factura',
  `bill_status_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `bill_status_nm` varchar(10) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado de la factura',
  `bill_status_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del estado de la factura',
  `bill_status_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del estado de la factura',
  PRIMARY KEY  (`bill_status_cd`,`bill_status_lang`),
  KEY `fk_constraint_bill_status.bill_status_lang_on_language` (`bill_status_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estados en los cuales se puede encontrar una factura';

-- 
-- Volcar la base de datos para la tabla `bill_status`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `client`
-- 

CREATE TABLE `client` (
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente',
  `cli_cd` char(10) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del cliente',
  `cli_firstname` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del cliente',
  `cli_lastname` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Apellidos del cliente',
  `cli_sex_cd` char(1) collate utf8_spanish_ci default NULL COMMENT 'Codigo del sexo del cliente',
  `cli_birthdate` date default NULL COMMENT 'Fecha de nacimiento del cliente - para particulares',
  `cli_company_nm` varchar(100) collate utf8_spanish_ci default NULL COMMENT 'Nombre de la empresa - para profesionales',
  `cli_ident_type_cd` char(4) collate utf8_spanish_ci default NULL COMMENT 'Codigo del tipo de documento de identificacion',
  `cli_ident_num` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero del documento de identificacion',
  `cli_act_cd` char(3) collate utf8_spanish_ci default NULL COMMENT 'Codigo del tipo de actividad del cliente',
  `cli_phone_num1` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero de telefono fijo #1',
  `cli_phone_num2` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero de telefono fijo #2',
  `cli_fax_num` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero de fax',
  `cli_cell_phone` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero de telefono movil',
  `cli_e_mail` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Direccion e-mail',
  `cli_address` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Direccion completa del cliente',
  `cli_postal_cd` mediumint(8) unsigned default NULL COMMENT 'Codigo postal de la residencia del cliente',
  `cli_town` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Ciudad de residencia del cliente',
  `cli_country_cd` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del pais de residencia',
  `cli_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - 0 es no vigente',
  `cli_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion de la informacion del cliente',
  PRIMARY KEY  (`id_client`,`cli_date_mod`),
  KEY `index_client.cli_cd` (`cli_cd`),
  KEY `index_client.cli_ident_num` (`cli_ident_num`),
  KEY `index_client.cli_country_cd` (`cli_country_cd`),
  KEY `fk_constraint_client.cli_sex_cd_on_sex` (`cli_sex_cd`),
  KEY `fk_const_client.cli_ident_type_cd_on_identification_doc_type` (`cli_ident_type_cd`),
  KEY `fk_constraint_client.cli_act_cd_on_client_activity` (`cli_act_cd`),
  KEY `fk_constraint_client.cli_postal_cd_on_geography` (`cli_postal_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contiene la informacion de los clientes del sitio web';

-- 
-- Volcar la base de datos para la tabla `client`
-- 

INSERT INTO `client` (`id_client`, `cli_cd`, `cli_firstname`, `cli_lastname`, `cli_sex_cd`, `cli_birthdate`, `cli_company_nm`, `cli_ident_type_cd`, `cli_ident_num`, `cli_act_cd`, `cli_phone_num1`, `cli_phone_num2`, `cli_fax_num`, `cli_cell_phone`, `cli_e_mail`, `cli_address`, `cli_postal_cd`, `cli_town`, `cli_country_cd`, `cli_current_flag`, `cli_date_mod`) VALUES 
(1, 'SP12345', 'LEUVYS', 'CASTRO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'lcastro@onspot.es', NULL, NULL, NULL, 'SP', 1, '2007-08-01 00:00:00'),
(2, 'SP12346', 'ARNULFO', 'PABON', 'M', '1975-12-23', NULL, 'EXTR', 'X09999999Z', 'PAR', NULL, NULL, NULL, NULL, 'apabonok@hotmail.com', 'Calle Isla de Arosa 23 3B', 28035, 'PENAGRANDE', 'SP', 1, '2007-08-01 00:00:00'),
(3, 'SP00003', 'Victor', 'Vallecilla Mira', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vallecilla@gmail.com', NULL, NULL, NULL, 'SP', 1, '2008-01-04 14:50:00'),
(4, 'SP00004', 'Carlos Andres', 'Vallecilla Mira', 'M', '1990-10-09', NULL, 'EXTR', '90100957620', 'PAR', '2440725', NULL, NULL, '3128769330', 'valle300@hotmail.com', 'Calle 4 N 52a 04', 8001, 'Barcelona', 'SP', 1, '2008-01-04 14:53:09'),
(5, 'SP00005', 'Carlos', 'Rojas Mendez', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'carlkant@gmail.com', NULL, NULL, NULL, 'SP', 1, '2008-01-05 11:15:15'),
(6, 'SP00006', 'Mario', 'Obregon ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mobregon@gmail.com', NULL, NULL, NULL, 'SP', 1, '2008-01-05 11:57:44'),
(7, 'SP00007', 'Jose', 'Mira ', 'M', NULL, 'La 14', 'VAT', '1234567', 'DRU', '4339608', '', '', '3128661303', 'jmira@gmail.com', 'Calle Isla de Arosa 23 3B', 8001, 'Barcelona', 'SP', 0, '2008-01-06 10:02:36'),
(7, 'SP00007', 'Jose', 'Mira Calderon', 'M', NULL, 'La 14', 'VAT', '1234567', 'DRU', '4339608', '', '', '3128661303', 'jmira@gmail.com', 'Calle Isla de Arosa 23 3B', 8001, 'Barcelona', 'SP', 1, '2008-01-06 10:48:21');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `client_activity`
-- 

CREATE TABLE `client_activity` (
  `cli_act_cd` char(3) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de la actividad del cliente',
  `cli_act_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `cli_act_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre de la actividad del cliente',
  `cli_act_grp_cd` char(3) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del grupo de la actividad del cliente',
  `cli_act_grp_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del grupo de la actividad del cliente',
  `cli_act_date_in` datetime NOT NULL COMMENT 'Fecha de alta de la actividad ',
  `cli_act_date_out` datetime default NULL COMMENT 'Fecha de baja de la actividad',
  PRIMARY KEY  (`cli_act_cd`,`cli_act_lang`),
  KEY `fk_constraint_client_activity.cli_act_lang_on_language` (`cli_act_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de actividades posibles de los usuarios del portal';

-- 
-- Volcar la base de datos para la tabla `client_activity`
-- 

INSERT INTO `client_activity` (`cli_act_cd`, `cli_act_lang`, `cli_act_nm`, `cli_act_grp_cd`, `cli_act_grp_nm`, `cli_act_date_in`, `cli_act_date_out`) VALUES 
('ALL', 'SP', 'Todos', 'ALL', 'Todos', '2008-01-02 21:09:27', NULL),
('ALL', 'UK', 'All', 'ALL', 'All', '2008-01-02 21:09:27', NULL),
('DRU', 'SP', 'Oficina de farm', 'PRO', 'Profesional', '2007-08-01 00:00:00', NULL),
('DRU', 'UK', 'Drugstore', 'PRO', 'Professionnal\r', '2007-08-01 00:00:00', NULL),
('PAR', 'SP', 'Particular', 'PAR', 'Particular\r', '2007-08-01 00:00:00', NULL),
('PAR', 'UK', 'Particular', 'PAR', 'Particular\r', '2007-08-01 00:00:00', NULL),
('VET', 'SP', 'Clinica veterin', 'PRO', 'Profesional', '2007-08-01 00:00:00', NULL),
('VET', 'UK', 'Veterinary', 'PRO', 'Professionnal', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `contact`
-- 

CREATE TABLE `contact` (
  `id_contact` int(10) unsigned NOT NULL COMMENT 'Id del contacto',
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente',
  `cont_firstname` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del contacto',
  `cont_lastname` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Apellido del contacto',
  `cont_address` varchar(150) collate utf8_spanish_ci default NULL COMMENT 'Direccion del contacto',
  `cont_postal_cd` mediumint(8) unsigned default NULL COMMENT 'Codigo postal del contacto',
  `cont_town` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Ciudad del contacto',
  `cont_country_cd` char(2) collate utf8_spanish_ci default NULL COMMENT 'Codigo del pais',
  `cont_phone` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero de telefono del contacto',
  `cont_cell_phone` varchar(15) collate utf8_spanish_ci default NULL COMMENT 'Numero de telefono movil del contacto',
  `cont_email` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'E-mail del contacto',
  `cont_sex_cd` char(1) collate utf8_spanish_ci default NULL COMMENT 'Codigo del sexo del contacto',
  `cont_birthdate` datetime default NULL COMMENT 'Fecha de nacimiento del contacto',
  `cont_prof_info` tinyint(1) default NULL COMMENT 'Indica si el contacto acepta recibir informacion del profesional - 0 para No',
  `cont_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - 0 para falso',
  `cont_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del contacto',
  `cont_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion de la informacion del contacto',
  `cont_date_out` datetime default NULL COMMENT 'Fecha de supresion del contacto',
  PRIMARY KEY  (`id_contact`,`cont_date_mod`),
  KEY `index_contact.cont_firstname` (`cont_firstname`),
  KEY `index_contact.cont_lastname` (`cont_lastname`),
  KEY `fk_constraint_contact.id_client_on_client` (`id_client`),
  KEY `fk_constraint_contact.cont_postal_cd_on_geography` (`cont_postal_cd`),
  KEY `fk_constraint_contact.cont_sex_cd_on_sex` (`cont_sex_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Datos de contactos de clientes';

-- 
-- Volcar la base de datos para la tabla `contact`
-- 

INSERT INTO `contact` (`id_contact`, `id_client`, `cont_firstname`, `cont_lastname`, `cont_address`, `cont_postal_cd`, `cont_town`, `cont_country_cd`, `cont_phone`, `cont_cell_phone`, `cont_email`, `cont_sex_cd`, `cont_birthdate`, `cont_prof_info`, `cont_current_flag`, `cont_date_in`, `cont_date_mod`, `cont_date_out`) VALUES 
(1, 7, 'GILLES', 'BURIN', '', 28035, '', '', '', '653658603', 'gburin@hotmail.com', 'M', '0000-00-00 00:00:00', 1, 1, '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
(2, 7, 'PEPITO', 'PEREZ', '', 28048, '', '', '914356785', '0', '', 'M', '0000-00-00 00:00:00', 1, 1, '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
(3, 2, 'ALEJANDRA', 'PABON', '', 28035, '', '', '917301618', '0', '', 'W', '0000-00-00 00:00:00', 0, 1, '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
(4, 2, 'NOMBRE1', 'APELLIDO1', 'DIRECCION1', 28035, '', '', '916666666', '666666666', 'correo@webmail.com', 'W', '0000-00-00 00:00:00', 1, 0, '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
(4, 2, 'NOMBRE1', 'APELLIDO1', 'DIRECCION2', 28048, '', '', '916666666', '666666666', 'correo@webmail.com', 'W', '0000-00-00 00:00:00', 1, 1, '2007-08-01 00:00:00', '2007-08-04 00:00:00', NULL),
(5, 2, 'Sergio', 'Ochoa', '', 8001, 'Barcelona', 'SP', '992440725', '', '', 'M', NULL, 0, 1, '2008-01-09 09:29:19', '2008-01-09 09:29:19', NULL),
(6, 2, 'Carlos', 'Velez', '', 8001, 'Barcelona', 'SP', '', '693001234567', '', 'M', '1985-01-24 00:00:00', 0, 1, '2008-01-09 09:34:56', '2008-01-09 09:34:56', NULL),
(7, 7, 'Jose', 'Neira', '', 8001, 'Barcelona', 'SP', NULL, '', '', 'M', '1985-08-29 00:00:00', 1, 1, '2008-01-09 11:00:08', '2008-01-09 11:00:08', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `credit`
-- 

CREATE TABLE `credit` (
  `id_credit` int(10) unsigned NOT NULL auto_increment COMMENT 'Id del bono',
  `credit_cd` char(5) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del bono',
  `credit_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del bono',
  `credit_dsc` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del bono',
  `credit_num` smallint(6) NOT NULL COMMENT 'Numero de creditos del bono',
  `credit_price` float NOT NULL COMMENT 'Precio sin IVA del bono',
  `credit_begin_date` datetime NOT NULL COMMENT 'Fecha de inicio de validez del bono',
  `credit_end_date` datetime default NULL COMMENT 'Fecha de fin de validez del bono',
  `credit_cli_act_cd` char(3) collate utf8_spanish_ci NOT NULL COMMENT 'Tipo de cliente al cual se ofrece el bono',
  `credit_free_flag` tinyint(1) NOT NULL COMMENT 'Indica si el bono se ofrece gratuitamente a los nuevos clientes',
  `credit_max_cli` int(10) unsigned default NULL COMMENT 'Numero maximo de clientes que pueden tener el bono',
  `credit_publish_flag` tinyint(1) NOT NULL COMMENT 'Indica si el bono se publica o no para el usuario',
  `credit_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado en el cual se encuentra el bono',
  `credit_cre_user_id` int(10) unsigned NOT NULL COMMENT 'Id del usuario que creo el bono',
  `credit_mod_user_id` int(10) unsigned default NULL COMMENT 'Id del ultimo usuario que modifico el bono',
  `credit_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del bono',
  `credit_date_mod` datetime default NULL COMMENT 'Fecha de ultima modificacion del bono',
  `credit_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del bono',
  PRIMARY KEY  (`id_credit`),
  KEY `index_credit.credit_nm` (`credit_nm`),
  KEY `fk_constraint_credit.credit_cli_act_cd_on_client_activity` (`credit_cli_act_cd`),
  KEY `fk_constraint_credit.credit_status_cd_on_creedit_status` (`credit_status_cd`),
  KEY `fk_constraint_credit.credit_cre_user_id_on_users` (`credit_cre_user_id`),
  KEY `fk_constraint_credit.credit_mod_user_id_on_users` (`credit_mod_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Bonos que se venden a los clientes' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `credit`
-- 

INSERT INTO `credit` (`id_credit`, `credit_cd`, `credit_nm`, `credit_dsc`, `credit_num`, `credit_price`, `credit_begin_date`, `credit_end_date`, `credit_cli_act_cd`, `credit_free_flag`, `credit_max_cli`, `credit_publish_flag`, `credit_status_cd`, `credit_cre_user_id`, `credit_mod_user_id`, `credit_date_in`, `credit_date_mod`, `credit_date_out`) VALUES 
(1, 'TEST', 'TEST1', 'Prueba de bono', 100, 120, '2008-01-04 00:00:00', '2008-01-31 00:00:00', 'ALL', 1, 10, 1, 'A', 1, 1, '2008-01-04 07:52:10', '2008-01-04 07:52:10', NULL),
(2, 'TEST2', 'TEST2', 'Segunda prueba', 200, 100, '2008-01-07 00:00:00', NULL, 'PAR', 0, NULL, 1, 'A', 1, 1, '2008-01-05 10:32:26', '2008-01-08 07:54:44', NULL),
(3, 'TEST3', 'TEST3', 'Tercera prueba', 600, 1000, '2008-01-05 00:00:00', NULL, 'DRU', 0, NULL, 1, 'F', 1, 1, '2008-01-05 11:12:51', '2008-01-05 11:12:51', NULL),
(4, 'TEST4', 'TEST4', 'Cuarta prueba', 100, 1200, '2008-01-14 00:00:00', '2008-01-31 00:00:00', 'ALL', 1, 100, 1, 'P', 1, 3, '2008-01-05 06:46:27', '2008-01-08 08:29:23', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `credit_status`
-- 

CREATE TABLE `credit_status` (
  `credit_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado del bono',
  `credit_status_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `credit_status_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado del bono',
  `credit_status_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del estado del bono',
  `credit_status_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del estado del bono',
  PRIMARY KEY  (`credit_status_cd`,`credit_status_lang`),
  KEY `fk_constraint_credit_status.credit_status_lang_on_language` (`credit_status_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estados en los cuales puede estar un bono';

-- 
-- Volcar la base de datos para la tabla `credit_status`
-- 

INSERT INTO `credit_status` (`credit_status_cd`, `credit_status_lang`, `credit_status_nm`, `credit_status_date_in`, `credit_status_date_out`) VALUES 
('A', 'SP', 'Activo\r', '2007-08-01 00:00:00', NULL),
('A', 'UK', 'Active\r', '2007-08-01 00:00:00', NULL),
('C', 'SP', 'Desactivado\r', '2007-08-01 00:00:00', NULL),
('C', 'UK', 'Canceled\r', '2007-08-01 00:00:00', NULL),
('F', 'SP', 'Finalizado\r', '2007-08-01 00:00:00', NULL),
('F', 'UK', 'Finalized\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'Pendiente\r', '2007-08-01 00:00:00', NULL),
('P', 'UK', 'Pending', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `form_request`
-- 

CREATE TABLE `form_request` (
  `id_frm_req` int(11) NOT NULL COMMENT 'Id de la solicitud',
  `id_client` int(10) unsigned default NULL COMMENT 'Id de cliente registrado - NULL si no esta registrado',
  `frm_req_cli_nm` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Nombre y apellidos de la persona de contacto - para usuarios no registrados',
  `frm_req_mail` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'E-mail de la persona de contacto - para usuarios no registrados',
  `frm_req_reason_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del motivo de la solicitud',
  `frm_req_cmnt` varchar(250) collate utf8_spanish_ci NOT NULL COMMENT 'Comentarios del usuario',
  `frm_req_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado de la solicitud',
  `frm_req_id_operator` int(10) unsigned default NULL COMMENT 'Id del operador que gestiona la solicitud',
  `frm_req_cmt_operator` varchar(250) collate utf8_spanish_ci default NULL COMMENT 'Comentarios del operador',
  `frm_req_answer` text collate utf8_spanish_ci COMMENT 'Respuesta dada a la solicitud',
  `frm_req_end_cd` char(1) collate utf8_spanish_ci default NULL COMMENT 'Codigo del tipo de finalizacion de la solicitud',
  `frm_req_date_in` datetime NOT NULL COMMENT 'Fecha de creación de la solicitud',
  `frm_req_date_admin` datetime default NULL COMMENT 'Fecha de primera gestion por parte de un operador',
  `frm_req_date_out` datetime default NULL COMMENT 'Fecha de finalizacion de la solicitud',
  PRIMARY KEY  (`id_frm_req`),
  KEY `index_form_request.id_client` (`id_client`),
  KEY `fk_const_form_req.frm_req_reason_cd_on_form_req_reason` (`frm_req_reason_cd`),
  KEY `fk_const_form_req.frm_req_status_cd_on_form_req_status` (`frm_req_status_cd`),
  KEY `fk_const_form_req.frm_req_id_operator_on_user` (`frm_req_id_operator`),
  KEY `fk_const_form_req.frm_req_end_cd_on_form_req_end` (`frm_req_end_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Solicitudes recibidas a traves del formulario de Atencion al';

-- 
-- Volcar la base de datos para la tabla `form_request`
-- 

INSERT INTO `form_request` (`id_frm_req`, `id_client`, `frm_req_cli_nm`, `frm_req_mail`, `frm_req_reason_cd`, `frm_req_cmnt`, `frm_req_status_cd`, `frm_req_id_operator`, `frm_req_cmt_operator`, `frm_req_answer`, `frm_req_end_cd`, `frm_req_date_in`, `frm_req_date_admin`, `frm_req_date_out`) VALUES 
(1, NULL, 'ma', 'ma@ho.com', 'A', 'amshaklhsd', 'C', 1, NULL, NULL, 'C', '2008-01-02 14:37:21', '2008-01-05 11:47:34', '2008-01-05 11:47:42'),
(2, 2, 'ARNULFO PABON', 'apabonok@hotmail.com', 'E', 'funcionamiento correcto de cambios', 'N', NULL, NULL, NULL, NULL, '2008-01-05 11:55:11', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `form_request_end`
-- 

CREATE TABLE `form_request_end` (
  `frm_req_end_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de finalizacion de la solicitud',
  `frm_req_end_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `frm_req_end_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de finalizacion de la solicitud',
  `frm_req_end_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del tipo de finalizacion de la solicitud',
  `frm_req_end_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del tipo de finalizacion de la solicitud',
  PRIMARY KEY  (`frm_req_end_cd`,`frm_req_end_lang`),
  KEY `fk_const_form_request_end.frm_req_end_lang_on_language` (`frm_req_end_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de finalizacion que se le puede dar a una solicitud re';

-- 
-- Volcar la base de datos para la tabla `form_request_end`
-- 

INSERT INTO `form_request_end` (`frm_req_end_cd`, `frm_req_end_lang`, `frm_req_end_nm`, `frm_req_end_date_in`, `frm_req_end_date_out`) VALUES 
('C', 'SP', 'Cancelada\r', '2007-08-01 00:00:00', NULL),
('E', 'SP', 'Por e-mail\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'Por telefono', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `form_request_reason`
-- 

CREATE TABLE `form_request_reason` (
  `frm_req_reason_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del motivo de la solicitud',
  `frm_req_reason_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `frm_req_reason_nm` varchar(100) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del motivo de la solicitud',
  `frm_req_reason_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del motivo de la solicitud',
  `frm_req_reason_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del motivo de la solicitud',
  PRIMARY KEY  (`frm_req_reason_cd`,`frm_req_reason_lang`),
  KEY `fk_const_form_request_reason.frm_req_reason_lang_on_geography` (`frm_req_reason_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de motivos de solicitudes hechas por formulario de Ate';

-- 
-- Volcar la base de datos para la tabla `form_request_reason`
-- 

INSERT INTO `form_request_reason` (`frm_req_reason_cd`, `frm_req_reason_lang`, `frm_req_reason_nm`, `frm_req_reason_date_in`, `frm_req_reason_date_out`) VALUES 
('A', 'SP', 'Preguntas sobre el funcionamiento del servicio\r', '2007-08-01 00:00:00', NULL),
('B', 'SP', 'Problemas para la creacion de una cuenta de usuario\r', '2007-08-01 00:00:00', NULL),
('C', 'SP', 'Comentarios sobre la Atencion al Cliente\r', '2007-08-01 00:00:00', NULL),
('D', 'SP', 'Sugerencias u opiniones de la pagina web\r', '2007-08-01 00:00:00', NULL),
('E', 'SP', 'Otras consultas', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `form_request_status`
-- 

CREATE TABLE `form_request_status` (
  `frm_req_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado de la solicitud',
  `frm_req_status_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `frm_req_status_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado de la solicitud',
  `frm_req_status_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del estado de la solicitud',
  `frm_req_status_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del estado de la solicitud ',
  PRIMARY KEY  (`frm_req_status_cd`,`frm_req_status_lang`),
  KEY `fk_const_form_request_status.frm_req_status_cd_on_language` (`frm_req_status_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estados en los que se puede encontrar una solicitud hecha po';

-- 
-- Volcar la base de datos para la tabla `form_request_status`
-- 

INSERT INTO `form_request_status` (`frm_req_status_cd`, `frm_req_status_lang`, `frm_req_status_nm`, `frm_req_status_date_in`, `frm_req_status_date_out`) VALUES 
('C', 'SP', 'Cerrada\r', '2007-08-01 00:00:00', NULL),
('C', 'UK', 'Closed\r', '2007-08-01 00:00:00', NULL),
('N', 'SP', 'Nueva\r', '2007-08-01 00:00:00', NULL),
('N', 'UK', 'New\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'En Proceso\r', '2007-08-01 00:00:00', NULL),
('P', 'UK', 'Processing', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `geography`
-- 

CREATE TABLE `geography` (
  `geo_postal_cd` mediumint(8) unsigned NOT NULL COMMENT 'Codigo Postal',
  `geo_town` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Ciudad',
  `geo_department` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Provincia',
  `geo_region` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Comunidad',
  `geo_country_cd` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del pais',
  `geo_country` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Pais',
  `geo_date_in` datetime NOT NULL COMMENT 'Fecha de alta del nivel geografico',
  `geo_date_out` datetime default NULL COMMENT 'Fecha de baja del nivel geografico',
  `geo_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion del nivel geografico',
  PRIMARY KEY  (`geo_postal_cd`,`geo_country_cd`,`geo_date_mod`),
  KEY `index_geography.geo_town` (`geo_town`),
  KEY `index_geography.geo_department` (`geo_department`),
  KEY `index_geography.geo_region` (`geo_region`),
  KEY `index_geography.geo_country` (`geo_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contiene la estructura geografica de los paises';

-- 
-- Volcar la base de datos para la tabla `geography`
-- 

INSERT INTO `geography` (`geo_postal_cd`, `geo_town`, `geo_department`, `geo_region`, `geo_country_cd`, `geo_country`, `geo_date_in`, `geo_date_out`, `geo_date_mod`) VALUES 
(8001, 'BARCELONA', 'BARCELONA', 'CATALUNA', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(8910, 'BADALONA', 'BARCELONA', 'CATALUNA', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(15001, 'LA CORUNA', 'LA CORUNA', 'GALICIA', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(24001, 'LEON', 'LEON', 'CASTILLA Y LEON', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(27001, 'LUGO', 'LUGO', 'GALICIA', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28035, 'PENAGRANDE', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28042, 'MADRID', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28048, 'EL PARDO', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28100, 'LA MORALEJA', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28800, 'ALCALA DE HENARES', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28910, 'LEGANES', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28920, 'GETAFE', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(28930, 'MOSTOLES', 'MADRID', 'COMUNIDAD DE MADRID', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(46001, 'VALENCIA', 'VALENCIA', 'COMUNIDAD VALENCIANA', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00'),
(46700, 'GANDIA', 'VALENCIA', 'COMUNIDAD VALENCIANA', 'SP', 'SPAIN\r', '2007-08-01 00:00:00', NULL, '2007-08-01 00:00:00');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `identification_doc_type`
-- 

CREATE TABLE `identification_doc_type` (
  `ident_type_cd` char(4) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de documento de identificacion',
  `ident_type_country` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del pais',
  `ident_type_nm` varchar(10) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de documento de identificacion',
  `ident_type_dsc` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del tipo de documento de identificacion',
  `ident_type_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del tipo de documento de identificacion',
  `ident_type_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del tipo de documento de identificacion',
  PRIMARY KEY  (`ident_type_cd`,`ident_type_country`),
  KEY `index_identification_doc_type.ident_type_country` (`ident_type_country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de documento de identificacion posibles por pais';

-- 
-- Volcar la base de datos para la tabla `identification_doc_type`
-- 

INSERT INTO `identification_doc_type` (`ident_type_cd`, `ident_type_country`, `ident_type_nm`, `ident_type_dsc`, `ident_type_date_in`, `ident_type_date_out`) VALUES 
('EXTR', 'SP', 'NIE', 'Numero de Identificacion de Extranjeros\r', '2007-08-01 00:00:00', NULL),
('IDEN', 'SP', 'NIF', 'Numero de Identificacion Fiscal\r', '2007-08-01 00:00:00', NULL),
('PASS', 'SP', 'Pasaporte', 'Pasaporte\r', '2007-08-01 00:00:00', NULL),
('VAT', 'SP', 'CIF', 'Codigo de Identificaci', '2007-08-01 00:00:00', NULL),
('VAT', 'UK', 'VAT', 'Value Added Tax registration number\r', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `intern_predefined_message`
-- 

CREATE TABLE `intern_predefined_message` (
  `id_int_pre_mess` int(10) unsigned NOT NULL auto_increment COMMENT 'Id del mensaje predefinido interno',
  `int_cli_act_cd` char(3) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de actividad del cliente',
  `int_pre_mess_title` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Titulo del mensaje predefinido interno',
  `int_pre_mess_txt` text collate utf8_spanish_ci NOT NULL COMMENT 'Texto del mensaje predefinido interno',
  `int_pre_mess_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del mensaje predefinido interno',
  `int_pre_mess_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del mensaje predefinido interno',
  PRIMARY KEY  (`id_int_pre_mess`),
  KEY `fk_const_intern_predef_mess.int_cli_act_cd_on_client_activity` (`int_cli_act_cd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Mensajes predefinidos disponibles para los clientes segun su' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `intern_predefined_message`
-- 

INSERT INTO `intern_predefined_message` (`id_int_pre_mess`, `int_cli_act_cd`, `int_pre_mess_title`, `int_pre_mess_txt`, `int_pre_mess_date_in`, `int_pre_mess_date_out`) VALUES 
(1, 'DRU', 'Toma de Medicamentos', 'Su farmacia le recuerda que debe tomar sus medicamentos\r', '2007-08-01 00:00:00', NULL),
(2, 'DRU', 'Invitacion', 'Su farmacia le invita a acercarse a conocer las ofertas del mes\r', '2007-08-01 00:00:00', NULL),
(4, 'PAR', 'Toma de Medicamentos', 'Recuerda que es hora de la medicina', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `language`
-- 

CREATE TABLE `language` (
  `language_cd` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `language_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del idioma',
  `language_uk` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del idioma en Ingles',
  `language_sp` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del idioma en castellano',
  `language_date_in` datetime NOT NULL COMMENT 'Fecha de activacion del idioma',
  `language_date_out` datetime default NULL COMMENT 'Fecha de desactivacion del idioma',
  PRIMARY KEY  (`language_cd`),
  UNIQUE KEY `unique_language.language_nm` (`language_nm`),
  UNIQUE KEY `unique_language.language_uk` (`language_uk`),
  UNIQUE KEY `unique_language.language_sp` (`language_sp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Diferentes idiomas posibles para el sitio web';

-- 
-- Volcar la base de datos para la tabla `language`
-- 

INSERT INTO `language` (`language_cd`, `language_nm`, `language_uk`, `language_sp`, `language_date_in`, `language_date_out`) VALUES 
('SP', 'ESPAÑOL', 'SPANISH', 'ESPAÑOL', '2007-08-01 00:00:00', NULL),
('UK', 'ENGLISH', 'ENGLISH', 'INGLES', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `lost_account_registry`
-- 

CREATE TABLE `lost_account_registry` (
  `id_reg_lost_acc` int(10) unsigned NOT NULL auto_increment COMMENT 'Id del registro',
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente que solicita sus datos de acceso',
  `reg_lost_acc_date` datetime NOT NULL COMMENT 'Fecha de la solicitud de los datos de acceso',
  PRIMARY KEY  (`id_reg_lost_acc`),
  KEY `fk_constraint_lost_account_registry.id_client_on_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Registro de solicitudes de usuarios para recuperar datos de ' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `lost_account_registry`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `measure_med_taking`
-- 

CREATE TABLE `measure_med_taking` (
  `mea_med_tak_cd` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de medida de toma de medicina',
  `mea_med_tak_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `mea_med_tak_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre de medida de toma de medicina',
  `mea_med_tak_dsc` varchar(60) collate utf8_spanish_ci default NULL COMMENT 'Descripcion de medida de toma de medicina',
  `mea_med_tak_date_in` datetime NOT NULL COMMENT 'Fecha de inicio de medida de toma de medicina',
  `mea_med_tak_date_out` datetime default NULL COMMENT 'Fecha de finalizacion de medida de toma de medicina',
  PRIMARY KEY  (`mea_med_tak_cd`,`mea_med_tak_lang`),
  KEY `fk_constraint_measure_med_taking.mea_med_tak_lang_on_language` (`mea_med_tak_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Medidas para las tomas de medicamentos';

-- 
-- Volcar la base de datos para la tabla `measure_med_taking`
-- 

INSERT INTO `measure_med_taking` (`mea_med_tak_cd`, `mea_med_tak_lang`, `mea_med_tak_nm`, `mea_med_tak_dsc`, `mea_med_tak_date_in`, `mea_med_tak_date_out`) VALUES 
('C', 'SP', 'CUCHARADA', 'Cucharadas\r', '2007-08-01 00:00:00', NULL),
('CA', 'SP', 'CAPSULA', 'Capsulas', '2007-08-01 00:00:00', NULL),
('MG', 'SP', 'MG', 'Miligramos\r', '2007-08-01 00:00:00', NULL),
('ML', 'SP', 'ML', 'Mililitros\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'PILDORA', 'Pildora\r', '2007-08-01 00:00:00', NULL),
('S', 'SP', 'SOBRE', 'Sobres\r', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `message`
-- 

CREATE TABLE `message` (
  `id_message` int(10) unsigned NOT NULL COMMENT 'Id del mensaje',
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente que crea el mensaje',
  `mess_title` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Titulo del mensaje',
  `mess_txt1` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Primera parte del texto del mensaje',
  `mess_txt2` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Segunda parte del texto del mensaje',
  `mess_txt3` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Tercera parte del texto del mensaje',
  `mess_send_type_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de envio del mensaje',
  `mess_begin_date` datetime NOT NULL COMMENT 'Fecha de inicio de envio del mensaje',
  `mess_end_date` datetime NOT NULL COMMENT 'Fecha de fin de envio del mensaje',
  `mess_send_time` time NOT NULL COMMENT 'Hora de envio del mensaje',
  `mess_days` char(7) collate utf8_spanish_ci NOT NULL COMMENT 'Dias de envio del mensaje',
  `mess_consumed_credit` float NOT NULL COMMENT 'Credito ya consumido por el mensaje',
  `mess_pending_credit` float NOT NULL COMMENT 'Credito pendiente por consumir por el mensaje',
  `mess_total_credit` float NOT NULL COMMENT 'Credito total del mensaje',
  `mess_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado del mensaje',
  `mess_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - o es falso',
  `mess_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del mensaje',
  `mess_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion del mensaje',
  `mess_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del mensaje',
  PRIMARY KEY  (`id_message`,`mess_date_mod`),
  KEY `fk_const_message.id_client_on_client` (`id_client`),
  KEY `fk_const_message.mess_send_type_cd_on_message_sending_type` (`mess_send_type_cd`),
  KEY `fk_const_message.mess_status_cd_on_message_status` (`mess_status_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Mensajes que se envian por SMS - no de prescripciones';

-- 
-- Volcar la base de datos para la tabla `message`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `message_sending_type`
-- 

CREATE TABLE `message_sending_type` (
  `mess_send_type_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de envio de SMS',
  `mess_send_type_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `mess_send_type_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de envio de SMS',
  `mess_send_type_dsc` varchar(60) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del tipo de envio de SMS',
  `mess_send_type_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del tipo de envio de SMS',
  `mess_send_type_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del tipo de envio de SMS',
  PRIMARY KEY  (`mess_send_type_cd`,`mess_send_type_lang`),
  KEY `fk_const_message_sending_type.mess_send_type_lang_on_language` (`mess_send_type_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contiene los diferentes tipos de envio de SMS';

-- 
-- Volcar la base de datos para la tabla `message_sending_type`
-- 

INSERT INTO `message_sending_type` (`mess_send_type_cd`, `mess_send_type_lang`, `mess_send_type_nm`, `mess_send_type_dsc`, `mess_send_type_date_in`, `mess_send_type_date_out`) VALUES 
('D', 'SP', 'Directo', 'El SMS se envia inmediatamente.\r', '2007-08-01 00:00:00', NULL),
('D', 'UK', 'Direct', 'SMS is sent immediately.\r', '2007-08-01 00:00:00', NULL),
('M', 'SP', 'Mensual', 'El SMS se envia mensualmente para el mismo dia.\r', '2007-08-01 00:00:00', NULL),
('M', 'UK', 'Monthly', 'SMS is sent monthly for the same day.\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'Periodo', 'El SMS se envia de forma periodica durante un periodo.\r', '2007-08-01 00:00:00', NULL),
('P', 'UK', 'Period', 'SMS is sent periodically during a period.\r', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `message_status`
-- 

CREATE TABLE `message_status` (
  `mess_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado del mensaje',
  `mess_status_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `mess_status_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado del mensaje',
  `mess_status_dsc` varchar(100) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del estado del mensaje',
  `mess_status_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del estado del mensaje',
  `mess_status_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del estado del mensaje',
  PRIMARY KEY  (`mess_status_cd`,`mess_status_lang`),
  KEY `fk_constraint_message_status.mess_status_lang_on_language` (`mess_status_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estados en los cuales se puede encontrar un mensaje';

-- 
-- Volcar la base de datos para la tabla `message_status`
-- 

INSERT INTO `message_status` (`mess_status_cd`, `mess_status_lang`, `mess_status_nm`, `mess_status_dsc`, `mess_status_date_in`, `mess_status_date_out`) VALUES 
('C', 'SP', 'Cancelado', 'El mensaje ha sido cancelado por el usuario.\r', '2007-08-01 00:00:00', NULL),
('C', 'UK', 'Canceled', 'The message has been canceled by user.\r', '2007-08-01 00:00:00', NULL),
('D', 'SP', 'Suprimido', 'El mensaje ha sido suprimido por el usuario.\r', '2007-08-01 00:00:00', NULL),
('D', 'UK', 'Deleted', 'The message has been deleted by user.\r', '2007-08-01 00:00:00', NULL),
('E', 'SP', 'Enviado', 'El mensaje ha sido enviado.\r', '2007-08-01 00:00:00', NULL),
('E', 'UK', 'Sent', 'The message was sent.\r', '2007-08-01 00:00:00', NULL),
('G', 'SP', 'Guardado', 'El mensaje esta guardado pero no esta activo.\r', '2007-08-01 00:00:00', NULL),
('G', 'UK', 'Saved', 'The message has been saved but is not active.\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'En proceso', 'El mensaje esta en proceso.\r', '2007-08-01 00:00:00', NULL),
('P', 'UK', 'Processing', 'The message is in process.\r', '2007-08-01 00:00:00', NULL),
('S', 'SP', 'Programado', 'El mensaje ha sido programado.\r', '2007-08-01 00:00:00', NULL),
('S', 'UK', 'Scheduled', 'The message has been scheduled.', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `module`
-- 

CREATE TABLE `module` (
  `module_cd` char(5) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de opcion del modulo',
  `module_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `module_option_nm` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre de opcion del modulo',
  `module_option_dsc` varchar(255) collate utf8_spanish_ci default NULL COMMENT 'Descripcion de opcion del modulo',
  `module_nm` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del modulo',
  `module_dsc` varchar(255) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del modulo',
  `module_ord` smallint(5) unsigned NOT NULL COMMENT 'Orden de la opcion dentro del modulo',
  `module_url` varchar(120) collate utf8_spanish_ci default NULL COMMENT 'URL de ubicacion de la pagina para la opcion',
  `module_date_in` datetime NOT NULL COMMENT 'Fecha de creacion de opcion del modulo',
  `module_date_out` datetime default NULL COMMENT 'Fecha de finalizacion de opcion del modulo',
  PRIMARY KEY  (`module_cd`,`module_lang`),
  KEY `fk_constraint_module.module_lang_on_language` (`module_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Modulos del sitio web';

-- 
-- Volcar la base de datos para la tabla `module`
-- 

INSERT INTO `module` (`module_cd`, `module_lang`, `module_option_nm`, `module_option_dsc`, `module_nm`, `module_dsc`, `module_ord`, `module_url`, `module_date_in`, `module_date_out`) VALUES 
('CACCO', 'SP', 'CONSULTAR PETICIONES AL CAC', 'Opcion para consultar y atender peticiones enviadas al CAC', 'CAC', 'Modulo para administracion del CAC', 801, '../../ui/cac/queryFormRequest.php', '2007-08-01 00:00:00', NULL),
('CACNU', 'SP', 'SOLICITAR INFORMACION AL CAC', 'Opcion para solicitar informacion al Centro de Atencion al Cliente', 'CAC', 'Modulo para administracion del CAC', 802, '../../ui/helpdesk/addHelp.php', '2007-08-01 00:00:00', NULL),
('CLIAD', 'SP', 'ADMINISTRAR CLIENTE', 'Opcion para modificar informacion del cliente', 'CLIENTES', 'Modulo para administracion de clientes', 302, '../../ui/user/showUsers.php', '2007-09-29 00:00:00', NULL),
('CLINU', 'SP', 'NUEVO CLIENTE', 'Opcion para crear un nuevo cliente del sistema', 'CLIENTES', 'Modulo para administracion de clientes', 301, '../user/selectUserAct.php', '2007-09-29 00:00:00', NULL),
('CONAD', 'SP', 'ADMINISTRAR CONTACTO', 'Opcion para modificar o eliminar contactos existentes', 'CONTACTOS', 'Modulo para gestion de contactos', 402, '../../ui/contacts/showContacts.php', '2007-08-01 00:00:00', NULL),
('CONNU', 'SP', 'NUEVO CONTACTO', 'Opcion para creacion de nuevos contactos', 'CONTACTOS', 'Modulo para gestion de contactos', 401, '../../control/contacts/selContact.php', '2007-08-01 00:00:00', NULL),
('CREAD', 'SP', 'ADMINISTRAR BONO', 'Opcion para modificar informacion del bono', 'CREDITO', 'Modulo para gestion de credito', 702, '../../ui/credit/showBonus.php', '2007-08-01 00:00:00', NULL),
('CRECO', 'SP', 'COMPRA CREDITO', 'Opcion para comprar credito', 'CREDITO', 'Modulo para gestion de credito', 705, '../../ui/credit/buyCredit.php', '2007-08-01 00:00:00', NULL),
('CRECR', 'SP', 'CREDITOS COMPRADOS', 'Opcion para consultar las compras realizadas', 'CREDITO', 'Modulo para gestion de credito', 704, '../../ui/credit/showBoughtCredit.php', '2007-08-01 00:00:00', NULL),
('CREES', 'SP', 'ESTADO CREDITO', 'Opcion para consultar el estado del credito', 'CREDITO', 'Modulo para gestion de credito', 703, '../../ui/credit/showCredit.php', '2007-08-01 00:00:00', NULL),
('CRENU', 'SP', 'NUEVO BONO', 'Opcion para la creacion de bonos', 'CREDITO', 'Modulo para gestion de credito', 701, '../../ui/credit/addBonus.php', '2007-08-01 00:00:00', NULL),
('CRETA', 'SP', 'TARIFAS', 'Opcion para consultar tarifas', 'CREDITO', 'Modulo para gestion de credito', 706, '../../ui/credit/creditCharge.php', '2007-08-01 00:00:00', NULL),
('PERAD', 'SP', 'ADMINISTRAR PERFIL', 'Opcion para gestionar perfiles existentes', 'PERFIL', 'Modulo para administracion del perfil de usuario', 102, '../../ui/profile/showProfiles.php', '2007-08-01 00:00:00', NULL),
('PERDA', 'SP', 'DATOS DE ACCESO', 'Opcion para administrar los datos de acceso', 'PERFIL', 'Modulo para administracion del perfil de usuario', 103, '../../ui/user/showUserDataAcces.php', '2007-08-01 00:00:00', NULL),
('PERDB', 'SP', 'DARSE DE BAJA', 'Opcion para darse de baja en el sistema', 'PERFIL', 'Modulo para administracion del perfil de usuario', 105, '../../ui/user/userDown.php', '2007-08-01 00:00:00', NULL),
('PERDP', 'SP', 'DATOS PERSONALES', 'Opcion para administrar los datos personales', 'PERFIL', 'Modulo para administracion del perfil de usuario', 104, '../../ui/user/showUserData.php', '2007-08-01 00:00:00', NULL),
('PERNU', 'SP', 'NUEVO PERFIL', 'Opcion para creacion de nuevos perfiles', 'PERFIL', 'Modulo para administracion del perfil de usuario', 101, '../../ui/profile/addProfile.php', '2007-08-01 00:00:00', NULL),
('PREAC', 'SP', 'PRESCRIPCIONES ACTIVAS', 'Opcion para modificar o eliminar prescripciones activas', 'PRESCRIPCIONES', 'Modulo para gestion de prescripciones', 502, NULL, '2007-08-01 00:00:00', NULL),
('PREGU', 'SP', 'PRESCRIPCIONES GUARDADAS', 'Opcion para modificar o eliminar prescripciones guardadas', 'PRESCRIPCIONES', 'Modulo para gestion de prescripciones', 503, NULL, '2007-08-01 00:00:00', NULL),
('PRENU', 'SP', 'NUEVA PRESCRIPCION', 'Opcion para creacion de nuevas prescripciones', 'PRESCRIPCIONES', 'Modulo para gestion de prescripciones', 501, '../../ui/prescription/selectAlertType.php', '2007-08-01 00:00:00', NULL),
('SMSAC', 'SP', 'SMS ACTIVOS', 'Opcion para modificacion o eliminacion de SMS activos', 'SMS', 'Modulo para gestion de SMS', 602, NULL, '2007-08-01 00:00:00', NULL),
('SMSGU', 'SP', 'SMS GUARDADOS', 'Opcion para modificacion o eliminacion de SMS guardados', 'SMS', 'Modulo para gestion de SMS', 603, NULL, '2007-08-01 00:00:00', NULL),
('SMSNU', 'SP', 'NUEVO SMS', 'Opcion para creacion de nuevos mensajes SMS', 'SMS', 'Modulo para gestion de SMS', 601, NULL, '2007-08-01 00:00:00', NULL),
('USUAD', 'SP', 'ADMINISTRAR USUARIO', 'Opcion para modificar informacion del usuario', 'USUARIOS', 'Modulo para administracion de usuarios', 202, '../../ui/user/showUsersInternals.php', '2007-08-01 00:00:00', NULL),
('USUNU', 'SP', 'NUEVO USUARIO', 'Opcion para crear un nuevo usuario del sistema', 'USUARIOS', 'Modulo para administracion de usuarios', 201, '../../ui/user/addUserInternal.php', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `moment`
-- 

CREATE TABLE `moment` (
  `cod_moment` smallint(5) unsigned NOT NULL auto_increment COMMENT 'Codigo del momento',
  `moment_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `moment_nm` varchar(20) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del momento',
  `moment_def_hour` time NOT NULL COMMENT 'Hora por defecto del momento',
  `moment_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del momento',
  `moment_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del momento',
  PRIMARY KEY  (`cod_moment`,`moment_lang`),
  KEY `fk_constraint_moment.moment_lang_on_language` (`moment_lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Diferentes momentos del dia en los cuales se envian alertas ' AUTO_INCREMENT=7 ;

-- 
-- Volcar la base de datos para la tabla `moment`
-- 

INSERT INTO `moment` (`cod_moment`, `moment_lang`, `moment_nm`, `moment_def_hour`, `moment_date_in`, `moment_date_out`) VALUES 
(1, 'SP', 'el desayuno', '07:00:00', '2007-08-01 00:00:00', NULL),
(1, 'UK', 'the breakfast', '07:00:00', '2007-08-01 00:00:00', NULL),
(2, 'SP', 'la media manana', '11:00:00', '2007-08-01 00:00:00', NULL),
(2, 'UK', 'the morning', '11:00:00', '2007-08-01 00:00:00', NULL),
(3, 'SP', 'la comida', '14:00:00', '2007-08-01 00:00:00', NULL),
(3, 'UK', 'the lunch', '14:00:00', '2007-08-01 00:00:00', NULL),
(4, 'SP', 'la media tarde', '18:00:00', '2007-08-01 00:00:00', NULL),
(4, 'UK', 'the afternoon', '18:00:00', '2007-08-01 00:00:00', NULL),
(5, 'SP', 'la cena', '21:00:00', '2007-08-01 00:00:00', NULL),
(5, 'UK', 'the dinner', '21:00:00', '2007-08-01 00:00:00', NULL),
(6, 'SP', 'la noche', '23:00:00', '2007-08-01 00:00:00', NULL),
(6, 'UK', 'the night', '23:00:00', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `predefined_message`
-- 

CREATE TABLE `predefined_message` (
  `id_pre_mess` int(10) unsigned NOT NULL auto_increment COMMENT 'Id del mensaje predefinido del cliente',
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente',
  `pre_mess_title` varchar(50) collate utf8_spanish_ci NOT NULL COMMENT 'Titulo del mensaje predefinido',
  `pre_mess_txt` text collate utf8_spanish_ci NOT NULL COMMENT 'Texto del mensaje predefinido',
  `pre_mess_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del mensaje predefinido',
  `pre_mess_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del mensaje predefinido',
  PRIMARY KEY  (`id_pre_mess`),
  KEY `fk_constraint_predefined_message.id_client_on_client` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Mensajes predefinidos creados por los clientes' AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `predefined_message`
-- 

INSERT INTO `predefined_message` (`id_pre_mess`, `id_client`, `pre_mess_title`, `pre_mess_txt`, `pre_mess_date_in`, `pre_mess_date_out`) VALUES 
(1, 1, 'Mensaje de prueba', 'Este mensaje es una prueba\r', '2007-08-01 00:00:00', NULL),
(2, 2, 'Mensaje de Bienvenida', 'Este mensaje de bienvenida es una prueba', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `prescription`
-- 

CREATE TABLE `prescription` (
  `id_prescription` int(10) unsigned NOT NULL COMMENT 'Id de la prescripcion',
  `id_contact` int(10) unsigned NOT NULL COMMENT 'Id del contacto que recibira las alertas',
  `pres_mess_type_cd` char(1) collate utf8_spanish_ci default NULL COMMENT 'Codigo del tipo de mensaje para las alertas por SMS',
  `pres_mess_txt1` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Primera parte del texto del mensaje de la prescripcion',
  `pres_mess_txt2` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Segunda parte del texto del mensaje de la prescripcion',
  `pres_mess_txt3` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Tercera parte del texto del mensaje de la prescripcion',
  `pres_cmnt_freq_cd` char(1) collate utf8_spanish_ci default NULL COMMENT 'Codigo de la frecuencia de envio de las observaciones con las alertas',
  `pres_cmnt_txt1` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Primera parte del texto de las observaciones',
  `pres_cmnt_txt2` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Segunda parte del texto de las observaciones',
  `pres_cmnt_txt3` varchar(160) collate utf8_spanish_ci default NULL COMMENT 'Tercera parte del texto de las observaciones',
  `pres_consumed_credit` float default NULL COMMENT 'Credito ya consumido por la prescripcion',
  `pres_pending_credit` float default NULL COMMENT 'Credito pendiente por consumir por la prescripcion',
  `pres_total_credit` float default NULL COMMENT 'Credito total de la prescripcion',
  `pres_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado de la prescripcion',
  `pres_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - o es falso',
  `pres_date_in` datetime NOT NULL COMMENT 'Fecha de creacion de la prescripcion',
  `pres_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion de la prescripcion',
  `pres_date_out` datetime default NULL COMMENT 'Fecha de finalizacion de la prescripcion',
  PRIMARY KEY  (`id_prescription`,`pres_date_mod`),
  KEY `fk_const_prescription.id_contact_on_contact` (`id_contact`),
  KEY `fk_const_prescription.pres_mess_type_cd_on_prescription_message` (`pres_mess_type_cd`),
  KEY `fk_const_prescription.pres_cmnt_freq_cd_on_prescript_cmnt_freq` (`pres_cmnt_freq_cd`),
  KEY `fk_const_prescription.pres_status_cd_on_prescription_status` (`pres_status_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Prescripciones creadas';

-- 
-- Volcar la base de datos para la tabla `prescription`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `prescription_cmnt_freq`
-- 

CREATE TABLE `prescription_cmnt_freq` (
  `pres_cmnt_freq_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de frecuencia de envio de las observaciones',
  `pres_cmnt_freq_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `pres_cmnt_freq_nm` varchar(30) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de frecuencia de envio de las observaciones',
  `pres_cmnt_freq_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del tipo de frecuencia de envio de las observaciones',
  `pres_cmnt_freq_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del tipo de frecuencia de envio de las observaciones',
  PRIMARY KEY  (`pres_cmnt_freq_cd`,`pres_cmnt_freq_lang`),
  KEY `fk_const_prescription_cmnt_freq.pres_cmnt_freq_lang_on_language` (`pres_cmnt_freq_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de frecuencia de envio de las observaciones de las pre';

-- 
-- Volcar la base de datos para la tabla `prescription_cmnt_freq`
-- 

INSERT INTO `prescription_cmnt_freq` (`pres_cmnt_freq_cd`, `pres_cmnt_freq_lang`, `pres_cmnt_freq_nm`, `pres_cmnt_freq_date_in`, `pres_cmnt_freq_date_out`) VALUES 
('A', 'SP', 'Con todas las alertas\r', '2007-08-01 00:00:00', NULL),
('A', 'UK', 'With all alerts\r', '2007-08-01 00:00:00', NULL),
('D', 'SP', 'Una vez por dia\r', '2007-08-01 00:00:00', NULL),
('D', 'UK', 'Once a day\r', '2007-08-01 00:00:00', NULL),
('N', 'SP', 'Nunca\r', '2007-08-01 00:00:00', NULL),
('N', 'UK', 'Never\r', '2007-08-01 00:00:00', NULL),
('S', 'SP', 'Solo con la primera alerta\r', '2007-08-01 00:00:00', NULL),
('S', 'UK', 'Only with the first alert\r', '2007-08-01 00:00:00', NULL),
('W', 'SP', 'Una vez por semana\r', '2007-08-01 00:00:00', NULL),
('W', 'UK', 'Once a week', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `prescription_message`
-- 

CREATE TABLE `prescription_message` (
  `pres_mess_type_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de mensaje',
  `pres_mess_type_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `pres_mess_type_nm` varchar(20) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del tipo de mensaje',
  `pres_mess_type_dsc` varchar(100) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del tipo de mensaje',
  `pres_mess_type_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del tipo de mensaje',
  `pres_mess_type_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del tipo de mensaje',
  PRIMARY KEY  (`pres_mess_type_cd`,`pres_mess_type_lang`),
  KEY `fk_const_prescription_message.pres_mess_type_lang_on_language` (`pres_mess_type_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tipos de mensaje que se pueden enviar con las alertas SMS pa';

-- 
-- Volcar la base de datos para la tabla `prescription_message`
-- 

INSERT INTO `prescription_message` (`pres_mess_type_cd`, `pres_mess_type_lang`, `pres_mess_type_nm`, `pres_mess_type_dsc`, `pres_mess_type_date_in`, `pres_mess_type_date_out`) VALUES 
('D', 'SP', 'Estandar detallado', 'Es un mensaje estandar que contiene toda la informacion detallada de la medicacion.\r', '2007-08-01 00:00:00', NULL),
('D', 'UK', 'Detailed standard\r', NULL, '2007-08-01 00:00:00', NULL),
('F', 'SP', 'Libre', 'El mensaje libre esta redactado por el propio usuario.\r', '2007-08-01 00:00:00', NULL),
('F', 'UK', 'Free\r', NULL, '2007-08-01 00:00:00', NULL),
('P', 'SP', 'Personal predefinido', 'El mensaje personal predefinido esta redactado y guardado por el propio usuario.\r', '2007-08-01 00:00:00', NULL),
('P', 'UK', 'Predefined personal\r', NULL, '2007-08-01 00:00:00', NULL),
('S', 'SP', 'Estandar simple', 'El mensaje estandar simple corresponde a una frase predefinida.\r', '2007-08-01 00:00:00', NULL),
('S', 'UK', 'Simple standard', NULL, '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `prescription_status`
-- 

CREATE TABLE `prescription_status` (
  `pres_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado de la prescripcion',
  `pres_status_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `pres_status_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado de la prescripcion',
  `pres_status_dsc` varchar(100) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del estado de la prescripcion',
  `pres_status_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del estado de la prescripcion',
  `pres_status_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del estado de la prescripcion',
  PRIMARY KEY  (`pres_status_cd`,`pres_status_lang`),
  KEY `fk_constraint_prescription_status.pres_status_lang_on_language` (`pres_status_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estados en los cuales se puede encontrar una prescripcion';

-- 
-- Volcar la base de datos para la tabla `prescription_status`
-- 

INSERT INTO `prescription_status` (`pres_status_cd`, `pres_status_lang`, `pres_status_nm`, `pres_status_dsc`, `pres_status_date_in`, `pres_status_date_out`) VALUES 
('A', 'SP', 'Activa', 'La prescripcion activa ya ha empezado.\r', '2007-08-01 00:00:00', NULL),
('A', 'UK', 'Active', 'Active prescription is already running.\r', '2007-08-01 00:00:00', NULL),
('C', 'SP', 'Cancelada', 'La prescripcion ha sido cancelada por el usuario.\r', '2007-08-01 00:00:00', NULL),
('C', 'UK', 'Canceled', 'Canceled prescription has been stopped by the user.\r', '2007-08-01 00:00:00', NULL),
('D', 'SP', 'Suprimida', 'La prescripcion ha sido suprimida por el usuario.\r', '2007-08-01 00:00:00', NULL),
('D', 'UK', 'Deleted', 'Prescription has been deleted by user.\r', '2007-08-01 00:00:00', NULL),
('E', 'SP', 'Terminada', 'La prescripcion ha terminado.\r', '2007-08-01 00:00:00', NULL),
('E', 'UK', 'Ended', 'Ended prescription has run and has finalized.\r', '2007-08-01 00:00:00', NULL),
('P', 'SP', 'Pendiente', 'La prescripcion esta programada pero no ha empezado.\r', '2007-08-01 00:00:00', NULL),
('P', 'UK', 'Pending', 'Pending prescription is scheduled but have not started yet.\r', '2007-08-01 00:00:00', NULL),
('S', 'SP', 'Guardada', 'El usuario tiene que activar la prescripcion.\r', '2007-08-01 00:00:00', NULL),
('S', 'UK', 'Saved', 'Saved prescription is waiting for the user to active it.\r', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `purchase`
-- 

CREATE TABLE `purchase` (
  `id_purchase` int(10) unsigned NOT NULL auto_increment COMMENT 'Id de la compra',
  `id_client` int(10) unsigned NOT NULL COMMENT 'Id del cliente',
  `id_credit` int(10) unsigned NOT NULL COMMENT 'Id del bono',
  `purchase_date_in` datetime NOT NULL COMMENT 'Fecha de la compra',
  PRIMARY KEY  (`id_purchase`),
  KEY `fk_constraint_purchase.id_client_on_client` (`id_client`),
  KEY `fk_constraint_purchase.id_credit_on_credit` (`id_credit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Registro de las compras de bonos' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `purchase`
-- 

INSERT INTO `purchase` (`id_purchase`, `id_client`, `id_credit`, `purchase_date_in`) VALUES 
(1, 2, 1, '2008-01-09 12:17:33');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `registry_connection`
-- 

CREATE TABLE `registry_connection` (
  `id_connection` int(10) unsigned NOT NULL auto_increment COMMENT 'Id de la conexion',
  `id_user` int(10) unsigned NOT NULL COMMENT 'Id del usuario',
  `connection_begin_date` datetime NOT NULL COMMENT 'Fecha de inicio de la conexion',
  `connection_end_date` datetime default NULL COMMENT 'Fecha de fin de la conexion',
  `connection_duration` mediumint(8) unsigned default NULL COMMENT 'Duracion de la conexion en segundos',
  PRIMARY KEY  (`id_connection`),
  KEY `fk_constraint_registry_connection.id_user_on_users` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Registro de conexiones al area privada' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `registry_connection`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_bill_purchase`
-- 

CREATE TABLE `rel_bill_purchase` (
  `id_bill` int(10) unsigned NOT NULL COMMENT 'Id de la factura',
  `id_purchase` int(10) unsigned NOT NULL COMMENT 'Id de la compra',
  `rel_bill_pur_date_in` datetime NOT NULL COMMENT 'Fecha de carga del registro',
  PRIMARY KEY  (`id_bill`,`id_purchase`),
  KEY `fk_constraint_rel_bill_purchase.id_purchase_on_purchase` (`id_purchase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Relaciona facturas con compras';

-- 
-- Volcar la base de datos para la tabla `rel_bill_purchase`
-- 

INSERT INTO `rel_bill_purchase` (`id_bill`, `id_purchase`, `rel_bill_pur_date_in`) VALUES 
(1, 1, '2008-01-09 14:00:21');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_mess_contact`
-- 

CREATE TABLE `rel_mess_contact` (
  `id_message` int(10) unsigned NOT NULL COMMENT 'Id del mensaje',
  `id_contact` int(10) unsigned NOT NULL COMMENT 'Id del contacto',
  `mess_cont_date_in` datetime NOT NULL COMMENT 'Fecha de activacion del contacto para el mensaje',
  `mess_cont_date_out` datetime default NULL COMMENT 'Fecha de desactivacion del contacto para el mensaje',
  PRIMARY KEY  (`id_message`,`id_contact`),
  KEY `fk_constraint_rel_mess_contact.id_contact_on_contact` (`id_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Relaciona los mensajes con los contactos de destino';

-- 
-- Volcar la base de datos para la tabla `rel_mess_contact`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_pres_alert`
-- 

CREATE TABLE `rel_pres_alert` (
  `id_prescription` int(10) unsigned NOT NULL COMMENT 'Id de la prescripcion',
  `alert_type_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del tipo de alerta',
  `pres_alert_date_in` datetime NOT NULL COMMENT 'Fecha de activacion de la alerta para la prescripcion',
  `pres_alert_date_out` datetime default NULL COMMENT 'Fecha de desactivacion de la alerta para la prescripcion',
  PRIMARY KEY  (`id_prescription`,`alert_type_cd`),
  KEY `fk_const_rel_pres_alert.id_alert_type_cd_on_alert_type` (`alert_type_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Relaciona la prescripcion con los tipos de alertas';

-- 
-- Volcar la base de datos para la tabla `rel_pres_alert`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_pres_med`
-- 

CREATE TABLE `rel_pres_med` (
  `id_medicine` int(10) unsigned NOT NULL COMMENT 'Id de la posologia',
  `id_prescription` int(10) unsigned NOT NULL COMMENT 'Id de la prescripcion',
  `med_drug_nm` varchar(50) collate utf8_spanish_ci default NULL COMMENT 'Nombre del medicamento',
  `med_begin_date` datetime NOT NULL COMMENT 'Fecha de inicio del tratamiento',
  `med_end_date` datetime NOT NULL COMMENT 'Fecha de fin del tratamiento',
  `med_days` char(7) collate utf8_spanish_ci NOT NULL COMMENT 'Dias de la semana para toma del medicamento',
  `mea_med_tak_cd` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Medida de la toma del medicamento',
  `med_brkfst_qty` float NOT NULL COMMENT 'Cantidad del medicamento a tomar en el desayuno',
  `med_brkfst_time` time default NULL COMMENT 'Hora de toma del medicamento al desayuno',
  `med_mrnng_qty` float NOT NULL COMMENT 'Cantidad del medicamento a tomar en la media mañana',
  `med_mrnng_time` time default NULL COMMENT 'Hora de toma del medicamento en la media mañana',
  `med_lnch_qty` float NOT NULL COMMENT 'Cantidad del medicamento a tomar en la comida',
  `med_lnch_time` time default NULL COMMENT 'Hora de toma del medicamento en la comida',
  `med_aftrnn_qty` float NOT NULL COMMENT 'Cantidad del medicamento a tomar en la tarde',
  `med_aftrnn_time` time default NULL COMMENT 'Hora de toma del medicamento en la tarde',
  `med_dnnr_qty` float NOT NULL COMMENT 'Cantidad del medicamento a tomar en la cena',
  `med_dnnr_time` time default NULL COMMENT 'Hora de toma del medicamento en la cena',
  `med_nght_qty` float NOT NULL COMMENT 'Cantidad del medicamento a tomar en la noche',
  `med_nght_time` time default NULL COMMENT 'Hora de toma del medicamento en la noche',
  `med_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - 0 es falso',
  `med_date_in` datetime NOT NULL COMMENT 'Fecha de activacion de la posologia',
  `med_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion de la posologia',
  `med_date_out` datetime default NULL COMMENT 'Fecha de desactivacion de la posologia',
  PRIMARY KEY  (`id_medicine`,`med_date_mod`),
  KEY `fk_const_rel_pres_med.id_prescription_on_prescription` (`id_prescription`),
  KEY `fk_const_rel_pres_med.mea_med_tak_cd_on_measure_med_taking` (`mea_med_tak_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Relaciona las prescripciones con las diferentes posologias';

-- 
-- Volcar la base de datos para la tabla `rel_pres_med`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rel_prof_module`
-- 

CREATE TABLE `rel_prof_module` (
  `user_prof_cd` char(5) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del perfil',
  `module_cd` char(5) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo de la opcion del modulo',
  `prof_mod_current_flag` tinyint(1) NOT NULL COMMENT 'Flag que indica el registro vigente',
  `prof_mod_date_mod` datetime NOT NULL COMMENT 'Fecha de modificación de la opcion del modulo al perfil ',
  PRIMARY KEY  (`user_prof_cd`,`module_cd`,`prof_mod_date_mod`),
  KEY `fk_constraint_rel_prof_module.module_cd_on_module` (`module_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Relacion de las opciones de los modulos con los perfiles de ';

-- 
-- Volcar la base de datos para la tabla `rel_prof_module`
-- 

INSERT INTO `rel_prof_module` (`user_prof_cd`, `module_cd`, `prof_mod_current_flag`, `prof_mod_date_mod`) VALUES 
('ADMIN', 'CACCO', 1, '2007-08-15 00:00:00'),
('ADMIN', 'CLIAD', 1, '2007-12-14 07:47:52'),
('ADMIN', 'CLINU', 1, '2007-12-14 07:47:52'),
('ADMIN', 'CREAD', 1, '2007-08-15 00:00:00'),
('ADMIN', 'CRENU', 1, '2007-08-15 00:00:00'),
('ADMIN', 'PERAD', 1, '2007-08-15 00:00:00'),
('ADMIN', 'PERDA', 1, '2007-08-15 00:00:00'),
('ADMIN', 'PERNU', 1, '2007-08-15 00:00:00'),
('ADMIN', 'USUAD', 1, '2007-08-15 00:00:00'),
('ADMIN', 'USUNU', 1, '2007-08-15 00:00:00'),
('DRU', 'CONAD', 0, '2008-01-08 11:59:58'),
('DRU', 'CONAD', 1, '2008-01-09 12:52:47'),
('DRU', 'CONNU', 0, '2008-01-08 11:59:58'),
('DRU', 'CONNU', 1, '2008-01-09 12:52:47'),
('DRU', 'CRECO', 1, '2008-01-09 12:52:47'),
('DRU', 'CRECR', 1, '2008-01-09 12:52:47'),
('DRU', 'CREES', 1, '2008-01-09 12:52:47'),
('DRU', 'CRETA', 1, '2008-01-09 12:52:47'),
('PAR', 'CACNU', 1, '2007-08-15 00:00:00'),
('PAR', 'CONAD', 1, '2007-08-15 00:00:00'),
('PAR', 'CONNU', 1, '2007-08-15 00:00:00'),
('PAR', 'CRECO', 1, '2007-08-15 00:00:00'),
('PAR', 'CRECR', 1, '2007-08-15 00:00:00'),
('PAR', 'CREES', 1, '2007-08-15 00:00:00'),
('PAR', 'CRETA', 1, '2007-08-15 00:00:00'),
('PAR', 'PERDA', 1, '2007-08-15 00:00:00'),
('PAR', 'PERDB', 1, '2007-08-15 00:00:00'),
('PAR', 'PERDP', 1, '2007-08-15 00:00:00'),
('PAR', 'PREAC', 1, '2007-08-15 00:00:00'),
('PAR', 'PREGU', 1, '2007-08-15 00:00:00'),
('PAR', 'PRENU', 1, '2007-08-15 00:00:00'),
('PAR', 'SMSAC', 1, '2007-08-15 00:00:00'),
('PAR', 'SMSGU', 1, '2007-08-15 00:00:00'),
('PAR', 'SMSNU', 1, '2007-08-15 00:00:00'),
('VET', 'CONAD', 0, '2008-01-08 11:59:41'),
('VET', 'CONAD', 1, '2008-01-09 12:52:31'),
('VET', 'CONNU', 0, '2008-01-08 11:59:41'),
('VET', 'CONNU', 1, '2008-01-09 12:52:31'),
('VET', 'CRECO', 1, '2008-01-09 12:52:31'),
('VET', 'CRECR', 1, '2008-01-09 12:52:31'),
('VET', 'CREES', 1, '2008-01-09 12:52:31'),
('VET', 'CRETA', 1, '2008-01-09 12:52:31');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `sex`
-- 

CREATE TABLE `sex` (
  `sex_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del sexo',
  `sex_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `sex_nm` varchar(10) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del sexo',
  `sex_treatment` varchar(5) collate utf8_spanish_ci default NULL COMMENT 'Tratamiento correspondiente al sexo',
  `sex_date_in` datetime NOT NULL COMMENT 'Fecha de alta del sexo',
  `sex_date_out` datetime default NULL COMMENT 'Fecha de baja del sexo',
  PRIMARY KEY  (`sex_cd`,`sex_lang`),
  KEY `fk_constraint_sex.sex_lang_on_language` (`sex_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contiene los sexos';

-- 
-- Volcar la base de datos para la tabla `sex`
-- 

INSERT INTO `sex` (`sex_cd`, `sex_lang`, `sex_nm`, `sex_treatment`, `sex_date_in`, `sex_date_out`) VALUES 
('M', 'SP', 'HOMBRE', 'SR', '2007-08-01 00:00:00', NULL),
('M', 'UK', 'MAN', 'MR ', '2007-08-01 00:00:00', NULL),
('W', 'SP', 'MUJER', 'SRA', '2007-08-01 00:00:00', NULL),
('W', 'UK', 'WOMAN', 'MRS', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `users`
-- 

CREATE TABLE `users` (
  `id_user` int(10) unsigned NOT NULL COMMENT 'ID del usuario',
  `id_client` int(10) unsigned NOT NULL COMMENT 'ID del cliente correspondiente',
  `user_prof_cd` char(5) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del perfil del usuario',
  `user_login` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre de usuario',
  `user_pass` varchar(10) collate utf8_spanish_ci NOT NULL COMMENT 'Contraseña del usuario',
  `user_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado del usuario',
  `user_prefer_lang` char(2) collate utf8_spanish_ci default NULL COMMENT 'Idioma preferido del usuario en el sitio',
  `user_info_cre` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Usuario que crea el usuario',
  `user_info_upd` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Ultimo usuario que modifica info del usuario',
  `user_date_req` datetime NOT NULL COMMENT 'Fecha de solicitud del usuario',
  `user_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - 0 es falso',
  `user_date_in` datetime NOT NULL COMMENT 'Fecha de alta del usuario',
  `user_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion de la informacion del usuario',
  `user_date_out` datetime default NULL COMMENT 'Fecha de baja del usuario',
  `user_out_reason` varchar(250) collate utf8_spanish_ci default NULL COMMENT 'Explicacion de baja del usuario',
  PRIMARY KEY  (`id_user`,`user_date_mod`),
  KEY `index_users.user_login` (`user_login`),
  KEY `fk_constraint_users.id_client_on_client` (`id_client`),
  KEY `fk_constraint_users.user_prof_cd_on_user_profile` (`user_prof_cd`),
  KEY `fk_constraint_users.user_prefer_lang_on_language` (`user_prefer_lang`),
  KEY `fk_constraint_users.user_status_cd_on_user_status` (`user_status_cd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contiene informacion relativa a los usuario del portal';

-- 
-- Volcar la base de datos para la tabla `users`
-- 

INSERT INTO `users` (`id_user`, `id_client`, `user_prof_cd`, `user_login`, `user_pass`, `user_status_cd`, `user_prefer_lang`, `user_info_cre`, `user_info_upd`, `user_date_req`, `user_current_flag`, `user_date_in`, `user_date_mod`, `user_date_out`, `user_out_reason`) VALUES 
(1, 1, 'ADMIN', 'lcastro', 'lcastro', 'A', 'SP', 'lcastro', 'lcastro', '2007-12-14 07:55:21', 1, '2007-12-14 07:55:21', '2007-12-14 07:55:21', NULL, NULL),
(2, 2, 'PAR', 'apabon', 'apabon', 'A', 'SP', 'apabon', 'apabon', '2007-12-14 07:55:21', 1, '2007-12-14 07:55:21', '2007-12-14 07:55:21', NULL, NULL),
(3, 3, 'ADMIN', 'vmanuel', 'vmanuel', 'A', 'SP', 'lcastro', 'lcastro', '2008-01-04 14:50:00', 0, '2008-01-04 14:50:00', '2008-01-04 14:50:00', '2008-01-04 14:50:00', NULL),
(3, 3, 'ADMIN', 'vmanuel', 'vmanuel', 'A', 'SP', 'lcastro', 'lcastro', '2008-01-04 14:50:00', 1, '2008-01-04 14:50:00', '2008-01-05 11:16:39', '2008-01-31 11:16:39', NULL),
(4, 4, 'PAR', 'candres', 'candres', 'C', 'SP', 'lcastro', 'candres', '2008-01-04 14:53:09', 1, '2008-01-04 14:53:09', '2008-01-04 14:53:09', '2008-01-07 10:19:31', NULL),
(5, 5, 'OPER', 'crojas', 'crojas', 'A', 'SP', 'lcastro', 'lcastro', '2008-01-05 11:15:15', 1, '2008-01-05 11:15:15', '2008-01-05 11:15:15', NULL, NULL),
(6, 6, 'COMER', 'lmario', 'lmario', 'A', 'SP', 'lcastro', 'lcastro', '2008-01-05 11:57:44', 1, '2008-01-07 11:57:44', '2008-01-05 11:57:44', NULL, NULL),
(7, 7, 'DRU', 'jomira', 'jomira', 'A', 'SP', 'lcastro', 'lcastro', '2008-01-06 10:02:36', 1, '2008-01-06 10:02:36', '2008-01-08 11:53:15', NULL, NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `user_profile`
-- 

CREATE TABLE `user_profile` (
  `user_prof_cd` char(5) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del perfil de usuario',
  `user_prof_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `user_prof_nm` varchar(20) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del perfil de usuario',
  `user_prof_group_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del grupo del perfil de usuario',
  `user_prof_group_nm` varchar(10) collate utf8_spanish_ci default NULL COMMENT 'Nombrel del grupo del perfil de usuario',
  `user_prof_current_flag` tinyint(1) NOT NULL COMMENT 'Indica el registro vigente - 0 es no vigente',
  `user_prof_cre` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Login de usuario que crea el perfil',
  `user_prof_upd` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Login de ultimo usuario que modifica el perfil',
  `user_prof_status` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Estado del perfil de usuario',
  `user_prof_date_in` datetime NOT NULL COMMENT 'Fecha de alta del perfil de usuario',
  `user_prof_date_mod` datetime NOT NULL COMMENT 'Fecha de modificacion del perfil de usuario',
  `user_prof_date_out` datetime default NULL COMMENT 'Fecha de baja del perfil de usuario',
  PRIMARY KEY  (`user_prof_cd`,`user_prof_lang`,`user_prof_date_mod`),
  KEY `index_user_profile.user_prof_group_cd` USING BTREE (`user_prof_group_cd`),
  KEY `fk_const_user_prof.user_prof_lang_on_language` (`user_prof_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Contiene los diferentes perfiles de usuario';

-- 
-- Volcar la base de datos para la tabla `user_profile`
-- 

INSERT INTO `user_profile` (`user_prof_cd`, `user_prof_lang`, `user_prof_nm`, `user_prof_group_cd`, `user_prof_group_nm`, `user_prof_current_flag`, `user_prof_cre`, `user_prof_upd`, `user_prof_status`, `user_prof_date_in`, `user_prof_date_mod`, `user_prof_date_out`) VALUES 
('ADMIN', 'SP', 'Administrador', 'I', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('ADMIN', 'UK', 'Administrator', 'I', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('COMER', 'SP', 'Comercial', 'I', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('COMER', 'UK', 'Comercial', 'I', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('DRU', 'SP', 'Oficina de farmacia', 'E', '', 0, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('DRU', 'SP', 'Oficina de farmacia', 'E', NULL, 0, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2008-01-08 11:59:58', NULL),
('DRU', 'SP', 'Oficina de farmacia', 'E', NULL, 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2008-01-09 12:52:47', NULL),
('DRU', 'UK', 'Drugstore', 'E', '', 0, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('OPER', 'SP', 'Operador', 'I', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('OPER', 'UK', 'Operator', 'I', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('PAR', 'SP', 'Particular', 'E', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('PAR', 'UK', 'Particular', 'E', '', 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('VET', 'SP', 'Clinica veterinaria', 'E', '', 0, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL),
('VET', 'SP', 'Clinica veterinaria', 'E', NULL, 0, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2008-01-08 11:59:41', NULL),
('VET', 'SP', 'Clinica veterinaria', 'E', NULL, 1, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2008-01-09 12:52:31', NULL),
('VET', 'UK', 'Veterinary', 'E', '', 0, 'lcastro', 'lcastro', 'A', '2007-08-01 00:00:00', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `user_status`
-- 

CREATE TABLE `user_status` (
  `user_status_cd` char(1) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del estado del usuario',
  `user_status_lang` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del idioma',
  `user_status_nm` varchar(15) collate utf8_spanish_ci NOT NULL COMMENT 'Nombre del estado del usuario',
  `user_status_dsc` varchar(100) collate utf8_spanish_ci default NULL COMMENT 'Descripcion del estado del usuario',
  `user_status_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del estado del usuario',
  `user_status_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del estado del usuario',
  PRIMARY KEY  (`user_status_cd`,`user_status_lang`),
  KEY `fk_constraint_user_status.user_status_cd_on_language` (`user_status_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Estados en los que se puede encontrar un usuario en el sitio';

-- 
-- Volcar la base de datos para la tabla `user_status`
-- 

INSERT INTO `user_status` (`user_status_cd`, `user_status_lang`, `user_status_nm`, `user_status_dsc`, `user_status_date_in`, `user_status_date_out`) VALUES 
('A', 'SP', 'Activo', 'El usuario es activo\r', '2007-08-01 00:00:00', NULL),
('A', 'UK', 'Active', 'The user is active\r', '2007-08-01 00:00:00', NULL),
('C', 'SP', 'Cerrado', 'El usuario se ha dado de baja\r', '2007-08-01 00:00:00', NULL),
('C', 'UK', 'Closed', 'User closed his account\r', '2007-08-01 00:00:00', NULL),
('D', 'SP', 'Desactivado', 'El usuario ha sido desactivado por Onspot\r', '2007-08-01 00:00:00', NULL),
('D', 'UK', 'Desabled', 'The user has been desabled by Onspot', '2007-08-01 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `vat`
-- 

CREATE TABLE `vat` (
  `id_vat` smallint(5) unsigned NOT NULL auto_increment COMMENT 'Codigo del IVA',
  `vat_country_cd` char(2) collate utf8_spanish_ci NOT NULL COMMENT 'Codigo del pais',
  `vat_value` float unsigned NOT NULL COMMENT 'Valor del IVA - porcentaje',
  `vat_date_in` datetime NOT NULL COMMENT 'Fecha de creacion del IVA',
  `vat_date_out` datetime default NULL COMMENT 'Fecha de finalizacion del IVA',
  PRIMARY KEY  (`id_vat`),
  KEY `index_vat.vat_country_cd` (`vat_country_cd`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='IVA de los diferentes paises' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `vat`
-- 

INSERT INTO `vat` (`id_vat`, `vat_country_cd`, `vat_value`, `vat_date_in`, `vat_date_out`) VALUES 
(1, 'SP', 0.16, '2007-08-01 00:00:00', NULL);

-- 
-- Filtros para las tablas descargadas (dump)
-- 

-- 
-- Filtros para la tabla `actual_planned_credit`
-- 
ALTER TABLE `actual_planned_credit`
  ADD CONSTRAINT `fk_constraint_actual_planned_credit.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `alert_price`
-- 
ALTER TABLE `alert_price`
  ADD CONSTRAINT `fk_constraint_alert_price.alert_type_cd_on_alert_type` FOREIGN KEY (`alert_type_cd`) REFERENCES `alert_type` (`alert_type_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `alert_type`
-- 
ALTER TABLE `alert_type`
  ADD CONSTRAINT `fk_constraint_alert_type.alert_type_lang_on_language` FOREIGN KEY (`alert_type_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `bill`
-- 
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_constraint_bill.bill_pay_mode_cd_on_bill_pay_mode` FOREIGN KEY (`bill_pay_mode_cd`) REFERENCES `bill_pay_mode` (`bill_pay_mode_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_bill.bill_vat_id_on_vat` FOREIGN KEY (`bill_vat_id`) REFERENCES `vat` (`id_vat`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `bill_pay_mode`
-- 
ALTER TABLE `bill_pay_mode`
  ADD CONSTRAINT `fk_constraint_bill_pay_mode.bill_pay_mode_lang_on_language` FOREIGN KEY (`bill_pay_mode_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `bill_status`
-- 
ALTER TABLE `bill_status`
  ADD CONSTRAINT `fk_constraint_bill_status.bill_status_lang_on_language` FOREIGN KEY (`bill_status_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `client`
-- 
ALTER TABLE `client`
  ADD CONSTRAINT `fk_constraint_client.cli_act_cd_on_client_activity` FOREIGN KEY (`cli_act_cd`) REFERENCES `client_activity` (`cli_act_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_client.cli_postal_cd_on_geography` FOREIGN KEY (`cli_postal_cd`) REFERENCES `geography` (`geo_postal_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_client.cli_sex_cd_on_sex` FOREIGN KEY (`cli_sex_cd`) REFERENCES `sex` (`sex_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_client.cli_ident_type_cd_on_identification_doc_type` FOREIGN KEY (`cli_ident_type_cd`) REFERENCES `identification_doc_type` (`ident_type_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `client_activity`
-- 
ALTER TABLE `client_activity`
  ADD CONSTRAINT `fk_constraint_client_activity.cli_act_lang_on_language` FOREIGN KEY (`cli_act_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `contact`
-- 
ALTER TABLE `contact`
  ADD CONSTRAINT `fk_constraint_contact.cont_postal_cd_on_geography` FOREIGN KEY (`cont_postal_cd`) REFERENCES `geography` (`geo_postal_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_contact.cont_sex_cd_on_sex` FOREIGN KEY (`cont_sex_cd`) REFERENCES `sex` (`sex_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_contact.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `credit`
-- 
ALTER TABLE `credit`
  ADD CONSTRAINT `fk_constraint_credit.credit_cli_act_cd_on_client_activity` FOREIGN KEY (`credit_cli_act_cd`) REFERENCES `client_activity` (`cli_act_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_credit.credit_cre_user_id_on_users` FOREIGN KEY (`credit_cre_user_id`) REFERENCES `users` (`id_user`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_credit.credit_mod_user_id_on_users` FOREIGN KEY (`credit_mod_user_id`) REFERENCES `users` (`id_user`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_credit.credit_status_cd_on_creedit_status` FOREIGN KEY (`credit_status_cd`) REFERENCES `credit_status` (`credit_status_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `credit_status`
-- 
ALTER TABLE `credit_status`
  ADD CONSTRAINT `fk_constraint_credit_status.credit_status_lang_on_language` FOREIGN KEY (`credit_status_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `form_request`
-- 
ALTER TABLE `form_request`
  ADD CONSTRAINT `fk_const_form_req.frm_req_end_cd_on_form_req_end` FOREIGN KEY (`frm_req_end_cd`) REFERENCES `form_request_end` (`frm_req_end_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_form_req.frm_req_id_operator_on_users` FOREIGN KEY (`frm_req_id_operator`) REFERENCES `users` (`id_user`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_form_req.frm_req_reason_cd_on_form_req_reason` FOREIGN KEY (`frm_req_reason_cd`) REFERENCES `form_request_reason` (`frm_req_reason_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_form_req.frm_req_status_cd_on_form_req_status` FOREIGN KEY (`frm_req_status_cd`) REFERENCES `form_request_status` (`frm_req_status_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `form_request_end`
-- 
ALTER TABLE `form_request_end`
  ADD CONSTRAINT `fk_const_form_request_end.frm_req_end_lang_on_language` FOREIGN KEY (`frm_req_end_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `form_request_reason`
-- 
ALTER TABLE `form_request_reason`
  ADD CONSTRAINT `fk_const_form_request_reason.frm_req_reason_lang_on_geography` FOREIGN KEY (`frm_req_reason_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `form_request_status`
-- 
ALTER TABLE `form_request_status`
  ADD CONSTRAINT `fk_const_form_request_status.frm_req_status_cd_on_language` FOREIGN KEY (`frm_req_status_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `intern_predefined_message`
-- 
ALTER TABLE `intern_predefined_message`
  ADD CONSTRAINT `fk_const_intern_predef_mess.int_cli_act_cd_on_client_activity` FOREIGN KEY (`int_cli_act_cd`) REFERENCES `client_activity` (`cli_act_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `lost_account_registry`
-- 
ALTER TABLE `lost_account_registry`
  ADD CONSTRAINT `fk_constraint_lost_account_registry.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `measure_med_taking`
-- 
ALTER TABLE `measure_med_taking`
  ADD CONSTRAINT `fk_constraint_measure_med_taking.mea_med_tak_lang_on_language` FOREIGN KEY (`mea_med_tak_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `message`
-- 
ALTER TABLE `message`
  ADD CONSTRAINT `fk_const_message.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_message.mess_send_type_cd_on_message_sending_type` FOREIGN KEY (`mess_send_type_cd`) REFERENCES `message_sending_type` (`mess_send_type_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_message.mess_status_cd_on_message_status` FOREIGN KEY (`mess_status_cd`) REFERENCES `message_status` (`mess_status_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `message_sending_type`
-- 
ALTER TABLE `message_sending_type`
  ADD CONSTRAINT `fk_const_message_sending_type.mess_send_type_lang_on_language` FOREIGN KEY (`mess_send_type_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `message_status`
-- 
ALTER TABLE `message_status`
  ADD CONSTRAINT `fk_constraint_message_status.mess_status_lang_on_language` FOREIGN KEY (`mess_status_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `module`
-- 
ALTER TABLE `module`
  ADD CONSTRAINT `fk_constraint_module.module_lang_on_language` FOREIGN KEY (`module_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `moment`
-- 
ALTER TABLE `moment`
  ADD CONSTRAINT `fk_constraint_moment.moment_lang_on_language` FOREIGN KEY (`moment_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `predefined_message`
-- 
ALTER TABLE `predefined_message`
  ADD CONSTRAINT `fk_constraint_predefined_message.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `prescription`
-- 
ALTER TABLE `prescription`
  ADD CONSTRAINT `fk_const_prescription.id_contact_on_contact` FOREIGN KEY (`id_contact`) REFERENCES `contact` (`id_contact`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_prescription.pres_cmnt_freq_cd_on_prescript_cmnt_freq` FOREIGN KEY (`pres_cmnt_freq_cd`) REFERENCES `prescription_cmnt_freq` (`pres_cmnt_freq_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_prescription.pres_mess_type_cd_on_prescription_message` FOREIGN KEY (`pres_mess_type_cd`) REFERENCES `prescription_message` (`pres_mess_type_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_prescription.pres_status_cd_on_prescription_status` FOREIGN KEY (`pres_status_cd`) REFERENCES `prescription_status` (`pres_status_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `prescription_cmnt_freq`
-- 
ALTER TABLE `prescription_cmnt_freq`
  ADD CONSTRAINT `fk_const_prescription_cmnt_freq.pres_cmnt_freq_lang_on_language` FOREIGN KEY (`pres_cmnt_freq_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `prescription_message`
-- 
ALTER TABLE `prescription_message`
  ADD CONSTRAINT `fk_const_prescription_message.pres_mess_type_lang_on_language` FOREIGN KEY (`pres_mess_type_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `prescription_status`
-- 
ALTER TABLE `prescription_status`
  ADD CONSTRAINT `fk_constraint_prescription_status.pres_status_lang_on_language` FOREIGN KEY (`pres_status_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `purchase`
-- 
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk_constraint_purchase.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_purchase.id_credit_on_credit` FOREIGN KEY (`id_credit`) REFERENCES `credit` (`id_credit`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `registry_connection`
-- 
ALTER TABLE `registry_connection`
  ADD CONSTRAINT `fk_constraint_registry_connection.id_user_on_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `rel_bill_purchase`
-- 
ALTER TABLE `rel_bill_purchase`
  ADD CONSTRAINT `fk_constraint_rel_bill_purchase.id_bill_on_bill` FOREIGN KEY (`id_bill`) REFERENCES `bill` (`id_bill`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_rel_bill_purchase.id_purchase_on_purchase` FOREIGN KEY (`id_purchase`) REFERENCES `purchase` (`id_purchase`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `rel_mess_contact`
-- 
ALTER TABLE `rel_mess_contact`
  ADD CONSTRAINT `fk_constraint_rel_mess_contact.id_contact_on_contact` FOREIGN KEY (`id_contact`) REFERENCES `contact` (`id_contact`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_rel_mess_contact.id_message_on_message` FOREIGN KEY (`id_message`) REFERENCES `message` (`id_message`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `rel_pres_alert`
-- 
ALTER TABLE `rel_pres_alert`
  ADD CONSTRAINT `fk_const_rel_pres_alert.id_alert_type_cd_on_alert_type` FOREIGN KEY (`alert_type_cd`) REFERENCES `alert_type` (`alert_type_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_rel_pres_alert.id_prescription_on_prescription` FOREIGN KEY (`id_prescription`) REFERENCES `prescription` (`id_prescription`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `rel_pres_med`
-- 
ALTER TABLE `rel_pres_med`
  ADD CONSTRAINT `fk_const_rel_pres_med.id_prescription_on_prescription` FOREIGN KEY (`id_prescription`) REFERENCES `prescription` (`id_prescription`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_const_rel_pres_med.mea_med_tak_cd_on_measure_med_taking` FOREIGN KEY (`mea_med_tak_cd`) REFERENCES `measure_med_taking` (`mea_med_tak_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `rel_prof_module`
-- 
ALTER TABLE `rel_prof_module`
  ADD CONSTRAINT `fk_constraint_rel_prof_module.module_cd_on_module` FOREIGN KEY (`module_cd`) REFERENCES `module` (`module_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_rel_prof_module.user_prof_cd_on_user_profile` FOREIGN KEY (`user_prof_cd`) REFERENCES `user_profile` (`user_prof_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `sex`
-- 
ALTER TABLE `sex`
  ADD CONSTRAINT `fk_constraint_sex.sex_lang_on_language` FOREIGN KEY (`sex_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `users`
-- 
ALTER TABLE `users`
  ADD CONSTRAINT `fk_constraint_users.id_client_on_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_users.user_prefer_lang_on_language` FOREIGN KEY (`user_prefer_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_users.user_prof_cd_on_user_profile` FOREIGN KEY (`user_prof_cd`) REFERENCES `user_profile` (`user_prof_cd`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_constraint_users.user_status_cd_on_user_status` FOREIGN KEY (`user_status_cd`) REFERENCES `user_status` (`user_status_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `user_profile`
-- 
ALTER TABLE `user_profile`
  ADD CONSTRAINT `fk_const_user_prof.user_prof_lang_on_language` FOREIGN KEY (`user_prof_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;

-- 
-- Filtros para la tabla `user_status`
-- 
ALTER TABLE `user_status`
  ADD CONSTRAINT `fk_constraint_user_status.user_status_cd_on_language` FOREIGN KEY (`user_status_lang`) REFERENCES `language` (`language_cd`) ON UPDATE NO ACTION;
