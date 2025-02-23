<?php


namespace App\Http\Middleware;
use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Route;


class CheckRole
{
  /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $MyRoute = Route::getFacadeRoot()->current()->uri();

        $route = explode('/', $MyRoute);
       
        $RoleArray = Role::distinct()->whereNotNull('allowed_route')
                                ->pluck('allowed_route')
                                ->toArray();
                               
        if (auth()->check()) {
           if (!in_array($route[0], $RoleArray)) {

              return $next($request);    

            } else {    

                if ($route[0] != auth()->user()->roles[0]->allowed_route) {
                    $path = $route[0] == auth()->user()->roles[0]->allowed_route ?
                    $route[0].'.show_login_form' : '' . auth()->user()->roles[0]->allowed_route.'.home';

                    return redirect()->route($path);
                } else {
                    return $next($request);
                }
            }
        } else {
                                 
            $routeDistination = in_array($route[0], $RoleArray) ? 
            $route[0].'.show_login_form':'frontend.home';  
                                     
                 $path = $route[0] != '' ? $routeDistination:auth()->user()->roles[0]->allowed_route.'.home';


                 return redirect()->route($path);


             return redirect()->route($path);



 
     }
 }
 
 


}
