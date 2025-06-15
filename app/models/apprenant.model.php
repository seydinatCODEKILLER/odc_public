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

function isEmailExist(string $email): bool
{
    $sql = "SELECT id FROM apprenant WHERE email = ?";
    $result = fetchResult($sql, [$email], false);
    return $result !== false;
}

function isNumeroExist(string $telephone): bool
{
    $sql = "SELECT id FROM apprenant WHERE telephone = ?";
    $result = fetchResult($sql, [$telephone], false);
    return $result !== false;
}

function createApprenant(array $apprenantData): int|false
{
    $sql = "INSERT INTO apprenant 
            (matricule, nom, prenom, date_naissance, lieu_naissance, 
            adresse, email, telephone, photo, promotion_id, referentiel_id,statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? , 'active') 
            RETURNING id";

    $params = [
        $apprenantData['matricule'],
        $apprenantData['nom'],
        $apprenantData['prenom'],
        $apprenantData['date_naissance'],
        $apprenantData['lieu_naissance'],
        $apprenantData['adresse'],
        $apprenantData['email'],
        $apprenantData['telephone'],
        $apprenantData['photo'] ?? null,
        $apprenantData['promotion_id'],
        $apprenantData['referentiel_id'],

    ];

    $result = executeQuery($sql, $params, true);

    return is_numeric($result) ? (int)$result : false;
}

function generateMatricule(): string
{
    $prefix = "MAT" . date("Ym");
    $sql = "SELECT MAX(CAST(SUBSTRING(matricule, 8) AS INTEGER)) as last_num 
            FROM apprenant 
            WHERE matricule LIKE ?";
    $params = [$prefix . '%'];

    $result = executeQuery($sql, $params);
    $lastNum = $result['last_num'] ?? 0;
    $nextNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);

    return $prefix . $nextNum;
}
