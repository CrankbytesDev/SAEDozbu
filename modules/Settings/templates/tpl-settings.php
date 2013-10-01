<section class="sidebar left">
    <form action="" class="custom" method="post" id="settingsform">
        <div class="row">
            <div class="large-12 columns">
                <h5>Name, Vorname</h5>
                <input type="text" name="name"/>
                <h5>Straße</h5>
                <input type="text" name="street"/>
                <h5>PLZ</h5>
                <input type="text" name="postcode"/>
                <h5>Ort</h5>
                <input type="text" name="city"/>
                <h5>&euro; / h</h5>
                <input type="text" name="mph"/>
                <h5>BA</h5>
                <select name="BA">
                    <option value="false">...</option>
                    <option value="ja">Ja</option>
                    <option value="nein">Nein</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input type="submit" class="large-12 button success column" name="lecturerSubmit"
                       value="Aktualisieren"/>
            </div>
        </div>
    </form>
</section>
<section class="inputarea">
    <table>
        <tr>
            <td><a href="" class="deleteLabel">löschen</a></td>
            <td>Nachname, Vorname</td>
            <td>Straße, Nr.</td>
            <td>PLZ</td>
            <td>Ort</td>
            <td>&euro; / h</td>
            <td>BA</td>
        </tr>
        <span class="viewport">
            <?php foreach ($this->siteContent->instructors as $k => $v) {
                print ('<tr>
                                <td><a href="' . BASE_URL . '?p=settings&amp;delete=' . $v['id'] . '" class="delete">X</a></td>
                                <td><input type="hidden" value="' . $v['id'] . '" form="settingsform" name="update_id_' . $v['id'] . '" />
                                <input type="text" value="' . $v['name'] . '" form="settingsform" name="update_name_' . $v['id'] . '" /></td>
                                <td><input type="text" value="' . $v['street'] . '" form="settingsform" name="update_street_' . $v['id'] . '" /></td>
                                <td><input type="text" value="' . $v['postcode'] . '" form="settingsform" name="update_postcode_' . $v['id'] . '" /></td>
                                <td><input type="text" value="' . $v['city'] . '" form="settingsform" name="update_city_' . $v['id'] . '" /></td>
                                <td><input type="text" value="' . $v['mph'] . '" form="settingsform" name="update_mph_' . $v['id'] . '" /></td>
                                <td><input type="text" value="' . $v['ba'] . '" form="settingsform" name="update_ba_' . $v['id'] . '" /></td>
                         </tr>
                    ');
            }
            ?>
        </span>
    </table>

</section>
