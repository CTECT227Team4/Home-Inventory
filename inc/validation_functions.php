<?php

    //stores errors
    $errors = array();

    function fieldname_as_text($fieldname) {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    } //end fieldname_as_text()

    // * presence
    function has_presence($value) {
        return isset($value) && $value !== "";
    } //end has_presence()

    function validate_presences($required_fields) {
        global $errors;
        foreach($required_fields as $field) {
            $value = trim($_POST[$field]);
            if (!has_presence($value)) {
                $errors[$field] = fieldname_as_text($field) . " can't be blank";
            }
        }
        return $errors;
    } //end validate_presences()

    // * string length
    //$value = "";
    function has_max_length($value, $max) {
        return strlen($value) <= $max;
    } //end has_max_length()

    function validate_max_lengths($fields_with_max_lengths) {
        global $errors;
        foreach($fields_with_max_lengths as $field => $max) {
            $value = trim($_POST[$field]);
            if (!has_max_length($value,$max)) {
                $errors[$field] = fieldname_as_text($field) . " is too long";
            }
        }
    } //end validate_max_lengths()

    // * inclusion in a set
    //doesn't fail because 1 is submitted as "1"
    function has_inclusion_in($value,$set) {
        return in_array($value, set);
    } //end has_inclusion_in()

?>