<?php
    
    require_once 'dao.php';

    function getALLModules()
    {
        $sql = "SELECT * FROM modules";
        return getDatas($sql, null);
    }

    function getALLStudents()
    {
        $sql = "SELECT * FROM etudiants";
        return getDatas($sql, null);
    }

    function getAllUsers(){
        $sql = "SELECT * FROM users";
        return getDatas($sql, null);
    }

    function getNotStudent($studentId)
    {   
        $sql = "SELECT * FROM notes, modules WHERE notes.module_id = modules.id and notes.etudiant_cin = '{$studentId}'";
        return getDatas($sql, null);
    }

    function deleteStudents($studentId)
    {
        try {
            $sql = "DELETE FROM `notes` WHERE etudiant_cin = ('{$studentId}')";
            setData($sql, null);

            $sql = "DELETE FROM `etudiants` WHERE cin = '{$studentId}'";
            setData($sql, null);

            return true;
        } catch (Exception $e) {
            return null;
        }
    }

    function updateStudents($data)
    {
        $cin = $data['cin'];
        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $date_naissance = $data['date_naissance'];
        $sql = "UPDATE `etudiants` SET `nom`='{$nom}', `prenom` = '{$prenom}',`date_naissance`='{$date_naissance}' WHERE `cin`='{$cin}'";
        return setData($sql, null);
    }

    function routeTo($route)
    {
        return ROOT . $route;   
    }

    function getUserByEmailAndPassword($email, $password) {
        $sql = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}' ";
        return getDatas($sql, null);
    }

    function setUser($data){
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $sql = "INSERT INTO users(name, email, password) VALUES ('{$name}', '{$email}', '{$password}')";
        return setData($sql, null);
    }

    function updateUser($data) {
        $id = $data["id"];
        $name = $data["name"];
        $email = $data["email"];
        $password = $data["password"];
        $created_at = $data["created_at"];
        $is_admin = $data["is_admin"];

        $sql = "UPDATE `users` SET `name`='{$name}',`email`='{$email}', `password` = '{$password}',`created_at`='{$created_at}',`is_admin`='{$is_admin}' WHERE `id`='{$id}'";
        return setData($sql, null);
    }

    function deleteUser($id){
        $sql = "DELETE FROM users WHERE id = '{$id}'";
        return setData($sql, null);
    }

    function updateCourse($data){
        $id = $data['id'];
        $name = $data['name'];
        $sql = "UPDATE `modules` SET `nom`='{$name}' WHERE `id`='{$id}'";
        return setData($sql, null);
    }

    function deleteCourse($id){
        try {
            $sql = "DELETE FROM `modules` WHERE id = '{$id}'";
            setData($sql, null);

            $sql = "DELETE FROM `notes` WHERE module_id = '{$id}'";
            setData($sql, null);

            return true;
        } catch (Exception $e) {
            return null;
        }
    }

    function createUser($data){
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $is_admin = $data['is_admin'];
        $sql = "INSERT INTO users(name, email, password, is_admin) VALUES ('{$name}', '{$email}', '{$password}', '{$is_admin}')";
        return setData($sql, null);
    }

    function createCourse($name){
        try {
            $sql = "INSERT INTO `modules`(nom) VALUES ('{$name}')";
            setData($sql, null);

            $sql = "SELECT `id` FROM `modules` WHERE nom = '{$name}'";
            $moduleId = getDatas($sql, null);
            $moduleId = $moduleId[0]['id'];

            $sql = "SELECT DISTINCT `etudiant_cin` FROM `notes`";
            $studentsId = getDatas($sql, null);

            foreach ($studentsId as $id) {
                $id = $id["etudiant_cin"];
                $sql = "INSERT INTO `notes`(`module_id`, `etudiant_cin`, `note`) VALUES ('{$moduleId}','{$id}',0)";
                setData($sql, null);
            }
            return true;
        } catch (Exception $e) {
            return null;
        }
    }

    function setNote($data){
        $student_id = $data["student_id"];
        $id_course = $data['id_course'];
        $Note = $data['Note'];
        $sql = "UPDATE `notes` SET `note`='{$Note}' WHERE `etudiant_cin`='{$student_id}' AND `module_id` = '{$id_course}'";
        return setData($sql, null);
    }
