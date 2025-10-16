<?php

namespace App\Services;

use Illuminate\Support\Arr;

class ColorService
{
    const COLORS = [
        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#E7E9ED',
        '#FF6B6B', '#6BCB77', '#4D96FF', '#FFD93D', '#C65D7B', '#845EC2', '#FFC75F',
        '#F9F871', '#008F7A', '#0081CF', '#FF8066', '#B0A8B9', '#C34A36', '#5F6F52',
        '#6B5B95', '#FEB236', '#D64161', '#FF7B25', '#91A8D0', '#45B8AC', '#EFC050',
        '#5B5EA6', '#9B2335', '#BC243C', '#C3447A', '#C1C8E4', '#FF6F61', '#88B04B',
        '#92A8D1', '#955251', '#B565A7', '#009B77', '#DD4124', '#D65076', '#45B8AC',
        '#EFC050', '#5B5EA6', '#9B2335', '#DFCFBE', '#55B4B0', '#E15D44', '#7FCDCD',
        '#BC243C', '#C3447A', '#98B4D4', '#F7CAC9', '#92A8D1', '#034F84', '#F7786B',
        '#79C753', '#DECF3F', '#6A0572', '#AB83A1', '#FC766A', '#5B84B1', '#B1B3B3',
        '#C34A36', '#C3447A', '#6F9FD8', '#009473', '#DD4132', '#9E1030', '#FE840E',
        '#FF6F61', '#F7CAC9', '#92A8D1', '#034F84', '#98B4D4', '#C3447A', '#6B4226',
        '#C3447A', '#9B1D20', '#E94B3C', '#009B77', '#DD4124', '#D65076', '#45B8AC',
        '#EFC050', '#5B5EA6', '#9B2335', '#BC243C', '#C3447A', '#D2386C', '#F2552C',
        '#6A0572', '#AB83A1', '#F5B700', '#FF4B3E', '#5C415D', '#BFD7EA', '#83C5BE',
        '#006D77', '#FFDDD2', '#E29578', '#FFAFCC', '#BDE0FE', '#A2D2FF', '#2EC4B6'
    ];

    public function getColors(int $amount = 5, $offset = 0): array
    {
        return array_slice(static::COLORS, $offset, $amount);
    }

    public function getRandomColors($amount = 5): array
    {
        return Arr::random(static::COLORS, $amount);
    }

    public function getRandomColor(): string
    {
        return Arr::random(static::COLORS);
    }

}
