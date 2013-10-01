<section class="sidebar left">
    <form action="" class="custom" method="post" id="casform">
        <div class="row">
            <div class="large-12 columns">
                <a href="<?php BASE_URL ?>?p=casview&amp;deleteAll" class="button alert large-12 column">Tabelle
                    Leeren</a>
                <input type="submit" class="large-12 button success column" name="csvSubmit" value="Aktualisieren"/>
            </div>
        </div>
    </form>
</section>
<section class="inputarea">
    <table>
        <tr>
            <td><a href="" class="deleteLabel">löschen</a></td>
            <td>course</td>
            <td>subject</td>
            <td>class</td>
            <td>chapter</td>
            <td>teacher</td>
            <td>location</td>
            <td>date</td>
            <td>time</td>
            <td>duration</td>
            <td>content</td>
            <td>att. type</td>
            <td>material</td>
        </tr>
        <span class="viewport">
            <?php foreach ($this->siteContent->csvData as $k => $v) {
                print('
                <tr>
                    <td><a href="' . BASE_URL . '?p=casview&amp;delete=' . $v['id_b'] . '" class="delete">X</a></td>
                    <td><input type="text" value="' . $v['course'] . '" form="casform" name="update_course_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['subject'] . '" form="casform" name="update_subject_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['class'] . '" form="casform" name="update_class_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['chapter'] . '" form="casform" name="update_chapter_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['teacher'] . '" form="casform" name="update_teacher_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['location'] . '" form="casform" name="update_location_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['date'] . '" form="casform" name="update_date_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['time'] . '" form="casform" name="update_time_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['duration'] . '" form="casform" name="update_duration_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['content'] . '" form="casform" name="update_content_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['att_type'] . '" form="casform" name="update_att_type_' . $v['id_b'] . '" /></td>
                    <td><input type="text" value="' . $v['material'] . '" form="casform" name="update_material_' . $v['id_b'] . '" /></td>
                </tr>');
            }
            ?>
        </span>
    </table>

</section>
