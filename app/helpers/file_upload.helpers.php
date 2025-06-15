<?php


/**
 * Upload un fichier image de manière sécurisée
 * 
 * @param array $file Données du fichier ($_FILES['nom_du_champ'])
 * @param string $directory Sous-dossier dans /uploads/ (ex: 'promotions')
 * @param string $prefix Préfixe pour le nom de fichier (ex: 'promo_')
 * @param int $maxSize Taille max en octets (défaut: 2Mo)
 * @return string Chemin relatif du fichier uploadé (depuis la racine publique)
 * @throws Exception Si l'upload échoue
 */
function uploadImage(
    array $file,
    string $directory,
    string $prefix = 'file_',
    int $maxSize = 7 * 1024 * 1024
): string {
    // 1. Validation du répertoire
    $baseDir = ROOT_PATH_UPLOAD . "/uploads/";
    $uploadDir = $baseDir . trim($directory, '/') . '/';

    // 2. Types MIME autorisés
    $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp'
    ];

    // 3. Validation basique du fichier
    if (!isset($file['tmp_name'])) {
        throw new Exception("Aucun fichier reçu");
    }

    // 4. Validation du type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!array_key_exists($mimeType, $allowedTypes)) {
        throw new Exception("Type de fichier non autorisé");
    }

    // 5. Validation de la taille
    if ($file['size'] > $maxSize) {
        throw new Exception("Le fichier ne doit pas dépasser " . formatBytes($maxSize));
    }

    // 6. Validation des erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors du transfert: " . getUploadError($file['error']));
    }

    // 7. Création du répertoire si inexistant
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // 8. Génération d'un nom de fichier sécurisé
    $extension = $allowedTypes[$mimeType];
    $filename = $prefix . uniqid() . '.' . $extension;
    $destination = $uploadDir . $filename;

    // 9. Déplacement sécurisé du fichier
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new Exception("Erreur lors de l'enregistrement du fichier");
    }

    // 10. Retourne le chemin relatif (depuis public/)
    return "/uploads/" . trim($directory, '/') . '/' . $filename;
}

/**
 * Helper pour formatter les octets en taille lisible
 */
function formatBytes(int $bytes, int $precision = 2): string
{
    $units = ['o', 'Ko', 'Mo', 'Go'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    return round($bytes / (1024 ** $pow), $precision) . ' ' . $units[$pow];
}

/**
 * Helper pour traduire les codes d'erreur d'upload
 */
function getUploadError(int $errorCode): string
{
    $errors = [
        UPLOAD_ERR_INI_SIZE => 'Fichier trop volumineux (php.ini)',
        UPLOAD_ERR_FORM_SIZE => 'Fichier trop volumineux (formulaire)',
        UPLOAD_ERR_PARTIAL => 'Transfert partiel',
        UPLOAD_ERR_NO_FILE => 'Aucun fichier',
        UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant',
        UPLOAD_ERR_CANT_WRITE => 'Erreur d\'écriture',
        UPLOAD_ERR_EXTENSION => 'Extension PHP bloquée'
    ];
    return $errors[$errorCode] ?? 'Erreur inconnue';
}
