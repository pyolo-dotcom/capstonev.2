<?php

if (!function_exists('getInitials')) {
    function getInitials($name) {
        if (empty($name)) return '';

        $words = preg_split('/\s+/', trim($name));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            if (strlen($initials) >= 2) break;
        }
        
        return $initials ?: 'US'; // Default to "US" if no name
    }
}