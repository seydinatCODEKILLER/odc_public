<?php

function getNombreReferentiels(): int
{
    $sql = "SELECT COUNT(*) AS total FROM referentiel";
    $result = fetchResult($sql, [], false);
    return $result ? (int) $result['total'] : 0;
}
