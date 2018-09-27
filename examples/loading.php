<?php
ob_start();
include dirname(__FILE__) . '/../vendor/autoload.php';

/*
 * Initiate new loading instance by overwriting the bar length, total row count and auto step increment straight
 * from the constructor.
 */
$loading = new \Edward\Indicator\Loading(100, 30, true);

/*
 * Overwrite the bar length on demand
 */
$loading->setBarLength(30);

/*
 * Overwrite the total row count on demand
 */
$loading->setTotal(100);

/*
 * Overwrite the necessity for steps to be incremented on every ping automatically. If set to false, the script will
 * not increment when ping is called but will rely on you to update via setCurrent()
 */
$loading->setAutoIncrement(true);

/*
 * You can change the current step even if auto increment is enabled, it will follow your input.
 */
$loading->setCurrent(0);

/*
 * Run ping on every row you are processing and it will output the string into your console if no argument is provided.
 */
$loading->ping();

/*
 * Alternatively you can provide a callable argument to process the output yourself.
 *
 * The variables you will receive in the argument:
 * "string" - A formatted string that can be outputted
 * "process.current" - Integer representing current step
 * "process.total" - Integer representing total row count
 * "percentageCompleted" - Float represented completion percentage
 * "elapsed.value" - Time unit elapsed since initial ping
 * "elapsed.format" - Time format elapsed since initial ping (seconds,minutes,hours)
 * "eta.value" - Estimated time unit until completion
 * "eta.format" - Estimated time format until completion (seconds,minutes,hours)
 */
$loading->ping(function ($info) use ($loading) {
    print $info['string'];
});

// to clear out output generated by code above.
ob_end_clean();

/*
 * Example show case 1
 */
print "\n\nExample show case 1:\n";

$loading = new \Edward\Indicator\Loading(100);

foreach (array_fill(0, 100, 'test') as $test) {
    $loading->ping();
    usleep(25e3);
}

print "Done\n";

/*
 * Example show case 2
 */
print "\n\nExample show case 2:\n";

$loading = new \Edward\Indicator\Loading(100);

foreach (array_fill(0, 100, 'test') as $test) {
    $loading->ping(function ($info) {
        if ($info === null) {
            print "\nThe loading has received ping for more rows than specified in total.\n";
            return;
        }

        print $info['string'] . "\r";

        if ($info['process']['current'] === $info['process']['total']) {
            print "\n";
        }
    });

    usleep(1e5);
}

print "Done\n";
