<?php
function parseDate($dateString) {
    $result = [
        'day' => null,
        'month' => null,
        'year' => null
    ];

    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateString, $matches)) {
        // Format: mm/dd/yyyy
        $result['month'] = (int)$matches[1];
        $result['day'] = (int)$matches[2];
        $result['year'] = (int)$matches[3];
    } elseif (preg_match('/^(\d{1,2})\/(\d{1,2})$/', $dateString, $matches)) {
        // Format: mm/dd
        $result['month'] = (int)$matches[1];
        $result['day'] = (int)$matches[2];
    } elseif (preg_match('/^(\d{4})$/', $dateString, $matches)) {
        // Format: yyyy
        $result['year'] = (int)$matches[1];
    }

    return $result;
}

// Example usage:
print_r(parseDate("12/25/2023")); // Full date
print_r(parseDate("12/25")); // Month and day only
print_r(parseDate("2023")); // Year only

/^(?:(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])\/(19[0-9]{2}|20[0-4][0-9]|2050)|(0[1-9]|1[0-2])\/(0[1-9]|[12][0-9]|3[01])|(19[0-9]{2}|20[0-4][0-9]|2050))$/
