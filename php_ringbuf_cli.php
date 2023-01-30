<?php

const LOCKED = 1;
const UNLOCKED = 2;

$state = LOCKED;
$secret = [ 4, 6, 4, 9 ];

$ringbuf = [ 0, 0, 0, 0 ];
$ringindex = 0;

for (;;) {
    printf("[%s] INPUT KEY: ", ($state == LOCKED) ? "LOCKED" : "** UNLOCKED **");
    $input = trim(fgets(STDIN)); 
    if (empty($input))
        continue;

    $ringbuf[$ringindex] = $input[0];
    $ringindex = ($ringindex + 1) % count($ringbuf);

    var_dump($input);

    print "\nringbuf =\n";
    print_r($ringbuf);
    print "\n";

    switch ($state) {
        case LOCKED:
            if (check_secret()) {
                print "PIN accepted\n";
                $state = UNLOCKED;
            }
            break;
        case UNLOCKED:
            if (check_asta()) {
                print "locked\n";
                $state = LOCKED;
            }
            break;
    }
}

function check_secret()
{
    global $ringbuf, $ringindex, $secret;

    for ($i = 0; $i < count($secret); $i++) {
        $ri = ($ringindex + $i) % count($ringbuf);
        if ($ringbuf[$ri] != $secret[$i])
            return false;
    }

    return true;
}

function check_asta()
{
    global $ringbuf, $ringindex, $secret;

    for ($i = 1; $i <= 2; $i++) {
        $ri = $ringindex - $i;
        if ($ri < 0)
            $ri = count($ringbuf) + $ri;
        if ($ringbuf[$ri] != '*')
            return false;
    }

    return true;
}
