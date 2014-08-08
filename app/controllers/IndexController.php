<?php

class IndexController extends BaseController {

	//////////////
	//Index Page//
	//////////////

	public function getIndex() {

		return View::make('index');

	}

}
