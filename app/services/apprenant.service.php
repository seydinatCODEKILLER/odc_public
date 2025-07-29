<?php
require_once ROOT_PATH . "/models/apprenant.model.php";
require_once ROOT_PATH . "/models/promotion.model.php";
require_once ROOT_PATH . "/validations/apprenant.validation.php";


function exportExcel()
{
    try {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Titre du document
        $sheet->setTitle('Liste des Apprenants');

        // En-têtes avec toutes les colonnes
        $headers = [
            'A' => 'Matricule',
            'B' => 'Photo',
            'C' => 'Nom',
            'D' => 'Prénom',
            'E' => 'Nom Complet',
            'F' => 'Adresse',
            'G' => 'Téléphone',
            'H' => 'Référentiel',
            'I' => 'Statut'
        ];

        foreach ($headers as $col => $title) {
            $sheet->setCellValue($col . '1', $title);
        }

        // Données
        $data = getApprenantInfos();
        $apprenants = $data['data'];
        $row = 2;

        foreach ($apprenants as $apprenant) {
            $sheet->setCellValue('A' . $row, $apprenant['matricule']);

            // Lien vers la photo (si disponible)
            if (!empty($apprenant['photo'])) {
                $photoPath = $apprenant['photo'];
                $sheet->setCellValue('B' . $row, 'Photo disponible');
                $sheet->getCell('B' . $row)->getHyperlink()->setUrl($photoPath);
            } else {
                $sheet->setCellValue('B' . $row, 'Aucune photo');
            }

            $sheet->setCellValue('C' . $row, $apprenant['nom']);
            $sheet->setCellValue('D' . $row, $apprenant['prenom']);
            $sheet->setCellValue('E' . $row, $apprenant['prenom'] . ' ' . $apprenant['nom']);
            $sheet->setCellValue('F' . $row, $apprenant['adresse']);
            $sheet->setCellValue('G' . $row, $apprenant['telephone']);
            $sheet->setCellValue('H' . $row, $apprenant['referentiel'] ?? 'N/A');
            $sheet->setCellValue('I' . $row, ucfirst($apprenant['statut']));

            $row++;
        }

        // Style et mise en forme
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
        ];

        // Appliquer le style aux en-têtes
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Auto-ajustement des colonnes
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Protection contre les erreurs de sortie
        ob_clean();

        // Envoi du fichier
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="apprenants_' . date('Ymd-His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    } catch (Exception $e) {
        // Journalisation de l'erreur et redirection
        error_log('Erreur export Excel: ' . $e->getMessage());
        setFieldError("general", "Erreur lors de la génération du fichier Excel");
        redirect_to('/admin/apprenant');
    }
}

