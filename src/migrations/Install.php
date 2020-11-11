<?php

namespace ournameismud\ukcounties\migrations;

use Craft;
use craft\db\Migration;
use craft\commerce\Plugin as craftCommerce;
use craft\commerce\records\Country;
use craft\commerce\records\State;
/**
 * Install migration.
 */
class Install extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        // IF CC check
        if (class_exists('craft\commerce\Plugin')) {
            // Place installation code here...
            $countyData = file_get_contents( __DIR__ . '/../uk-counties.json');
            $states = (array)json_decode($countyData);

            /** @var ActiveRecord $countries */
            $countries = Country::find()->where(['in', 'iso', array_keys($states)])->all();
            $code2id = [];
            foreach ($countries as $record) {
                $code2id[$record->iso] = $record->id;
            }

            $rows = [];
            foreach ($states as $iso => $list) {
                $sortNumber = 1;
                foreach ($list as $abbr => $name) {
                    $rows[] = [$code2id[$iso], $abbr, $name, $sortNumber];
                    $sortNumber++;
                }
            }

            $this->batchInsert(State::tableName(), ['countryId', 'abbreviation', 'name', 'sortOrder'], $rows);
            // Craft::dd($countyData);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // Place uninstallation code here...

        // IF CC check
        if (class_exists('craft\commerce\Plugin')) {
            $countyData = file_get_contents( __DIR__ . '/../uk-counties.json');
            $states = (array)json_decode($countyData);

            /** @var ActiveRecord $countries */
            $countries = Country::find()->where(['in', 'iso', array_keys($states)])->all();
            foreach ($countries as $record) {
                $this->delete(State::tableName(),'countryId=' . $record->id);
            }
        }
    }
}
