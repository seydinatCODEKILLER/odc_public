<?php

function getNombreReferentiels(): int
{
    $sql = "SELECT COUNT(*) AS total FROM referentiel";
    $result = fetchResult($sql, [], false);
    return $result ? (int) $result['total'] : 0;
}


function getAllReferentiels(): array
{
    $sql = "SELECT id, nom, description 
            FROM referentiel 
            WHERE statut = 'active' 
            ORDER BY nom ASC";

    $result = fetchResult($sql);

    return $result ?: [];
}

function getAllReferentielsPaginated(array $filters = [], int $page = 1, int $perPage = 3): array|false
{
    $sql = "SELECT id, nom, description,image,capacite
            FROM referentiel";

    $where = [];
    $params = [];

    if (!empty($filters['search'])) {
        $where[] = "referentiel.nom LIKE ?";
        $params[] = '%' . $filters['search'] . '%';
    }

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " ORDER BY referentiel.nom ASC";

    return paginateQuery($sql, $params, $page, $perPage);
}

function referentielExistsByName(string $name, ?int $excludeId = null): bool
{
    $sql = "SELECT COUNT(*) FROM referentiel WHERE nom = ?";
    $params = [trim($name)];

    if ($excludeId !== null) {
        $sql .= " AND id != ?";
        $params[] = $excludeId;
    }

    $result = fetchResult($sql, $params, false);
    return $result['count'] > 0;
}

function createReferentiel(array $referentielData): int|false
{
    $sql = "INSERT INTO referentiel 
            (nom, description, capacite, image, statut,session_id) 
            VALUES (?, ?, ?, ?, 'active',?)";

    $params = [
        $referentielData['nom'],
        $referentielData['description'],
        $referentielData['capacite'],
        $referentielData['image'] ?? null,
        $referentielData['session'],
    ];

    return executeQuery($sql, $params, true);
}
