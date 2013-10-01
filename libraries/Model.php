<?php
/* GETTER UND SETTER */
class Model
{

    public function __construct()
    {
        $this->database = new Database();
        $this->db = $this->database->getInstance();
        $this->request = array_merge($_GET, $_POST);
    }

    public function generatePDFIndex(){
        $data = $this->getLecturer();
        // TODO greift sobald eine pdf generiert wurde. Der Counter wird hochgesetzt und bei einem neuem Tag resettet
        foreach($data as $k => $v){
            if($v['id'] == $this->request['lecturerSelect']){
                if($v['date'] != date("Y-m-d")){
                    $index = 1;
                    $this->upDate();
                }elseif(isset($this->request['correct'])){
                    $index = $v['counter'];
                }
                elseif($v['date'] == date("Y-m-d")){
                    $index = $v['counter'] += 1;
                }
                return $index;
            }
        }
    }


    public function getValidUser()
    {
        $sql = 'SELECT * FROM users WHERE name = :username AND password = :password';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':username' => $this->request['username'],
                ':password' => md5($this->request['password'])
            )
        );
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getLectures()
    {
        $sql = 'SELECT * FROM lectures';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getLecturer()
    {
        $sql = 'SELECT * FROM lecturers ORDER BY name ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getLecturerForPDF()
    {
        $sql = 'SELECT * FROM lecturers WHERE id = :id ORDER BY name ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':id' => $this->request['lecturerSelect']
            )
        );
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getLecturesForPDF()
    {
        $sql = 'SELECT b.*, a.mph, a.ba FROM lecturers a,  lectures b WHERE a.name = b.teacher AND a.id = :id ORDER BY name ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':id' => $this->request['lecturerSelect']
            )
        );
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    public function getMeAPDFPost(){
        $_POST['pdfDataPerson'] = $this->getLecturerForPDF();
        $_POST['pdfDataLectures'] = $this->getLecturesForPDF();
        $_POST['pdfDataPerson']['0']['name'] = explode(',', $_POST['pdfDataPerson'][0]['name']);
    }

    public function getLectureOfLecturer()
    {
        $sql = 'SELECT * FROM  lecturers a,  lectures b WHERE a.name = b.teacher AND a.id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':id' => $this->request['lecturerSelect']
            )
        );
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function getDataForUpdateFromBooking()
    {
        $sql = 'SELECT b.id_b, a.* FROM lectures b, lecturers a';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function csvToArray($path)
    {
        $file = fopen($path, 'r');
        $csv = array();
        while (($line = fgetcsv($file, 5000)) !== FALSE) {
            $csv[] = $line;
        }
        fclose($file);
        return $csv;
    }

    public function csvToDatabase($csv)
    {
        $sql = 'INSERT INTO lectures
                    (course, subject, class, chapter, teacher, location, date, time, duration, content, att_type, material)
                    VALUES
                    (:course, :subject, :class, :chapter, :teacher, :location, :date, :time, :duration, :content, :att_type, :material)
                    ON DUPLICATE KEY UPDATE
                    course = :course, subject = :subject, class = :class, chapter = :chapter, teacher = :teacher, location = :location,
                    date = :date, time = :time, duration = :duration, content = :content, att_type = :att_type, material = :material';
        $stmt = $this->db->prepare($sql);
        foreach ($csv as $k => $v) {
            if ($v['0'] != 'Course' && $v['1'] != 'Subject') {
                $stmt->execute(
                    array(
                        ':course'   => $v['0'],
                        ':subject'  => $v['1'],
                        ':class'    => $v['2'],
                        ':chapter'  => $v['3'],
                        ':teacher'  => $v['4'],
                        ':location' => $v['5'],
                        ':date'     => $v['6'],
                        ':time'     => $v['7'],
                        ':duration' => $v['8'],
                        ':content'  => $v['9'],
                        ':att_type' => $v['10'],
                        ':material' => $v['11']
                    )
                );
            }
        }
    }

    public function setLecturersFromXMLToDb($source)
    {
        foreach ($source->Dozentendetails as $k => $v) {
            $sql = 'INSERT INTO lecturers
                    (name, street, postcode, city, ba, mph, date)
                    VALUES
                    (:name, :street, :postcode, :city, :ba, :mph, :date)
                    ON DUPLICATE KEY UPDATE
                    name = :name, street = :street, postcode = :postcode, city = :city, ba = :ba, mph = :mph, date = :date';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                array(
                    ':name'     => $v->Name,
                    ':street'   => $v->Strasse,
                    ':postcode' => $v->PLZ,
                    ':city'     => $v->Ort,
                    ':ba'       => $v->BA,
                    ':mph'      => $v->Stundenlohn,
                    ':date'     => date("Y-m-d")
                )
            );
        }

    }

    public function addNewLecturer()
    {
        $sql = 'INSERT INTO lecturers
                    (name, street, postcode, city, ba, mph)
                    VALUES
                    (:name, :street, :postcode, :city, :ba, :mph)
                    ON DUPLICATE KEY UPDATE
                    name = :name, street = :street, postcode = :postcode, city = :city, ba = :ba, mph = :mph, date = :date';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':name'     => $this->request['name'],
                ':street'   => $this->request['street'],
                ':postcode' => $this->request['postcode'],
                ':city'     => $this->request['city'],
                ':ba'       => $this->request['BA'],
                ':mph'      => $this->request['mph'],
                ':date'     => date("Y-m-d")
            )
        );
    }


    public function updateIndex($param){
        $sql = 'UPDATE lecturers SET counter = :counter WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':counter' => $this->generatePDFIndex(),
                ':id' => $param
            )
        );

    }

    public function upDate(){
        $sql = 'UPDATE lecturers SET date = :date';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':date' => date("Y-m-d")
            )
        );
    }

    public function updateLecturers()
    {
        $data = $this->getLecturer();
        $sql = 'UPDATE lecturers SET name = :name, street = :street, postcode = :postcode, city = :city, ba = :ba, mph = :mph, date = :date WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->execute(
                array(
                    ':id'       => $v['id'],
                    ':name'     => $this->request['update_name' . '_' . $v['id']],
                    ':street'   => $this->request['update_street' . '_' . $v['id']],
                    ':postcode' => $this->request['update_postcode' . '_' . $v['id']],
                    ':city'     => $this->request['update_city' . '_' . $v['id']],
                    ':ba'       => $this->request['update_ba' . '_' . $v['id']],
                    ':mph'      => $this->request['update_mph' . '_' . $v['id']],
                    ':date'     => date("Y-m-d")
        )
            );
        }
    }

    public function updateLectures()
    {
        $data = $this->getLectures();
        $sql = 'UPDATE lectures SET course = :course, subject = :subject, class = :class, chapter = :chapter, teacher = :teacher, location = :location,
                    date = :date, time = :time, duration = :duration, content = :content, att_type = :att_type, material = :material WHERE id_b = :id';
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->execute(
                array(
                    ':id'       => $v['id_b'],
                    ':course'   => $this->request['update_course' . '_' . $v['id_b']],
                    ':subject'  => $this->request['update_subject' . '_' . $v['id_b']],
                    ':class'    => $this->request['update_class' . '_' . $v['id_b']],
                    ':chapter'  => $this->request['update_chapter' . '_' . $v['id_b']],
                    ':teacher'  => $this->request['update_teacher' . '_' . $v['id_b']],
                    ':location' => $this->request['update_location' . '_' . $v['id_b']],
                    ':date'     => $this->request['update_date' . '_' . $v['id_b']],
                    ':time'     => $this->request['update_time' . '_' . $v['id_b']],
                    ':duration' => $this->request['update_duration' . '_' . $v['id_b']],
                    ':content'  => $this->request['update_content' . '_' . $v['id_b']],
                    ':att_type' => $this->request['update_att_type' . '_' . $v['id_b']],
                    ':material' => $this->request['update_material' . '_' . $v['id_b']],
                )
            );
        }
    }

    public function updateLecturesFromBooking()
    {
        $data = $this->getDataForUpdateFromBooking();
        $adress = explode(',', str_replace('&#10;', '',$this->request['update_adress']));
        $sql = 'UPDATE lectures SET course = :course, subject = :subject, chapter = :chapter, date = :date, time = :time, duration = :duration WHERE id_b = :id';
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            if ($this->request['id_' . $v['id_b']] == $v['id_b']) {
                $stmt->execute(
                    array(
                        ':id'       => $this->request['id_' . $v['id_b']],
                        ':course'   => $this->request['update_course_' . $v['id_b']],
                        ':subject'  => $this->request['update_subject_' . $v['id_b']],
                        ':chapter'  => $this->request['update_chapter_' . $v['id_b']],
                        ':date'     => $this->request['update_date_' . $v['id_b']],
                        ':time'     => $this->request['update_time_' . $v['id_b']],
                        ':duration' => $this->request['update_duration_' . $v['id_b']],
                    )
                );
            }
        }
        $sql = 'UPDATE lecturers SET street = :street, postcode = :postcode, city = :city WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':id' => $this->request['lecturerSelect'],
                ':street' => trim($adress['0']),
                ':postcode' => trim($adress['1']),
                ':city' => trim($adress['2'])
            )
        );

    }

    public function deleteLecturer($deleteParam)
    {
        $sql = 'DELETE FROM lecturers WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':id' => $deleteParam
            )
        );
    }

    public function deleteLecture($deleteParam)
    {
        $sql = 'DELETE FROM lectures WHERE id_b = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(
            array(
                ':id' => $deleteParam
            )
        );
    }

    public function truncateTable($param)
    {
        $sql = 'TRUNCATE ' . $param . '';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

}