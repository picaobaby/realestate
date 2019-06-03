<?php

class BasisDataForm extends CFormModel
{

    public $pd_title;
    public $pd_cities;
    public $loc_country;
    public $loc_region;
    public $loc_city;
    public $city_id;
    public $i_enable_slider_and_pd;
    public $i_enable_best_ads;
    public $i_enable_feature;
    public $i_enable_contact;
    public $i_enable_last_news;
    public $popular_dest_user_set;

    public $i_vk;
    public $i_facebook;
    public $i_twitter;

    public $i_lat;
    public $i_lng;
    public $i_zoom;

    public function rules()
    {
        return array(
            array('i_enable_slider_and_pd, i_enable_best_ads, i_enable_feature, i_enable_contact, i_enable_last_news, popular_dest_user_set', 'safe'),
            array('i_facebook, i_vk, i_twitter', 'safe'),
            array('i_lat, i_lng, i_zoom', 'numerical'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'pd_title' => tc('Title'),
            'pd_cities' => tt('Cities'),
            'i_enable_slider_and_pd' => tt('Display widget "slider" and "popular directions"'),
            'i_enable_best_ads' => tt('Display widget "Best listings"'),
            'i_enable_feature' => tt('Display widget "Feature"'),
            'i_enable_contact' => tt('Display widget "Contact"'),
            'i_enable_last_news' => tt('Display widget "Last news"'),
            'popular_dest_user_set' => tt('Show specified cities'),

            'i_vk' => tt('Link to group in vk'),
            'i_facebook' => tt('Link to group in facebook'),
            'i_twitter' => tt('Link to group in twitter'),

            'i_lat' => tt('Coordinates of the marker contacts, latitude'),
            'i_lng' => tt('Coordinates of the marker contacts, longitude'),
            'i_zoom' => tt('Zoom for contact map'),
        );
    }

    public function save(Themes $model)
    {
        foreach ($this->attributes as $attribute => $value) {
            if (isset($this->{$attribute}) && $this->{$attribute} !== null) {
                $model->setInJson($attribute, $value);
            }
        }
        return $model->saveJson();
    }
}
