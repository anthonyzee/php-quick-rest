<?php

function odataToMySQLWhereClause($odataQuery) {
    // Replace operators with SQL equivalents
    $patterns = [
        "/\beq\b/" => "=",
        "/\bne\b/" => "!=",
        "/\blt\b/" => "<",
        "/\ble\b/" => "<=",
        "/\bgt\b/" => ">",
        "/\bge\b/" => ">=",
        "/\band\b/i" => "AND",
        "/\bor\b/i" => "OR"
    ];
    $odataQuery = preg_replace(array_keys($patterns), array_values($patterns), $odataQuery);

    // Replace OData functions with SQL syntax
    $odataQuery = preg_replace_callback('/startswith\(([^,]+),\s*\'([^\']+)\'\)/i', function($matches) {
        return "{$matches[1]} LIKE '{$matches[2]}%'";
    }, $odataQuery);

    $odataQuery = preg_replace_callback('/endswith\(([^,]+),\s*\'([^\']+)\'\)/i', function($matches) {
        return "{$matches[1]} LIKE '%{$matches[2]}'";
    }, $odataQuery);

    $odataQuery = preg_replace_callback('/contains\(([^,]+),\s*\'([^\']+)\'\)/i', function($matches) {
        return "{$matches[1]} LIKE '%{$matches[2]}%'";
    }, $odataQuery);

    $odataQuery = preg_replace_callback('/substringof\(\s*\'([^\']+)\',\s*([^\)]+)\)/i', function($matches) {
        return "{$matches[2]} LIKE '%{$matches[1]}%'";
    }, $odataQuery);

    return $odataQuery;
}

function buildSQLFromOData($tableName, $queryParams) {
    $columns = '*';
    $whereClause = '';
    $limit = '';
    $offset = '';

    // Handle $select
    if (!empty($queryParams['$select'])) {
        $selectedCols = array_map('trim', explode(',', $queryParams['$select']));
        $columns = implode(', ', array_map(function($col) {
            return "`" . str_replace("`", "", $col) . "`";
        }, $selectedCols));
    }

    // Handle $filter
    if (!empty($queryParams['$filter'])) {
        $where = odataToMySQLWhereClause($queryParams['$filter']);
        $whereClause = "WHERE $where";
    }

    // Handle $top
    if (!empty($queryParams['$top']) && is_numeric($queryParams['$top'])) {
        $limit = "LIMIT " . intval($queryParams['$top']);
    }

    // Handle $skip
    if (!empty($queryParams['$skip']) && is_numeric($queryParams['$skip'])) {
        $offset = "OFFSET " . intval($queryParams['$skip']);
    }

    // Final SQL
    $sql = "SELECT $columns FROM `$tableName`";
    if ($whereClause) $sql .= " $whereClause";
    if ($limit) $sql .= " $limit";
    if ($offset) $sql .= " $offset";

    return $sql . ";";
}
?>
