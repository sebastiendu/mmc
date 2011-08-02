<?php
/*
 * (c) 2007-2008 Mandriva, http://www.mandriva.com/
 *
 * $Id$
 *
 * This file is part of Mandriva Management Console (MMC).
 *
 * MMC is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * MMC is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MMC; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

include_once('libchart/libchart.php');

/**
 * Display a nice graph from data
 *
 * @param type Type of data.
 * @param sort Field
 */
function renderGraph($machines, $type, $sort, $filter) {

    $id = "$type $sort";
    $chart = new PieChart(770, 340);

    $div = 1;
    $mod = 0;
    $suffix = "";

    switch($id) {
        case "BootGeneral TotalMem":
            $div = 1024;
            $mod = 64;
            $suffix = " MB";
            break;
        case "BootGeneral Freq":
            $div = 1;
            $mod = 200;
            $suffix = " Mhz";
            break;
        case "BootDisk Capacity":
            $div = 1000;
            $mod = 20;
            $suffix = " GB";
            break;
        case "Memory Size":
            $div = 1024;
            $mod = 0;
            $suffix = " MB";
            break;
    }

    $data = array();
    foreach ($machines as $machine) {
        foreach ($machine[1] as $inv) {
            // filter data in ranges
            if ($div != 1) {
                $inv /= $div;
                $inv = round($inv);
            }
            if ($mod) {
                $inv /= $mod;
                $inv = round($inv);
                $inv *= $mod;
                if ($inv != 0) $inv = ($d-$mod+1)."-".$inv;
            }
            if ($suffix != "") {
                $inv = $inv.$suffix;
            }
            $data[$inv] += 1;
        }
    }

    // For each data count the occurence
    foreach($data as $key => $value)
        $chart->addPoint(new Point("$key ($value)", $value));

    $chart->setTitle(ucfirst($sort));
    header("Content-type: image/png");
    @$chart->render();

    exit;
}


?>

