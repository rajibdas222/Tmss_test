<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Contracts\Auth\Factory as Auth;
    use Illuminate\Http\Request;


    class JwtMiddleware
    {

        public function __construct(Auth $auth){
            $this->auth = $auth;
        }

        public function handle($request, Closure $next, $guard = null, $role = null){
            $cookie_name = env('AUTH_COOKIE_NAME');
            if (!$request->bearerToken()) {
                if ($request->hasCookie($cookie_name)) {
                    $token = $request->cookie($cookie_name);
                    $request->headers->add([
                        'Authorization' => 'Bearer ' . $token
                    ]);
                }
            }

            if($this->auth->guard($guard)->guest())
                return response()->json(['message' => 'Unauthorized'], 401);

            if($role) {
                $auth_user = auth()->user();
                dd($auth_user);
                if ($auth_user->role !== $role)
                    return response()->json(['message' => 'Permission denied'], 412);
            }

            return $next($request);
        }



    }
