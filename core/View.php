<?php

namespace mini\core;

use Mini;

class View extends Base
{
    public function render($view, $params = [])
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            $content = $this->renderFile($file, $params);
            echo $this->renderFile($this->getLayoutFile(), ['content' => $content]);
        }

        return;
    }

    public function renderPartial($view, $params = [])
    {
        $file = $this->getViewFile($view);

        if (file_exists($file)) {
            return $this->renderFile($file, $params);
        }

        return;
    }

    public function renderFile($file, $params = [])
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try {
            require $file;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }
}
