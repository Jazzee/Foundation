<?php
namespace Foundation\VC;

/**
 * Regex Rewrite Router
 * Routes a request using mod_rewrite and regulr expressions
 * Allows for full pattern matching and replacemenet
 * 
 * @package Foundation\vc 
 */
class FullRegexRewriteRouter extends \Lvc_RegexRewriteRouter
{

    public function route($request)
    {
        $params = $request->getParams();
        if (isset($params['get']['url'])) {
            // Use mod_rewrite's url
            $url = $params['get']['url'];
            $matches = array();
            foreach ($this->routes as $regex => $parsingInfo) {
                if (preg_match($regex, $url, $matches)) {
                    // Check for redirect action first
                    if (isset($parsingInfo['redirect'])) {
                        $redirectUrl = preg_replace($regex, $parsingInfo['redirect'], $url);
                        header('Location: ' . $redirectUrl);
                        exit();
                    }
                    // Get controller name if available
                    if (isset($parsingInfo['controller'])) {
                        $request->setControllerName(preg_replace($regex, $parsingInfo['controller'], $url));
                    }

                    // Get action name if available
                    if (isset($parsingInfo['action'])) {
                        $request->setActionName(preg_replace($regex, $parsingInfo['action'], $url));
                    }

                    // Get action parameters
                    $actionParams = array();
                    if (isset($parsingInfo['action_params'])) {
                        foreach ($parsingInfo['action_params'] as $key => $value) {
                            $actionParams[$key] = preg_replace($regex, $value, $url);
                        }
                    }
                    if (isset($parsingInfo['additional_params'])) {
                        $additionalParams = preg_replace($regex, $parsingInfo['additional_params'], $url);
                        if (!empty($additionalParams)) {
                            $actionParams = $actionParams + explode('/', $additionalParams);
                        }
                    }
                    $request->setActionParams($actionParams);

                    return true;
                } // route matched
            } // loop through routes
        } // url _GET value set

        return false;
    }
}
