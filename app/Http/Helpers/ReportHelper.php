<?php

namespace App\Http\Helpers;


class ReportHelper
{


    public static function replaceSpaceCharInString($string, $search, $replace)
    {
        return str_replace($search, $replace, $string);
    }

    public static function generateStudentMonthlyAttendanceSumTableRows(?array $dateWisePresent, ?array $dateWiseAbsent)
    {
        $row1 = '<tr><td colspan="4" style="text-align: left;">T.P</td>';
        $row2 = '<tr><td colspan="4" style="text-align: left;">T.A</td>';

        foreach ($dateWisePresent as $date => $total) {
            $row1 .= "<td>{$total}</td>";
            $row2 .= "<td>{$dateWiseAbsent[$date]}</td>";
        }

        $row1 .= '<td rowspan="2" colspan="4"></td>';
        $row1 .= "</tr>";
        $row2 .= "</tr>";
        return $row1 . $row2;
    }

    public static function generateEmployeeMonthlyAttendanceSumTableRows(?array $dateWisePresent, ?array $dateWiseAbsent)
    {
        $row1 = '<tr><td colspan="2" style="text-align: left;">T.P</td>';
        $row2 = '<tr><td colspan="2" style="text-align: left;">T.A</td>';

        foreach ($dateWisePresent as $date => $total) {
            $row1 .= "<td>{$total}</td>";
            $row2 .= "<td>{$dateWiseAbsent[$date]}</td>";
        }

        $row1 .= '<td rowspan="2" colspan="3"></td>';
        $row1 .= "</tr>";
        $row2 .= "</tr>";
        return $row1 . $row2;
    }


}
