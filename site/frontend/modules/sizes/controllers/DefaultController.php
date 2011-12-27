<?php

class DefaultController extends Controller
{
	public function actionWomenUnderwear()
	{
		$this->render('women_underwear');
	}

    public function actionWomenShoes()
    {
        $this->render('women_shoes');
    }

    public function actionChildrenClothes()
    {
        $this->render('children_clothes');
    }
}