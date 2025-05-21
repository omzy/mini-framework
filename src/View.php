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
     * @throws Throwable
     */
    public function render(string $view, array $params = []): null
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            $content = $this->renderFile($file, $params);
            echo $this->renderFile($this->getLayoutFile(), ['content' => $content]);
        }

        return null;
    }

    /**
     * @throws Throwable
     */
    public function renderPartial(string $view, array $params = []): false|string|null
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            return $this->renderFile($file, $params);
        }

        return null;
    }

    public function renderFile(string $file, array $params = []): false|string
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
