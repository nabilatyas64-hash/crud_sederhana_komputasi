<?php
/**
 * Project entity model extending the generic Model.
 */

require_once __DIR__ . '/Model.php';

class Project extends Model
{
    protected static string $tableName = 'projects';
    protected static array $fields = ['title', 'description', 'status', 'created_at'];

    // Convenience method to create a new project with current timestamp.
    public function createProject(string $title, string $description, string $status = 'new'): int
    {
        $data = [
            'title'       => $title,
            'description' => $description,
            'status'      => $status,
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        return $this->create($data);
    }
}
?>