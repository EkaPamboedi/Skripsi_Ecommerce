<?php declare(strict_types=1);

namespace App\Models;

class Similarity
{
  
    public static function euclidean(array $array1, array $array2, bool $returnDistance = false): float
    {
        $a   = $array1;
        $b   = $array2;
        $set = [];


        foreach ($a as $index => $value) {
            $set[] = $value - $b[$index] ?? 0;
        }

        $distance = sqrt(
                          array_sum(//Menambahkan semua hasil
                            array_map(//menjalankan semua function
                              function ($x) {
                                return pow($x, 2);
                              }, $set)));

        if ($returnDistance) {
            return $distance;
        }
        // doesn't work well with distances larger than 1
        // return 1 / (1 + $distance);
        // so we'll use angular similarity instead
        // dd(1- $distance);
        return 1 - $distance;
    }

    public static function jaccard(string $string1, string $string2, string $separator = ','): float
    {
        $a            = explode($separator, $string1);
        $b            = explode($separator, $string2);
        $intersection = array_unique(array_intersect($a, $b));
        // dd($intersection);
        $union        = array_unique(array_merge($a, $b));

        return count($intersection) / count($union);
    }

    public static function minMaxNorm(array $values, $min = null, $max = null): array
    {
        $norm = [];
        $min  = $min ?? min($values);
        // dd($min);
        $max  = $max ?? max($values);

        foreach ($values as $value) {
            $numerator   = $value - $min;
            $denominator = $max - $min;
            $minMaxNorm  = $numerator / $denominator;
            $norm[]      = $minMaxNorm;
        }
        return $norm;
    }
}
