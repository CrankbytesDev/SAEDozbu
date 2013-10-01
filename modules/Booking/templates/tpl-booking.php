<section class="sidebar left">
    <form action="" class="custom" method="post" id="bookingform">
        <div class="row">
            <div class="large-12 column">
                <h5>Dozent</h5>
                <select class="dropdown custom large" name="lecturerSelect">
                    <option value="false">Wählen</option>
                    <?php foreach ($this->siteContent->lecturer as $k => $v) {
                        if($_GET['lecturerSelect'] == $v['id']){
                            $selected = 'selected="selected"';
                            $street = $v['street'].',';
                            $postcode .= $v['postcode'].',';
                            $city .= $v['city'];
                            $precounter = $v['name'].'_'.$v['date'].'_';
                            $index = $v['counter'];
                        }else{
                            $selected = '';
                        }
                        print ('
                        <option '.$selected.' value="'.$v['id'].'">' . $v['name'] . '</option>
                    ');
                    }?>
                </select>
                <input type="submit" class="large-12 button success" name="lecturerSubmit" value="Dozenten laden"/>
            </div>
        </div>
        <div class="row">
            <div class="large-12 column">
                <h5>Adresse</h5>
                <textarea id="adress" name="update_adress" class="large-12"><?php echo($street.'&#10;'.$postcode.'&#10;'.$city); ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns">
                <h5>Auftragsnummer</h5>
                <input type="text" value="<?php echo $index ?>" name=""/>
            </div>
            <div class="large-6 columns">
                <h5>Korrektur</h5>
                <input type="checkbox" name="correct"/>
            </div>
            <div class="clear"></div>
            <?php
                if(isset($_GET['lecturerSelect'])){
                    echo '<p class="large-12 columns">Output:<br />'.str_replace(', ', '_',$precounter.$index).'.pdf</p>';
                }
            ?>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input type="submit" class="large-6 button column" name="pdfPreview" value="PDF Vorschau"/>
                <input type="submit" class="large-6 button column" name="pdfSubmit" value="PDF Erzeugen"/>
                <input type="submit" class="large-12 button success" name="bookingSubmit" value="Änderungen Aktualisieren"/>
            </div>
        </div>
    </form>
</section>
<section class="inputarea">
    <table>
        <tr>
            <td><a href="" class="deleteLabel">löschen</a></td>
            <td>Datum</td>
            <td>Thema</td>
            <td>Kurs</td>
            <td>Block</td>
            <td>Start</td>
            <td>Dauer</td>
        </tr>
        <span class="viewport">

            <?php
            if(!isset($_GET['lecturerSelect'])){
                echo '<p style="text-align: center; color: red; font-weight: bold;">kein Dozent ausgewählt</p>';
            }else{
                foreach($this->siteContent->lecturesOfLecturers as $k => $v){
                    print('
                        <tr>
                            <td><a href="' . BASE_URL . '?p=booking&amp;delete=' . $v['id_b'] . '" class="delete">X</a>
                            <input type="hidden" value="'.$v['id_b'].'" form="bookingform" name="id_'.$v['id_b'].'" />
                            <input type="hidden" value="'.str_replace(', ', '_',$precounter.$index).'.pdf" form="bookingform" name="filename" /></td>
                            <td><input type="text" value="'.$v['date'].'" form="bookingform" name="update_date_'.$v['id_b'].'" /></td>
                            <td><input type="text" value="'.$v['subject'].'" form="bookingform" name="update_subject_'.$v['id_b'].'" /></td>
                            <td><input type="text" value="'.$v['course'].'" form="bookingform" name="update_course_'.$v['id_b'].'" /></td>
                            <td><input type="text" value="'.$v['chapter'].'" form="bookingform" name="update_chapter_'.$v['id_b'].'" /></td>
                            <td><input type="text" value="'.$v['time'].'" form="bookingform" name="update_time_'.$v['id_b'].'" /></td>
                            <td><input type="text" value="'.$v['duration'].'" form="bookingform" name="update_duration_'.$v['id_b'].'" /></td>
                        </tr>');
                }
            }
            ?>
        </span>
    </table>

</section>
