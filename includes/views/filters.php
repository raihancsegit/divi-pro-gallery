<?php

$hide_all_filter  = $filters_data['options']['hide_all_filter'];
$all_filter_label = $filters_data['options']['all_filter_label'];
$filters = isset($filters_data['filters']) ? $filters_data['filters'] : [];

echo "<ul class='dpg-filters-list'>";

if ($hide_all_filter) {
    echo '<li class="dpg-filter-item current">';
    echo '<a data-filter="*" href="#all">';
    echo esc_html($all_filter_label);
    echo '</a>';
    echo '</li>';
}

foreach ($filters as $filter) {
    $filter_slug = sanitize_title($filter);
    $filter_url  = "#" . $filter_slug;
    echo '<li class="dpg-filter-item">';
    echo '<a data-filter=".' . esc_attr($filter_slug) . '" class="dpg-link" href="' . esc_url($filter_url) . '">';
    echo esc_html($filter);
    echo '</a>';
    echo '</li>';
}

echo "</ul>";
