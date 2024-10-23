<?php

namespace Services;
class LuckyService {
    public function calculateLuckyResult() {
        $randomNumber = rand(1, 1000);
        $result = ($randomNumber % 2 == 0) ? 'Win' : 'Lose';
        $winAmount = 0;

        if ($result === 'Win') {
            if ($randomNumber > 900) {
                $winAmount = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $winAmount = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $winAmount = $randomNumber * 0.3;
            } else {
                $winAmount = $randomNumber * 0.1;
            }
        }

        return ['result' => $result, 'winAmount' => round($winAmount, 2)];
    }
}
