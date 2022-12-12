<?php

include_once('HabitablePlanetsClass.php');
$habitable_planets = new HabitablePlanetsClass('kepler_data.csv');
var_dump($habitable_planets->get_habitable_planets());