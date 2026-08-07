<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateNumber($date)
    {
        $carbonDate = \Carbon\Carbon::parse($date);
        $monthRoman = self::romanNumerals($carbonDate->month);
        $year = $carbonDate->year;

        // SR-RNS/XII/2024
        $lastReport = self::whereYear('working_start', $year)
                          ->whereMonth('working_start', $carbonDate->month)
                          ->orderBy('id', 'desc')
                          ->first();

        $nextNumber = 1;
        if ($lastReport) {
            // Extract number from format "03/SR-RNS/XII/2024"
            $parts = explode('/', $lastReport->report_no);
            if (isset($parts[0])) {
                $nextNumber = (int)$parts[0] + 1;
            }
        }

        return sprintf("%03d/SR-RAND/%s/%s", $nextNumber, $monthRoman, $year);
    }

    private static function romanNumerals($num)
    {
        $n = intval($num);
        $res = '';
        $roman_numerals = [
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C'  => 100,
            'XC' => 90,
            'L'  => 50,
            'XL' => 40,
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1
        ];

        foreach ($roman_numerals as $roman => $number) {
            $matches = intval($n / $number);
            $res .= str_repeat($roman, $matches);
            $n = $n % $number;
        }

        return $res;
    }
}
