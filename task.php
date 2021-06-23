<?php

// Sidehustle Internship Week 1 (One) Web Design and Development(Backend) task by Enwerem Melvin Confidence

// array and sum class
class task {
    public function __construct() {
        $range = range(0, 10);
        
        $sum = array_sum($range);

        echo $sum;
    }
}

// class instantiation 
new task();

?>