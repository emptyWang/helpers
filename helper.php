<?php


function number_to_big_chinese_number($number)
{
    $numberStr = (string) $number;
    $reserve_arr = str_split(strrev($numberStr), 4);
    array_walk($reserve_arr, function (&$item) {
        $item = strrev($item);
    });

    array_walk($reserve_arr, function (&$item, $kkey) {
        $insideUnitMap = [ '', '拾', '佰', '仟' ];
        $outsideUnitMap = ['', '萬', '億', '兆', '京', '垓', '杼', '穰', '溝', '澗', '正', '載', '極', '恒河沙', '阿僧祇', '那由他', '不可思議', '無量', '大數' ];
        $littltUnitMap = ['分','厘','毫','丝','忽','微','纤','沙','尘','埃','渺','漠','模糊','逡巡','须臾','瞬息','弹指','刹那','六德','虚空','清净','阿赖耶','阿摩罗','涅槃寂静'];
        $chineseNumber = [ '零', '壹', '贰', '叁', '肆', '伍', '陸', '柒', '捌', '玖' ];

        $final = '';
        $length = strlen($item)-1;
        $have_zero = false;
        foreach (array_reverse(range(0, $length)) as $key) {
            $word_value = $chineseNumber[$item{abs($key-$length)}];
            if ($word_value == '零') {
                if ($have_zero) {
                    continue;
                }
                $final .= $word_value;
                $have_zero = true;
            } else {
                $final .= $word_value . $insideUnitMap[$key];
                $have_zero = false;
            }
        }
        $final = rtrim($final, "零");
        $item = $final.$outsideUnitMap[$kkey];
    });

    $final_str = implode(array_reverse($reserve_arr));

    return $final_str == '壹拾' ? '拾' : $final_str;
}

