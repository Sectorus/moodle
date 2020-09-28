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
 * Adds arrangement tools inside of the edit form of choice modules.
 *
 * @module     choice_arrange/choice_arrange
 * @package    choice_arrange
 * @copyright  2020 Stephan Lorbek
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

var options = [];

function moveDown(pos) {
  if ((pos + 1) < options.length - 1) {
    var val = document.getElementById("id_option_" + pos);
    var increment = pos + 1;
    var val_below = document.getElementById("id_option_" + parseInt(increment));
    var tmp = val.value;
    val.value = val_below.value;
    val_below.value = tmp;
  }
}

function moveUp(pos) {
  if (pos > 0) {
    var val = document.getElementById("id_option_" + pos);
    var decrement = pos - 1;
    var val_above = document.getElementById("id_option_" + parseInt(decrement));
    var tmp = val.value;
    val.value = val_above.value;
    val_above.value = tmp;
  }
}

function sortValues() {
  var values = [];
  for (var i = 0; i < (options.length - 1); i++) {
    var val = document.getElementById("id_option_" + i).value;
    if (val){
      values.push(val);
    }
  }
  values.sort();
  values = values.filter(a => a !== '');
  for (var i = 0; i < (options.length - 1); i++) {
    if (values[i]){
      document.getElementById("id_option_" + i).value = values[i];
    }
  }
}

define(['jquery'], function($) {
  function addPositionSelectors(element, iterator) {
    if (!element.id.includes('add')) {
      var up_button = document.createElement("input");
      up_button.type = "button";
      up_button.classList.add("btn");
      up_button.classList.add("btn-primary");
      up_button.style.padding = "auto";
      up_button.value = "▲";
      up_button.setAttribute("onclick", "moveUp(" + iterator + ");");

      var down_button = document.createElement("input");
      down_button.type = "button";
      down_button.classList.add("btn");
      down_button.classList.add("btn-primary");
      down_button.style.padding = "auto";
      down_button.value = "▼";
      down_button.setAttribute("onclick", "moveDown(" + iterator + ");");

      element.getElementsByClassName('col-md-9')[0].appendChild(up_button);
      element.getElementsByClassName('col-md-9')[0].appendChild(down_button);
    }
  }

  return {
    init: function() {
      options = document.querySelectorAll('[id ^= "fitem_id_option_"]');
      Array.prototype.forEach.call(options, addPositionSelectors);
      var sort_button = document.createElement("input");
      sort_button.type = "button";
      sort_button.classList.add("btn");
      sort_button.classList.add("btn-primary");
      sort_button.style.padding = "auto";
      sort_button.value = "Sortieren";
      sort_button.setAttribute("onclick", "sortValues();");

      var div = document.createElement("div");
      div.style.width = "10px";
      document.getElementById("fitem_id_option_add_fields").getElementsByClassName('col-md-9')[0].appendChild(div);
      document.getElementById("fitem_id_option_add_fields").getElementsByClassName('col-md-9')[0].appendChild(sort_button);
    }
  };
});
