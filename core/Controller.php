<?php
namespace core;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Controller
{
    protected function redirect($url)
    {
        header("Location: " . $this->getBaseUrl() . $url);
        exit();
    }

    private function getBaseUrl()
    {
        $base =
            isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on'
                ? 'https://'
                : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':' . $_SERVER['SERVER_PORT'];
        }
        $base .= getenv('BASE_DIR');

        return $base;
    }

    protected function setErrorLog($error)
    {
        $log = new Logger('error');
        $log->pushHandler(
            new StreamHandler('../logs/error.log', Logger::ERROR),
        );

        $log->error($error);
    }

    private function _render($folder, $viewName, $viewData = [])
    {
        if (file_exists('../src/views/' . $folder . '/' . $viewName . '.php')) {
            extract($viewData);
            $render = fn($vN, $vD = []) => $this->renderPartial($vN, $vD);
            $base = $this->getBaseUrl();
            require '../src/views/' . $folder . '/' . $viewName . '.php';
        }
    }

    private function renderPartial($viewName, $viewData = [])
    {
        $this->_render('partials', $viewName, $viewData);
        $this->_render('components', $viewName, $viewData);
    }

    public function render($viewName, $viewData = [])
    {
        $this->_render('pages', $viewName, $viewData);
    }
}
