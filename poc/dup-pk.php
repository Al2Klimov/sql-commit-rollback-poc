<?php

require_once __DIR__ . '/../util/db.php';
require_once __DIR__ . '/../util/misc.php';

setup();

$conn = mkDbConn();

execSql(
    $conn,
    'conn. #1',
    <<<EOD
CREATE TABLE IF NOT EXISTS poc_dup_pk (
id BIGINT PRIMARY KEY
);
EOD
);

execSql($conn, 'conn. #1', 'DELETE FROM poc_dup_pk;');

begin($conn, 'conn. #1');
execSql($conn, 'conn. #1', 'INSERT INTO poc_dup_pk(id) VALUES (1);');
execSql($conn, 'conn. #1', 'INSERT INTO poc_dup_pk(id) VALUES (1);');
rollback($conn, 'conn. #1');

fetchAll(mkDbConn(), 'conn. #2', 'SELECT * FROM poc_dup_pk;');
