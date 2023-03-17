<?php
namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Auth;
class VerifyJWTToken
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
        $profile = Auth::guard('api')->user();
        if ($profile->status == 2) {
            return response()->json(['error' => 'Yor account is permanently inactive.'], 401);
        } else if ($profile->status == 3) {
            return response()->json(['error' => 'Yor account is temporarily deactivated.'], 401);
        } else if ($profile->is_phon_verified == 0) {
            return response()->json(['error' => 'Yor account is not yet verified.'], 401);
        }
        return $next($request);
    }
}
?>
