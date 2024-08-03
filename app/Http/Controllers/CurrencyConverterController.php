<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    public function index()
    {
        return view('converter');
    }

    public function convert(Request $request)
    {
        $input = $request->input('number');
        $conversionType = $request->input('conversion_type');

        if ($conversionType === 'to_roman') {
            $result = $this->fromReaisToRoman($input);
        } elseif ($conversionType === 'to_reais') {
            $result = $this->fromRomanToReais($input);
        } else {
            return back()->withErrors(['error' => 'Invalid conversion type']);
        }

        return back()->with('result', $result);
    }


    private function fromReaisToRoman($value)
    {
        $value = str_replace(['R$', ' ', ','], ['', '', '.'], $value);
        $number = (float)$value;

        $map = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I',
        ];

        $roman = '';

        foreach ($map as $num => $char) {
            while ($number >= $num) {
                $roman .= $char;
                $number -= $num;
            }
        }

        return $roman;
    }

    private function fromRomanToReais($roman)
    {
        $roman = strtoupper($roman);
        $map = [
            'M' => 1000,
            'D' => 500,
            'C' => 100,
            'L' => 50,
            'X' => 10,
            'V' => 5,
            'I' => 1,
        ];

        $number = 0;
        $lastValue = 0;

        for ($i = strlen($roman) - 1; $i >= 0; $i--) {
            $currentValue = $map[$roman[$i]];

            if ($currentValue < $lastValue) {
                $number -= $currentValue;
            } else {
                $number += $currentValue;
            }
            $lastValue = $currentValue;
        }

        return 'R$ ' . number_format($number, 2, ',', '.');
    }
}

