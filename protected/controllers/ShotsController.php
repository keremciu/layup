<?php

class ShotsController extends Controller
{

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','view','like'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('new','update','share','shareit'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$ip = Yii::app()->request->getUserHostAddress();
		$record=Viewers::model()->findByAttributes(array('ip'=>$ip,'relevant_id'=>$id));

		// Check is it drafted
		if ($model->user->type != "Player") {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_URL, 'https://api.dribbble.com/players/'.$model->user->username);
			$user = curl_exec($curl);
			curl_close($curl);
			$user = json_decode($user);

			if (isset($user->drafted_by_player_id)) {
				// Update player type
				$getplayer = Users::model()->findByPk($model->user->id);
				$getplayer->drafted_by_player_id = $user->drafted_by_player_id;
				$getplayer->type = "Player";
				$getplayer->activate = 3;
				$getplayer->update();
				// Update drafted shots
				Shots::model()->updateAll(array('activate'=>3),'user_id="'.$model->user->id.'"');
			}
		}

		if($record===null) {
			$view = new Viewers;
			$view->relevant_id = $id;
			$view->ip = $ip;
			$view->user_agent = Yii::app()->request->getUserAgent();
			$view->datetime = new CDbExpression('NOW()');
			if (!Yii::app()->user->isGuest){ 
				$view->user_id = Yii::app()->user->id;
			}
			if ($view->save()) {
				$model->views_count++;
				$model->update();
			}
		}

		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionLike() {
		$id = $_POST["id"];

		if (Yii::app()->user->isGuest) {
			$type = "Guest";
		} else {
			$type = Yii::app()->user->type;
		}
 
		if ($type == "Player") {
			$model = $this->loadModel($id);
			$user = Yii::app()->user->id;
			$record=Likes::model()->findByAttributes(array('user_id'=>$user,'shot_id'=>$id));

			if($record===null) {
				$likes = New Likes;
				$likes->user_id = $user;
				$likes->shot_id = $id;
				$likes->created_at = new CDbExpression('NOW()');
				if ($likes->save()) {
					$model->likes_count++;
					$model->update();
				} 
				// Like Saved
				echo "success";
			} else {
				// Already Liked
				echo "You already liked.";
			}

		} else {
			// Not Allowed
			echo "Only dribbblers can like shots.";
		}

	}

	public function actionNew()
	{
		$model=new Shots;

		$myshots = Shots::model()->findAll(array('condition' => 'user_id = :pid','params'=>array(':pid'=>Yii::app()->user->id)));
		$shots_count = count($myshots);

		if(isset($_POST['Shots']))
		{
			$model->attributes=$_POST['Shots'];
			$model->user_id = Yii::app()->user->id;

			$image=CUploadedFile::getInstance($model,'image');
			if ($image) {
				$ext = pathinfo($image, PATHINFO_EXTENSION);
				$model->getimage = $image;
				$model->image = date("Y").'-'.date("j").'-'.rand(0,9999999).'-'.rand(0,9999999).'.'.$ext;
				$root = Yii::getPathOfAlias('webroot').'/images/shots/';

				if($model->save()) {
					$image->saveAs($root.$model->image);
					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'shots_count'=>$shots_count,
		));
	}

	public function actionShare()
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_URL, 'https://api.dribbble.com/players/'.Yii::app()->user->username.'/shots/');
		$myshots = curl_exec($curl);
		curl_close($curl);
		$myshots = json_decode($myshots);

		$this->render('share',array(
			'myshots'=>$myshots->shots,
		));
	}

	public function actionShareIt()
	{
		if (isset($_POST)) {
			$object = $this->objectToArray($_POST);

			$model = New Shares;
			// Share data replaces new share entry fields
			$model->attributes = $object;

			$validation=Shares::model()->findByAttributes(array('shot_id'=>$model->shot_id));

			if (isset($validation)) {
				Shares::model()->findByPk($validation->id)->delete();
				echo "deleted";
			} else {
				if ($model->save()) {
					echo "success";
				}
			}
		}
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Shots']))
		{
			$model->attributes=$_POST['Shots'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Shots');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Shots('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Shots']))
			$model->attributes=$_GET['Shots'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Shots the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Shots::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Shots $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shots-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
