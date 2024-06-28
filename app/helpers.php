<?php

use App\Models\User;

if (!function_exists('gravatar'))
{
    /**
     * Generate the gravatar profile image URL
     *
     * @param mixed|null $target
     * @param int        $size
     * @param string     $default_image
     * @param string     $rating
     *
     * @return string
     */
    function gravatar(mixed $target = null, int $size = 128, string $default_image = 'robohash', string $rating = 'g'): string
    {
        $_user = User::class;

        if (!$target && auth()->check())
            $target = auth()->user()->email;
        else if ($target instanceof $_user)
            $target = $target->email;
        else if (is_string($target))
            $target = strtolower($target);
        else
            $target = time() . '-i-am-panicked';

        $hash = md5(strtolower(trim($target)));
        return "https://www.gravatar.com/avatar/$hash?s=$size&d=$default_image&r=$rating";
    }
}
