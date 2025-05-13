<?php

function getNombreApprenants(): int
{
    $sql = "SELECT COUNT(*) AS total FROM apprenant";
    $result = fetchResult($sql, [], false);
    return $result ? (int) $result['total'] : 0;
}
