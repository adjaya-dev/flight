<?php
/**
 * Flight: an extensible PHP micro-framework.
 *
 * @copyright   Copyright (c) 2011, Mike Cao <mike@mikecao.com>
 * @license     http://www.opensource.org/licenses/mit-license.php
 * @version     0.1
 */
class View {
    protected $templatePath;

    public function __construct($templatePath = null) {
        $this->templatePath = $templatePath ?: './views';
    }

    /**
     * Renders a template.
     *
     * @param string $file Template file
     * @param array $data Template data
     */
    public function render($file, $data = null) {
        // Bind template data to view
        if (!is_null($data)) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $this->{$key} = $value;
                }
            }
            else if (is_object($data)) {
                foreach (get_object_vars($data) as $key => $value) {
                    $this->{$key} = $value;
                }
            }
        }

        // Display template
        include $this->templatePath.'/'.((substr($file,-4) == '.php') ? $file : $file.'.php');
    }

    /**
     * Gets the output of a template.
     *
     * @param string $file Template file
     * @param array $data Template data
     */
    public function fetch($file, $data = null) {
        ob_start();

        $this->render($file, $data);
        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    /**
     * Displays escaped output.
     *
     * @param string $str String to escape
     */
    public function e($str) {
        echo htmlentities($str);
    }
}
?>
