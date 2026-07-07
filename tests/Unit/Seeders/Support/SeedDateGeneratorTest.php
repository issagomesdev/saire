<?php

namespace Tests\Unit\Seeders\Support;

use Carbon\Carbon;
use Database\Seeders\Support\SeedDateGenerator;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class SeedDateGeneratorTest extends TestCase
{
    public function test_date_falls_within_2023_and_now(): void
    {
        $now = Carbon::create(2026, 7, 5);
        $generator = new SeedDateGenerator(Factory::create('pt_BR'), $now);

        for ($i = 0; $i < 50; $i++) {
            $date = $generator->randomDate();

            $this->assertGreaterThanOrEqual(2023, $date->year);
            $this->assertLessThanOrEqual($now->year, $date->year);
            $this->assertTrue($date->lessThanOrEqualTo($now));
        }
    }

    public function test_date_never_lands_in_the_future(): void
    {
        $now = Carbon::create(2026, 7, 5, 10, 0);
        $generator = new SeedDateGenerator(Factory::create('pt_BR'), $now);

        for ($i = 0; $i < 50; $i++) {
            $this->assertTrue($generator->randomDate()->lessThanOrEqualTo($now));
        }
    }

    public function test_season_months_constrain_the_generated_month(): void
    {
        $now = Carbon::create(2026, 7, 5);
        $generator = new SeedDateGenerator(Factory::create('pt_BR'), $now);

        for ($i = 0; $i < 30; $i++) {
            $date = $generator->randomDate([6]);

            $this->assertSame(6, $date->month);
        }
    }

    public function test_only_years_restricts_the_generated_year(): void
    {
        $now = Carbon::create(2026, 7, 5);
        $generator = new SeedDateGenerator(Factory::create('pt_BR'), $now);

        for ($i = 0; $i < 30; $i++) {
            $date = $generator->randomDate(null, [2023]);

            $this->assertSame(2023, $date->year);
        }
    }
}
