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

function getAllPromotionsWithReferentiels(array $filters = [], int $page = 1, int $perPage = 3): array|false
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

function promotionExistsByName(string $name, ?int $excludeId = null): bool
{
    $sql = "SELECT COUNT(*) FROM promotion WHERE nom = ?";
    $params = [trim($name)];

    if ($excludeId !== null) {
        $sql .= " AND id != ?";
        $params[] = $excludeId;
    }

    $result = fetchResult($sql, $params, false);
    return $result['count'] > 0;
}

function createPromotion(array $promotionData): int|false
{
    $sql = "INSERT INTO promotion 
            (nom, date_debut, date_fin, image, statut, nombre_apprenants) 
            VALUES (?, ?, ?, ?, 'inactive', ?) 
            RETURNING id";

    $params = [
        $promotionData['nom'],
        $promotionData['date_debut'],
        $promotionData['date_fin'],
        $promotionData['image'] ?? null,
        $promotionData['nombre_apprenants']
    ];

    $result = executeQuery($sql, $params, true);

    return is_numeric($result) ? (int)$result : false;
}

function addReferentielToPromotion(int $promotionId, int $referentielId): bool
{
    $checkSql = "SELECT COUNT(*) FROM promotion_referentiel WHERE promotion_id = ? AND referentiel_id = ?";
    $exists = fetchResult($checkSql, [$promotionId, $referentielId], false)['count'] > 0;

    if ($exists) {
        return true;
    }

    $insertSql = "INSERT INTO promotion_referentiel (promotion_id, referentiel_id) VALUES (?, ?)";
    return (bool) executeQuery($insertSql, [$promotionId, $referentielId]);
}

function updatePromotionReferentiels(int $promotionId, array $referentielIds): bool
{

    try {
        $deleteSql = "DELETE FROM promotion_referentiel WHERE promotion_id = ?";
        executeQuery($deleteSql, [$promotionId]);

        foreach ($referentielIds as $refId) {
            if (!addReferentielToPromotion($promotionId, $refId)) {
                throw new Exception("Erreur lors de l'ajout du référentiel $refId");
            }
        }
        return true;
    } catch (Exception $e) {
        error_log("Erreur updatePromotionReferentiels: " . $e->getMessage());
        return false;
    }
}

function desactivateAllPromotions(): bool
{
    $sql = "UPDATE promotion SET statut = 'inactive' WHERE statut = 'active'";
    return executeQuery($sql);
}

function setPromotionStatus(int $promotionId, string $status): bool
{
    $allowedStatuses = ['active', 'inactive'];
    if (!in_array($status, $allowedStatuses)) {
        return false;
    }

    $sql = "UPDATE promotion SET statut = ? WHERE id = ?";

    return executeQuery(
        $sql,
        [$status, $promotionId]
    );
}

function getPromotionStatus(int $promotionId): ?string
{
    $result = fetchResult(
        "SELECT statut FROM promotion WHERE id = ?",
        [$promotionId],
        false
    );

    return $result['statut'] ?? null;
}
