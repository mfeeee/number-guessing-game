<?php

$flag = true;

while ($flag) {
    main();
}

function main() {
    echo "Welcome to the Number Guessing Game!" . PHP_EOL;
    echo "I'm thinking of a number between 1 and 100." . PHP_EOL;
    echo "You have 5 chances to guess the correct number.\n" . PHP_EOL;

    echo "Please select the difficulty level:" . PHP_EOL;
    echo "1. Easy (10 chances)" . PHP_EOL;
    echo "2. Medium (5 chances)" . PHP_EOL;
    echo "3. Hard (3 chances)\n" . PHP_EOL;
    $choice = readline("Enter your choice: ");

    switch($choice) {
        case "1":
            startMessage($choice);
            runGame(10);
            break;
        case "2":
            startMessage($choice);
            runGame(5);
            break;
        case "3":
            startMessage($choice);
            runGame(3);
            break;
        default:
            echo "Invalid command. Allowed levels: 1 (Easy), 2 (Medium), 3 (Hard).\n" . PHP_EOL;
            exit(1);
    }
}

function startMessage(string $difficulty) {
    $levels = [
        "1" => "Easy", 
        "2" => "Medium", 
        "3" => "Hard", 
    ];

    echo "\nGreat! You have selected the $levels[$difficulty] difficulty level." . PHP_EOL;
    echo "Let's start the game!\n" . PHP_EOL;
}

function defineSecretNumber() {
    $secretNumber = new \Random\Randomizer();

    return $secretNumber->getInt(1, 100);
}

function validateGuess(?string $guess = null) {
    if (trim($guess) === '') {
        echo "Your guess is blank! You lost an attempt.\n" . PHP_EOL;
        return false;
    }
    else if (!is_numeric($guess)) {
        echo "Your guess isn't a number. You lost an attempt.\n" . PHP_EOL;
        return false;
    }
    return true;
}

function runGame(int $attempts) {
    $answer = defineSecretNumber();
    $foundAnswer = false;

    for($i = 1; $i <= $attempts; $i++) {
        $plural = "";
        $guess = readline("Enter your guess: ");
        if(!validateGuess($guess)) {
            continue;
        }

        if ((int)$guess == $answer) {
            if ($i > 1) $plural = "s";
            $foundAnswer = true;
            echo "Congratulations! You guessed the correct number in $i attempt$plural.\n" . PHP_EOL;
            break;
        }
        elseif ((int)$guess > $answer) {
            echo "Incorrect! The number is less than $guess.\n" . PHP_EOL;
        } else {
            echo "Incorrect! The number is greater than $guess.\n" . PHP_EOL;
        }
    }

    if(!$foundAnswer) {
        echo "Game over! The correct number was $answer.\n" . PHP_EOL;
    }

    $playAgain = readline("Do you want to play again? (y/n)");
    echo "\n" . PHP_EOL;

    if (strtolower(trim($playAgain)) !== 'y') {
        global $flag; 
        $flag = false;
        echo "Thanks for playing! Goodbye!\n";
    }
}