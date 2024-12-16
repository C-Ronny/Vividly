<?php
require '../config.php';





// Return data as JSON
echo json_encode([
    'totalUsers' => $totalUsers,
    'newUsers' => $newUsers,
    'totalBoards' => $totalBoards,
    'totalPins' => $totalPins,
    'mostActiveCategory' => $mostActiveCategory,
    'avgPins' => round($avgPins, 1),
    'totalCategories' => $totalCategories
]);

?>