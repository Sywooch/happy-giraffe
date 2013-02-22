<?php
/**
 * Author: alexk984
 * Date: 13.12.12
 */
Yii::import('site.frontend.modules.cook.models.*');
Yii::import('site.frontend.modules.cook.components.*');
Yii::import('site.frontend.modules.geo.models.*');

class CookCommand extends CConsoleCommand
{
    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->order = 'id desc';

        $models = array(0);
        while (!empty($models)) {
            $models = CookRecipe::model()->findAll($criteria);
            foreach ($models as $recipe)
                if ($recipe->section == 1 && !empty($recipe->tags)) {
                    $recipe->tags = array();
                    Yii::app()->db->createCommand()->delete('cook__recipe_recipes_tags',
                        'recipe_id = :recipe_id',
                        array(':recipe_id' => $recipe->id));
                }

            $criteria->offset += 100;
        }

    }

    public function actionFeed()
    {
        $recipes = CookRecipe::model()->with('cuisine', 'author', 'ingredients', 'ingredients.ingredient', 'ingredients.unit')->findAll(array(
            'order' => 'created DESC',
            'condition' => 't.id != 16589',
            'limit' => 1,
        ));

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><entities/>');

        foreach ($recipes as $r) {
            if (empty($r->ingredients))
                continue;

            $recipe = $xml->addChild('recipe');
            $recipe->addChild('name', $r->title);
            $recipe->addChild('url', $r->getUrl(false, true));
            $recipe->addChild('type', $r->typeString);
            if ($r->cuisine !== null) {
                $recipe->addChild('cuisine-type', $r->cuisine->title . ' кухня');
            }
            $recipe->addChild('author', $r->author->fullName);

            foreach ($r->ingredients as $i) {
                $ingredient = $recipe->addChild('ingredient');
                switch ($i->unit->type) {
                    case 'qty':
                        $ingredient->addChild('name', HDate::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value));
                        $ingredient->addChild('quantity', $i->display_value);
                        break;
                    case 'undefined':
                        $ingredient->addChild('name', $i->title . ' ' . $i->unit->title);
                        break;
                    default:
                        $ingredient->addChild('name', $i->title);
                        $ingredient->addChild('type', HDate::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value));
                        $ingredient->addChild('value', $i->display_value);
                }
            }

            foreach ($r->nutritionals['total']['nutritionals'] as $id => $value) {
                $nutrition = $recipe->addChild('nutrition');
                $nutrition->addChild('type', CookNutritional::model()->findByPk($id)->title);
                $nutrition->addChild('value', $value);
            }

            $recipe->addChild('instructions', html_entity_decode(strip_tags($r->text), ENT_COMPAT, 'utf-8'));
            $recipe->addChild('calorie', $r->nutritionals['total']['nutritionals'][1] . ' ккал');
            $recipe->addChild('weight', $r->nutritionals['total']['weight'] . ' г');
            if ($r->mainPhoto !== null) {
                $recipe->addChild('final-photo', $r->mainPhoto->getPreviewUrl(441, null, Image::WIDTH));
            }
            if ($r->servings !== null) {
                $recipe->addChild('yield', $r->servings);
            }
            if ($r->cooking_duration !== null) {
                $recipe->addChild('duration', $r->cookingDurationString);
            }
        }

        $path = Yii::getPathOfAlias('site.common.data') . DIRECTORY_SEPARATOR . 'recipeFeed.xml';
        file_put_contents($path, $xml->asXML());
    }
}