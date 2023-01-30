<?php

const EVENT_KEY_0   = 0;
const EVENT_KEY_1   = 1;
const EVENT_KEY_2   = 2;
const EVENT_KEY_3   = 3;
const EVENT_KEY_4   = 4;
const EVENT_KEY_5   = 5;
const EVENT_KEY_6   = 6;
const EVENT_KEY_7   = 7;
const EVENT_KEY_8   = 8;
const EVENT_KEY_9   = 9;
const EVENT_KEY_A   = 10;
const EVENT_KEY_S   = 11;
const EVENT_KEY_OTH = 12;

const S_LOCKED      = 0;
const S_L_INPUT_1   = 1;
const S_L_INPUT_2   = 2;
const S_L_INPUT_3   = 3;
const S_UNLOCKED    = 4;
const S_U_INPUT_A   = 5;

const STATE_STRING = [
    "LOCKED", "L_INPUT_1", "L_INPUT_2", "L_INPUT_3",
    "UNLOCKED", "U_INPUT_A",
];

const STATE_TABLE = [
    // S_LOCKED           2         3         4            5         6            7         8         9           A         S         OTH
    [ S_LOCKED, S_LOCKED, S_LOCKED, S_LOCKED, S_L_INPUT_1, S_LOCKED, S_LOCKED,    S_LOCKED, S_LOCKED, S_LOCKED,   S_LOCKED, S_LOCKED, S_LOCKED ],
    // S_L_INPUT_1
    [ S_LOCKED, S_LOCKED, S_LOCKED, S_LOCKED, S_L_INPUT_1, S_LOCKED, S_L_INPUT_2, S_LOCKED, S_LOCKED, S_LOCKED,   S_LOCKED, S_LOCKED, S_LOCKED ],
    // S_L_INPUT_2
    [ S_LOCKED, S_LOCKED, S_LOCKED, S_LOCKED, S_L_INPUT_3, S_LOCKED, S_LOCKED,    S_LOCKED, S_LOCKED, S_LOCKED,   S_LOCKED, S_LOCKED, S_LOCKED ],
    // S_L_INPUT_3
    [ S_LOCKED, S_LOCKED, S_LOCKED, S_LOCKED, S_L_INPUT_1, S_LOCKED, S_L_INPUT_2, S_LOCKED, S_LOCKED, S_UNLOCKED, S_LOCKED, S_LOCKED, S_LOCKED ],

    // S_UNLOCKED             2           3           4           5           6           7           8           9           A            S           OTH
    [ S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_U_INPUT_A, S_UNLOCKED, S_UNLOCKED ],
    // S_U_INPUT_A
    [ S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_UNLOCKED, S_LOCKED,    S_UNLOCKED, S_UNLOCKED ],
];

$state = S_LOCKED;

// main
for (;;) {
    $event = get_event();
    $state = STATE_TABLE[$state][$event];
}

function get_event()
{
    global $state, $state_string;

    for (;;) {
        printf("[%s] INPUT KEY: ", STATE_STRING[$state]);
        $input = trim(fgets(STDIN)); 
        if (empty($input))
            continue;

        $event = input_to_event($input[0]);
        if (!empty($event))
            return $event;
    }
}

function input_to_event($input)
{
    $event_code = [
        '0' => EVENT_KEY_0,
        '1' => EVENT_KEY_1,
        '2' => EVENT_KEY_2,
        '3' => EVENT_KEY_3,
        '4' => EVENT_KEY_4,
        '5' => EVENT_KEY_5,
        '6' => EVENT_KEY_6,
        '7' => EVENT_KEY_7,
        '8' => EVENT_KEY_8,
        '9' => EVENT_KEY_9,
        '*' => EVENT_KEY_A,
        '#' => EVENT_KEY_S,
    ];

    return $event_code[$input] ?? EVENT_KEY_OTH;
}    
