<?php

class Controller {

	private $request = null;	// combination of $_GET and $_POST
	private $view = null;		// $view contains the 'outer' view

	private $template = '';		// to choose the outward appearance

	/**
	 * Constructor to create a new Controller with the parameters 
	 * @param $request, array with $_GET and $_POST from index.php
	 */
	public function __construct($request) {
		$this->request = $request;
		$this->view = new View();
		$this->template = !empty($request['view']) ? $request['view'] : 'default';
		// if no view is specified, use the default template
	}

	public function display() {
		$innerView = new View();
		switch($this->template) {
			case 'entry':
				$innerView->setTemplate('entry');
				$entryid = $this->request['id'];
				$entry = Model::getEntry($entryid);
				$innerView->assign('title', $entry['title']);
				$innerView->assign('content', $entry['content']);
				break;
			case 'default':
			default:
				$entries = Model::getEntries();
				$innerView->setTemplate('default');
				$innerView->assign('entries', $entries);
		}
		$this->view->setTemplate('main');
		$this->view->assign('blog_title', 'First Steps with Model View Controller!');
		$this->view->assign('blog_footer', '... this could be a footer!');
		$this->view->assign('blog_content', $innerView->loadTemplate());
		return $this->view->loadTemplate();
	}
}