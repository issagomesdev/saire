<?php

namespace Database\Seeders\Support;

use Carbon\Carbon;
use Faker\Generator;

/**
 * Gera datas espalhadas por 2023-2026, com hora do dia variada e viés
 * sazonal (ex.: São João em junho) quando o tópico declarar um mês.
 */
class SeedDateGenerator
{
    private const FIRST_YEAR = 2023;

    public function __construct(private readonly Generator $faker, private readonly Carbon $now)
    {
    }

    /**
     * @param int[]|null $seasonMonths Meses preferidos (1-12), ou null para qualquer mês.
     * @param int[]|null $onlyYears Restringe a esses anos (ex.: [2023] para Covid-19).
     */
    public function randomDate(?array $seasonMonths = null, ?array $onlyYears = null): Carbon
    {
        $years = $onlyYears ?? range(self::FIRST_YEAR, $this->now->year);
        $year = $this->faker->randomElement($years);

        $month = $seasonMonths !== null
            ? $this->faker->randomElement($seasonMonths)
            : $this->faker->numberBetween(1, 12);

        $maxDay = Carbon::create($year, $month, 1)->daysInMonth;
        $day = $this->faker->numberBetween(1, $maxDay);

        $date = Carbon::create($year, $month, $day, $this->randomHour(), $this->faker->numberBetween(0, 59));

        // Nunca gerar uma data no futuro em relação ao "hoje" do ambiente.
        return $date->greaterThan($this->now) ? $this->now->copy()->subDays($this->faker->numberBetween(1, 30)) : $date;
    }

    /**
     * Hora do dia com viés realista: mais publicações de manhã e à tarde
     * (horário comercial da Prefeitura) do que à noite.
     */
    private function randomHour(): int
    {
        $band = $this->faker->randomElement(['manha', 'manha', 'tarde', 'tarde', 'noite']);

        return match ($band) {
            'manha' => $this->faker->numberBetween(7, 11),
            'tarde' => $this->faker->numberBetween(13, 18),
            default => $this->faker->numberBetween(19, 22),
        };
    }
}
