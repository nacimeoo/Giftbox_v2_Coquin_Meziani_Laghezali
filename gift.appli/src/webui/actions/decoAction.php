<?php
use Slim\Routing\RouteContext;

class decoAction
{
    public function __invoke($request, $response, $args)
    {
        session_start(); 
        session_unset(); 
        session_destroy(); 

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('box_post');
        return $response->withHeader('Location', $url)->withStatus(302);
    }
}


exit();
?>