function exportPdf()
{
    try {
        // Configuration TCPDF en mode paysage
        $pdf = new \TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Paramètres du document
        $pdf->SetCreator('Ecole 221');
        $pdf->SetMargins(10, 15, 10);  // Marges réduites
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();

        // Titre centré
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Liste des Apprenants', 0, 1, 'C');
        $pdf->Ln(8);

        // Largeurs des colonnes (total ≈ 270mm en paysage)
        $widths = [
            'photo' => 18,     // Colonne photo légèrement élargie
            'matricule' => 22,
            'nom' => 35,
            'prenom' => 35,
            'telephone' => 25,
            'statut' => 20
        ];

        // Ajustement précis pour utiliser toute la largeur
        $totalCurrentWidth = array_sum($widths);
        $adjustmentFactor = 270 / $totalCurrentWidth;
        foreach ($widths as $key => $width) {
            $widths[$key] = $width * $adjustmentFactor;
        }

        // En-têtes avec style épuré
        $header = ['Photo', 'Matricule', 'Nom', 'Prénom', 'Téléphone', 'Statut'];
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetFillColor(240, 240, 240);  // Gris très clair
        $pdf->SetTextColor(0);              // Texte noir

        foreach ($header as $i => $col) {
            $pdf->Cell($widths[array_keys($widths)[$i]], 8, $col, 1, 0, 'C', 1);
        }
        $pdf->Ln();

        // Données des apprenants
        $pdf->SetFont('helvetica', '', 8);
        $data = getApprenantInfos();
        $fill = false;

        foreach ($data['data'] as $row) {
            // Cellule Photo avec image redimensionnée
            $pdf->Cell($widths['photo'], 15, '', 1, 0, 'C', $fill);

            if (!empty($row['photo'])) {
                try {
                    $tempImg = tempnam(sys_get_temp_dir(), 'img');
                    file_put_contents($tempImg, file_get_contents($row['photo']));

                    // Insertion avec taille réduite et centrage précis
                    $imgWidth = 12; // Largeur image en mm
                    $imgHeight = 10; // Hauteur image en mm
                    $xPos = $pdf->GetX() - $widths['photo'] + ($widths['photo'] - $imgWidth) / 2;
                    $yPos = $pdf->GetY() + (15 - $imgHeight) / 2;

                    $pdf->Image($tempImg, $xPos, $yPos, $imgWidth, $imgHeight, '', '', '', false, 300);
                    unlink($tempImg);
                } catch (Exception $e) {
                    // Fallback sobre
                    $pdf->Image(
                        ROOT_PATH . '/assets/images/default-avatar.jpg',
                        $xPos,
                        $yPos,
                        $imgWidth,
                        $imgHeight
                    );
                }
            }

            // Autres cellules avec hauteur uniforme
            $cells = [
                'matricule' => $row['matricule'],
                'nom' => $row['nom'],
                'prenom' => $row['prenom'],
                'telephone' => $row['telephone'],
                'statut' => ucfirst($row['statut'])
            ];

            foreach ($cells as $key => $value) {
                $pdf->Cell($widths[$key], 15, $value, 'LR', ($key === 'statut') ? 1 : 0, 'C', $fill);
            }

            $fill = !$fill;
        }

        // Ligne de fermeture du tableau
        $pdf->Cell(array_sum($widths), 0, '', 'T');

        // Génération du PDF
        ob_clean();
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="apprenants_' . date('Y-m-d_H-i') . '.pdf"');
        $pdf->Output('apprenants.pdf', 'D');
        exit;
    } catch (Exception $e) {
        error_log('Export PDF Error: ' . $e->getMessage());
        setFieldError("general", "Erreur lors de la génération du fichier Excel");
        redirect_to('/admin/apprenant');
    }
}

function addApprenantService(array $postData, array $fileData): array
{
    $promotion = getPromotionActive();
    $matricule = generateMatricule();
    // 1. Préparer les données
    $apprenantData = [
        'nom' => trim($postData['nom'] ?? ''),
        'prenom' => trim($postData['prenom'] ?? ''),
        'date_naissance' => $postData['date_naissance'] ?? '',
        'lieu_naissance' => trim($postData['lieu_naissance'] ?? ''),
        'adresse' => trim($postData['adresse'] ?? ''),
        'email' => trim($postData['email'] ?? ''),
        'telephone' => trim($postData['telephone'] ?? ''),
        'promotion_id' => $promotion["id"] ?? null,
        'referentiel_id' => $postData["referentiel_id"],
        'matricule' => $matricule
    ];

    // 2. Valider les données
    if (!validateApprenantData($apprenantData, $fileData)) {
        return [
            'success' => false,
            'message' => 'Validation échouée',
            'errors' => getFieldErrors()
        ];
    }

    // 3. Uploader la photo
    $photoPath = null;
    if (!empty($fileData['photo']['name'])) {
        try {
            $photoPath = uploadImage($fileData['photo'], "apprenants", "_profile");
            $apprenantData['photo'] = $photoPath;
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => ['photo' => $e->getMessage()]
            ];
        }
    }

    try {
        // 4. Créer l'apprenant dans la base de données
        $apprenantId = createApprenant($apprenantData);
        if (!$apprenantId) {
            throw new Exception("Erreur lors de la création de l'apprenant");
        }

        return [
            'success' => true,
            'message' => 'Apprenant créé avec succès',
            'apprenantId' => $apprenantId
        ];
    } catch (Exception $e) {
        // Nettoyage en cas d'erreur
        if ($photoPath && file_exists(ROOT_PATH . $photoPath)) {
            unlink(ROOT_PATH . $photoPath);
        }

        return [
            'success' => false,
            'message' => $e->getMessage(),
            'errors' => ['general' => $e->getMessage()]
        ];
    }
}
