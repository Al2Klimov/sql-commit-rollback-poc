<?php

require_once __DIR__ . '/../util/db.php';
require_once __DIR__ . '/../util/misc.php';

setup();

$conn1 = mkDbConn();

execSql(
    $conn1,
    'conn. #1',
    <<<EOD
CREATE TABLE IF NOT EXISTS poc_bad_rollback (
id BIGINT PRIMARY KEY
);
EOD
);

execSql($conn1, 'conn. #1', 'DELETE FROM poc_bad_rollback;');

$conn2 = mkDbConn();

begin($conn1, 'conn. #1');
begin($conn2, 'conn. #2');
execSql($conn1, 'conn. #1', 'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
execSql($conn2, 'conn. #2', 'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
fetchAll($conn1, 'conn. #1', 'SELECT COUNT(*) FROM poc_bad_rollback;');
fetchAll($conn2, 'conn. #2', 'SELECT COUNT(*) FROM poc_bad_rollback;');
execSql($conn1, 'conn. #1', 'INSERT INTO poc_bad_rollback(id) VALUES (1);');
execSql($conn2, 'conn. #2', 'INSERT INTO poc_bad_rollback(id) VALUES (2);');
commit($conn1, 'conn. #1');
commit($conn2, 'conn. #2');
rollback($conn2, 'conn. #2');

unset($conn1);
unset($conn2);

fetchAll(mkDbConn(), 'conn. #3', 'SELECT * FROM poc_bad_rollback;');
