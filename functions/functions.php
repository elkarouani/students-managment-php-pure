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

    function getNotStudent($studentId)
    {
        $sql = "SELECT * FROM notes, modules WHERE notes.module_id = modules.id and notes.etudiant_cin = '{$studentId}'";
        return getDatas($sql, null);
    }

    function deleteStudents($studentId)
    {
        $sql = "DELETE FROM etudiants WHERE cin = '{$studentId}'";
        return setData($sql, null);
    }