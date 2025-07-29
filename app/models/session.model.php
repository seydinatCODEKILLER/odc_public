<?php

function getAllSessions()
{
    $sql = "SELECT id, nom 
            FROM session 
            ORDER BY nom ASC";

    $result = fetchResult($sql);
    return $result ?: [];
}
