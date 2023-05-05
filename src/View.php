<?php

namespace Mini;

use Exception;
use Throwable;

class View extends Base
{
    public $title;
    public $description;
    public $pageClass;

    /**
     * @param string $view
     * @param array $params
     * @return void
     * @throws Throwable
     */
    public function render(string $view, array $params = [])
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            $content = $this->renderFile($file, $params);
            echo $this->renderFile($this->getLayoutFile(), ['content' => $content]);
        }

        return;
    }

    /**
     * @param string $view
     * @param array $params
     * @return false|string|void
     * @throws Throwable
     */
    public function renderPartial(string $view, array $params = [])
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            return $this->renderFile($file, $params);
        }

        return;
    }

    /**
     * @param string $file
     * @param array $params
     * @return false|string
     */
    public function renderFile(string $file, array $params = [])
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try {
            require $file;
            return ob_get_clean();
        } catch (Exception|Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }
}
