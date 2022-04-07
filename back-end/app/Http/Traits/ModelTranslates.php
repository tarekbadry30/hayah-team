<?php


namespace App\Http\Traits;


trait ModelTranslates
{
    //public $translatedAttributes=[];
    public function setTranslated($locales=[]){
        foreach ($locales as $locale)
            foreach ($this->translatedAttributes as $attribute) {
                $newAttribute = $attribute . "_" . $locale;
                $this->$newAttribute = $this->translate($locale)->$attribute;
            }
    }
}

