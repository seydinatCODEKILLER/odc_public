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
