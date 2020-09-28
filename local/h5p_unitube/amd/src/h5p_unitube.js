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
 * Replaces manual video upload with UNITube
 *
 * @module     h5p_unitube/h5p_unitube
 * @package    h5p_unitube
 * @copyright  2020 Stephan Lorbek
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function Sleep(milliseconds) {
 return new Promise(resolve => setTimeout(resolve, milliseconds));
}

async function setHTML(h5p_frame) {
    var frameDoc = h5p_frame.contentWindow.document || h5p_frame.contentDocument;
    if (frameDoc.readyState == 'complete' || h5p_frame.contentWindow.document.getElementsByClassName('h5p-dialog-box').length > 0) {
      if(typeof frameDoc.getElementsByClassName('h5p-dialog-box')[0] !== 'undefined') {
            frameDoc.getElementsByClassName('h5p-dialog-box')[0]
                .innerHTML = "<h3>Unitube</h3><div class='h5p-file-drop-upload-inner'>" +
                "<img id='tube_banner' src='https://static.uni-graz.at/typo3conf/ext/unigraz/Resources/" +
                "Public/Icons/UniGraz/Header/universitaet_graz_logo_signet.svg'>" +
                "</div>";
            h5p_frame.contentWindow.document.getElementById('tube_banner').addEventListener('click', function() {
                alert("TODO");
                h5p_frame.contentWindow.document.getElementsByClassName('h5p-file-url h5peditor-text')[0].value = "direct.mp4";
            }, false);
            return;
       }
    }
    await Sleep(100);
    setHTML(h5p_frame);
}
define(['require', 'jquery'], function (require, $) {
  return {
    init: async function() {
        await Sleep(1000);
        $(document).ready(function (){
        var h5p_frame = document.getElementsByClassName('h5p-editor-iframe')[0];
        setHTML(h5p_frame);
      });
    }
  };
});
