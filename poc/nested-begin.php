<?php

require_once __DIR__ . '/../util/db.php';
require_once __DIR__ . '/../util/misc.php';

setup();

$conn = mkDbConn();

begin($conn, 'conn.');
begin($conn, 'conn.');
