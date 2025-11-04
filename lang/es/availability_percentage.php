<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language strings.
 *
 * @package availability_percentage
 * @copyright 2025 Your Name
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Restricción por porcentaje de finalización';
$string['title'] = 'Porcentaje de finalización';
$string['description'] = 'Requiere que un porcentaje de estudiantes complete otra actividad.';

$string['label_cm'] = 'Actividad o recurso';
$string['label_percentage'] = 'Porcentaje requerido';

$string['error_selectcmid'] = 'Debes seleccionar una actividad para la restricción por porcentaje de finalización.';
$string['error_percentage'] = 'Debes ingresar un porcentaje válido entre 0 y 100.';

$string['missing'] = '(Actividad faltante)';

$string['requires_complete'] = 'Al menos <strong>{$a->percentage}%</strong> de los estudiantes deben completar la actividad <strong>{$a->name}</strong>';
$string['requires_notcomplete'] = 'Menos del <strong>{$a->percentage}%</strong> de los estudiantes deben haber completado la actividad <strong>{$a->name}</strong>';

$string['privacy:metadata'] = 'El plugin de restricción por porcentaje de finalización no almacena ningún dato personal.';
