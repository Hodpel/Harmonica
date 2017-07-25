<?php
// +----------------------------------------------------------------------+
// | PHP version 5.5.38                                                   |
// +----------------------------------------------------------------------+
// | Authors: Bert                                                        |
// +----------------------------------------------------------------------+
//
// $Id:Do_sth


echo page_links($content);
function page_links($content) {
    $content = $content . "###end###";
    preg_match_all("/@@@(.*)@@@/", $content, $title);
    //var_dump($title[0]);
    $n = count($title[0]);
    $o = 0;
    $array = array();
    $html = "";
    for ($i = 0; $i < $n; $i++) {
        //echo $i;
        if (!isset($title[0][$i + 1])) {
            $var = "###end###";
        } else {
            $var = $title[0][$i + 1];
        }
        $html = $html . "<h3>" . $title[1][$i] . "</h3>	<div class=\"link-box\">";
        //array_push($array, get_between($content, $title[0][$i], $var));
        $a = get_between($content, $title[0][$i], $var);
        preg_match_all("/\[\+(.*)\+\]/", $a, $name);
        preg_match_all("/\(\+(.*)\+\)/", $a, $avatar);
        preg_match_all("/\{\+(.*)\+\}/", $a, $link);
        $n1 = count($name[0]);
        for ($c = 0; $c < $n1; $c++) {
            $html = $html . '<a href="' . $link[1][$c] . '" target="_blank" class="no-underline">
			<div class="thumb">
				<img width="200" height="200" src="' . $avatar[1][$c] . '" alt="' . $name[1][$c] . '">
			</div>
			<div class="link-content">
				<div class="link-title">
					<span id="menu_index_' . ++$o . '" name="menu_index_' . $o . '"></span>
					<h3>' . $name[1][$c] . '</h3>
				</div>
			</div>
		</a>';
        }
        $html = $html . "</div>";
    }
    return $html;
}
function get_between($input, $start, $end) {
    $substr = substr($input, strlen($start) + strpos($input, $start) , (strlen($input) - strpos($input, $end)) * (-1));
    return $substr;
}

