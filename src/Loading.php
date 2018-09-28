<?php

namespace Edward\Indicator;

/**
 * Class Loading
 * @package Edward\Indicator
 */
class Loading
{

    /**
     * Loading constructor.
     * @param int $totalRows
     * @param int $barLength
     * @param boolean $autoIncrement
     */
    public function __construct(int $totalRows = 0, int $barLength = 30, bool $autoIncrement = true)
    {
        $this->total = $totalRows;
        $this->barLength = $barLength;
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * @var bool
     */
    private $autoIncrement = true;

    /**
     * @return bool
     */
    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * @param bool $autoIncrement
     */
    public function setAutoIncrement(bool $autoIncrement)
    {
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * @var int
     */
    private $barLength = 30;

    /**
     * @return int
     */
    public function getBarLength(): int
    {
        return $this->barLength;
    }

    /**
     * @param int $barLength
     */
    public function setBarLength(int $barLength)
    {
        $this->barLength = $barLength;
    }

    /**
     * @var int
     */
    private $current = 0;

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }

    /**
     * @param int $current
     */
    public function setCurrent(int $current)
    {
        $this->current = $current;
    }

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total)
    {
        $this->total = $total;
    }

    /**
     * @var int
     */
    private $startTimer;

    /**
     * @param callable|null $callback
     * @return mixed
     */
    public function ping(callable $callback = null)
    {

        if ($this->current > $this->total) {
            if ($callback !== null) {
                return $callback(null);
            }

            return null;
        }

        if ($this->autoIncrement) {
            $this->current++;
        }

        if (empty($this->startTimer)) {
            $this->startTimer = time();
        }

        $now = time();

        $percentage = $this->current && $this->total ? (double)($this->current / $this->total) : 0;
        $bar = floor($percentage * $this->barLength);

        $output = '[' . str_repeat('=', $bar);

        if ($bar < $this->barLength) {
            $output .= ">";
            $output .= str_repeat(" ", $this->barLength - $bar);
        } else {
            $output .= "=";
        }

        $percentageView = number_format($percentage * 100, 2, '.', '');

        $output .= '] ' . $percentageView . '%  ' . $this->current . '/' . $this->total;

        @$rate = ($now - $this->startTimer) / $this->current;
        $left = $this->total - $this->current;
        $eta = $rate * $left;
        $elapsed = $now - $this->startTimer;

        $etaFormat = 'seconds';
        $elapsedFormat = 'seconds';

        if ($eta > 60) {
            $eta = $eta / 60;
            $etaFormat = 'minutes';

            if ($eta > 60) {
                $eta = $eta / 60;
                $etaFormat = 'hours';
            }
        }

        if ($elapsed > 60) {
            $elapsed = $elapsed / 60;
            $elapsedFormat = 'minutes';

            if ($elapsed > 60) {
                $elapsed = $elapsed / 60;
                $elapsedFormat = 'hours';
            }
        }

        $eta = round($eta, 2);
        $elapsed = round($elapsed, 2);

        $output .= ' remaining: ' . number_format($eta) . ' ' . $etaFormat . ', elapsed: ' . number_format($elapsed) . ' ' . $elapsedFormat . '.';

        if ($callback !== null) {
            return $callback([
                'string' => $output,
                'process' => [
                    'current' => $this->current,
                    'total' => $this->total,
                ],
                'percentageCompleted' => floatval($percentageView),
                'elapsed' => [
                    'value' => $elapsed,
                    'format' => $elapsedFormat
                ],
                'eta' => [
                    'value' => $eta,
                    'format' => $etaFormat
                ]
            ]);
        }

        print "$output\r";

        if ($this->current === $this->total) {
            print "\n";
        }
    }

}