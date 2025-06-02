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
