<?php
class SessionHelper {
   public static function isLoggedIn() {
    return isset($_SESSION['user']);
}

    public static function isAdmin(): bool {
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin';
}

}
