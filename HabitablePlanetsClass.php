<?php 
class HabitablePlanetsClass {

    public function __construct(public string $kepler_data){
        $kepler_data = $this->kepler_data;
    }

    public function get_habitable_planets(){
        $kepler_data = fopen($this->kepler_data, 'r');
        return $this->csv_remove_comments($kepler_data);
    }

    /**
     * Take Kepler Data remove the comments and push into another array
     *
     * @param [type] $kepler_data
     * @return void
     */

    private function csv_remove_comments($kepler_data){

        $csv_no_comm_array = [];
        while($line = fgetcsv($kepler_data, 0, ',')){
            if(!str_contains($line[0], '#')){
                array_push($csv_no_comm_array, $line);
            }
        }

        return $this->find_index_habitat_items_csv($csv_no_comm_array);
    }

    /**
     * Find the Index of some information to have live on planet
     *
     * @param array $csv_no_comm_array
     * @return void
     */
    private function find_index_habitat_items_csv(array $csv_no_comm_array){
        $koi_disposition = array_search('koi_disposition', $csv_no_comm_array[0]);
        $koi_insol = array_search('koi_insol', $csv_no_comm_array[0]);
        $koi_prad = array_search('koi_prad', $csv_no_comm_array[0]);
        return $this->is_habitable_planet($koi_disposition, $koi_insol, $koi_prad, $csv_no_comm_array);
    }

    /**
     * Checking if the planet is habitable following the NASA information.
     *
     * @param integer $koi_disposition
     * @param integer $koi_insol
     * @param integer $koi_prad
     * @param array $value
     * @return boolean
     */
    private function is_habitable_planet(int $koi_disposition, int $koi_insol, int $koi_prad, array $value): array{
        $habitable_planets = [];
        foreach ($value as $key => $planet) {
            if($planet[$koi_disposition] === 'CONFIRMED'
            && $planet[$koi_insol] > 0.36
            && $planet[$koi_insol] < 1.11
            && $planet[$koi_prad] < 1.6){
                array_push($habitable_planets, $planet);
            }
        }

        // echo "<pre>";
        // print_r($habitable_planets);
        // echo "</pre>";
        return $habitable_planets;
    }
}