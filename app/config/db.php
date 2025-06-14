<?php
require_once ROOT_PATH . "/models/model.php";

function prepareStatement(PDO $pdo, string $sql): PDOStatement
{
    $stmt = $pdo->prepare($sql);
    if (!$stmt) {
        throw new PDOException("Échec de la préparation de la requête");
    }
    return $stmt;
}

function determineParamType(mixed $value): int
{
    return match (true) {
        is_int($value) => PDO::PARAM_INT,
        is_bool($value) => PDO::PARAM_BOOL,
        is_null($value) => PDO::PARAM_NULL,
        default => PDO::PARAM_STR,
    };
}

function bindParams(PDOStatement $stmt, array $params): void
{
    $paramIndex = 1;
    foreach ($params as $value) {
        $paramType = determineParamType($value);
        $stmt->bindValue($paramIndex, $value, $paramType);
        $paramIndex++;
    }
}

function logSqlError(PDOException $e, string $sql): void
{
    die("Erreur SQL: " . $e->getMessage() . "\nRequête: " . $sql);
}

function executeQuery(string $sql, array $params = [], bool $returnLastInsertId = false): bool|int
{
    try {
        $pdo = connectDB();
        $stmt = prepareStatement($pdo, $sql);
        bindParams($stmt, $params);
        $success = $stmt->execute();

        if ($returnLastInsertId && $success) {
            return $pdo->lastInsertId();
        }

        return $success;
    } catch (PDOException $e) {
        logSqlError($e, $sql);
        return false;
    }
}

function fetchResult(string $sql, array $params = [], bool $all = true): array|false
{
    try {
        $pdo = connectDB();
        $stmt = prepareStatement($pdo, $sql);
        bindParams($stmt, $params);

        if (!$stmt->execute()) {
            return false;
        }

        if ($all) {
            $result = $stmt->fetchAll();
            return $result ?: [];
        }

        return $stmt->fetch() ?: false;
    } catch (PDOException $e) {
        logSqlError($e, $sql);
        return false;
    }
}
