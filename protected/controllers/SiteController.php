<?php

// Main controller
class SiteController extends Controller
{
	public function actions()
	{
		return array(
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionIndex()
	{
		// Return values from System function
		if (isset($_REQUEST["code"])) {
			// Post data for token
			$code = $_REQUEST["code"];
			$curl = curl_init();
			curl_setopt_array($curl, array(
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_URL => 'https://dribbble.com/oauth/token',
			    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			    CURLOPT_POST => 1,
			    CURLOPT_POSTFIELDS => array(
			        'client_id' => Yii::app()->params['client_id'],
			        'client_secret' =>  Yii::app()->params['client_secret'],
			        'code' => $code
			    )
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			curl_close($curl);

			// Get response
			if (isset($resp)) {
				// Decode response
				$decoded_resp = json_decode($resp);
				if (isset($decoded_resp->access_token)) {
					// Get user details with access token
					$token = $decoded_resp->access_token;
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($curl, CURLOPT_URL, 'https://api.dribbble.com/v1/user?access_token='.$token);
					$user = curl_exec($curl);
					$user = json_decode($user);
					$try = $this->objectToArray($user);
					curl_close($curl);
					$model = New Users;
					// Dribbble data replaces users table fields
					$model->attributes = $try;
					// Search users for choose action to register or login
					$validation = Users::model()->findAll(
						array('condition' => "name = :match", 'params' => array(':match' => $model->name), "order"=>"id DESC","limit"=>"1")
					);

					if ($validation) {
						// Login
						if($model->login($token)) {
							Yii::app()->user->setFlash('info', '<strong>Success!</strong> You signed in with dribbble.');
						}
					} else {
						// Register data
						$model->id = false;
						$model->player_id = $user->id;
						$model->links = serialize($model->links);
						$model->activate = 1;
						if ($model->save()) {
							Yii::app()->user->setFlash('info', '<strong>Success!</strong> We created your dribbbler account with your dribbble.');
							$this->redirect(Yii::app()->homeUrl);
						}
					}
				}
			}
		}

		// Get shots
		$shots = Shots::model()->findAll();

		$this->render('index',array('shots'=>$shots));
	}

	public function actionAbout() {
		$this->render('about');
	}

	public function actionSignin() {
		// Go dribbble for login
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'https://dribbble.com/oauth/authorize?client_id='.Yii::app()->params['client_id']);
		$redirect = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
		curl_close($curl);

		// Redirect to Index function with "code" value
		$this->redirect($redirect);
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}