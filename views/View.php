<?php
session_start();
class View
{
	private $_file;
	private $_t;
	private $_pseudo;
	private $_errorMsg;

	public function __construct($action)
	{
		$this->_file = 'views/view'.$action.'.php';
	}

	// generate and display the view
	public function generate($data)
	{
		// specific part of the view
		$content = $this->generateFile($this->_file, $data);

		// template
		$view = $this->generateFile('views/template.php', array('t' => $this->_t, 'content' => $content, 'pseudo' => $this->_pseudo, 'errorMsg' => $this->_errorMsg));

		echo $view;
	}

	// generate a view file and return the result produced
	private function generateFile($file, $data)
	{
		if (file_exists($file))
        {
			extract($data);

			// start buffering
			ob_start();

			// include the view file
			require $file;

			// get current buffer contents and delete current output buffer
			return ob_get_clean();
		}
		else
            throw new Exception('View: File '.$file.' not found !');
	}
}
