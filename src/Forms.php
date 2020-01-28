<?php

namespace FastForms;

Class Forms{

    static protected $form;
    static protected $form_end = "</form>";

    protected function parse(array $tags, array $form_data){
        $inputs = [];
        $inputs[0] = [self::setForm($form_data)];
        $keys = array_keys($tags);
        $counter = 0;

        foreach($tags as $tag => $value){
            if(method_exists(self::class, "$tag")){
                $inputs[] = self::$tag($value);
            }
            else{
                $inputs[] = self::convert_to_tags($value);
            }
            $counter++;
        }

        $inputs[] = self::$form_end;
        return self::flatten_array($inputs);
    }

    protected function convert_to_tags(array $views){
        $inputs = [];
        $keys = array_keys($views);
        $tag = $views['tag'];
        $text = isset($views['text']) ? $views['text'] : '';
        $counter = 0;
        $end = "";
        $html = "";
        $start = false;

        if($tag != "input"){
            $end = "</$tag>";
        }

        foreach($views as $data => $value){
            if($data == "tag"){
                continue;
            }
            if($counter > 0){
                $start = true;
            }
            if(!$start){
                $html .= "<".$tag." ".$data.'="'.$value.'" ';
            }
            else{
                $html .= $data.'="'.$value.'"';
            }
            $counter++;
        }

        $inputs[] = $html.">$text$end";
        return $inputs;
    }


    public static function flatten_array($array){
        $flattened_array = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
        foreach($iterator as $value){
            $flattened_array[] = $value;
        }
        return $flattened_array;
    }

    protected function submit(array $attributes = null){
        $name = isset($attributes['name']) ? $attributes['name'] : 'submit';
        $value = isset($attributes['value']) ? "value=\"".$attributes['value']."\"" : '';

        if(isset($attributes['classes'])){
            $classes = implode(' ', $attributes['classes']);
            return '<input type="submit" name="'.$name.'" class="'.$classes.'" '.$value.'>';
        }

        return '<input type="submit" name="'.$name.'" '.$value.'>';
    }

    protected function username(array $attributes = null){
        $name = !isset($attributes['name']) ? 'username' : $attributes['name'];

        if(isset($attributes['classes'])){
            $classes = implode(' ', $attributes['classes']);
            return '<input type="text" name="'.$name.'" class="'.$classes.'">';
        }

        return '<input type="text" name="'.$name.'">';
    }

    protected function setForm($data){
        return self::$form = '<form method="'.$data['method'].'" action="'.$data['action'].'">';
    }
}

?>