<?php

function mkDbConn(): PDO {
    $pdo = new PDO('pgsql:host=127.0.0.1;port=5432;dbname=commit_poc', 'commit_poc', 'commit_poc');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function begin(PDO $db, string $dbName) {
    echo "+ [$dbName] BEGIN -- (by PDO)\n\n";

    try {
        $db->beginTransaction();
    } catch (Exception $e) {
        echo "$e\n\n";
    }
}

function commit(PDO $db, string $dbName) {
    echo "+ [$dbName] COMMIT -- (by PDO)\n\n";

    try {
        $db->commit();
    } catch (Exception $e) {
        echo "$e\n\n";
    }
}

function rollback(PDO $db, string $dbName) {
    echo "+ [$dbName] ROLLBACK -- (by PDO)\n\n";

    try {
        $db->rollBack();
    } catch (Exception $e) {
        echo "$e\n\n";
    }
}

function execSql(PDO $db, string $dbName, string $sql) {
    echo "+ [$dbName] $sql\n\n";

    try {
        $statement = $db->prepare($sql);
        $statement->execute();
    } catch (Exception $e) {
        echo "$e\n\n";
    }
}

function fetchAll(PDO $db, string $dbName, string $sql) {
    echo "+ [$dbName] $sql\n\n";

    try {
        $statement = $db->prepare($sql);
        $statement->execute();
    } catch (Exception $e) {
        echo "$e\n\n";
    }

    var_export($statement->fetchAll(PDO::FETCH_ASSOC));
    echo "\n\n";
}
