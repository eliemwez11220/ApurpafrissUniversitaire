<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2018, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

    protected function secure (){

        if (! isset($this->session->role_ut)){

            redirect('auth/deconnexion');
        }
        elseif ($this->uri->segment(1, 0) !== $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut])->role_ut){

            $red = $this->Ci_apurpafriss_model->get_unique('utilisateurs', ['nom_ut' => $this->session->nom_ut])->role_ut;
            $this->session->set_userdata(['role_ut' => $red]);
            redirect($red);
        }
    }


    /**
     * la fonction qui initialise les données à envoyer sur une vue
     * @param $vue
     * @param array $data
     */
    protected function data ($vue, $data = []){

        $data["title1"] = $this->session->role_ut;
        $data['role_ut'] = $this->session->role_ut;
        $data['nom_comp'] = $this->session->nom_comp;

        $this->load->view('layout/entete', $data);
        $this->load->view($this->session->role_ut . '/' . $this->session->role_ut . '_entete');
        $this->load->view($this->session->role_ut . '/' . $vue);
        $this->load->view('layout/pied');
    }

    protected function get_msg($msg = '', $cls = 'error'){
        $_SESSION[$cls] = (empty($msg)) ? validation_errors('', '') : $msg;
    }


    protected function matricule($string, $fonction = 'E')
    {

        $length = strlen($string);
        $position = mt_rand(0, $length - 1);
        $random_char_mat = strtoupper($string[$position]);
        while (!in_array($random_char_mat, ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'])) {
            $position = mt_rand(0, $length - 1);
            $random_char_mat = strtoupper($string[$position]);
        }

        $my_rand_mat = rand() % (1000000);
        while (strlen($my_rand_mat) < 4) {
            $my_rand_mat = rand() % (1000000);
        }

        $list_complement = ['-', '1', '3', '-', '5', '7', '9', '-', ''];
        $mat_et = $fonction . $random_char_mat . $my_rand_mat . $list_complement[rand(0, 8)];

        $this->form_validation->set_data(compact('mat_et'));
        $this->form_validation->set_rules('mat_et', 'Génération du Matricule', 'is_unique[etudiants.mat_et]',
            ['is_unique' => 'La %s a échouée']);

        return $this->form_validation->run() ? $mat_et : $this->matricule($string);
    }

    /**
     * la fonction pour afficher les donnees de test ou de debogage
     * @param mixed ...$dd
     * @return void
     */
    protected function dd(...$dd){
        foreach ($dd as $debug):
            echo '<pre>';
            var_dump($debug);
            echo '</pre>';
        endforeach;
        exit();
    }
}
