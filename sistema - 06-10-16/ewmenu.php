<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(351, "mi_dato_establecimiento", $Language->MenuPhrase("351", "MenuText"), "dato_establecimientolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento'), FALSE, FALSE);
$RootMenu->AddMenuItem(57, "mci_Administracion", $Language->MenuPhrase("57", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(58, "mci_Establecimiento", $Language->MenuPhrase("58", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(418, "mi_cargo_autoridad", $Language->MenuPhrase("418", "MenuText"), "cargo_autoridadlist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mi_cursos", $Language->MenuPhrase("7", "MenuText"), "cursoslist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos'), FALSE, FALSE);
$RootMenu->AddMenuItem(11, "mi_division", $Language->MenuPhrase("11", "MenuText"), "divisionlist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division'), FALSE, FALSE);
$RootMenu->AddMenuItem(54, "mi_turno", $Language->MenuPhrase("54", "MenuText"), "turnolist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno'), FALSE, FALSE);
$RootMenu->AddMenuItem(35, "mi_nivel_educativo", $Language->MenuPhrase("35", "MenuText"), "nivel_educativolist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo'), FALSE, FALSE);
$RootMenu->AddMenuItem(30, "mi_modalidad_establecimiento", $Language->MenuPhrase("30", "MenuText"), "modalidad_establecimientolist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento'), FALSE, FALSE);
$RootMenu->AddMenuItem(29, "mi_materias_anuales", $Language->MenuPhrase("29", "MenuText"), "materias_anualeslist.php", 58, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales'), FALSE, FALSE);
$RootMenu->AddMenuItem(59, "mci_Personas", $Language->MenuPhrase("59", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(16, "mi_estado_persona", $Language->MenuPhrase("16", "MenuText"), "estado_personalist.php", 59, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona'), FALSE, FALSE);
$RootMenu->AddMenuItem(40, "mi_ocupacion_tutor", $Language->MenuPhrase("40", "MenuText"), "ocupacion_tutorlist.php", 59, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor'), FALSE, FALSE);
$RootMenu->AddMenuItem(17, "mi_estado_civil", $Language->MenuPhrase("17", "MenuText"), "estado_civillist.php", 59, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil'), FALSE, FALSE);
$RootMenu->AddMenuItem(47, "mi_sexo_personas", $Language->MenuPhrase("47", "MenuText"), "sexo_personaslist.php", 59, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas'), FALSE, FALSE);
$RootMenu->AddMenuItem(51, "mi_tipo_relacion_alumno_tutor", $Language->MenuPhrase("51", "MenuText"), "tipo_relacion_alumno_tutorlist.php", 59, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mi_cargo_persona", $Language->MenuPhrase("6", "MenuText"), "cargo_personalist.php", 59, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona'), FALSE, FALSE);
$RootMenu->AddMenuItem(67, "mci_Tramites_Varios", $Language->MenuPhrase("67", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(661, "mci_Pases", $Language->MenuPhrase("661", "MenuText"), "", 67, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(13, "mi_establecimientos_educativos_pase", $Language->MenuPhrase("13", "MenuText"), "establecimientos_educativos_paselist.php", 661, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase'), FALSE, FALSE);
$RootMenu->AddMenuItem(22, "mi_estado_pase", $Language->MenuPhrase("22", "MenuText"), "estado_paselist.php", 661, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase'), FALSE, FALSE);
$RootMenu->AddMenuItem(662, "mci_Prestamos", $Language->MenuPhrase("662", "MenuText"), "", 67, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(23, "mi_estado_prestamo_equipo", $Language->MenuPhrase("23", "MenuText"), "estado_prestamo_equipolist.php", 662, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(32, "mi_motivo_prestamo_equipo", $Language->MenuPhrase("32", "MenuText"), "motivo_prestamo_equipolist.php", 662, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(663, "mci_Devoluciones", $Language->MenuPhrase("663", "MenuText"), "", 67, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(580, "mi_motivo_devolucion", $Language->MenuPhrase("580", "MenuText"), "motivo_devolucionlist.php", 663, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion'), FALSE, FALSE);
$RootMenu->AddMenuItem(102, "mi_estado_equipo_devuleto", $Language->MenuPhrase("102", "MenuText"), "estado_equipo_devuletolist.php", 663, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuleto'), FALSE, FALSE);
$RootMenu->AddMenuItem(664, "mci_Reasignacion", $Language->MenuPhrase("664", "MenuText"), "", 67, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(33, "mi_motivo_reasignacion", $Language->MenuPhrase("33", "MenuText"), "motivo_reasignacionlist.php", 664, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion'), FALSE, FALSE);
$RootMenu->AddMenuItem(665, "mci_Denuncias", $Language->MenuPhrase("665", "MenuText"), "", 67, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(18, "mi_estado_deuncia", $Language->MenuPhrase("18", "MenuText"), "estado_deuncialist.php", 665, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_deuncia'), FALSE, FALSE);
$RootMenu->AddMenuItem(60, "mci_Equipos", $Language->MenuPhrase("60", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(495, "mi_ano_entrega", $Language->MenuPhrase("495", "MenuText"), "ano_entregalist.php", 60, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega'), FALSE, FALSE);
$RootMenu->AddMenuItem(27, "mi_marca", $Language->MenuPhrase("27", "MenuText"), "marcalist.php", 60, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca'), FALSE, FALSE);
$RootMenu->AddMenuItem(31, "mi_modelo", $Language->MenuPhrase("31", "MenuText"), "modelolist.php", 60, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo'), FALSE, FALSE);
$RootMenu->AddMenuItem(56, "mi_ubicacion_equipo", $Language->MenuPhrase("56", "MenuText"), "ubicacion_equipolist.php", 60, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(20, "mi_estado_equipo", $Language->MenuPhrase("20", "MenuText"), "estado_equipolist.php", 60, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(48, "mi_situacion_estado", $Language->MenuPhrase("48", "MenuText"), "situacion_estadolist.php", 60, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado'), FALSE, FALSE);
$RootMenu->AddMenuItem(62, "mci_Ubicacion", $Language->MenuPhrase("62", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(34, "mi_paises", $Language->MenuPhrase("34", "MenuText"), "paiseslist.php", 62, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises'), FALSE, FALSE);
$RootMenu->AddMenuItem(45, "mi_provincias", $Language->MenuPhrase("45", "MenuText"), "provinciaslist.php", 62, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias'), FALSE, FALSE);
$RootMenu->AddMenuItem(579, "mi_departamento", $Language->MenuPhrase("579", "MenuText"), "departamentolist.php", 62, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento'), FALSE, FALSE);
$RootMenu->AddMenuItem(26, "mi_localidades", $Language->MenuPhrase("26", "MenuText"), "localidadeslist.php", 62, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades'), FALSE, FALSE);
$RootMenu->AddMenuItem(66, "mci_Atenciones", $Language->MenuPhrase("66", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(496, "mi_tipo_falla", $Language->MenuPhrase("496", "MenuText"), "tipo_fallalist.php", 66, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla'), FALSE, FALSE);
$RootMenu->AddMenuItem(44, "mi_problema", $Language->MenuPhrase("44", "MenuText"), "problemalist.php", 66, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema'), FALSE, FALSE);
$RootMenu->AddMenuItem(53, "mi_tipo_solucion_problema", $Language->MenuPhrase("53", "MenuText"), "tipo_solucion_problemalist.php", 66, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mi_estado_actual_solucion_problema", $Language->MenuPhrase("15", "MenuText"), "estado_actual_solucion_problemalist.php", 66, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema'), FALSE, FALSE);
$RootMenu->AddMenuItem(50, "mi_tipo_prioridad_atencion", $Language->MenuPhrase("50", "MenuText"), "tipo_prioridad_atencionlist.php", 66, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion'), FALSE, FALSE);
$RootMenu->AddMenuItem(52, "mi_tipo_retiro_atencion_st", $Language->MenuPhrase("52", "MenuText"), "tipo_retiro_atencion_stlist.php", 66, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st'), FALSE, FALSE);
$RootMenu->AddMenuItem(493, "mci_Datos_Conectar_Igualdad", $Language->MenuPhrase("493", "MenuText"), "", 57, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(494, "mi_estado_equipos_piso", $Language->MenuPhrase("494", "MenuText"), "estado_equipos_pisolist.php", 493, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso'), FALSE, FALSE);
$RootMenu->AddMenuItem(419, "mi_estado_server", $Language->MenuPhrase("419", "MenuText"), "estado_serverlist.php", 493, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server'), FALSE, FALSE);
$RootMenu->AddMenuItem(420, "mi_marca_server", $Language->MenuPhrase("420", "MenuText"), "marca_serverlist.php", 493, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server'), FALSE, FALSE);
$RootMenu->AddMenuItem(421, "mi_modelo_server", $Language->MenuPhrase("421", "MenuText"), "modelo_serverlist.php", 493, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server'), FALSE, FALSE);
$RootMenu->AddMenuItem(425, "mi_so_server", $Language->MenuPhrase("425", "MenuText"), "so_serverlist.php", 493, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server'), FALSE, FALSE);
$RootMenu->AddMenuItem(426, "mi_turno_rte", $Language->MenuPhrase("426", "MenuText"), "turno_rtelist.php", 493, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte'), FALSE, FALSE);
$RootMenu->AddMenuItem(103, "mi_personas", $Language->MenuPhrase("103", "MenuText"), "personaslist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas'), FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mi_equipos", $Language->MenuPhrase("12", "MenuText"), "equiposlist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos'), FALSE, FALSE);
$RootMenu->AddMenuItem(55, "mi_tutores", $Language->MenuPhrase("55", "MenuText"), "tutoreslist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores'), FALSE, FALSE);
$RootMenu->AddMenuItem(572, "mci_Atencif3n_de_Equipos", $Language->MenuPhrase("572", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(497, "mi_atencion_equipos", $Language->MenuPhrase("497", "MenuText"), "atencion_equiposlist.php", 572, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos'), FALSE, FALSE);
$RootMenu->AddMenuItem(573, "mci_Consultar", $Language->MenuPhrase("573", "MenuText"), "", 572, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(8, "mi_denuncia_robo_equipo", $Language->MenuPhrase("8", "MenuText"), "denuncia_robo_equipolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mi_devolucion_equipo", $Language->MenuPhrase("10", "MenuText"), "devolucion_equipolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(25, "mi_liberacion_equipo", $Language->MenuPhrase("25", "MenuText"), "liberacion_equipolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(41, "mi_pase_establecimiento", $Language->MenuPhrase("41", "MenuText"), "pase_establecimientolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento'), FALSE, FALSE);
$RootMenu->AddMenuItem(43, "mi_prestamo_equipo", $Language->MenuPhrase("43", "MenuText"), "prestamo_equipolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(46, "mi_reasignacion_equipo", $Language->MenuPhrase("46", "MenuText"), "reasignacion_equipolist.php", -1, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo'), FALSE, FALSE);
$RootMenu->AddMenuItem(350, "mci_Operaciones_Masivas", $Language->MenuPhrase("350", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(9, "mi_detalle_atencion", $Language->MenuPhrase("9", "MenuText"), "detalle_atencionlist.php?cmd=resetall", 350, "", IsLoggedIn() || AllowListMenu('{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion'), FALSE, FALSE);
$RootMenu->AddMenuItem(724, "mci_Informes_Varios", $Language->MenuPhrase("724", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->