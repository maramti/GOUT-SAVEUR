<?php
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $query = escapeshellarg($_GET['query']);
    $command = "python includes/indexer.py $query";
    $output = shell_exec($command);
    
    // Décoder le JSON et renvoyer
    $result = json_decode($output, true);
    
    if ($result && !isset($result['error'])) {
        // Construction du HTML des résultats
        $html = '<div class="results-nav">...</div>';
        $html .= '<div class="search-results">';
        
        foreach ($result['results'] as $item) {
            $html .= '<div class="result-item">'.$item.'</div>';
        }
         
        $html .= '</div>';
        echo json_encode(["html" => $html]);
    } else {
        echo json_encode(["error" => $result['error'] ?? "Erreur inconnue"]);
    }
} else {
    echo json_encode(["error" => "Requête vide"]);
}
?>