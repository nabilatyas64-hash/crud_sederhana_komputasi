<?php
/**
 *
 * Run this script from the project root (c:\\Semester V\\Komputasi Awan\\crud_sederhana).
 * It will:
 *   1. Create a new project record.
 *   2. Retrieve and display that record.
 *   3. Update the record.
 *   4. List all records.
 *   5. Delete the record.
 */

require_once __DIR__ . '/Project.php';

$projectModel = new Project();

// 1. CREATE (Contoh data baru yang ingin dimasukkan)
echo "\n=== CREATE ===\n";
$newId = $projectModel->createProject(
    'Aplikasi Anti Gravity', 
    'Pengembangan modul navigasi berbasis gravitasi nol.', 
    'aktif'
);
echo "Created project with ID: $newId\n";

// 2. READ (single)
echo "\n=== READ (single) ===\n";
$project = $projectModel->find($newId);
print_r($project);

// 3. UPDATE
echo "\n=== UPDATE ===\n";
$updated = $projectModel->update($newId, [
    'status' => 'in_progress',
    'description' => 'Updated description after starting work.'
]);
echo $updated ? "Update successful.\n" : "Update failed.\n";

// Verify update
$project = $projectModel->find($newId);
print_r($project);

// 4. READ ALL
echo "\n=== READ ALL ===\n";
$allProjects = $projectModel->all();
print_r($allProjects);

// 5. DELETE (Dinonaktifkan agar data tidak terhapus)
echo "\n=== DELETE ===\n";
// $deleted = $projectModel->delete($newId);
// echo $deleted ? "Deleted project ID $newId.\n" : "Delete failed.\n";

// Final list untuk mengecek data yang tersisa
echo "\n=== FINAL LIST (Data Tersimpan) ===\n";
print_r($projectModel->all());
?>