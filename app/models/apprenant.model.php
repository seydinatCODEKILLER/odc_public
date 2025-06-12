<?php

function getNombreApprenants(): int
{
    $sql = "SELECT COUNT(*) AS total FROM apprenant";
    $result = fetchResult($sql, [], false);
    return $result ? (int) $result['total'] : 0;
}

function getApprenantsByStatut(string $statut): array
{
    $sql = "SELECT * FROM apprenant WHERE statut_accepted = ?";
    return fetchResult($sql, ['statut' => $statut]);
}

function getApprenantInfos(array $filters = [], int $page = 1, int $perPage = 4): array
{
    $sql = "SELECT 
    a.id,
    a.photo,
    a.matricule,
    a.nom,
    a.prenom,
    a.adresse,
    a.telephone,
    a.statut,
    r.nom AS referentiel,
    p.nom AS promotion
    FROM apprenant a
    JOIN referentiel r ON a.referentiel_id = r.id
    JOIN promotion p ON a.promotion_id = p.id";

    $where = [];
    $params = [];

    if (!empty($filters['statut'])) {
        $where[] = "a.statut = ?";
        $params[] = $filters['statut'];
    }

    if (!empty($filters['referentiel'])) {
        $where[] = "a.referentiel_id = ?";
        $params[] = $filters['referentiel'];
    }

    if (!empty($filters['search'])) {
        $where[] = "a.prenom ILIKE ?";
        $params[] = '%' . $filters['search'] . '%';
    }

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " ORDER BY a.nom ASC";
    return paginateQuery($sql, $params, $page, $perPage);
}

function getApprenantById(int $id): ?array
{
    $sql = "SELECT 
    a.id,
    a.photo,
    a.matricule,
    a.nom,
    a.prenom,
    a.adresse,
    a.telephone,
    a.statut,
    r.nom AS referentiel,
    p.nom AS promotion
    FROM apprenant a
    JOIN referentiel r ON a.referentiel_id = r.id
    JOIN promotion p ON a.promotion_id = p.id
    WHERE a.id = ?";

    $result = fetchResult($sql, [$id], false);
    return $result ?: null;
}

function getModuleByApprenant(int $id): ?array
{
    $sql = "SELECT m.*
        FROM module m
        JOIN apprenant a ON m.referentiel_id = a.referentiel_id
        WHERE a.id = ?";
    $result = fetchResult($sql, [$id]);
    return $result ?: null;
}

function getNombrePresenceByApprenant(int $id): int
{
    $sql = "SELECT COUNT(*) AS total
        FROM presence
        WHERE apprenant_id = ?";
    $result = fetchResult($sql, [$id], false);
    return $result ? (int) $result['total'] : 0;
}

function getNombreRetardByApprenant(int $id): int
{
    $sql = "SELECT COUNT(*) AS total
        FROM retard
        WHERE apprenant_id = ?";
    $result = fetchResult($sql, [$id], false);
    return $result ? (int) $result['total'] : 0;
}

function getNombreAbsenceByApprenant(int $id): int
{
    $sql = "SELECT COUNT(*) AS total
        FROM absence
        WHERE apprenant_id = ?";
    $result = fetchResult($sql, [$id], false);
    return $result ? (int) $result['total'] : 0;
}

function getInfoAbsenceByApprenant(int $id)
{
    $sql = "SELECT 
    abs.id,
    abs.date_absence,
    abs.heure_absence,
    abs.is_justified,
    m.nom AS module
    FROM absence abs
    JOIN module m ON abs.module_id = m.id
    WHERE abs.apprenant_id = ?
    ORDER BY abs.date_absence DESC";

    return paginateQuery($sql, [$id]);
}
