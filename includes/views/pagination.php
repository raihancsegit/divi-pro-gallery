<?php

if (isset($_REQUEST['current_page']) && is_array($_REQUEST['current_page'])) {
    $current_url = $_REQUEST['current_page']['url'];
} else {
    $current_url = '';
}

$pattern = '/et_fb=1/';
$is_et_activated = false;

if (preg_match($pattern, $current_url)) {
    $is_et_activated = true;
}

if ($is_et_activated) {
    $total_images = count($gallery_items);

    $pages = ceil($total_images / $this->props['items_per_page']);

    for ($x = 1; $x <= $pages; $x++) {
        $page = $x;
        $current_class = ($page == 1) ? 'current' : '';

        echo '<a href="javascript:void(0);" class="pager ' . $current_class . '">';
        echo $x;
        echo '</a>';
    }
}
