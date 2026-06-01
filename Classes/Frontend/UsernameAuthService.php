<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "username" by Oliver Bartsch.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Bo\Username\Frontend;

use TYPO3\CMS\Core\Authentication\AbstractAuthenticationService;
use TYPO3\CMS\Core\Authentication\LoginType;

final class UsernameAuthService extends AbstractAuthenticationService
{
    public function getUser(): array|false
    {
        if (LoginType::tryFrom((string)($this->login['status'] ?? '')) !== LoginType::LOGIN) {
            return false;
        }

        $username = (string)($this->login['uname'] ?? '');
        if ($username === '') {
            return false;
        }

        $user = $this->fetchUserRecord($username);
        if (!is_array($user) || ($user['disabled'] ?? false)) {
            // Failed login attempt (no username found)
            return false;
        }

        return $user;
    }

    public function authUser(array $user): int
    {
        return 200;
    }
}
