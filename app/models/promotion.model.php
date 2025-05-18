<?php

function getNombrePromotions(): int
{
    $sql = "SELECT COUNT(*) AS total FROM promotion";
    $result = fetchResult($sql, [], false);
    return $result ? (int) $result['total'] : 0;
}

function getNombrePromotionsActives(): int
{
    $sql = "SELECT COUNT(*) AS total FROM promotion WHERE statut = 'active'";
    $result = fetchResult($sql, [], false);
    return $result ? (int) $result['total'] : 0;
}

function getAllPromotionsWithReferentiels(array $filters = [], int $page = 1, int $perPage = 2): array|false
{
    $sql = "
        SELECT 
            p.id AS promotion_id,
            p.nom AS promotion_nom,
            p.statut,
            p.date_debut,
            p.date_fin,
            p.nombre_apprenants,
            p.image,
            ARRAY_AGG(r.nom ORDER BY r.nom) AS referentiels
        FROM promotion p
        LEFT JOIN promotion_referentiel pr ON p.id = pr.promotion_id
        LEFT JOIN referentiel r ON r.id = pr.referentiel_id
    ";

    $where = [];
    $params = [];

    if (!empty($filters['statut'])) {
        $where[] = "p.statut = ?";
        $params[] = $filters['statut'];
    }

    if (!empty($filters['search'])) {
        $where[] = "p.nom ILIKE ?";
        $params[] = '%' . $filters['search'] . '%';
    }

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " GROUP BY p.id ORDER BY p.date_debut DESC";

    return paginateQuery($sql, $params, $page, $perPage);
}
