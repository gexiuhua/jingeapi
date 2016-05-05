<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    public function actionIndex()
    {
        return "Hello World";
    }

    public function actionError(){
        return "Hello Bug";
    }
}
