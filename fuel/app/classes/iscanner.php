<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Matthias
 */
interface IScanner {
    // Name of the scanner
    public function get_name();
    // Author of the scanner
    public function get_author();
    // Version of the scanner
    public function get_version();
    // Type of scanner: Movie, TV, People
    public function get_type();
}

?>
