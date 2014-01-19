<?php

function yearsA($year)
{
    $today = (int)date('Y');
    $total_years = $today - $year;

    if ($total_years > 0) {
        return $total_years;
    }

    return false;
}

function yearsB($year)
{
    $today = (int)date('Y');
    $total_years = 0;

    if ($today > $year) {
        while ($today > $year) {
            $total_years++;
            $year++;
        }
        return $total_years;
    }
    return false;
}

/**
 * Crappy code to test the PHPMD Cyclomatic Complexity rule.
 *
 * @param integer $grade
 * @return integer
 */
function cyclomaticComplexityTest( $grade )
{
    if ( $grade >= 5 ) {
        switch( $grade ) {
            case 5:
            case 6:
                echo "passed";
                break;
            case 7:
            case 8:
                echo "well done";
            break;
            case 9:
                echo "impressive";
            break;
            case 10:
                echo "awesome";
            break;
            default:
                echo "cheater";

        }
    } else {
        echo "failed";
    }

    return $grade;
}